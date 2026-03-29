<?php

namespace App\Domains\User\Entities;

class UserEntity
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?int $id = null,
        public ?string $status = 'pending',
        public ?string $emailVerifiedAt = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public array $roles = [],
        public array $permissions = []


    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function activate(): void
    {
        $this->status = 'active';
    }

    public function suspend(): void
    {
        $this->status = 'suspended';
    }

    public function getEmailVerifiedAt()
    {
        $this->emailVerifiedAt = now();
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
