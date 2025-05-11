<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategotyRepository implements CategoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAll(): Collection
    {
        return Category::all();
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): ?Category
    {
        $category = Category::find($id);
        if (!$category) {
            return null;
        }

        $category->update($data);

        return $category;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        $category = Category::find($id);
        if (!$category) {
            return false;
        }

        return $category->delete();
    }
}
