<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/categories');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_store_creates_category()
    {
        $payload = [
            'name' => 'Новая категория',
            'parent_id' => null,
        ];

        $response = $this->postJson('/categories', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Новая категория']);

        $this->assertDatabaseHas('categories', ['name' => 'Новая категория']);
    }

    public function test_show_returns_category_with_children_recursive()
    {
        $parent = Category::factory()->create(['name' => 'Родитель']);
        $child = Category::factory()->create(['parent_id' => $parent->id]);

        $response = $this->getJson("categories/{$parent->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Родитель'])
            ->assertJsonFragment(['parent_id' => $parent->id]); // ребёнок загружен рекурсивно
    }

    public function test_update_category()
    {
        $category = Category::factory()->create(['name' => 'Старая категория']);

        $payload = [
            'name' => 'Обновлённая категория',
            'parent_id' => null,
        ];

        $response = $this->putJson("categories/{$category->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Обновлённая категория']);

        $this->assertDatabaseHas('categories', ['name' => 'Обновлённая категория']);
    }

    public function test_destroy_deletes_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Категория удалена']);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
