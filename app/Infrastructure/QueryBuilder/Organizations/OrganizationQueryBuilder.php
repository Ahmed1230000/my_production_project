<?php

namespace App\Infrastructure\QueryBuilder\Organizations;

use App\Infrastructure\QueryBuilder\BaseQueryBuilder;
use App\Models\Organization;


class OrganizationQueryBuilder extends BaseQueryBuilder
{
    protected string $model = Organization::class;

    protected array $allowedIncludes = [
        'owner',
    ];

    protected array $allowedFilters = [
        'name',
        'slug',
        'description',
        'owner_id',
    ];

    protected array $allowedSorts = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function forCurrentUser()
    {
        return $this->spatie()
            ->where('owner_id', auth()->id());
    }

    public function findForCurrentUserOrFail($id)
    {
        return $this->spatie()
            ->where('owner_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
    }
}
