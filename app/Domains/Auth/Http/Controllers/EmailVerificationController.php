<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\Auth\DTOs\VerifyEmailDTO;
use App\Domains\Auth\Http\Requests\EmailVerificationFormRequest;
use Illuminate\Http\Request;
use App\Domains\Auth\UseCases\VerifyEmailUseCase;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private VerifyEmailUseCase $verifyEmailUseCase
    ) {}

    public function verify(Request $request)
    {
        try {
            $dto = new VerifyEmailDTO(
                userId: (int) $request->route('id'),
                hash: (string) $request->route('hash'),
                request: $request
            );

            $this->verifyEmailUseCase->execute($dto);

            return $this->apiResponse(
                data: null,
                message: 'Email verified successfully.'
            );
        } catch (\Throwable $e) {

            $this->logMessage(
                'Email verification failed',
                ['error' => $e->getMessage()],
                'error'
            );

            return $this->apiResponse(
                data: null,
                message: 'Email verification failed.',
                statusCode: 400
            );
        }
    }
}
