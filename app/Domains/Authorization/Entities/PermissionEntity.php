<?php

namespace App\Domains\Authorization\Entities;

use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;

class PermissionEntity
{
    private ?PermissionIdVO $id;
    private PermissionNameVO $name;

    private function __construct(
        ?PermissionIdVO $id,
        PermissionNameVO $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): ?PermissionIdVO
    {
        return $this->id;
    }

    public function name(): PermissionNameVO
    {
        return $this->name;
    }

    public static function create(PermissionNameVO $name): self
    {
        return new self(null, $name);
    }

    public static function reconstitute(
        PermissionIdVO $id,
        PermissionNameVO $name
    ): self {
        return new self($id, $name);
    }

    public function rename(PermissionNameVO $newName): void
    {
        if ($this->name->getName() === $newName->getName()) {
            return;
        }
        $this->name = $newName;
    }
}
