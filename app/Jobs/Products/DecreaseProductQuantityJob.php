<?php

namespace App\Jobs\Products;

use App\Services\Contracts\ProductServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DecreaseProductQuantityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $products;
    protected $productService;

    public function __construct($products, ProductServiceContract $productService)
    {
        $this->products = $products;
        $this->productService = $productService;
    }

    public function handle()
    {
        foreach ($this->products as $product) {
            $this->productService->decreaseQuantity($product['id'], $product['quantity']);
        }
    }
}
