<?php

namespace Tests\Feature;

use App\Models\Frame;
use App\Models\Accessory;
use App\Models\Lens;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\ProductCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;
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

        $this->actingAs($customer)->get('/orders')
            ->assertStatus(200)
            ->assertSee(route('orders.invoice', Order::where('user_id', $customer->id)->first()), false)
            ->assertSee('Cetak Faktur');
    }

    public function test_authenticated_user_can_update_address_and_phone(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->actingAs($customer)
            ->get(route('settings.profile.edit'))
            ->assertOk()
            ->assertSee('Pengaturan Profil')
            ->assertSee('name="address"', false)
            ->assertSee('name="phone"', false);

        $this->put(route('settings.profile.update'), [
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'phone' => '+62 812-3456-7890',
        ])
            ->assertRedirect(route('settings.profile.edit'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'phone' => '+62 812-3456-7890',
        ]);
    }

    public function test_profile_settings_reject_invalid_phone_and_require_authentication(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->actingAs($customer)
            ->put(route('settings.profile.update'), [
                'address' => 'Alamat',
                'phone' => '0812-INVALID',
            ])
            ->assertSessionHasErrors('phone');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'address' => null,
            'phone' => null,
        ]);

        auth()->logout();

        $this->get(route('settings.profile.edit'))->assertRedirect('/login');
    }

    public function test_customer_can_print_all_items_in_their_transaction_invoice(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $firstOrder = Order::create([
            'user_id' => $customer->id,
            'product_type' => 'lens',
            'product_name' => 'Lensa Progresif',
            'product_category' => 'Lensa',
            'transaction_code' => 'TRX-INVOICE-001',
            'branch_id' => 'ciburaleng',
            'branch_name' => 'Optik Gumelar Ciburaleng',
            'quantity' => 1,
            'status' => 'pending',
            'total_price' => 250000,
        ]);

        Order::create([
            'user_id' => $customer->id,
            'product_type' => 'frame',
            'product_name' => 'Frame Titanium',
            'product_category' => 'Frame Pria',
            'transaction_code' => 'TRX-INVOICE-001',
            'branch_id' => 'ciburaleng',
            'branch_name' => 'Optik Gumelar Ciburaleng',
            'quantity' => 2,
            'status' => 'pending',
            'total_price' => 700000,
        ]);

        $this->actingAs($customer)
            ->get(route('orders.invoice', $firstOrder))
            ->assertOk()
            ->assertSee('Lensa Progresif')
            ->assertSee('Frame Titanium')
            ->assertSee('TRX-INVOICE-001')
            ->assertSee('950.000')
            ->assertSee('window.print()');
    }

    public function test_customer_cannot_print_another_customers_invoice(): void
    {
        $owner = User::factory()->create(['role' => 'PELANGGAN']);
        $otherCustomer = User::factory()->create(['role' => 'PELANGGAN']);
        $order = Order::create([
            'user_id' => $owner->id,
            'product_type' => 'accessory',
            'product_name' => 'Kain Lap',
            'transaction_code' => 'TRX-PRIVATE-001',
            'quantity' => 1,
            'status' => 'pending',
            'total_price' => 15000,
        ]);

        $this->actingAs($otherCustomer)
            ->get(route('orders.invoice', $order))
            ->assertForbidden();
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

    public function test_google_login_creates_new_account_as_customer(): void
    {
        config([
            'services.google.client_id' => 'client-id',
            'services.google.client_secret' => 'client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);

        $googleUser = GoogleUser::fake([
            'id' => 'google-user-123',
            'name' => 'Google Customer',
            'email' => 'google@example.com',
            'verified_email' => true,
        ]);

        Socialite::fake('google', $googleUser);

        $this->get('/auth/google/callback')->assertRedirect('/dashboard');

        $user = User::where('email', 'google@example.com')->firstOrFail();
        $this->assertSame('google-user-123', $user->google_id);
        $this->assertSame('PELANGGAN', $user->role);
        $this->assertAuthenticatedAs($user);
    }

    public function test_google_login_links_existing_user_without_changing_role(): void
    {
        config([
            'services.google.client_id' => 'client-id',
            'services.google.client_secret' => 'client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);

        $employee = User::factory()->create([
            'email' => 'staff@example.com',
            'role' => 'KARYAWAN',
        ]);
        $googleUser = GoogleUser::fake([
            'id' => 'google-staff-123',
            'email' => 'staff@example.com',
            'verified_email' => true,
        ]);
        Socialite::fake('google', $googleUser);

        $this->get('/auth/google/callback')->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($employee);
        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'google_id' => 'google-staff-123',
            'role' => 'KARYAWAN',
        ]);
    }

    public function test_google_login_rejects_unverified_email(): void
    {
        config([
            'services.google.client_id' => 'client-id',
            'services.google.client_secret' => 'client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);

        $googleUser = GoogleUser::fake([
            'id' => 'unverified-google-user',
            'email' => 'unverified@example.com',
            'verified_email' => false,
        ]);
        Socialite::fake('google', $googleUser);

        $this->get('/auth/google/callback')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('google');

        $this->assertDatabaseMissing('users', ['email' => 'unverified@example.com']);
        $this->assertGuest();
    }

    public function test_login_page_has_google_login_button_and_incomplete_configuration_is_reported(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
            'services.google.redirect' => null,
        ]);

        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk dengan Google');

        $this->get('/auth/google/redirect')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('google');
    }

    public function test_google_login_redirects_to_provider_when_configured(): void
    {
        config([
            'services.google.client_id' => 'client-id',
            'services.google.client_secret' => 'client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);
        Socialite::fake('google', GoogleUser::fake());

        $this->get('/auth/google/redirect')
            ->assertRedirect('https://socialite.fake/google/authorize');
    }

    public function test_checkout_creates_catalog_record_for_products_that_are_not_in_database(): void
    {
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        $this->actingAs($customer)
            ->withSession(['cart' => [
                'frame-classic-round-tr90' => [
                    'product_type' => 'frame',
                    'product_key' => 'classic-round-tr90',
                    'name' => 'Classic Round TR90',
                    'category' => 'Pria',
                    'price' => 350000,
                    'quantity' => 1,
                ],
                'accessory-hard-case-kacamata' => [
                    'product_type' => 'accessory',
                    'product_key' => 'hard-case-kacamata',
                    'name' => 'Hard Case Kacamata',
                    'category' => 'Aksesoris',
                    'price' => 75000,
                    'quantity' => 1,
                ],
            ]])
            ->post('/checkout', [
                'terms' => '1',
                'branch_id' => 'ciburaleng',
                'buyer_latitude' => '-6.9662878',
                'buyer_longitude' => '107.8181306',
            ])
            ->assertRedirect('/dashboard');

        $this->assertDatabaseHas('frames', [
            'catalog_key' => 'classic-round-tr90',
            'name' => 'Classic Round TR90',
            'stock' => 0,
        ]);

        $frame = Frame::where('catalog_key', 'classic-round-tr90')->firstOrFail();
        $this->assertDatabaseHas('orders', [
            'product_type' => 'frame',
            'product_id' => $frame->id,
            'product_key' => 'classic-round-tr90',
        ]);
        $this->assertDatabaseHas('accessories', [
            'catalog_key' => 'hard-case-kacamata',
            'name' => 'Hard Case Kacamata',
            'stock' => 0,
        ]);
        $this->assertDatabaseCount('orders', 2);
    }

    public function test_product_catalog_seeder_adds_dummy_products_and_preserves_stock_on_repeat_runs(): void
    {
        $this->seed(ProductCatalogSeeder::class);

        $this->assertDatabaseCount('frames', 6);
        $this->assertDatabaseCount('lenses', 8);
        $this->assertDatabaseCount('accessories', 6);
        $this->assertDatabaseHas('frames', [
            'catalog_key' => 'classic-round-tr90',
            'stock' => 10,
        ]);

        Frame::where('catalog_key', 'classic-round-tr90')->update(['stock' => 4]);
        $this->seed(ProductCatalogSeeder::class);

        $this->assertDatabaseCount('frames', 6);
        $this->assertDatabaseCount('lenses', 8);
        $this->assertDatabaseCount('accessories', 6);
        $this->assertDatabaseHas('frames', [
            'catalog_key' => 'classic-round-tr90',
            'stock' => 4,
        ]);

        $this->get('/produk/frame')->assertOk()->assertSee('Classic Round TR90');
        $this->get('/produk/lensa')->assertOk()->assertSee('Single Vision Standard');
        $this->get('/produk/aksesoris')->assertOk()->assertSee('Hard Case Kacamata');

        $customer = User::factory()->create(['role' => 'PELANGGAN']);
        $lens = Lens::where('catalog_key', 'single-vision-standard')->firstOrFail();

        $this->actingAs($customer)
            ->post('/beli-sekarang', [
                'product_type' => 'lens',
                'product_key' => 'single-vision-standard',
                'quantity' => 1,
            ])
            ->assertRedirect('/checkout');

        $this->post('/checkout', [
            'terms' => '1',
            'branch_id' => 'ciburaleng',
            'buyer_latitude' => '-6.9662878',
            'buyer_longitude' => '107.8181306',
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'product_type' => 'lens',
            'product_id' => $lens->id,
            'product_key' => 'single-vision-standard',
            'total_price' => 150000,
        ]);
    }

    public function test_accessory_management_has_spreadsheet_link_and_requires_staff_role(): void
    {
        $employee = User::factory()->create(['role' => 'KARYAWAN']);
        $customer = User::factory()->create(['role' => 'PELANGGAN']);

        Accessory::create([
            'name' => 'Kain Lap Uji',
            'category' => 'Aksesoris',
            'price' => 10000,
            'stock' => 2,
        ]);

        $this->actingAs($employee)
            ->get('/accessories')
            ->assertOk()
            ->assertSee(config('products.inventory_spreadsheet_url'));

        $this->actingAs($customer)->get('/accessories')->assertForbidden();
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
