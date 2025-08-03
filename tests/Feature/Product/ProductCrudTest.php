<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

public function test_product_can_be_listed()
{
    Product::factory()->count(5)->create();

    $response = $this->actingAsApiUser()->getJson('/api/products');
    $response->assertStatus(200)->assertJsonStructure(['data']);
}

    public function test_product_can_be_created()
    {
        $response = $this->actingAsApiUser()->postJson('/api/products', [
            'name' => 'Test Product',
            'price' => 100,
            'quantity' => 10,
        ]);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'Test Product']);
    }

    public function test_product_can_be_updated()
    {

        $product = Product::factory()->create();

        $response = $this->actingAsApiUser()->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'price' => 120,
            'quantity' => 5,
        ]);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Product']);
    }

    public function test_product_can_be_deleted()
    {
        $product = Product::factory()->create();

        $response = $this->actingAsApiUser()->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
