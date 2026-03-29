<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token;

class PassportTokenService implements AuthTokenServiceInterface
{
    public function generateToken(int $userId): string
    {
        $user = User::findOrFail($userId);

        return $user
            ->createToken('auth_token')
            ->accessToken;
    }

    public function revokeToken(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->tokens()->delete();
    }

    public function refreshToken(string $refreshToken): array
    {
        $response = Http::asForm()->timeout(10)->post(config('RefreshToken.token_endpoint'), [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('RefreshToken.client_id'),
            'client_secret' => config('RefreshToken.client_secret'),
            'scope' => '',
        ]);

        return $response->json();
    }
}
