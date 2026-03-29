<?php

namespace Tests\Unit;

use App\Domains\Auth\DTOs\LoginUserDTO;
use App\Domains\Auth\Exceptions\EmailNotVerifiedException;
use App\Domains\Auth\Exceptions\InvalidCredentialsException;
use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;
use App\Domains\Auth\Repositories\Contracts\HashServiceInterface;
use App\Domains\Auth\UseCases\LoginUseCase;
use App\Domains\User\Entities\UserEntity;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use Mockery;
use PHPUnit\Framework\TestCase;

class LoginUseCaseTest extends TestCase
{
    public  $useCase;
    public $userRepositoryInterface;
    public $authTokenServiceInterface;

    public $hashServiceInterface;


    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterface = Mockery::mock(UserRepositoryInterface::class);
        $this->authTokenServiceInterface = Mockery::mock(AuthTokenServiceInterface::class);
        $this->hashServiceInterface = Mockery::mock(HashServiceInterface::class);

        $this->useCase = new LoginUseCase($this->userRepositoryInterface, $this->authTokenServiceInterface, $this->hashServiceInterface);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    public function test_login_fails_when_user_not_found(): void
    {
        $this->userRepositoryInterface->shouldReceive('findByEmail')
            ->once()
            ->andReturn(null);

        $this->expectException(InvalidCredentialsException::class);

        $dto = new LoginUserDTO('admin@system.com', 'password');

        $this->useCase->execute($dto);
    }

    public function test_login_fails_with_inactive_user(): void
    {
        $userMockery = Mockery::mock(User::class);
        $this->userRepositoryInterface->shouldReceive('findByEmail')
            ->once()
            ->andReturn(new UserEntity(
                id: 1,
                name: 'Admin',
                email: 'admin@system.com',
                password: 'password',
                status: 'active',
                emailVerifiedAt: now(),
            ));

        $this->hashServiceInterface->shouldReceive('check')
            ->once()
            ->andReturn(true);

        $this->authTokenServiceInterface->shouldReceive('generateToken')
            ->once()
            ->andReturn('auth_token');

        $this->userRepositoryInterface->shouldReceive('findByEmailWithRolesAndPermissions')
            ->once()
            ->andReturn($userMockery);

        $result = $this->useCase->execute(new LoginUserDTO('admin@system.com', 'password'));

        $this->assertEquals('auth_token', $result->accessToken);
        $this->assertEquals($userMockery, $result->userModel);
    }
}
