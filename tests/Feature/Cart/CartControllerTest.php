<?php

namespace Tests\Feature\Cart;

use Database\Seeders\ProductsSeeder;

class CartControllerTest extends TestCart
{
    public function test_request_api_v1_cart()
    {
        // Arrange
        $this->seed(ProductsSeeder::class);

        // Act
        $response = $this->get(route('api.v1.catestore.cart'));

        // Assert
        $response->assertStatus(200)->assertJsonStructure([[
            'title',
            'price',
            'quantity',
            'image_url'
        ]]);
    }
}
