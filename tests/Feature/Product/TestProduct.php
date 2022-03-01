<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Services\ProductService;
use App\Services\ProductServiceContract;

class TestProduct extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var mixed
     */
    public $productService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(ProductRepositoryContract::class, ProductRepositoryEloquent::class);
        app()->bind(ProductServiceContract::class, ProductService::class);
        $this->productService = app()->make('App\Services\ProductServiceContract');
    }
}
