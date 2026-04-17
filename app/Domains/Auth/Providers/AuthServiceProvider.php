<?php

namespace App\Domains\Auth\Providers;

use App\Domains\Auth\Listeners\SendEmailVerificationListener;
use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;
use App\Domains\Auth\Repositories\Contracts\EmailVerificationServiceInterface;
use App\Domains\Auth\Repositories\Contracts\EventDispatcherInterface;
use App\Domains\Auth\Repositories\Contracts\HashServiceInterface;
use App\Domains\Auth\Repositories\Contracts\PasswordResetServiceInterface;
use App\Domains\Auth\Repositories\Eloquent\LaravelEventDispatcher;
use App\Domains\Auth\Services\CustomHashService;
use App\Domains\Auth\Services\LaravelEmailVerificationService;
use App\Domains\Auth\Services\LaravelPasswordResetService;
use App\Domains\Auth\Services\PassportTokenService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AuthTokenServiceInterface::class,
            PassportTokenService::class
        );
        $this->app->bind(
            EmailVerificationServiceInterface::class,
            LaravelEmailVerificationService::class
        );

        $this->app->bind(
            PasswordResetServiceInterface::class,
            LaravelPasswordResetService::class
        );

        $this->app->bind(
            EventDispatcherInterface::class,
            LaravelEventDispatcher::class
        );

        $this->app->bind(
            HashServiceInterface::class,
            CustomHashService::class
        );
    }

    public function boot(): void
    {
        Passport::enablePasswordGrant();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Routes/api.php');

        Passport::tokensExpireIn(now()->addMinutes(3));
        Passport::refreshTokensExpireIn(now()->addDays(7));
        Event::subscribe(SendEmailVerificationListener::class);

        Passport::tokensExpireIn(now()->addDays(30));
        Passport::refreshTokensExpireIn(now()->addDays(60));
    }
}
