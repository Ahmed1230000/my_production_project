<?php

namespace App\Domains\Authorization\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use Throwable;

use App\Domains\Authorization\DTOs\Roles\RoleDTO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;
use App\Domains\Authorization\Http\Requests\RoleFormRequest\{
    StoreRoleFormRequest,
    UpdateRoleFormRequest
};
use App\Domains\Authorization\Http\Resources\RoleResource;

use App\Domains\Authorization\UseCases\RolesUseCases\{
    CreateRoleUseCase,
    UpdateRoleUseCase,
    DeleteRoleUseCase,
    ListRolesUseCase,
    GetRoleByIdUseCase
};
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private CreateRoleUseCase $createRoleUseCase,
        private UpdateRoleUseCase $updateRoleUseCase,
        private DeleteRoleUseCase $deleteRoleUseCase,
        private ListRolesUseCase $listRolesUseCase,
        private GetRoleByIdUseCase $getRoleByIdUseCase,
    ) {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        try {
            $roles = $this->listRolesUseCase->execute();

            return $this->apiResponse(
                RoleResource::collection(collect($roles)),
                'Roles retrieved successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage());
            return $this->apiResponse(null, 'Failed to retrieve roles', 500);
        }
    }

    public function store(StoreRoleFormRequest $request)
    {
        try {
            $dto = new RoleDTO(
                null,
                new RoleNameVO($request->name)
            );

            $role = $this->createRoleUseCase->execute($dto);

            return $this->apiResponse(
                new RoleResource($role),
                'Role created successfully',
                201
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function show(int $id)
    {
        try {
            $role = $this->getRoleByIdUseCase->execute(
                new RoleIdVO($id)
            );

            return $this->apiResponse(
                new RoleResource($role),
                'Role retrieved successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage());
            return $this->apiResponse(null, $e->getMessage(), 404);
        }
    }

    public function update(UpdateRoleFormRequest $request, int $id)
    {
        try {
            $dto = new RoleDTO(
                new RoleIdVO($id),
                new RoleNameVO($request->name)
            );

            $role = $this->updateRoleUseCase->execute($dto);

            return $this->apiResponse(
                new RoleResource($role),
                'Role updated successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage().$e->getFile().$e->getLine());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deleteRoleUseCase->execute(
                new RoleIdVO($id)
            );

            return $this->apiResponse(null, 'Role deleted successfully');
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }
}
