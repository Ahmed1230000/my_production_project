<?php

namespace App\Domains\Authorization\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('permission-index');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->can('permission-show');
    }

    public function create(User $user): bool
    {
        return $user->can('permission-store');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->can('permission-update');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->can('permission-delete');
    }
}
