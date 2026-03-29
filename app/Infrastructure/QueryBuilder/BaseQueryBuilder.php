<?php

namespace App\Infrastructure\QueryBuilder;

use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseQueryBuilder
{
    protected array $allowedIncludes = [];
    protected array $allowedFilters = [];
    protected array $allowedSorts = [];

    protected string $model;

    public function spatie()
    {
        $query =  QueryBuilder::for($this->model);


        if (!empty($this->allowedIncludes)) {
            $query->allowedIncludes($this->allowedIncludes);
        }

        if (!empty($this->allowedFilters)) {
            $query->allowedFilters($this->allowedFilters);
        }

        if (!empty($this->allowedSorts)) {
            $query->allowedSorts($this->allowedSorts);
        }

        return $query;
    }
}
