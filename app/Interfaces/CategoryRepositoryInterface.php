<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    /**
     * Method to return the category by ID
     * 
     * @param int $categoryId
     * 
     * @return Category|null
     */
    public function getById(int $categoryId): ?Category;

     /**
     * Method to return all category
     * 
     * @return Collection 
     */
    public function getAll(): Collection;

    /**
     * Method for creating new category
     * 
     * @param array $data
     * 
     * @return Category 
     */
    public function create(array $data): Category;

    /**
     * Method to update category
     * 
     * @param int $id
     * @param array $data
     * 
     * @return Category|null
     */
    public function update(int $id, array $data): ?Category;

    /**
     * Method to delete category
     * 
     * @param int $id
     * 
     * @return bool 
     */
    public function delete(int $id): bool;
}
