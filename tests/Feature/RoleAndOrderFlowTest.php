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

    public function test_public_navigation_shows_login_or_dashboard_based_on_authentication(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="/login"', false)
            ->assertDontSee('href="/dashboard"', false);

        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->actingAs($customer)->get('/')
            ->assertOk()
            ->assertSee('href="/dashboard"', false)
            ->assertDontSee('href="/login"', false);

        $this->actingAs($customer)->get('/dashboard')
            ->assertOk()
            ->assertSee('href="/"', false)
            ->assertSee('Kembali ke Beranda');
    }

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
            'planned_visit_date' => now()->addDay()->toDateString(),
            'notes' => 'Butuh untuk kerja',
        ]);

        $response->assertRedirect('/orders');
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'product_type' => 'lens',
            'product_id' => $lens->id,
            'status' => 'pending',
            'planned_visit_date' => now()->addDay()->toDateString(),
        ]);

        $this->actingAs($customer)->get('/orders')->assertStatus(200);
    }

    public function test_customer_can_add_product_without_leaving_product_page(): void
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])->post('/keranjang/tambah', [
            'product_type' => 'frame',
            'product_key' => 'classic-round-tr90',
            'quantity' => 1,
        ]);

        $response->assertOk()->assertJson(['cart_count' => 1]);
        $this->assertSame(1, collect(session('cart'))->sum('quantity'));
    }

    public function test_customer_can_checkout_cart_items_as_one_transaction(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->withHeaders(['Accept' => 'application/json'])->post('/keranjang/tambah', [
            'product_type' => 'frame',
            'product_key' => 'classic-round-tr90',
            'quantity' => 1,
        ]);
        $this->withHeaders(['Accept' => 'application/json'])->post('/keranjang/tambah', [
            'product_type' => 'accessory',
            'product_key' => 'hard-case-kacamata',
            'quantity' => 2,
        ]);

        $this->actingAs($customer)->get('/checkout')->assertOk();
        $this->actingAs($customer)->post('/checkout', ['terms' => '1'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['branch_id', 'buyer_latitude', 'buyer_longitude']);
        $this->actingAs($customer)->post('/checkout', [
            'terms' => '1',
            'branch_id' => 'ciburaleng',
            'buyer_latitude' => -6.9662878,
            'buyer_longitude' => 107.8181306,
        ])->assertRedirect('/dashboard');

        $orders = Order::where('user_id', $customer->id)->get();
        $this->assertCount(2, $orders);
        $this->assertCount(1, $orders->pluck('transaction_code')->unique());
        $this->assertSame('ciburaleng', $orders->first()->branch_id);
        $this->assertSame(0.0, (float) $orders->first()->branch_distance_km);
        $this->assertSame(500000.0, (float) $orders->sum('total_price'));
        $this->assertSame([], session('cart', []));
        $this->actingAs($customer)->get('/dashboard')
            ->assertOk()
            ->assertSee('Optik Gumelar Ciburaleng')
            ->assertSee('0,00 km dari lokasi saat checkout (perkiraan garis lurus)');
    }

    public function test_customer_can_confirm_direct_purchase_after_accepting_terms(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->post('/beli-sekarang', [
            'product_type' => 'accessory',
            'product_key' => 'hard-case-kacamata',
            'quantity' => 2,
        ])->assertRedirect('/checkout');

        $this->get('/checkout')->assertRedirect('/login');

        $this->actingAs($customer)->post('/beli-sekarang', [
            'product_type' => 'accessory',
            'product_key' => 'hard-case-kacamata',
            'quantity' => 2,
        ])->assertRedirect('/checkout');

        $this->actingAs($customer)->post('/checkout', [
            'notes' => 'Konfirmasi di toko',
        ])->assertSessionHasErrors('terms');

        $this->actingAs($customer)->post('/checkout', [
            'terms' => '1',
            'notes' => 'Konfirmasi di toko',
            'branch_id' => 'cinunuk',
            'buyer_latitude' => -6.9394172,
            'buyer_longitude' => 107.7386285,
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'product_type' => 'accessory',
            'product_key' => 'hard-case-kacamata',
            'product_name' => 'Hard Case Kacamata',
            'branch_id' => 'cinunuk',
            'quantity' => 2,
        ]);
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

    public function test_guest_can_register_as_customer(): void
    {
        $response = $this->post('/register', [
            'name' => 'Pelanggan Baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'name' => 'Pelanggan Baru',
            'email' => 'baru@example.com',
            'role' => 'PELANGGAN',
        ]);
    }

    public function test_customer_can_add_product_to_cart_and_checkout_with_visit_date(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);
        $lens = Lens::create([
            'name' => 'Lensa Keranjang',
            'category' => 'Premium',
            'description' => 'Lensa untuk keranjang',
            'price' => 200000,
            'stock' => 5,
        ]);

        $this->actingAs($customer)->post('/cart', [
            'product_type' => 'lens',
            'product_id' => $lens->id,
            'quantity' => 2,
        ])->assertRedirect();

        $this->actingAs($customer)->post('/cart/checkout', [
            'planned_visit_date' => now()->addDay()->toDateString(),
            'notes' => 'Datang sore hari',
        ])->assertRedirect('/orders');

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'product_id' => $lens->id,
            'quantity' => 2,
            'status' => 'pending',
            'notes' => 'Datang sore hari',
        ]);
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_customer_can_submit_direct_order_from_product_page(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);
        $frame = Frame::create([
            'name' => 'Frame Direct',
            'category' => 'Premium',
            'description' => 'Frame direct order',
            'price' => 350000,
            'stock' => 3,
        ]);

        $this->actingAs($customer)->post('/orders', [
            'product_type' => 'frame',
            'product_id' => $frame->id,
            'quantity' => 1,
            'planned_visit_date' => now()->addDays(2)->toDateString(),
            'notes' => 'Pesan langsung',
        ])->assertRedirect('/orders');

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'product_type' => 'frame',
            'product_id' => $frame->id,
            'status' => 'pending',
            'notes' => 'Pesan langsung',
        ]);
    }
}
