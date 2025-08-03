<?php

namespace Tests\Feature\StockMovement;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockMovementCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_stock_movement(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAsApiUser()->postJson('/api/stock-movements', [
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => 10,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.product.id', $product->id);
    }

    public function test_can_list_stock_movements(): void
    {
        StockMovement::factory()->count(5)->create();

        $response = $this->actingAsApiUser()->getJson('/api/stock-movements');

        $response->assertOk()->assertJsonStructure(['data']);
    }
}
