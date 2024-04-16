<?php

namespace App\Providers;

use App\Models\Movie;
use App\Observers\MovieObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Movie::observe(MovieObserver::class);
    }
}
