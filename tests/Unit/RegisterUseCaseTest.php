<?php

namespace Tests\Unit;

use App\Domains\Auth\DTOs\RegisterUserDTO;
use App\Domains\Auth\Events\UserRegisteredEvent;
use App\Domains\Auth\Repositories\Contracts\EventDispatcherInterface;
use App\Domains\Auth\UseCases\RegisterUseCase;
use App\Domains\Auth\ValueObjects\EmailVO;
use App\Domains\Auth\ValueObjects\PasswordVO;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class RegisterUseCaseTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_can_register_successfully(): void
    {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class);

        $userRepository->shouldReceive('findByEmail')
            ->once()
            ->andReturn(null);

        $userRepository->shouldReceive('create')
            ->once()
            ->andReturnUsing(fn($userEntity) => $userEntity);

        $eventDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Mockery::type(UserRegisteredEvent::class));

        $useCase = new RegisterUseCase($userRepository, $eventDispatcher);

        $dto = new RegisterUserDTO(
            'Admin',
            new EmailVO('ahmed@gmail.com'),
            new PasswordVO('Ahmed123!@#')
        );

        $result = $useCase->execute($dto);

        $this->assertInstanceOf(\App\Domains\User\Entities\UserEntity::class, $result);
        $this->assertEquals('ahmed@gmail.com', $result->email);

        $this->assertNotEquals('Ahmed123!@#', $result->password);
    }
}
