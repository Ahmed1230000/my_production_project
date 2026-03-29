<?php

namespace App\Domains\Auth\DTOs;

use App\Domains\Auth\ValueObjects\EmailVO;

class ForgotPasswordDTO
{
    public function __construct(
        public EmailVO $email
    ) {}
}
