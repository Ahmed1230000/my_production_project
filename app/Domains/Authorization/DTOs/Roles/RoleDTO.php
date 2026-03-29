<?php

namespace App\Domains\Authorization\DTOs\Roles;


use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;

class RoleDTO
{
    private ?RoleIdVO $id;
    private RoleNameVO $name;

    public function __construct(?RoleIdVO $id, RoleNameVO $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?RoleIdVO
    {
        return $this->id;
    }

    public function getName(): RoleNameVO
    {
        return $this->name;
    }
}
