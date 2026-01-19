<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Helpers\PaginationHelper;
use App\Helpers\ExportHelper;

class UserService
{
    public function getAll($data, $user_type)
    {
        $query = User::query();
        
        // Filter by type - always apply this filter first
        $query->where('type', $user_type);
        // Search by name, email, phone, or location
        if(isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search, $user_type) {
                $q->where('f_name', 'like', "%{$search}%")
                    ->orWhere('l_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
                });
        }

        if(isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            switch($data['sorted_by']) {
                case 'name':
                    $query->orderBy('f_name', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        }

        // Filter by is_active
        if(isset($data['is_active']) && $data['is_active'] !== 'all') {
            $query->where('is_active', $data['is_active']);
        }

        if(isset($data['role_id']) && $data['role_id'] !== 'all') {
            $query->where('role_id', $data['role_id']);
        }
        return $query;
    }

    public function getById($id): ?User
    {
        return User::with('origin')->find($id);
    }

    public function create($data)
    {
        $userData = [
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'type' => $data['type'],
            'location' => $data['location'] ?? null,
            'is_active' => $data['is_active'],
            'password' => Hash::make('123456'),
            'role_id' => $data['role_id'] ?? null,
        ];

        return User::create($userData);
    }

    public function update($id, $data)
    {
        // dd($data);
        $user = User::find($id);
        if (!$user) {
            throw ValidationException::withMessages([
                'user' => ['User not found'],
            ]);
        }

        // Validate type-specific fields if type is being changed
        if (isset($data['type']) && $data['type'] !== $user->type) {
            $this->validateTypeSpecificFields($data);
        }

        $updateData = [];

        if (isset($data['f_name'])) {
            $updateData['f_name'] = $data['f_name'];
        }

        if (isset($data['l_name'])) {
            $updateData['l_name'] = $data['l_name'];
        }

        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (isset($data['phone'])) {
            $updateData['phone'] = $data['phone'];
        }

        if (isset($data['type'])) {
            $updateData['type'] = $data['type'];
        }

        if (isset($data['origin_id'])) {
            $updateData['origin_id'] = $data['origin_id'];
        }

        if (isset($data['national_id'])) {
            $updateData['national_id'] = $data['national_id'];
        }

        if (isset($data['commercial_number'])) {
            $updateData['commercial_number'] = $data['commercial_number'];
        }

        if (isset($data['is_active'])) {
            $updateData['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
        }

        if (isset($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (isset($data['email_verified_at'])) {
            $updateData['email_verified_at'] = $data['email_verified_at'];
        }

        if (isset($data['role_id'])) {
            $updateData['role_id'] = $data['role_id'];
        }

        $user->update($updateData);

        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);
        return $user->forceDelete();
    }

    public function toggleActive($ids)
    {
        $users = User::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            $user->is_active = !$user->is_active;
            $user->save();
        }
        return true;
    }

    // blocklist
    public function blocklist($data)
    {
        // get only deleted users
        $query = User::onlyTrashed()->where('type', $data['user_type']);

        if(isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('f_name', 'like', "%{$search}%")
                ->orWhere('l_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query;
    }
    public function block($ids)
    {
        $users = User::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            $user->agents->each(function ($agent) {
                $agent->delete();
            });
            $user->delete(); 
        }
        return true;
    }

    public function unblock($ids)
    {
        $users = User::withTrashed()->whereIn('id', $ids)->get();
        foreach ($users as $user) {
            $user->restore();
        }
        return true;
    }

    public function export($ids)
    {
        $users = User::whereIn('id', $ids)->get();
        $csvData = [];
        
        foreach ($users as $user) {
            $csvData[] = [
                'name' => $user->f_name . ' ' . $user->l_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'type' => $user->type,
                'location' => $user->location,
                'is_active' => $user->is_active == '1' ? 'مفعل' : 'غير مفعل',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        }
        // Generate CSV file
        $user = auth()->user();
        $filename = 'users_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, $user, 'exports', $filename);
        return $media->getUrl();
    }

    public function stats($userType)
    {
        $now = now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();
        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // Base query for the user type
        $baseQuery = User::where('type', $userType);

        // Total Blocked Accounts (is_active = false or '0')
        $totalBlocked = (clone $baseQuery)
            ->where('is_active', '0')
            ->count();

        // Blocked accounts created in current month
        $currentMonthBlocked = (clone $baseQuery)
            ->where('is_active', '0')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        // Blocked accounts created in last month
        $lastMonthBlocked = (clone $baseQuery)
            ->where('is_active', '0')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $blockedPercentage = $this->calculatePercentageChange($lastMonthBlocked, $currentMonthBlocked);

        // Total Active Accounts (is_active = true or '1')
        $totalActive = (clone $baseQuery)
            ->where('is_active', '1')
            ->count();

        // Active accounts created in current month
        $currentMonthActive = (clone $baseQuery)
            ->where('is_active', '1')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        // Active accounts created in last month
        $lastMonthActive = (clone $baseQuery)
            ->where('is_active', '1')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $activePercentage = $this->calculatePercentageChange($lastMonthActive, $currentMonthActive);

        // Total Accounts (all users of this type)
        $totalAccounts = (clone $baseQuery)->count();

        // Total accounts created in current month
        $currentMonthTotal = (clone $baseQuery)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        // Total accounts created in last month
        $lastMonthTotal = (clone $baseQuery)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $totalPercentage = $this->calculatePercentageChange($lastMonthTotal, $currentMonthTotal);

        $result = [
            'blocked_accounts' => [
                'count' => $totalBlocked,
                'percentage' => $blockedPercentage,
                'label' => 'الحسابات المحظورة',
            ],
            'active_accounts' => [
                'count' => $totalActive,
                'percentage' => $activePercentage,
                'label' => 'الحسابات النشطة',
            ],
            'total_accounts' => [
                'count' => $totalAccounts,
                'percentage' => $totalPercentage,
                'label' => 'إجمالي الأفراد',
            ],
        ];

        // If user type is origin, add total_agents
        if ($userType === 'origin') {
            // Get all origin user IDs
            $originIds = User::where('type', 'origin')->pluck('id');

            // Total agents belonging to all origins
            $totalAgents = User::where('type', 'agent')
                ->whereIn('origin_id', $originIds)
                ->count();

            // Agents created in current month
            $currentMonthAgents = User::where('type', 'agent')
                ->whereIn('origin_id', $originIds)
                ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->count();

            // Agents created in last month
            $lastMonthAgents = User::where('type', 'agent')
                ->whereIn('origin_id', $originIds)
                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->count();

            $agentsPercentage = $this->calculatePercentageChange($lastMonthAgents, $currentMonthAgents);

            $result['total_agents'] = [
                'count' => $totalAgents,
                'percentage' => $agentsPercentage,
                'label' => 'إجمالي الوكلاء',
            ];
        }

        return $result;
    }

    /**
     * Calculate percentage change between two values
     */
    protected function calculatePercentageChange(float $oldValue, float $newValue): float
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100.0 : 0.0;
        }

        $change = (($newValue - $oldValue) / $oldValue) * 100;
        return round($change, 2);
    }

    /**
     * Validate type-specific fields
     */
    protected function validateTypeSpecificFields($data): void
    {
        $type = $data['type'] ?? null;

        // Validate national_id for individual type
        if ($type === 'individual' && empty($data['national_id'])) {
            throw ValidationException::withMessages([
                'national_id' => ['National ID is required for individual users.'],
            ]);
        }

        // Validate commercial_number for origin type
        if ($type === 'origin' && empty($data['commercial_number'])) {
            throw ValidationException::withMessages([
                'commercial_number' => ['Commercial number is required for origin users.'],
            ]);
        }

        // Validate origin_id for agent type
        if ($type === 'agent' && empty($data['origin_id'])) {
            throw ValidationException::withMessages([
                'origin_id' => ['Origin ID is required for agent users.'],
            ]);
        }

        // Ensure origin exists if provided
        if (isset($data['origin_id']) && $data['origin_id']) {
            $origin = User::where('id', $data['origin_id'])
                ->where('type', 'origin')
                ->first();

            if (!$origin) {
                throw ValidationException::withMessages([
                    'origin_id' => ['The selected origin does not exist or is not an origin type.'],
                ]);
            }
        }
    }
}
