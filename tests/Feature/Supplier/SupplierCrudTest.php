<?php

namespace Tests\Feature\Supplier;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_suppliers()
    {
        Supplier::factory()->count(3)->create();

        $response = $this->actingAsApiUser()->getJson('/api/suppliers');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'created_at', 'updated_at']
                     ],
                     'links',
                     'meta',
                 ]);
    }

    public function test_store_creates_supplier()
    {
        $data = ['name' => 'Test Supplier'];

        $response = $this->actingAsApiUser()->postJson('/api/suppliers', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Test Supplier']);

        $this->assertDatabaseHas('suppliers', ['name' => 'Test Supplier']);
    }

    public function test_show_returns_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->actingAsApiUser()->getJson("/api/suppliers/{$supplier->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $supplier->name]);
    }

    public function test_update_changes_supplier()
    {
        $supplier = Supplier::factory()->create(['name' => 'Old Name']);
        $data = ['name' => 'New Name'];

        $response = $this->actingAsApiUser()->putJson("/api/suppliers/{$supplier->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'New Name']);

        $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'name' => 'New Name']);
    }

    public function test_destroy_deletes_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->actingAsApiUser()->deleteJson("/api/suppliers/{$supplier->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Deleted']);

        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }
}
