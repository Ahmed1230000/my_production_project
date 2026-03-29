<?php

namespace App\Domains\Auth\Repositories\Contracts;

interface PasswordResetServiceInterface
{
    public function sendResetLinkEmail(string $email): bool;

    public function resetPassword(string $token, string $email, string $password): bool;
}
