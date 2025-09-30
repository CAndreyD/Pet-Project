<?php

namespace App\Services\Shipment;

use App\Models\Shipment;

/**
 * Сервис управления поставками.
 *
 * Отвечает за создание и обновление поставок и связанных продуктов.
 */
class ShipmentService
{
    /**
     * Создать новую поставку с привязкой продуктов.
     *
     * @param  array  $data  Данные поставки:
     *                       [
     *                       'supplier_id' => int,
     *                       'shipment_date' => string (Y-m-d),
     *                       'products' => [
     *                       ['product_id' => int, 'quantity' => int],
     *                       ...
     *                       ]
     *                       ]
     * @return Shipment Поставка с загруженными отношениями supplier и products
     */
    public function store(array $data): Shipment
    {
        $shipment = Shipment::create([
            'supplier_id' => $data['supplier_id'],
            'shipment_date' => $data['shipment_date'],
        ]);

        foreach ($data['products'] as $product) {
            $shipment->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
        }

        return $shipment->load('supplier', 'products');
    }

    /**
     * Обновить поставку и синхронизировать связанные продукты.
     *
     * @param  Shipment  $shipment  Поставка для обновления
     * @param  array  $data  Данные для обновления (та же структура, что и в store)
     * @return Shipment Обновлённая поставка с загруженными отношениями supplier и products
     */
    public function update(Shipment $shipment, array $data): Shipment
    {
        $shipment->update([
            'supplier_id' => $data['supplier_id'],
            'shipment_date' => $data['shipment_date'],
        ]);

        $syncData = [];
        foreach ($data['products'] as $product) {
            $syncData[$product['product_id']] = ['quantity' => $product['quantity']];
        }

        $shipment->products()->sync($syncData);

        return $shipment->load('supplier', 'products');
    }
}
