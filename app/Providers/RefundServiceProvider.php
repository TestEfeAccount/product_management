<?php

namespace App\Providers;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Factories\RefundStrategyFactory;
use App\Interfaces\ProductServiceInterface;
use App\Interfaces\LedgerServiceInterface;

class RefundServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RefundStrategyFactory::class, function ($app) {
            return new RefundStrategyFactory(
                $app->make(ProductServiceInterface::class),
                $app->make(LedgerServiceInterface::class),
                $app->make(OrderServiceInterface::class),
            );
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
    }
}
