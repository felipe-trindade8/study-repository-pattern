<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryContract;
use App\Services\Contracts\ProductServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceContract
{

    protected $productRepository;

    /**
     * @param ProductRepositoryContract $productRepository
     */
    public function __construct(ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        return $this->productRepository->createProduct($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProduct(int $paymentId, array $data): bool
    {
        return $this->productRepository->updateProduct($paymentId, $data);
    }

    /**
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function decreaseQuantity(int $paymentId, int $quantity): bool
    {
        return $this->productRepository->decreaseQuantity($paymentId, $quantity);
    }

    /**
     * @param int $productId
     * @return void
     */
    public function deleteProduct($productId): void
    {
        $this->productRepository->deleteProduct($productId);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->productRepository->getAllProducts();
    }

    /**
     * @return Collection
     */
    public function getAllAvailableProducts(): Collection
    {
        return $this->productRepository->getAllAvailableProducts();
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getProductsById(int $id): Product
    {
        return $this->productRepository->getProductsById($id);
    }
}
