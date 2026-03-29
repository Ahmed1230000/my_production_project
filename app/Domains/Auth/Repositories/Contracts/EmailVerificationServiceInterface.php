<?php


namespace App\Domains\Auth\Repositories\Contracts;

use App\Domains\Auth\DTOs\VerifyEmailDTO;

interface EmailVerificationServiceInterface
{
    public function hasValidSignature(VerifyEmailDTO $dto): bool;

    public function markEmailVerified(VerifyEmailDTO $dto): void;
}
