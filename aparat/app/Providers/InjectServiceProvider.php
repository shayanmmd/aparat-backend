<?php

namespace App\Providers;

use App\Interfaces\Models\Auth\AuthRepositoryInterface;
use App\Interfaces\Models\Channel\ChannelRepositoryInterface;
use App\Interfaces\Models\Playlist\PlaylistRepositoryInterface;
use App\Interfaces\Models\Tag\TagRepositoryInterface;
use App\Interfaces\Services\Email\EmailServiceInterface;
use App\Interfaces\Models\User\UserRespositoryInterface;
use App\Interfaces\Models\Video\VideoRepositoryInterface;
use App\Interfaces\Services\FileUploader\FileUploaderInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Channel\ChannelRepository;
use App\Repositories\Playlist\PlaylistRepository;
use App\Repositories\Tag\TagRepository;
use App\Repositories\User\UserRespository;
use App\Repositories\Video\VideoRepository;
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
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
        $this->app->bind(PlaylistRepositoryInterface::class, PlaylistRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }
}
