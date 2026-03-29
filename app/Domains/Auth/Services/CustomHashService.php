<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Repositories\Contracts\HashServiceInterface;
use Illuminate\Support\Facades\Hash;

class CustomHashService implements HashServiceInterface
{
    public function check(string $value, string $hashedValue): bool
    {
        // return password_verify($value, $hashedValue);
        return Hash::check($value, $hashedValue);
    }
}
