<?php

namespace App\Domains\Authorization\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('role-index');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('role-show');
    }

    public function create(User $user): bool
    {
        return $user->can('role-store');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('role-update');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('role-delete');
    }
}
