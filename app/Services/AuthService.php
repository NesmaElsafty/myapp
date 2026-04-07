<?php

namespace App\Services;

use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
            // origin_id only for type individual (optional)
            'origin_id' => ($data['type'] ?? null) === 'individual' ? ($data['origin_id'] ?? null) : null,
            'national_id' => $data['national_id'] ?? null,
            'commercial_number' => $data['commercial_number'] ?? null,
            'email_verified_at' => now(),
            'bank_name' => $data['bank_name'] ?? null,
            'bank_account_number' => $data['bank_account_number'] ?? null,
            'bank_account_iban' => $data['bank_account_iban'] ?? null,
            'bank_account_address' => $data['bank_account_address'] ?? null,
            'language' => $data['language'] ?? 'ar',
        ]);

        $tokens = $this->issueTokenPair($user);

        return [
            'user' => $user,
            'token' => $tokens['token'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
            'expires_in' => $tokens['expires_in'],
        ];
    }

    /**
     * Login user
     */
    public function login(array $credentials): array
    {
        $type = $credentials['type'] ?? null;

        // Admin or user login: use phone + password
        if (in_array($type, ['admin', 'user']) && !empty($credentials['phone'])) {
            $phone = trim($credentials['phone']);

            $user = User::where('phone', $phone)
                ->where('type', $type)
                ->first();

            if (!$user || !Hash::check($credentials['password'] ?? '', $user->getAuthPassword())) {
                throw ValidationException::withMessages([
                    'phone' => ['The provided credentials are incorrect.'],
                ]);
            }
        } elseif ($type === 'individual' && !empty($credentials['national_id'])) {
            // Individual login: use national_id + password
            $nationalId = trim($credentials['national_id']);

            $user = User::where('national_id', $nationalId)
                ->where('type', 'individual')
                ->first();

            if (!$user || !Hash::check($credentials['password'] ?? '', $user->getAuthPassword())) {
                throw ValidationException::withMessages([
                    'national_id' => ['The provided credentials are incorrect.'],
                ]);
            }
        } elseif ($type === 'origin' && !empty($credentials['commercial_number'])) {
            // Origin login: use commercial_number + password
            $commercialNumber = trim($credentials['commercial_number']);

            $user = User::where('commercial_number', $commercialNumber)
                ->where('type', 'origin')
                ->first();

            if (!$user || !Hash::check($credentials['password'] ?? '', $user->getAuthPassword())) {
                throw ValidationException::withMessages([
                    'commercial_number' => ['The provided credentials are incorrect.'],
                ]);
            }
        } else {
            // Default: email + password (for user, individual, origin, or admin without phone)
            $email = isset($credentials['email']) ? trim($credentials['email']) : '';

            $query = User::where('email', $email);

            if (isset($credentials['type'])) {
                $query->where('type', $credentials['type']);
            }

            $usersWithEmail = User::where('email', $email)->get();

            if ($usersWithEmail->count() > 1 && !isset($credentials['type'])) {
                throw ValidationException::withMessages([
                    'type' => ['Multiple accounts found with this email. Please specify the user type.'],
                ]);
            }

            $user = $query->first();
        }

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->is_active === '0' || $user->is_active === false) {
            throw ValidationException::withMessages([
                'email' => ['This account has been deactivated.'],
            ]);
        }

        $tokens = $this->issueTokenPair($user);

        return [
            'user' => $user,
            'token' => $tokens['token'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
            'expires_in' => $tokens['expires_in'],
        ];
    }

    /**
     * Exchange a valid refresh token for a new access + refresh pair (rotation).
     *
     * @return array{token: string, access_token: string, refresh_token: string, expires_in: int}
     */
    public function refresh(string $plainRefreshToken): array
    {
        $hash = hash('sha256', $plainRefreshToken);

        $record = RefreshToken::query()
            ->where('token_hash', $hash)
            ->first();

        if (!$record) {
            throw ValidationException::withMessages([
                'refresh_token' => [__('messages.invalid_refresh_token')],
            ])->status(401);
        }

        $user = $record->user;

        if (!$user) {
            $record->delete();
            throw ValidationException::withMessages([
                'refresh_token' => [__('messages.invalid_refresh_token')],
            ])->status(401);
        }

        if ($user->is_active === '0' || $user->is_active === false) {
            throw ValidationException::withMessages([
                'refresh_token' => [__('messages.invalid_refresh_token')],
            ])->status(401);
        }

        $oldAccessId = $record->personal_access_token_id;

        $tokens = $this->issueTokenPair($user);

        if ($oldAccessId) {
            $user->tokens()->where('id', $oldAccessId)->delete();
        } else {
            $record->delete();
        }

        return $tokens;
    }

    /**
     * @return array{token: string, access_token: string, refresh_token: string, expires_in: int}
     */
    protected function issueTokenPair(User $user): array
    {
        $accessMinutes = max(1, (int) config('sanctum.access_token_expiration_minutes', 60));
        $refreshDays = max(1, (int) config('sanctum.refresh_token_expiration_days', 30));

        $accessTokenResult = $user->createToken(
            'auth-access',
            ['*'],
            now()->addMinutes($accessMinutes)
        );

        $plainRefresh = Str::random(64);

        RefreshToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $plainRefresh),
            'expires_at' => now()->addDays($refreshDays),
            'personal_access_token_id' => $accessTokenResult->accessToken->id,
        ]);

        $expiresAt = $accessTokenResult->accessToken->expires_at;
        $expiresIn = $expiresAt
            ? max(1, $expiresAt->getTimestamp() - now()->getTimestamp())
            : $accessMinutes * 60;

        $plainAccess = $accessTokenResult->plainTextToken;

        return [
            'access_token' => $plainAccess,
            'refresh_token' => $plainRefresh,
            'expires_in' => $expiresIn,
            'token' => $plainAccess,
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

        // origin_id is only allowed for individual type; if provided must be a valid origin
        if (isset($data['origin_id']) && $data['origin_id'] && $type !== 'individual') {
            throw ValidationException::withMessages([
                'origin_id' => ['Origin ID is only allowed for individual users.'],
            ]);
        }

        // Ensure origin exists if provided (for individual)
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
        if (array_key_exists('bank_name', $data)) {
            $user->bank_name = $data['bank_name'];
        }
        if (array_key_exists('bank_account_number', $data)) {
            $user->bank_account_number = $data['bank_account_number'];
        }
        if (array_key_exists('bank_account_iban', $data)) {
            $user->bank_account_iban = $data['bank_account_iban'];
        }
        if (array_key_exists('bank_account_address', $data)) {
            $user->bank_account_address = $data['bank_account_address'];
        }
        if (array_key_exists('language', $data)) {
            $user->language = $data['language'];
        }

        // for individuals & origins
        if (array_key_exists('specialty_areas', $data)) {
            $user->specialty_areas = json_encode($data['specialty_areas']);
        }
        if (array_key_exists('major', $data)) {
            $user->major = $data['major'] ?? null;
        }
        if (array_key_exists('summary', $data)) {
            $user->summary = $data['summary'] ?? null;
        }

        $user->save();
        return $user;
    }
}
