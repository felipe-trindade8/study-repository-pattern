<?php

namespace App\Services\Contracts;

interface CartServiceContract
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
