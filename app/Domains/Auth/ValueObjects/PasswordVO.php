<?php

namespace App\Domains\Auth\ValueObjects;

use App\Domains\Auth\Exceptions\PasswordException;
use Illuminate\Support\Facades\Hash;

class PasswordVO
{
    public function __construct(private string $password)
    {
        $this->validatePassword($password);
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function value(): string
    {
        return $this->password;
    }

    public function Hash(): string
    {
        return Hash::make($this->password);
    }

    private function validatePassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new PasswordException("Password must be at least 8 characters long.");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new PasswordException("Password must contain uppercase letter.");
        }
        if (!preg_match('/[a-z]/', $password)) {
            throw new PasswordException("Password must contain lowercase letter.");
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new PasswordException("Password must contain number.");
        }
        if (!preg_match('/[\W_]/', $password)) {
            throw new PasswordException("Password must contain special character.");
        }
    }
}
