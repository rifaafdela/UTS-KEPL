<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\MovieRepositoryInterface;
use App\Repositories\MovieRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }

    public function boot(): void
    {
        //
    }
}