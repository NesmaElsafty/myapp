<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Services\SystemSettingService;
use App\Http\Resources\SystemSettingResource;

class SystemSettingController extends Controller
{
    //
    public function __construct(
        protected SystemSettingService $systemSettingService
    ) {}
    public function index(Request $request)
    {
        try {
            $systemSettings = $this->systemSettingService->getAll();
            return response()->json([
                'message' => 'System settings retrieved successfully',
                'data' => SystemSettingResource::collection($systemSettings),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve system settings',
                'error' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    public function show($key)
    {
        try {
            $systemSetting = $this->systemSettingService->getByName($key);
            return response()->json([
                'message' => 'System setting retrieved successfully',
                'data' => new SystemSettingResource($systemSetting),
            ], 200);
        
        } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to retrieve system setting',
                    'error' => $e->getMessage(),
                    'status' => 'error',
                ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'setting' => 'required|array',
                'setting.*.key' => 'required|exists:system_settings,key',
                'setting.*.value' => 'required|string',
            ]);

            foreach ($request->setting as $index => $setting) {
                $systemSetting = $this->systemSettingService->update($setting['key'], $setting['value']);
                
                // Check if there's a file uploaded for this setting
                $fileKey = 'setting.' . $index . '.image';
                if ($request->hasFile($fileKey)) {
                    $systemSetting->clearMediaCollection('image');
                    $systemSetting->addMediaFromRequest($fileKey)->toMediaCollection('image');
                }
            }
            // get all system settings
            $systemSettings = $this->systemSettingService->getAll();
            return response()->json([
                'message' => 'System settings updated successfully',
                'data' => SystemSettingResource::collection($systemSettings),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update system settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
