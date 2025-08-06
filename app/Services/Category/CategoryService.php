<?php
namespace App\Services\Category;

use App\Models\Category;

class CategoryService
{
    public function create(array $data): Category
    {
        $depth = Category::calculateDepth($data['parent_id'] ?? null);

        if ($depth >= Category::MAX_DEPTH) {
            throw new \Exception("Максимальная вложенность категорий — " . Category::MAX_DEPTH);
        }

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        if (array_key_exists('parent_id', $data)) {
            $depth = Category::calculateDepth($data['parent_id']);

            if ($depth >= Category::MAX_DEPTH) {
                throw new \Exception("Максимальная вложенность категорий — " . Category::MAX_DEPTH);
            }
        }

        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        $category->deleteWithChildren();
    }
}
