<?php

namespace App\Domains\Organizations\Providers;

use App\Domains\Organizations\Repositories\Contracts\OrganizationRepositoryInterface;
use App\Domains\Organizations\Repositories\Eloquent\EloquentOrganizationRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class OrganizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void 
    {
        $this->app->bind(
            OrganizationRepositoryInterface::class,
            EloquentOrganizationRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
