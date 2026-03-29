<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\Auth\UseCases\LogoutUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private LogoutUseCase $logoutUseCase
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $this->logoutUseCase->execute($userId);

            return $this->apiResponse(
                null,
                'User logged out successfully',
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {

            $this->logMessage('Logout failed', [
                'exception' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                null,
                'Something went wrong',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
