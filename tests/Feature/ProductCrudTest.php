<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use DatabaseMigrations;
    protected function setUp(): void
    {
        parent::setUp();
        \Log::info('DB_DATABASE: ' . env('DB_DATABASE'));
    }

    public function test_can_create_product()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('product.store'), [
            'name' => 'Test Product',
            'price' => 100,
            'quantity' => 5,
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Product created']);
    }

    public function test_can_update_product()
    {
        // Создаем тестовый продукт
        $product = Product::factory()->create([
            'name' => 'Old Name',
            'price' => 10,
            'quantity' => 5,
        ]);

        // Данные для обновления
        $updateData = [
            'name' => 'New Name',
            'price' => 20.5,
            'quantity' => 10,
        ];

        // Принудительно укажи путь как строку
        $url = '/product/' . $product->id;
        // Отправляем PUT-запрос на роут обновления продукта
        $response = $this->putJson($url, $updateData);
        // Проверяем редирект на индекс продуктов
        $response->assertRedirect(route('product.index'));

        // Проверяем наличие сессионного сообщения
        $response->assertSessionHas('success', 'Product updated!');

        // Проверяем, что данные в базе обновились
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Name',
            'price' => 20.5,
            'quantity' => 10,
        ]);
    }


    public function test_can_delete_product()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertRedirect(route('product.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
