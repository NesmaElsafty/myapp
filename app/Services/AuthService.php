<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user
     */
    public function register(array $data): array
    {
        // Validate type-specific fields
        $this->validateTypeSpecificFields($data);

        // Create user
        $user = User::create([
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'origin_id' => $data['origin_id'] ?? null,
            'national_id' => $data['national_id'] ?? null,
            'commercial_number' => $data['commercial_number'] ?? null,
            'email_verified_at' => now(),
        ]);

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Login user
     */
    public function login(array $credentials): array
    {
        $query = User::where('email', $credentials['email']);

        // If type is provided, filter by type
        if (isset($credentials['type'])) {
            $query->where('type', $credentials['type']);
        }

        // Check if email exists in multiple types
        $usersWithEmail = User::where('email', $credentials['email'])->get();
        
        if ($usersWithEmail->count() > 1 && !isset($credentials['type'])) {
            throw ValidationException::withMessages([
                'type' => ['Multiple accounts found with this email. Please specify the user type.'],
            ]);
        }

        $user = $query->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Delete existing tokens (optional - for single device login)
        // $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Logout user
     */
    public function logout(User $user, ?string $tokenId = null): void
    {
        if ($tokenId) {
            // Delete specific token
            $user->tokens()->where('id', $tokenId)->delete();
        } else {
            // Delete all tokens for the user
            $user->tokens()->delete();
        }
    }

    /**
     * Validate type-specific fields
     */
    protected function validateTypeSpecificFields(array $data): void
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

    // update profile
    public function updateProfile($data)
    {
        $user = auth()->user();
        $user->f_name = $data['f_name'] ?? $user->f_name;
        $user->l_name = $data['l_name'] ?? $user->l_name;
        $user->email = $data['email'] ?? $user->email;
        $user->phone = $data['phone'] ?? $user->phone;
        $user->save();
        return $user;
    }
}
