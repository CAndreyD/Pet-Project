<?php
namespace App\Services\Shipment;

use App\Models\Shipment;

class ShipmentService
{
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
