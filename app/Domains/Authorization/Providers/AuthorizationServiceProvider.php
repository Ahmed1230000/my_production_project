<?php

namespace App\Domains\Authorization\Providers;

use App\Domains\Authorization\Console\Commands\syncRoleAndPermissionCommand;
use App\Domains\Authorization\Policies\PermissionPolicy;
use App\Domains\Authorization\Policies\RolePolicy;
use App\Domains\Authorization\Repositories\Contracts\{
    PermissionRepositoryInterface,
    RoleRepositoryInterface
};
use App\Domains\Authorization\Repositories\Eloquent\{
    SpatiePermissionRepository,
    SpatieRoleRepository
};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthorizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            RoleRepositoryInterface::class,
            SpatieRoleRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            SpatiePermissionRepository::class
        );
    }

    public function boot()
    {
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        if ($this->app->runningInConsole()) {
            $this->commands([
                syncRoleAndPermissionCommand::class,
            ]);
        }
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
