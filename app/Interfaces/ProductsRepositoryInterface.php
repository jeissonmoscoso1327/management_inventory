<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductsRepositoryInterface
{
    /**
     * Method to return the product by ID
     * 
     * @param int $productId
     * 
     * @return Product|null
     */
    public function getById(int $productId): ?Product;

    /**
     * Method to return all products
     * 
     * @return Collection 
     */
    public function getAll(): Collection;

    /**
     * Method for creating new products
     * 
     * @param array $data
     * 
     * @return Product 
     */
    public function create(array $data): Product;

    /**
     * Method to update products
     * 
     * @param int $id
     * @param array $data
     * 
     * @return Product|null
     */
    public function update(int $id, array $data): ?Product;

    /**
     * Method to delete products
     * 
     * @param int $id
     * 
     * @return bool 
     */
    public function delete(int $id): bool;
}

