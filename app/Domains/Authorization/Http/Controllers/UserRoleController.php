<?php

namespace App\Domains\Authorization\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use Throwable;

use App\Domains\Authorization\Http\Requests\RoleAndUserFormRequest\{
    AssignRolesToUserRequest,
    RemoveRolesFromUserRequest
};

use App\Domains\User\Http\Resources\UserResource;

use App\Domains\Authorization\UseCases\RoleAndUserUseCases\{
    AssignRoleToUserUseCase,
    RemoveRoleToUserUseCase
};

use App\Domains\Authorization\DTOs\Roles\{
    RoleToUserDTO,
    RemoveRolesFromUserDTO
};
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Http\Controllers\Controller;

class UserRoleController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private AssignRoleToUserUseCase $assignRoleToUserUseCase,
        private RemoveRoleToUserUseCase $removeRoleToUserUseCase,
    ) {}

    public function assign(AssignRolesToUserRequest $request, int $userId)
    {
        try {

            $roleVOs = array_map(
                fn($roleId) => new RoleIdVO($roleId),
                $request->roles
            );

            $dto = new RoleToUserDTO(
                userId: $userId,
                roleIds: $roleVOs
            );

            $user = $this->assignRoleToUserUseCase->execute($dto);

            return $this->apiResponse(
                $user->toArray(),
                'Roles assigned successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());

            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function remove(RemoveRolesFromUserRequest $request, int $userId)
    {
        try {

            $roleVOs = array_map(
                fn($roleId) => new RoleIdVO($roleId),
                $request->roles
            );


            $dto = new RemoveRolesFromUserDTO(
                userId: $userId,
                roleIds: $roleVOs
            );

            $user = $this->removeRoleToUserUseCase->execute($dto);

            return $this->apiResponse(
                $user->toArray(),
                'Roles removed successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());

            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }
}
