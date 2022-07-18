<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ICategoryRepo;
use App\Data\CategoryRepo;
use App\Data\CommentRepo;
use App\Data\LikeRepo;
use App\Interfaces\ICommentRepo;
use App\Interfaces\ILikeRepo;

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
