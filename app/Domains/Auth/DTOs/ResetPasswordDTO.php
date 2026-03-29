<?php

namespace App\Domains\Auth\DTOs;

use App\Domains\Auth\ValueObjects\EmailVO;
use App\Domains\Auth\ValueObjects\PasswordVO;

class ResetPasswordDTO
{
    public function __construct(
        public EmailVO $email,
        public string $token,
        public PasswordVO $password,
    ) {}
}
