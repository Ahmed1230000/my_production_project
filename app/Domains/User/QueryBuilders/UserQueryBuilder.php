<?php

namespace App\Domains\User\QueryBuilders;

use App\Infrastructure\QueryBuilder\BaseQueryBuilder;
use App\Models\User;

class UserQueryBuilder extends BaseQueryBuilder
{
    protected string $model = User::class;

    protected array $allowedIncludes = [
        'roles',
        'permissions',
    ];

    protected array $allowedFilters = [
        'name',
        'email',
    ];

    protected array $allowedSorts = [
        'name',
        'email',
    ];
}
