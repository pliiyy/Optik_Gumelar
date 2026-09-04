<?php

namespace Tests\Feature;

use App\Models\Frame;
use App\Models\Lens;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAndOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_order_and_view_own_orders(): void
    {
        $customer = User::factory()->create([
            'role' => 'PELANGGAN',
            'email' => 'customer@example.com',
        ]);

        $lens = Lens::create([
            'name' => 'Lensa Premium',
            'category' => 'Resep',
            'description' => 'Lensa premium',
            'price' => 250000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($customer)->post('/orders', [
            'product_type' => 'lens',
            'product_id' => $lens->id,
            'quantity' => 2,
            'notes' => 'Butuh untuk kerja',
        ]);

        $response->assertRedirect('/orders');
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'product_type' => 'lens',
            'product_id' => $lens->id,
            'status' => 'pending',
        ]);

        $this->actingAs($customer)->get('/orders')->assertStatus(200);
    }

    public function test_karyawan_can_update_order_status_to_completed(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);
        $karyawan = User::factory()->create(['role' => 'KARYAWAN']);

        $frame = Frame::create([
            'name' => 'Frame Classic',
            'category' => 'Premium',
            'description' => 'Frame klasik',
            'price' => 300000,
            'stock' => 8,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'product_type' => 'frame',
            'product_id' => $frame->id,
            'quantity' => 1,
            'notes' => 'Pesanan baru',
            'status' => 'pending',
            'total_price' => 300000,
        ]);

        $this->actingAs($karyawan)
            ->patch('/orders/' . $order->id . '/status', ['status' => 'selesai'])
            ->assertRedirect('/orders');

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'selesai']);
    }

    public function test_customer_cannot_access_employee_management_page(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->actingAs($customer)->get('/lenses')->assertStatus(403);
    }
}
