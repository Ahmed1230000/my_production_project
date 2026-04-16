<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\InvalidCredentialsException;
use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Token;

class PassportTokenService implements AuthTokenServiceInterface
{
    public function generateToken(string $email, string $password): array
    {
        $request = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('RefreshToken.client_id'),
            'client_secret' => config('RefreshToken.client_secret'),
            'username' => $email,
            'password' => $password,
            'scope' => '',
        ]);


        $response = app()->handle($request);


        $data = json_decode($response->getContent(), true);

        if ($response->getStatusCode() !== 200) {
            $data = json_decode($response->getContent(), true);

            if (($data['error'] ?? null) === 'invalid_grant') {
                throw new InvalidCredentialsException("Invalid credentials");
            }

            throw new \Exception('Login failed');
        }

        return $data;
    }

    public function revokeToken(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->tokens()->delete();
    }

    public function refreshToken(string $refreshToken): array
    {
        $request = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('RefreshToken.client_id'),
            'client_secret' => config('RefreshToken.client_secret'),
            'scope' => '',
        ]);

        $response = app()->handle($request);

        $data = json_decode($response->getContent(), true);

        if ($response->getStatusCode() !== 200) {
            Log::error('Refresh token failed', [
                'status' => $response->getStatusCode(),
                'body' => $response->getContent(),
            ]);

            throw new \Exception('Refresh token failed');
        }

        return $data;
    }
}
