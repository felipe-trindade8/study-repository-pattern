<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Database\Seeders\ProductsSeeder;

class CartServiceTest extends TestCart
{

    public function test_get_only_available_products()
    {
        // Arrange
        $mockCartShouldReturn = Product::factory()->create([
            'quantity' => 1
        ])->toArray();
        $mockCartShouldNotReturn = Product::factory()->create([
            'quantity' => 0
        ]);

        //Act
        $cart = $this->cartService->getCart();

        // Assert
        $this->assertEquals([$mockCartShouldReturn], $cart);
    }

    public function test_check_cart_in_cache()
    {
        // Arrange
        $this->seed(ProductsSeeder::class);

        // Act
        $this->cartService->getCart();

        // Assert
        $this->assertTrue(cache()->has('cart'));
    }

    public function test_get_cart_amount_in_cache()
    {
        // Arrange
        $this->seed(ProductsSeeder::class);

        // Act
        $this->cartService->getCart();
        $cartAmount = $this->cartService->getCartAmount();

        // Assert
        $this->assertTrue($cartAmount > 0);
    }

    public function test_clear_cart_in_cache()
    {
        // Arrange
        $this->seed(ProductsSeeder::class);

        // Act
        $this->cartService->getCart();
        $this->cartService->clearCart();
        $cartAmount = $this->cartService->getCartAmount();

        // Assert
        $this->assertTrue($cartAmount == 0);
    }
}
