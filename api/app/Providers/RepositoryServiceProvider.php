<?php

namespace App\Providers;

use App\Repositories\{
    Users\UserRepository,
    Users\UserRepositoryInterface,
    Movies\MovieRepository,
    Movies\MovieRepositoryInterface
};

use App\Services\{
    Auth\AuthService,
    Auth\AuthServiceInterface,
    Movies\MovieService,
    Movies\MovieServiceInterface,
    TheMovieDB\TheMovieDBService,
    TheMovieDB\TheMovieDBServiceInterface,
    Users\UserService,
    Users\UserServiceInterface,
};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class,
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class,
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            MovieServiceInterface::class,
            MovieService::class,
        );

        $this->app->bind(
            MovieRepositoryInterface::class,
            MovieRepository::class,
        );

        $this->app->bind(
            TheMovieDBServiceInterface::class,
            TheMovieDBService::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
