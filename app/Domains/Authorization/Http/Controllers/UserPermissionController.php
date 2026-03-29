<?php

namespace App\Domains\Authorization\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use Throwable;

use App\Domains\Authorization\Http\Requests\PermissionsAndUserFormRequest\{
    AssignPermissionsToUserRequest,
    RemovePermissionsFromUserRequest
};

use App\Domains\User\Http\Resources\UserResource;

use App\Domains\Authorization\UseCases\PermissionAndUserUseCases\{
    AssignPermissionToUserUseCase,
    RemovePermissionFromUserUseCase
};

use App\Domains\Authorization\DTOs\Permissions\{
    PermissionToUserDTO,
    RemovePermissionsFromUserDTO
};

use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Http\Controllers\Controller;

class UserPermissionController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private AssignPermissionToUserUseCase $assignPermissionToUserUseCase,
        private RemovePermissionFromUserUseCase $removePermissionFromUserUseCase,
    ) {}

    public function assign(AssignPermissionsToUserRequest $request, int $userId)
    {
        try {

            $permissionVOs = array_map(
                fn($permissionId) => new PermissionIdVO($permissionId),
                $request->permissions
            );

            $dto = new PermissionToUserDTO(
                userId: $userId,
                permissionIds: $permissionVOs
            );

            $user = $this->assignPermissionToUserUseCase->execute($dto);

            return $this->apiResponse(
                $user->toArray(),
                'Permissions assigned successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());

            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function remove(RemovePermissionsFromUserRequest $request, int $userId)
    {
        try {

            $permissionVOs = array_map(
                fn($permissionId) => new PermissionIdVO($permissionId),
                $request->permissions
            );

            $dto = new RemovePermissionsFromUserDTO(
                userId: $userId,
                permissionIds: $permissionVOs
            );

            $user = $this->removePermissionFromUserUseCase->execute($dto);

            return $this->apiResponse(
                $user->toArray(),
                'Permissions removed successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());

            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }
}
