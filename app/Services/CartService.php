<?php

namespace App\Services;

use App\Repositories\Cart\CartRepositoryContract;
use App\Services\Contracts\CartServiceContract;

class CartService implements CartServiceContract
{

    protected $cartRepository;

    /**
     * @param CartRepositoryContract $cartRepository
     * @return void
     */
    public function __construct(CartRepositoryContract $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @return array
     */
    public function getCart(): array
    {
        return $this->cartRepository->getCart();
    }

    /**
     * @return float
     */
    public function getCartAmount(): float
    {
        return $this->cartRepository->getCartAmount();
    }

    /**
     * @return void
     */
    public function clearCart(): void
    {
        $this->cartRepository->clearCart();
    }
}
