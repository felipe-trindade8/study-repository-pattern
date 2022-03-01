<?php

namespace Tests\Feature\Product;

use App\Models\Product;

class ProductServiceTest extends TestProduct
{
    public function test_create_product()
    {
        // Arrange
        $mockProduct = Product::factory()->make()->toArray();

        // Act
        $product = $this->productService->createProduct($mockProduct)->toArray();

        // Assert
        $this->assertDatabaseHas('products', $product);
    }

    public function test_update_product()
    {
        // Arrange
        $mockProduct = Product::factory()->create([
            'quantity' => 0
        ]);

        // Act
        $product = $this->productService->updateProduct($mockProduct->id, ['quantity' => 10]);

        // Assert
        $this->assertTrue($product);
        $this->assertDatabaseHas('products', $mockProduct->fresh()->toArray());
    }

    public function test_delete_product()
    {
        // Arrange
        $mockProduct = Product::factory()->make()->toArray();
        $product = $this->productService->createProduct($mockProduct);

        // Act
        $this->productService->deleteProduct($product->id);

        // Assert
        $this->assertDatabaseMissing('products', $mockProduct);
    }

    public function test_get_all_products()
    {
        // Arrange
        $mockProductShouldReturn = Product::factory()->create([
            'quantity' => 1
        ])->toArray();
        $mockProductShouldNotReturn = Product::factory()->create([
            'quantity' => 0
        ])->toArray();

        //Act
        $products = $this->productService->getAllProducts()->toArray();

        // Assert
        $this->assertArrayHasKey('data', $products);
        $this->assertArrayHasKey('current_page', $products);
        $this->assertArrayHasKey('first_page_url', $products);
        $this->assertArrayHasKey('from', $products);
        $this->assertArrayHasKey('last_page', $products);
        $this->assertArrayHasKey('last_page_url', $products);
        $this->assertArrayHasKey('links', $products);
        $this->assertArrayHasKey('next_page_url', $products);
        $this->assertArrayHasKey('path', $products);
        $this->assertArrayHasKey('per_page', $products);
        $this->assertArrayHasKey('prev_page_url', $products);
        $this->assertArrayHasKey('to', $products);
        $this->assertArrayHasKey('total', $products);
        $this->assertEquals([$mockProductShouldReturn, $mockProductShouldNotReturn], $products['data']);
    }

    public function test_get_only_available_products()
    {
        // Arrange
        $mockProductShouldReturn = Product::factory()->create([
            'quantity' => 1
        ])->toArray();
        $mockProductShouldNotReturn = Product::factory()->create([
            'quantity' => 0
        ]);

        //Act
        $products = $this->productService->getAllAvailableProducts()->toArray();

        // Assert
        $this->assertEquals([$mockProductShouldReturn], $products);
    }

    public function test_get_product_by_id()
    {
        // Arrange
        $mockProduct = Product::factory()->create();

        // Act
        $this->productService->getProductsById($mockProduct->id);

        // Assert
        $this->assertDatabaseHas('products', $mockProduct->toArray());
    }

    public function test_decrease_product_quantity()
    {
        // Arrange
        $mockProduct = Product::factory()->create([
            'quantity' => 1
        ]);

        // Act
        $product = $this->productService->decreaseQuantity($mockProduct->id, 1);
        // Assert
        $this->assertTrue($product);
        $this->assertTrue($mockProduct->fresh()->quantity == 0);
    }
}
