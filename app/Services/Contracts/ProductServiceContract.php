<?php

namespace App\Services\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceContract
{

    /**
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProduct(int $paymentId, array $data): bool;

    /**
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function decreaseQuantity(int $paymentId, int $quantity): bool;

    /**
     * @param int $productId
     * @return void
     */
    public function deleteProduct($productId): void;

    /**
     * @return LengthAwarePaginator
     */
    public function getAllProducts(): LengthAwarePaginator;

    /**
     * @return Collection
     */
    public function getAllAvailableProducts(): Collection;

    /**
     * @param int $id
     * @return Product
     */
    public function getProductsById(int $id): Product;
}
