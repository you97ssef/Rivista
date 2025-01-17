<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ICategoryRepo;
use App\Data\CategoryRepo;
use App\Interfaces\ICommentRepo;
use App\Data\CommentRepo;
use App\Interfaces\ILikeRepo;
use App\Data\LikeRepo;
use App\Data\MediaRepo;
use App\Interfaces\IRivistaRepo;
use App\Data\RivistaRepo;
use App\Interfaces\IUserRepo;
use App\Data\UserRepo;
use App\Interfaces\IMediaRepo;
use App\Interfaces\IMediaService;
use App\Services\MediaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // REPOSITORIES
        $this->app->bind(ICategoryRepo::class, CategoryRepo::class);
        $this->app->bind(ICommentRepo::class, CommentRepo::class);
        $this->app->bind(ILikeRepo::class, LikeRepo::class);
        $this->app->bind(IRivistaRepo::class, RivistaRepo::class);
        $this->app->bind(IUserRepo::class, UserRepo::class);
        $this->app->bind(IMediaRepo::class, MediaRepo::class);

        $this->app->bind(IMediaService::class, MediaService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
