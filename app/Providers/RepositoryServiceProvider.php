<?php

namespace App\Providers;

use App\Repositories\Interfaces\Refactoring\BannerRepositoryInterface;
use App\Repositories\Interfaces\Refactoring\InvoiceRepositoryInterface;
use App\Repositories\Refactoring\BannerRepository;
use App\Repositories\Refactoring\InvoiceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InvoiceRepositoryInterface::class,InvoiceRepository::class);
        $this->app->bind(BannerRepositoryInterface::class,BannerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
