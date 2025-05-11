<?php

namespace App\Repositories;

use App\Interfaces\ProductsRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductsRepository implements ProductsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): ?Product
    {
        $product = Product::find($id);
        if (! $product) {
            return null;
        }

        $product->update($data);

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        $product = Product::find($id);
        if (! $product) {
            return false;
        }

        return $product->delete();
    }
}
