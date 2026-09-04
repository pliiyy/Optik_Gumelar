<?php

namespace Tests\Feature;

use App\Models\Frame;
use App\Models\Lens;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_crud_routes_work(): void
    {
        $admin = User::factory()->create([
            'role' => 'ADMIN',
        ]);

        $this->actingAs($admin)
            ->post('/users', [
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'role' => 'PELANGGAN',
                'password' => 'secret123',
            ])
            ->assertRedirect('/users');

        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);

        $user = User::where('email', 'budi@example.com')->first();

        $this->actingAs($admin)
            ->put('/users/' . $user->id, [
                'name' => 'Budi Updated',
                'email' => 'budi.updated@example.com',
                'role' => 'ADMIN',
            ])
            ->assertRedirect('/users');

        $this->assertDatabaseHas('users', ['email' => 'budi.updated@example.com']);

        $this->actingAs($admin)
            ->delete('/users/' . $user->id)
            ->assertRedirect('/users');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_lens_crud_routes_work(): void
    {
        $admin = User::factory()->create([
            'role' => 'ADMIN',
        ]);

        $this->actingAs($admin)
            ->post('/lenses', [
                'name' => 'Single Vision',
                'category' => 'Resep',
                'description' => 'Lensa anti silau',
                'price' => 150000,
                'stock' => 20,
            ])
            ->assertRedirect('/lenses');

        $this->assertDatabaseHas('lenses', ['name' => 'Single Vision']);

        $lens = Lens::where('name', 'Single Vision')->first();

        $this->actingAs($admin)
            ->put('/lenses/' . $lens->id, [
                'name' => 'Single Vision Pro',
                'category' => 'Premium',
                'description' => 'Update detail',
                'price' => 175000,
                'stock' => 15,
            ])
            ->assertRedirect('/lenses');

        $this->assertDatabaseHas('lenses', ['name' => 'Single Vision Pro']);

        $this->actingAs($admin)
            ->delete('/lenses/' . $lens->id)
            ->assertRedirect('/lenses');

        $this->assertDatabaseMissing('lenses', ['id' => $lens->id]);
    }

    public function test_frame_crud_routes_work(): void
    {
        $admin = User::factory()->create([
            'role' => 'ADMIN',
        ]);

        $this->actingAs($admin)
            ->post('/frames', [
                'name' => 'Frame Classic',
                'category' => 'Premium',
                'description' => 'Frame modern',
                'price' => 320000,
                'stock' => 12,
            ])
            ->assertRedirect('/frames');

        $this->assertDatabaseHas('frames', ['name' => 'Frame Classic']);

        $frame = Frame::where('name', 'Frame Classic')->first();

        $this->actingAs($admin)
            ->put('/frames/' . $frame->id, [
                'name' => 'Frame Classic Pro',
                'category' => 'Luxury',
                'description' => 'Update frame',
                'price' => 350000,
                'stock' => 10,
            ])
            ->assertRedirect('/frames');

        $this->assertDatabaseHas('frames', ['name' => 'Frame Classic Pro']);

        $this->actingAs($admin)
            ->delete('/frames/' . $frame->id)
            ->assertRedirect('/frames');

        $this->assertDatabaseMissing('frames', ['id' => $frame->id]);
    }
}
