<?php

namespace App\Common\Providers;

use App\Domains\User\Providers\UserServiceProvider;
use App\Domains\Auth\Providers\AuthServiceProvider;
use App\Domains\Authorization\Providers\AuthorizationServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainsServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(AuthorizationServiceProvider::class);
    }

    public function boot(): void {}
}
