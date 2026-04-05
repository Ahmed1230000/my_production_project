<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\Auth\DTOs\LoginUserDTO;
use App\Domains\Auth\Exceptions\EmailNotVerifiedException;
use App\Domains\Auth\Exceptions\InvalidCredentialsException;
use App\Domains\Auth\Http\Requests\LoginFormRequest;
use App\Domains\Auth\UseCases\LoginUseCase;
use App\Domains\Auth\ValueObjects\EmailVO;
use App\Domains\Auth\ValueObjects\PasswordVO;
use App\Domains\User\Http\Resources\UserResource;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    use ApiResponse, LogMessage;
    /**
     * Handle the incoming request.
     */
    public function __construct(
        private LoginUseCase $loginUseCase,
    ) {}
    public function __invoke(LoginFormRequest $request)
    {
        try {
            $dto = new LoginUserDTO(
                email: $request->validated()['email'],
                password: $request->validated()['password'],
            );

            $result = $this->loginUseCase->execute($dto);

            return $this->apiResponse(
                [
                    'user'  => UserResource::make($result->userModel),
                    'token' => $result->accessToken
                ],
                'User logged in successfully',
                200,
            );
        } catch (InvalidCredentialsException $e) {

            return $this->apiResponse(
                $e->getMessage(),
                '',
                401 //
            );
        } catch (EmailNotVerifiedException $e) {

            return $this->apiResponse(
                $e->getMessage(),
                '',
                403
            );
        } catch (\Throwable $e) {

            $this->logMessage('Login failed', [
                'exception' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                'Something went wrong' . ' ' . $e->getMessage(),
                '',
                500
            );
        }
    }
}
