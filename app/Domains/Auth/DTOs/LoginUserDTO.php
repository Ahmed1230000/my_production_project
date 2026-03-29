<?php

namespace App\Domains\Auth\DTOs;

// use App\Domains\Auth\ValueObjects\EmailVO;
// use App\Domains\Auth\ValueObjects\PasswordVO;

class LoginUserDTO
{
    public function __construct(
        // public string $name,
        public string $email,
        public string $password,
    ) {}


    public function toArray(): array
    {
        return array_filter([
            // 'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ], fn($value) => $value !== null);
    }
}
