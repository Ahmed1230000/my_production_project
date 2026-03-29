<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;

class RefreshTokenUseCase
{
    public function __construct(
        private AuthTokenServiceInterface $tokenService
    ) {}

    public function execute(string $refreshToken)
    {
        return $this->tokenService->refreshToken($refreshToken);
    }
}
