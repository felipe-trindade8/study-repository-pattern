<?php

declare(strict_types=1);

namespace App\Repositories\Cart;

interface CartRepositoryContract
{
    /**
     * @return array
     */
    public function getCart(): array;

    /**
     * @return float
     */
    public function getCartAmount(): float;

    /**
     * @return void
     */
    public function clearCart(): void;
}
