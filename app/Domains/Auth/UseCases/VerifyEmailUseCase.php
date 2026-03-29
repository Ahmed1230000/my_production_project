<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\DTOs\VerifyEmailDTO;
use App\Domains\Auth\Exceptions\InvalidVerificationLinkException;
use App\Domains\Auth\Repositories\Contracts\EmailVerificationServiceInterface;

class VerifyEmailUseCase
{
    public function __construct(
        private EmailVerificationServiceInterface $verificationService
    ) {}

    public function execute(VerifyEmailDTO $dto): void
    {
        if (! $this->verificationService->hasValidSignature($dto)) {
            throw new InvalidVerificationLinkException(
                'The email verification link is invalid or expired.'
            );
        }

        $this->verificationService->markEmailVerified($dto);
    }
}
