<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\Auth\DTOs\RegisterUserDTO;
use App\Domains\Auth\Http\Requests\RegisterFormRequest;
use App\Domains\Auth\UseCases\RegisterUseCase;
use App\Domains\Auth\ValueObjects\EmailVO;
use App\Domains\Auth\ValueObjects\PasswordVO;
use App\Domains\User\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use ApiResponse, LogMessage;
    /**
     * Handle the incoming request.
     */

    public function __construct(private RegisterUseCase $registerUseCase) {}
    public function __invoke(RegisterFormRequest $request)
    {
        try {
            $dto = new RegisterUserDTO(
                name: $request->validated()['name'],
                email: new EmailVO($request->validated()['email']),
                password: new PasswordVO($request->validated()['password']),
            );
            $user = $this->registerUseCase->execute($dto);
            return $this->apiResponse(
                UserResource::make($user),
                'User registered successfully',
                201,
            );
        } catch (\Throwable $e) {
            $this->logMessage('Register failed', [
                'exception' => $e
            ], 'error');
            return $this->apiResponse('Failed to register user' . $e->getMessage(), 500);
        }
    }
}
