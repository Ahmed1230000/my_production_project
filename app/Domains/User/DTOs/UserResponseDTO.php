<?php

namespace App\Domains\User\DTOs;

class UserResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public \DateTime $created_at,
        public \DateTime $updated_at,
        public array $roles,
        public array $permissions
    ) {}


   public function toArray(): array
{
    return array_filter([
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        'roles' => $this->roles,
        'permissions' => $this->permissions,
    ], fn($value) => $value !== null);
}
}
