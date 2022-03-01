<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepositoryContract;
use App\Repositories\Cart\CartRepositoryCaching;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryEloquent;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Repositories\Transaction\TransactionRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentMethodRepositoryContract::class, PaymentMethodRepositoryEloquent::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepositoryEloquent::class);
        $this->app->bind(CartRepositoryContract::class, CartRepositoryCaching::class);
        $this->app->bind(TransactionRepositoryContract::class, TransactionRepositoryEloquent::class);
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
