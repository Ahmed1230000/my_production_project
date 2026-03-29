<?php

namespace App\Domains\Authorization\Http\Controllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;
use Throwable;

use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;

use App\Domains\Authorization\Http\Requests\PermissionFormRequest\{
    StorePermissionFormRequest,
    UpdatePermissionFormRequest
};

use App\Domains\Authorization\Http\Resources\PermissionResource;

use App\Domains\Authorization\UseCases\PermissionsUseCases\{
    CreatePermissionUseCase,
    UpdatePermissionUseCase,
    DeletePermissionUseCase,
    ListPermissionsUseCase,
    GetPermissionByIdUseCase
};
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private CreatePermissionUseCase $createPermissionUseCase,
        private UpdatePermissionUseCase $updatePermissionUseCase,
        private DeletePermissionUseCase $deletePermissionUseCase,
        private ListPermissionsUseCase $listPermissionsUseCase,
        private GetPermissionByIdUseCase $getPermissionByIdUseCase,
    ) {
        $this->authorizeResource(Permission::class, 'permission');
    }

    public function index()
    {
        try {
            $permissions = $this->listPermissionsUseCase->execute();

            return $this->apiResponse(
                PermissionResource::collection(collect($permissions)),
                'Permissions retrieved successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage());
            return $this->apiResponse(null, 'Failed to retrieve permissions', 500);
        }
    }

    public function store(StorePermissionFormRequest $request)
    {
        try {
            $permission = $this->createPermissionUseCase->execute(
                $request->name
            );

            return $this->apiResponse(
                new PermissionResource($permission),
                'Permission created successfully',
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
            $permission = $this->getPermissionByIdUseCase->execute($id);

            return $this->apiResponse(
                new PermissionResource($permission),
                'Permission retrieved successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage());
            return $this->apiResponse(null, $e->getMessage(), 404);
        }
    }

    public function update(UpdatePermissionFormRequest $request, int $id)
    {
        try {
            $permission = $this->updatePermissionUseCase->execute(
                $id,
                $request->name
            );

            return $this->apiResponse(
                new PermissionResource($permission),
                'Permission updated successfully'
            );
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage() . $e->getFile() . $e->getLine());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deletePermissionUseCase->execute($id);

            return $this->apiResponse(null, 'Permission deleted successfully');
        } catch (Throwable $e) {
            $this->logMessage($e->getMessage());
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }
}
