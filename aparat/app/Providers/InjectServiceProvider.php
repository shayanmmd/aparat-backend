<?php

namespace App\Providers;

use App\Interfaces\Models\Auth\AuthRepositoryInterface;
use App\Interfaces\Models\Channel\ChannelRepositoryInterface;
use App\Interfaces\Services\Email\EmailServiceInterface;
use App\Interfaces\Models\User\UserRespositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Channel\ChannelRepository;
use App\Repositories\User\UserRespository;
use App\Services\Email\EmailService;
use App\Services\FileUploader\FileUploader;
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
        $this->app->bind(ChannelRepositoryInterface::class, ChannelRepository::class);
        $this->app->bind(FileUploaderInterface::class, FileUploader::class);
    }
}
