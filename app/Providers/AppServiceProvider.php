<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\Contracts\CartServiceContract;
use App\Services\Contracts\PaymentMethodServiceContract;
use App\Services\Contracts\TransactionServiceContract;
use App\Services\Contracts\ValidateCardServiceContract;
use App\Services\PaymentMethodService;
use App\Services\ProductService;
use App\Services\Contracts\ProductServiceContract;
use App\Services\TransactionService;
use App\Services\ValidateCardService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartServiceContract::class, CartService::class);
        $this->app->bind(ValidateCardServiceContract::class, ValidateCardService::class);
        $this->app->bind(PaymentMethodServiceContract::class, PaymentMethodService::class);
        $this->app->bind(TransactionServiceContract::class, TransactionService::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);
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
