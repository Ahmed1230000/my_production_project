<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Repositories\Contracts\PasswordResetServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LaravelPasswordResetService implements PasswordResetServiceInterface
{
    public function sendResetLinkEmail(string $email): bool
    {
        $status = Password::sendResetLink(['email' => $email]) === Password::RESET_LINK_SENT;
        return $status;
    }

    public function resetPassword(string $token, string $email, string $password): bool
    {
        $status = Password::reset(
            [
                'email' => $email,
                'token' => $token,
                'password' => $password,
            ],
            function (User $user) use ($password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );
        // dd($status);

        if ($status !== Password::PASSWORD_RESET) {
            throw new \Exception("Invalid or expired token");
        }
        return $status === Password::PASSWORD_RESET;
    }
}
