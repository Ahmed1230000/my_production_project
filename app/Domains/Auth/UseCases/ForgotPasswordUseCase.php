<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\DTOs\ForgotPasswordDTO;
use App\Domains\Auth\Repositories\Contracts\PasswordResetServiceInterface;

class ForgotPasswordUseCase
{
    public function __construct(
        private readonly PasswordResetServiceInterface $passwordResetService
    ) {}

    public function execute(ForgotPasswordDTO $dto): bool
    {
        return $this->passwordResetService->sendResetLinkEmail($dto->email->getEmail());
    }
}
