<?php

namespace App\Domains\Organizations\Http\Controllers\OrganizationControllers;

use App\Common\Traits\ApiResponse;
use App\Common\Traits\LogMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\Domains\Organizations\Http\Requests\OrganizationRequests\{
    StoreOrganizationFormRequest,
    UpdateOrganizationFormRequest
};

use App\Domains\Organizations\DTOs\OrganizationDTOs\OrganizationDTO;
use App\Domains\Organizations\UseCases\OrganizationUseCases\{
    CreateOrganizationUseCase,
    UpdateOrganizationUseCase,
    DeleteOrganizationUseCase
};
use App\Domains\Organizations\ValueObjects\OrganizationVO\{
    OrganizationIdVO,
    OrganizationNameVO,
    OrganizationSlugVO
};
use App\Domains\Organizations\Http\Resources\{
    OrganizationResource,
    OrganizationReadResource
};
use App\Infrastructure\QueryBuilder\Organizations\OrganizationQueryBuilder;

class OrganizationController extends Controller
{
    use ApiResponse, LogMessage;

    public function __construct(
        private CreateOrganizationUseCase $createOrganizationUseCase,
        private UpdateOrganizationUseCase $updateOrganizationUseCase,
        private DeleteOrganizationUseCase $deleteOrganizationUseCase,
        private OrganizationQueryBuilder $organizationQueryBuilder
    ) {}

    public function index()
    {
        try {
            $organizations = $this->organizationQueryBuilder
                ->forCurrentUser()
                ->paginate();

            return  OrganizationReadResource::collection($organizations);
        } catch (\Throwable $e) {
            $this->logMessage('Fetch Organizations Failed', [
                'error' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                null,
                'Something went wrong' . ' ' . $e->getMessage() . '' . $e->getFile() . ' ' . $e->getLine(),
                500
            );
        }
    }


    public function store(StoreOrganizationFormRequest $request): JsonResponse
    {
        try {
            $dto = new OrganizationDTO(
                id: null,
                name: new OrganizationNameVO($request->input('name')),
                slug: null,
                description: $request->input('description'),
                owner_id: auth()->id(),
            );

            $result = $this->createOrganizationUseCase->execute($dto);

            return $this->apiResponse(
                new OrganizationResource($result),
                'Organization created successfully',
                201
            );
        } catch (\Throwable $e) {
            $this->logMessage('Create Organization Failed', [
                'error' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                null,
                'Something went wrong' . ' ' . $e->getMessage() . '' . $e->getFile() . ' ' . $e->getLine(),
                500
            );
        }
    }
    public function show($id)
    {
        try {
            $organizations = $this->organizationQueryBuilder->findForCurrentUserOrFail($id);

            return $this->apiResponse(
                OrganizationReadResource::make($organizations),
                'Organizations retrieved successfully',
                200
            );
        } catch (\Throwable $e) {
            $this->logMessage('Fetch Organizations Failed', [
                'error' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                null,
                'Something went wrong' . ' ' . $e->getMessage() . '' . $e->getFile() . ' ' . $e->getLine(),
                500
            );
        }
    }
    public function update(UpdateOrganizationFormRequest $request, $id): JsonResponse
    {
        try {
            $dto = new OrganizationDTO(
                id: new OrganizationIdVO($id),
                name: new OrganizationNameVO($request->validated()['name']),
                slug: null,
                description: $request->validated()['description'] ?? null,
                owner_id: auth()->id(),
            );

            $result = $this->updateOrganizationUseCase->execute($dto);

            return $this->apiResponse(
                new OrganizationResource($result),
                'Organization updated successfully',
                200
            );
        } catch (\Throwable $e) {
            $this->logMessage('Update Organization Failed', [
                'error' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                null,
                'Something went wrong' . ' ' . $e->getMessage() . '' . $e->getFile() . ' ' . $e->getLine(),
                500
            );
        }
    }
    public function destroy($id)
    {
        try {
            $idVO = new OrganizationIdVO($id);
            $this->deleteOrganizationUseCase->execute($idVO);

            return $this->apiResponse(
                null,
                'Organization deleted successfully',
                200
            );
        } catch (\Throwable $e) {
            $this->logMessage('Delete Organization Failed', [
                'error' => $e->getMessage()
            ], 'error');

            return $this->apiResponse(
                null,
                'Something went wrong' . ' ' . $e->getMessage() . '' . $e->getFile() . ' ' . $e->getLine(),
                500
            );
        }
    }
}
