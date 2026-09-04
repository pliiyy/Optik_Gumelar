<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagementPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_management_page(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'ADMIN',
        ]);

        $response = $this->actingAs($admin)->get('/users');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_lenses_management_page(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin2@example.com',
            'role' => 'ADMIN',
        ]);

        $response = $this->actingAs($admin)->get('/lenses');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_frames_management_page(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin3@example.com',
            'role' => 'ADMIN',
        ]);

        $response = $this->actingAs($admin)->get('/frames');

        $response->assertStatus(200);
    }
}
