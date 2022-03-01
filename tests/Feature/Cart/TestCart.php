<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;

class TestCart extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var mixed
     */
    public $cartService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(ProductRepositoryContract::class, ProductRepositoryEloquent::class);
        $this->cartService = app()->make('App\Services\CartService');
    }
}
