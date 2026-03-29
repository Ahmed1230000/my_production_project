<?php

namespace App\Domains\Auth\ValueObjects;

use App\Domains\Auth\Exceptions\EmailException;

class EmailVO
{
    public function __construct(public string $email)
    {
        $this->validateEmail($email);
    }

    private function validateEmail(string $email): void
    {
        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             throw new EmailException("Invalid email format: $email");
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
