<?php

namespace App\Domains\Auth\DTOs;

use App\Domains\Auth\ValueObjects\EmailVO;
use App\Domains\Auth\ValueObjects\PasswordVO;

class RegisterUserDTO
{
    public function __construct(
        public string $name,
        public EmailVO $email,
        public PasswordVO $password,
    ) {}


    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email->getEmail(),
            'password' => $this->password,
        ], fn($value) => $value !== null);
    }
}
