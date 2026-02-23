<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Exception;
use App\Models\Role;
use App\Helpers\PaginationHelper;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Helpers\ExportHelper;
class RoleController extends Controller
{
    //
    public function index(Request $request)
    {
        try {   
            $roles = Role::query();
            if ($request->has('search')) {
                $roles->where('name_en', 'like', '%' . $request->search . '%')
                    ->orWhere('name_ar', 'like', '%' . $request->search . '%')
                    ->orWhere('description_en', 'like', '%' . $request->search . '%')
                    ->orWhere('description_ar', 'like', '%' . $request->search . '%');
            }
            $roles = $roles->paginate(10);
            return response()->json([
                'message' => __('messages.roles_retrieved_success'),
                'roles' => RoleResource::collection($roles),
                'pagination' => PaginationHelper::paginate($roles),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_roles'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $role = Role::with('permissions')->find($id);
            if (!$role) {
                return response()->json([
                    'message' => __('messages.role_not_found'),
                ], 404);
            }

            return response()->json([
                'message' => __('messages.role_retrieved_success'),
                'role' => new RoleResource($role),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_role'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        
        try {
            $request->validate([
                'name_en' => 'required|string|max:255|unique:roles,name_en',
                'name_ar' => 'required|string|max:255|unique:roles,name_ar',
                'description_en' => 'required|string|max:255',
                'description_ar' => 'required|string|max:255',
                'permissions' => 'required|array',
                'permissions.*' => 'required|exists:permissions,name',
            ]);
            $role = Role::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
            ]);

            $permissions = Permission::whereIn('name', $request->permissions)->pluck('id')->toArray();
            $role->permissions()->attach($permissions);

            // dd($role);

            return response()->json([
                'message' => __('messages.role_created_success'),
                'role' => new RoleResource($role),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_role'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                // names are unique
                'name_en' => 'nullable|string|max:255|unique:roles,name_en,' . $id . ',id',
                'name_ar' => 'nullable|string|max:255|unique:roles,name_ar,' . $id . ',id',
                'description_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string|max:255',
                'permissions' => 'nullable|array',
                'permissions.*' => 'nullable|exists:permissions,name',
            ]);
            $role = Role::find($id);
            if (!$role) {
                return response()->json([
                    'message' => __('messages.role_not_found'),
                ], 404);
            }
            
            $role->update([
                'name_en' => $request->name_en ?? $role->name_en,
                'name_ar' => $request->name_ar ?? $role->name_ar,
                'description_en' => $request->description_en ?? $role->description_en,
                'description_ar' => $request->description_ar ?? $role->description_ar,
            ]);
            
            $permissions = Permission::whereIn('name', $request->permissions)->pluck('id')->toArray();
            $role->permissions()->sync($permissions);
            return response()->json([
                'message' => __('messages.role_updated_success'),
                'role' => new RoleResource($role),
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_role'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return response()->json([
                    'message' => __('messages.role_not_found'),
                ], 404);
            }
            if ($role->users->count() > 0) {
                return response()->json([
                    'message' => __('messages.role_has_users'),
                ], 400);
            }
            $role->permissions()->detach();
            $role->delete();
            return response()->json([
                'message' => __('messages.role_deleted_success'),
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_role'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // permissions
    public function permissions()
    {
        try {
            $permissions = Permission::all();
            return response()->json([
                'message' => __('messages.permissions_retrieved_success'),
                'permissions' => PermissionResource::collection($permissions),
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_permissions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // export
    public function export(Request $request)
    {
        try {
            $roles = Role::all();
            
            $data = [];
            foreach ($roles as $role) {
                $locale = app()->getLocale();
                $name = $locale == 'ar' ? $role['name_ar'] : $role['name_en'];
                $description = $locale == 'ar' ? $role['description_ar'] : $role['description_en'];
                $data[] = [
                    'id' => $role->id,
                    'name' => $name,
                    'description' => $description,
                    'total_admins' => $role->users()->count(),
                    // merge group and display name like this: group - display name
                    'permissions' => implode(' - ', array_map(function($group, $displayName) {
                        return "$displayName ($group)";
                    }, $role->permissions()->pluck('group')->toArray(), $role->permissions()->pluck('display_name_'.app()->getLocale())->toArray())),
                    'created_at' => $role->created_at,
                ];
            }
            $filename = 'roles_export_' . now()->format('Ymd_His') . '.xlsx';
            $media = ExportHelper::exportToMedia($data, auth()->user(), 'exports', $filename);
            return $media->getUrl();
        }
        catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_export_roles'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
