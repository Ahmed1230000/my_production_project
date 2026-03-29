<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\Auth\UseCases\RefreshTokenUseCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefreshTokenController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private RefreshTokenUseCase $refreshTokenUseCase
    ) {}

    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->input('refresh_token');

            if (!$refreshToken) {
                return $this->apiResponse(
                    null,
                    'Refresh token is required',
                    400
                );
            }

            $data = $this->refreshTokenUseCase->execute($refreshToken);

            return $this->apiResponse(
                $data,
                'Token refreshed successfully'
            );
        } catch (\Throwable $e) {

            $this->logMessage(
                'Refresh token failed',
                ['error' => $e->getMessage()],
                'error'
            );

            return $this->apiResponse(
                null,
                'Unable to refresh token',
                401
            );
        }
    }
}
