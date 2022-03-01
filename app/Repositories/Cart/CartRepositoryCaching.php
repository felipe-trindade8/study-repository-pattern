<?php

declare(strict_types=1);

namespace App\Repositories\Cart;

use App\Repositories\Cart\CartRepositoryContract;
use App\Repositories\Product\ProductRepositoryContract;
use Illuminate\Support\Facades\Cache;

class CartRepositoryCaching implements CartRepositoryContract
{
    protected $productRepository;
    protected const FIVE_MINUTES_CACHE = 300;

    /**
     * @param ProductRepositoryContract $productRepository
     * @return void
     */
    public function __construct(ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return array
     */
    public function getCart(): array
    {
        return Cache::remember('cart', self::FIVE_MINUTES_CACHE, function () {
            return $this->productRepository->getAllAvailableProducts()->map(function ($product) {
                $product->quantity = 1;
                return $product;
            })->toArray();
        });
    }

    /**
     * @return float
     */
    public function getCartAmount(): float
    {
        return collect(Cache::get('cart'))->sum('price');
    }

    public function clearCart(): void
    {
        Cache::forget('cart');
    }
}
