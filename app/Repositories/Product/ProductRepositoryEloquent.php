<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepositoryEloquent implements ProductRepositoryContract
{

    protected $product;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->product->paginate();
    }

    /**
     * @return Collection
     */
    public function getAllAvailableProducts(): Collection
    {
        return $this->product->where('quantity', '>', 0)->get();
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getProductsById(int $id): Product
    {
        return $this->product->whereId($id)->first();
    }

    /**
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        return $this->product->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProduct(int $id, array $data): bool
    {
        return (bool) $this->product->whereId($id)->update($data);
    }

    /**
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function decreaseQuantity(int $id, int $quantity): bool
    {
        return (bool) $this->product->whereId($id)->decrement('quantity', $quantity);
    }

    /**
     * @param int $productId
     * @return void
     */
    public function deleteProduct(int $productId): void
    {
        $this->product->destroy($productId);
    }
}
