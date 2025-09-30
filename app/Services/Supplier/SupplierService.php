<?php

namespace App\Services\Supplier;

use App\Models\Supplier;

/**
 * Сервис управления поставщиками.
 *
 * Отвечает за создание, обновление и удаление поставщиков.
 */
class SupplierService
{
    /**
     * Создать нового поставщика.
     *
     * @param  array  $data  Данные поставщика ['name' => string, 'email' => string, ...]
     * @return Supplier Созданный поставщик
     */
    public function store(array $data): Supplier
    {
        return Supplier::create($data);
    }

    /**
     * Обновить поставщика.
     *
     * @param  Supplier  $supplier  Поставщик для обновления
     * @param  array  $data  Данные для обновления
     * @return Supplier Обновлённый поставщик
     */
    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);

        return $supplier;
    }

    /**
     * Удалить поставщика.
     *
     * @param  Supplier  $supplier  Поставщик для удаления
     */
    public function delete(Supplier $supplier): void
    {
        $supplier->delete();
    }
}
