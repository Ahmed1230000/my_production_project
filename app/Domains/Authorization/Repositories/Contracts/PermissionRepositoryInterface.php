<?php

namespace App\Domains\Authorization\Repositories\Contracts;

use App\Domains\Authorization\Entities\PermissionEntity;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;

interface PermissionRepositoryInterface
{
    public function save(PermissionEntity $permission): PermissionEntity;

    public function findById(PermissionIdVO $id): ?PermissionEntity;

    public function findByName(PermissionNameVO $name): ?PermissionEntity;

    public function findAll(): array;

    public function delete(PermissionIdVO $id): void;

    /**
     * @param PermissionIdVO[] $ids
     * @return PermissionEntity[]
     */
    public function findManyByIds(array $ids): array;
}
