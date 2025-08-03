<?php

namespace Tests\Feature;

use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShipmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_shipments()
    {
        Shipment::factory()->count(3)->create();

        $response = $this->getJson('shipments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'supplier' => ['id', 'name', 'created_at', 'updated_at'],
                        'shipment_date',
                        'products' => [
                            '*' => ['id', 'name', 'quantity']
                        ],
                        'created_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_store_creates_shipment_with_products()
    {
        $supplier = Supplier::factory()->create();
        $products = Product::factory()->count(2)->create();

        $payload = [
            'supplier_id' => $supplier->id,
            'shipment_date' => now()->toDateString(),
            'products' => [
                ['product_id' => $products[0]->id, 'quantity' => 10],
                ['product_id' => $products[1]->id, 'quantity' => 5],
            ],
        ];

        $response = $this->postJson('shipments', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('supplier.id', $supplier->id)
            ->assertJsonPath('supplier.name', $supplier->name)
            ->assertJsonPath('shipment_date', $payload['shipment_date']);

        $this->assertDatabaseHas('shipments', [
            'supplier_id' => $supplier->id,
            'shipment_date' => $payload['shipment_date'],
        ]);

        foreach ($payload['products'] as $product) {
            $this->assertDatabaseHas('shipment_product', [
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }
    }

    public function test_show_returns_shipment()
    {
        $shipment = Shipment::factory()
            ->hasAttached(
                Product::factory()->count(2)->create(),
                ['quantity' => 7]
            )
            ->create();

        $shipment->load('supplier', 'products');

        $response = $this->getJson("shipments/{$shipment->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $shipment->id]);
    }

    public function test_update_changes_shipment_and_products()
    {
        $shipment = Shipment::factory()
            ->hasAttached(Product::factory()->create(), ['quantity' => 3])
            ->create();

        $newSupplier = Supplier::factory()->create();
        $newProduct = Product::factory()->create();

        $payload = [
            'supplier_id' => $newSupplier->id,
            'shipment_date' => now()->addDay()->toDateString(),
            'products' => [
                ['product_id' => $newProduct->id, 'quantity' => 15],
            ],
        ];

        $response = $this->putJson("shipments/{$shipment->id}", $payload);

        $response->assertStatus(200)
            ->assertJson(
                fn($json) =>
                $json->where('id', $shipment->id)
                    ->where('shipment_date', $payload['shipment_date'])
                    ->where('supplier.id', $newSupplier->id)
                    ->where('supplier.name', $newSupplier->name)
                    ->has('products')
                    ->etc()
            );


        $this->assertDatabaseHas('shipments', [
            'id' => $shipment->id,
            'supplier_id' => $newSupplier->id,
            'shipment_date' => $payload['shipment_date'],
        ]);

        $this->assertDatabaseHas('shipment_product', [
            'product_id' => $newProduct->id,
            'quantity' => 15,
        ]);
    }


    public function test_destroy_deletes_shipment()
    {
        $shipment = Shipment::factory()->create();

        $response = $this->deleteJson("shipments/{$shipment->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Shipment deleted']);

        $this->assertDatabaseMissing('shipments', ['id' => $shipment->id]);
    }
}
