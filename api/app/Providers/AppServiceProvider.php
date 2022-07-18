<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ICategoryRepo;
use App\Data\CategoryRepo;

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
