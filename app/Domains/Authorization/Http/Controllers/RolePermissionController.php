<?php

namespace App\Domains\Authorization\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use Throwable;

use App\Domains\Authorization\Http\Requests\RoleAndPermissionsFormRequest\{
    AddPermissionsFormRequest,
    RemovePermissionsFormRequest
};

use App\Domains\Authorization\Http\Resources\RoleResource;

use App\Domains\Authorization\UseCases\PermissionsToRoleUseCases\{
    AddPermissionsToRoleUseCase,
    RemovePermissionsFromRoleUseCase
};
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private AddPermissionsToRoleUseCase $addPermissionsToRoleUseCase,
        private RemovePermissionsFromRoleUseCase $removePermissionsFromRoleUseCase,
    ) {}

    public function add(AddPermissionsFormRequest $request, int $roleId)
    {
        try {
            $role = $this->addPermissionsToRoleUseCase->execute(
                $roleId,
                $request->permissions
            );

            return $this->apiResponse(
                new RoleResource($role),
                'Permissions added successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function remove(RemovePermissionsFormRequest $request, int $roleId)
    {
        try {
            $role = $this->removePermissionsFromRoleUseCase->execute(
                $roleId,
                $request->permissions
            );

            return $this->apiResponse(
                new RoleResource($role),
                'Permissions removed successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }
}
