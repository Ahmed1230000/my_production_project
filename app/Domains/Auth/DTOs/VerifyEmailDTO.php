<?php

namespace App\Domains\Auth\DTOs;

use Illuminate\Http\Request;


class VerifyEmailDTO
{
    public function __construct(
        public int $userId,
        public string $hash,
        public Request $request,
    ) {}
}
