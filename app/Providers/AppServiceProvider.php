<?php

namespace App\Providers;

use App\Contracts\AuthRepoInterface;
use App\Contracts\ProductRepoInterface;
use App\Repositories\AuthRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepoInterface::class, ProductRepository::class);
        $this->app->bind(AuthRepoInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
