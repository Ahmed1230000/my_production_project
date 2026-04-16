<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\DTOs\AuthResultDTO;
use App\Domains\Auth\DTOs\LoginUserDTO;
use App\Domains\Auth\Exceptions\EmailNotVerifiedException;
use App\Domains\Auth\Exceptions\InvalidCredentialsException;
use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;
use App\Domains\Auth\Repositories\Contracts\HashServiceInterface;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AuthTokenServiceInterface $tokenService,
        private HashServiceInterface $hashService,

    ) {}

    public function execute(LoginUserDTO $dto): AuthResultDTO
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user) {
            throw new InvalidCredentialsException("Invalid credentials");
        }

        $user->ensureCanLogin();

        $token = $this->tokenService->generateToken($dto->email, $dto->password);

        return new AuthResultDTO(
            user: $user,
            accessToken: $token['access_token'],
            refreshToken: $token['refresh_token'],
        );
    }
}
