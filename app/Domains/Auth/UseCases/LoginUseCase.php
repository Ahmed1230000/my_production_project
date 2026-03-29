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

        if (!$this->hashService->check($dto->password, $user->password)) {
            throw new InvalidCredentialsException("Invalid credentials");
        }

        if ($user->status !== 'active') {
            throw new EmailNotVerifiedException("Please verify your email");
        }

        if (!$user->emailVerifiedAt) {
            throw new EmailNotVerifiedException("Please verify your email");
        }

        $token = $this->tokenService->generateToken($user->id);
        $model = $this->userRepository->findByEmailWithRolesAndPermissions($dto->email);



        return new AuthResultDTO(
            user: $user,
            accessToken: $token,
            userModel: $model,
        );
    }
}
