<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminOnlyControllerTest extends TestCase
{
    private function getAdminUser(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    private function getRegularUser(): User
    {
        return User::factory()->create([
            'is_admin' => false,
        ]);
    }

    public function test_guest_cannot_access()
    {
        $response = $this->getJson('/api/admin');
        $response->assertStatus(401);
    }

    public function test_non_admin_cannot_access()
    {
        $user = $this->getRegularUser();
        $response = $this->actingAsApiUser($user)->getJson('/api/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_index()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAsApiUser($admin)->getJson('/api/admin');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Admin index - список ресурсов']);
    }

    public function test_admin_can_access_show()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAsApiUser($admin)->getJson('/api/admin/1');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Admin show - показываем ресурс с ID 1']);
    }

    public function test_admin_can_access_store()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAsApiUser($admin)->postJson('/api/admin', [
            'some_field' => 'some_value',
        ]);
        $response->assertStatus(201)
            ->assertJson(['message' => 'Admin store - создан ресурс']);
    }

    public function test_admin_can_access_update()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAsApiUser($admin)->putJson('/api/admin/1', [
            'some_field' => 'new_value',
        ]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Admin update - обновлен ресурс с ID 1']);
    }

    public function test_admin_can_access_destroy()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAsApiUser($admin)->deleteJson('/api/admin/1');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Admin destroy - удален ресурс с ID 1']);
    }
}
