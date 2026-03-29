<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\DTOs\ResetPasswordDTO;
use App\Domains\Auth\Repositories\Contracts\PasswordResetServiceInterface;
use Illuminate\Support\Facades\Hash;

class ResetPasswordUseCase
{
    public function __construct(
        private PasswordResetServiceInterface $passwordService
    ) {}

    public function execute(ResetPasswordDTO $dto): bool
    {
        return $this->passwordService->resetPassword(
            email: $dto->email->getEmail(),
            token: $dto->token,
            password: $dto->password->value(),

        );
    }
}
