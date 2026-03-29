<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\DTOs\RegisterUserDTO;
use App\Domains\Auth\Events\UserRegisteredEvent;
use App\Domains\Auth\Exceptions\UserAlreadyExistsException;
use App\Domains\Auth\Repositories\Contracts\EventDispatcherInterface;
use App\Domains\User\Entities\UserEntity;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;

class RegisterUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(RegisterUserDTO $registerUserDTO): UserEntity
    {
        $existingUser = $this->userRepository->findByEmail($registerUserDTO->email->getEmail());
        if ($existingUser) {
            throw new UserAlreadyExistsException("Email already in use: " . $registerUserDTO->email->getEmail());
        }

        $userEntity = new UserEntity(
            name: $registerUserDTO->name,
            email: $registerUserDTO->email->getEmail(),
            password: $registerUserDTO->password->value(),
            created_at: now(),
            updated_at: now(),
        );

        $user = $this->userRepository->create($userEntity);

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user));

        return $user;
    }
}
