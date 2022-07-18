<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ICategoryRepo;
use App\Data\CategoryRepo;
use App\Interfaces\ICommentRepo;
use App\Data\CommentRepo;
use App\Interfaces\ILikeRepo;
use App\Data\LikeRepo;
use App\Interfaces\IRivistaRepo;
use App\Interfaces\RivistaRepo;

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
