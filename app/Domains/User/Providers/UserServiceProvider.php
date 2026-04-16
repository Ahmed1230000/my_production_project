<?php

namespace App\Domains\User\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void 
    {
        $this->app->bind(
            \App\Domains\User\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Domains\User\Repositories\Eloquent\UserRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
