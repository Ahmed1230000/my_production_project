<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\Auth\DTOs\ForgotPasswordDTO;
use App\Domains\Auth\DTOs\ResetPasswordDTO;
use App\Domains\Auth\Http\Requests\ForgetPasswordFormRequest;
use App\Domains\Auth\Http\Requests\ResetPasswordFormRequest;
use App\Domains\Auth\UseCases\ForgotPasswordUseCase;
use App\Domains\Auth\UseCases\ResetPasswordUseCase;
use App\Domains\Auth\ValueObjects\EmailVO;
use App\Domains\Auth\ValueObjects\PasswordVO;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private ForgotPasswordUseCase $forgotUseCase,
        private ResetPasswordUseCase $resetUseCase
    ) {}

    public function forgot(ForgetPasswordFormRequest $request)
    {
        try {
            $emailVO = new EmailVO($request->validated()['email']);

            $dto = new ForgotPasswordDTO(
                email: $emailVO
            );

            $this->forgotUseCase->execute($dto);

            return $this->apiResponse(
                null,
                'If your email exists, a reset link has been sent.'
            );
        } catch (\Throwable $e) {

            $this->logMessage(
                'Forgot password failed',
                ['error' => $e->getMessage()],
                'error'
            );

            return $this->apiResponse(
                null,
                'Unable to process request.',
                400
            );
        }
    }

    public function reset(ResetPasswordFormRequest $request)
    {
        try {
            $emailVO = new EmailVO($request->validated()['email']);
            $passwordVO = new PasswordVO($request->validated()['password']);

            $dto = new ResetPasswordDTO(
                email: $emailVO,
                token: $request->validated()['token'],
                password: $passwordVO
            );

            $this->resetUseCase->execute($dto);

            return $this->apiResponse(
                null,
                'Password reset successfully.'
            );
        } catch (\Throwable $e) {

            $this->logMessage(
                'Reset password failed',
                ['error' => $e->getMessage()],
                'error'
            );

            return $this->apiResponse(
                null,
                'Unable to reset password.',
                400
            );
        }
    }
}
