<?php

namespace App\Domains\User\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use App\Domains\User\DTOs\UserDeleteDTO;
use App\Domains\User\UseCases\UserDeleteUseCase;
use App\Domains\User\ValueObjects\UserIdVO;

class UserDeactivateController
{
    use ApiResponse, LogMessage;
    public function __construct(
        private UserDeleteUseCase $useCase
    ) {}
    public function deactivate(int $id)
    {
        try {
            $dto = new UserDeleteDTO(

                id: new UserIdVO($id)

            );
            $this->useCase->execute($dto);

            return $this->apiResponse('', message: "User deleted successfully.", statusCode: 200);
        } catch (\Exception $e) {

            $this->logMessage("Error deleting user: " . $e->getMessage() . '' . $e->getLine() . '' . $e->getFile());

            return $this->apiResponse('', message: $e->getMessage(), statusCode: 500);
        }
    }
}
