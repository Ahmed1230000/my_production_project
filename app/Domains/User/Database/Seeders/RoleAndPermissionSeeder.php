<?php

namespace App\Domains\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Summary of GUARD_NAME
     * @var string
     */
    const GUARD_NAME = 'api';

    const INDEX = 'index';
    const STORE = 'store';
    const SHOW = 'show';
    const UPDATE = 'update';
    const DELETE = 'delete';

    public $roles =
    [
        'admin',
        'vendor',
        'customer'
    ];

    public $permissions =
    [
        'user',
        'product',
        'order',
        'role',
        'permission'
    ];
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $this->createRoles();
        $this->createPermissions();
        $this->assignPermissionsToRoles();
        $this->assignPermissionsToUser();
        $this->assignRoleToUser();
    }

    public function createRoles()
    {
        foreach ($this->roles as $role) {
            Role::findOrCreate($role, self::GUARD_NAME);
        }
    }

    public function createPermissions()
    {
        foreach ($this->permissions as $permission) {
            foreach (
                [
                    self::INDEX,
                    self::STORE,
                    self::SHOW,
                    self::UPDATE,
                    self::DELETE,
                ] as $action
            ) {
                $permissionName = $permission . '-' . $action;
                Permission::findOrCreate($permissionName, self::GUARD_NAME);
            }
        }
    }

    public function assignPermissionsToRoles()
    {
        foreach ($this->roles as $roleName) {
            $role = Role::findByName($roleName, self::GUARD_NAME);

            foreach ($this->permissions as $permission) {
                foreach ([self::INDEX, self::STORE, self::SHOW, self::UPDATE, self::DELETE] as $action) {

                    $permissionName = $permission . '-' . $action;

                    $perm = Permission::findByName($permissionName, self::GUARD_NAME);

                    $role->givePermissionTo($perm);
                }
            }
        }
    }

    public function assignPermissionsToUser()
    {
        $user = User::where('email', 'admin@system.com')->first();
        foreach ($this->permissions as $permission) {
            foreach ([self::INDEX, self::STORE, self::SHOW, self::UPDATE, self::DELETE] as $action) {

                $permissionName = $permission . '-' . $action;

                $perm = Permission::findByName($permissionName, self::GUARD_NAME);

                $user->givePermissionTo($perm);

            }
        }
    }
    public function assignRoleToUser()
    {
        $user = User::find(1);
        if ($user) {
            foreach ($this->roles as $roleName) {
                $role = Role::findByName($roleName, self::GUARD_NAME);
                $user->assignRole($role);
            }
        }
    }
}
