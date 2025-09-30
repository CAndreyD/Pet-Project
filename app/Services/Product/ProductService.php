<?php

namespace App\Services\Product;

use App\Models\Product;

/**
 * Сервис управления продуктами.
 *
 * Отвечает за создание, обновление и удаление продуктов.
 */
class ProductService
{
    /**
     * Создать новый продукт.
     *
     * @param  array  $data  Данные продукта ['name' => string, 'price' => float, 'category_id' => int, ...]
     * @return Product Созданный продукт
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Обновить продукт.
     *
     * @param  Product  $product  Продукт для обновления
     * @param  array  $data  Данные для обновления
     * @return Product Обновлённый продукт
     */
    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    /**
     * Удалить продукт.
     *
     * @param  Product  $product  Продукт для удаления
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }
}
