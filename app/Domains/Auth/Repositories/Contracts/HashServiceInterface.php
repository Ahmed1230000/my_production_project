<?php

namespace App\Domains\Auth\Repositories\Contracts;

interface HashServiceInterface
{
    public function check(string $value, string $hashedValue): bool;
}
