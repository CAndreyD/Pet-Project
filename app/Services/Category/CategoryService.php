<?php
namespace App\Services\Category;

use App\Models\Category;

/**
 * Сервис управления категориями.
 *
 * Отвечает за создание, обновление и удаление категорий с проверкой вложенности.
 */
class CategoryService
{
    /**
     * Создать новую категорию.
     *
     * Проверяет глубину вложенности, чтобы не превышать MAX_DEPTH.
     *
     * @param array $data Данные категории ['name' => string, 'parent_id' => int|null, ...]
     * @return Category
     * @throws \Exception Если глубина вложенности превышает MAX_DEPTH
     */
    public function create(array $data): Category
    {
        $depth = Category::calculateDepth($data['parent_id'] ?? null);

        if ($depth >= Category::MAX_DEPTH) {
            throw new \Exception("Максимальная вложенность категорий — " . Category::MAX_DEPTH);
        }

        return Category::create($data);
    }

    /**
     * Обновить категорию.
     *
     * Проверяет новую глубину вложенности, если изменяется parent_id.
     *
     * @param Category $category
     * @param array $data Данные для обновления
     * @return Category
     * @throws \Exception Если новая глубина вложенности превышает MAX_DEPTH
     */
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

    /**
     * Удалить категорию вместе со всеми её потомками.
     *
     * @param Category $category
     * @return void
     */
    public function delete(Category $category): void
    {
        $category->deleteWithChildren();
    }
}
