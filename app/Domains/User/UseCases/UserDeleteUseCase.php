<?php 

namespace App\Domains\User\UseCases;

use App\Domains\User\DTOs\UserDeleteDTO;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;

class UserDeleteUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(UserDeleteDTO $dto): void
    {
        $user = $this->userRepository->findById($dto->id->value);
        if (!$user) {
            throw new \Exception("User not found");
        }
        $user->deactivate() ;
        $this->userRepository->update($user);
    }
}