<?php

namespace App\Providers;

use App\Interfaces\BatchServiceInterface;
use App\Interfaces\LedgerServiceInterface;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\RefundServiceInterface;
use App\Interfaces\WarehouseServiceInterface;
use App\Services\BatchService;
use App\Services\LedgerService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\RefundService;
use App\Services\WarehouseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(WarehouseServiceInterface::class, WarehouseService::class);
        $this->app->bind(BatchServiceInterface::class, BatchService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(RefundServiceInterface::class, RefundService::class);
        $this->app->bind(LedgerServiceInterface::class, LedgerService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
