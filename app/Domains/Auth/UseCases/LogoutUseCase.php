<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;

class LogoutUseCase
{
    public function __construct(
        private AuthTokenServiceInterface $tokenService
    ) {}

    public function execute(int $userId): void
    {
        $this->tokenService->revokeToken($userId);
    }
}
