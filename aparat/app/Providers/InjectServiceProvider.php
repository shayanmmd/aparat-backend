<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Interfaces\Services\Email\EmailServiceInterface;
use App\Interfaces\User\UserRespositoryInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\User\UserRespository;
use App\Services\Email\EmailService;
use Illuminate\Support\ServiceProvider;

class InjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRespositoryInterface::class, UserRespository::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
    }
}
