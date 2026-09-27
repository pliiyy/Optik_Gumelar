<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Frame;
use App\Models\Lens;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        return view('cart', ['cart' => session('cart', [])]);
=======
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
>>>>>>> 2b8faee8b8c69a612160f21999c4fbe6f18f1ec5
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'product_type' => ['required', 'in:lens,frame'],
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $model = $validated['product_type'] === 'lens' ? Lens::class : Frame::class;
        $product = $model::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Jumlah melebihi stok yang tersedia.']);
        }

        $key = $validated['product_type'] . ':' . $product->id;
        $cart = session('cart', []);
        $quantity = ($cart[$key]['quantity'] ?? 0) + $validated['quantity'];

        if ($quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Jumlah di keranjang melebihi stok yang tersedia.']);
        }

        $cart[$key] = [
            'product_type' => $validated['product_type'],
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'quantity' => $quantity,
        ];

        session(['cart' => $cart]);

        return back()->with('cart_success', $product->name . ' ditambahkan ke keranjang.');
    }

    public function remove(string $key)
    {
        $cart = session('cart', []);
        unset($cart[$key]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
=======
            'product_type' => 'required|in:lens,frame,accessory',
            'product_key' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = $this->catalog()[$validated['product_type']][$validated['product_key']] ?? null;
        abort_unless($product, 404);

        $cart = $request->session()->get('cart', []);
        $key = $validated['product_type'] . '-' . $validated['product_key'];

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $validated['quantity'];
        } else {
            $cart[$key] = [
                'product_type' => $validated['product_type'],
                'product_key' => $validated['product_key'],
                'name' => $product['name'],
                'category' => $product['category'],
                'price' => $product['price'],
                'quantity' => $validated['quantity'],
            ];
        }

        $request->session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'cart_count' => collect($cart)->sum('quantity'),
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function buyNow(Request $request)
    {
        $validated = $request->validate([
            'product_type' => 'required|in:lens,frame,accessory',
            'product_key' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = $this->catalog()[$validated['product_type']][$validated['product_key']] ?? null;
        abort_unless($product, 404);

        $request->session()->put('direct_buy', [
            'product_type' => $validated['product_type'],
            'product_key' => $validated['product_key'],
            'name' => $product['name'],
            'category' => $product['category'],
            'price' => $product['price'],
            'quantity' => $validated['quantity'],
        ]);

        return redirect()->route('checkout.index');
>>>>>>> 2b8faee8b8c69a612160f21999c4fbe6f18f1ec5
    }

    public function update(Request $request, string $key)
    {
<<<<<<< HEAD
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $cart = session('cart', []);

        if (!isset($cart[$key])) {
            return redirect()->route('cart.index');
        }

        $model = $cart[$key]['product_type'] === 'lens' ? Lens::class : Frame::class;
        $product = $model::findOrFail($cart[$key]['product_id']);

        if ($request->integer('quantity') > $product->stock) {
            return back()->withErrors(['quantity' => 'Jumlah melebihi stok yang tersedia.']);
        }

        $cart[$key]['quantity'] = $request->integer('quantity');
        $cart[$key]['price'] = $product->price;
        $cart[$key]['stock'] = $product->stock;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Jumlah keranjang diperbarui.');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'planned_visit_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        foreach ($cart as $item) {
            $model = $item['product_type'] === 'lens' ? Lens::class : Frame::class;
            $product = $model::findOrFail($item['product_id']);

            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->withErrors(['cart' => "Stok {$product->name} tidak mencukupi."]);
            }

            Order::create([
                'user_id' => Auth::id(),
                'product_type' => $item['product_type'],
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'planned_visit_date' => $validated['planned_visit_date'],
                'notes' => $validated['notes'] ?: 'Harus datang ke toko untuk konfirmasi pesanan.',
                'status' => 'pending',
                'total_price' => $product->price * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat. Status pending. Silakan datang ke toko sesuai tanggal rencana kunjungan.');
=======
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = $request->session()->get('cart', []);
        abort_unless(isset($cart[$key]), 404);

        $cart[$key]['quantity'] = $validated['quantity'];
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove(Request $request, string $key)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$key]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    private function catalog(): array
    {
        return [
            'lens' => [
                'single-vision-standard' => ['name' => 'Single Vision Standard', 'category' => 'Lensa Resep', 'price' => 150000],
                'anti-radiasi-blue-light' => ['name' => 'Anti Radiasi Blue Light', 'category' => 'Lensa Resep', 'price' => 275000],
                'photochromic-transisi' => ['name' => 'Photochromic (Transisi)', 'category' => 'Lensa Resep', 'price' => 550000],
                'progressive-multifocal' => ['name' => 'Progressive Multifocal', 'category' => 'Lensa Resep', 'price' => 850000],
                'soft-contact-lens-bening' => ['name' => 'Soft Contact Lens Bening', 'category' => 'Lensa Kontak', 'price' => 120000],
                'contact-lens-silicone-hydrogel' => ['name' => 'Contact Lens Silicone Hydrogel', 'category' => 'Lensa Kontak', 'price' => 210000],
                'lapisan-anti-gores' => ['name' => 'Lapisan Anti Gores', 'category' => 'Lensa Tambahan', 'price' => 50000],
                'lapisan-anti-air-minyak' => ['name' => 'Lapisan Anti Air & Minyak', 'category' => 'Lensa Tambahan', 'price' => 75000],
            ],
            'frame' => [
                'classic-round-tr90' => ['name' => 'Classic Round TR90', 'category' => 'Pria', 'price' => 350000],
                'cat-eye-acetate' => ['name' => 'Cat Eye Acetate', 'category' => 'Wanita', 'price' => 420000],
                'kids-flexible-frame' => ['name' => 'Kids Flexible Frame', 'category' => 'Anak', 'price' => 275000],
                'titanium-rimless' => ['name' => 'Titanium Rimless', 'category' => 'Pria', 'price' => 650000],
                'vintage-square-metal' => ['name' => 'Vintage Square Metal', 'category' => 'Wanita', 'price' => 390000],
                'reading-glasses-basic' => ['name' => 'Reading Glasses Basic', 'category' => 'Kacamata Baca', 'price' => 180000],
            ],
            'accessory' => [
                'hard-case-kacamata' => ['name' => 'Hard Case Kacamata', 'category' => 'Aksesoris', 'price' => 75000],
                'pouch-kacamata' => ['name' => 'Pouch Kacamata', 'category' => 'Aksesoris', 'price' => 35000],
                'kain-lap-mikrofiber' => ['name' => 'Kain Lap Mikrofiber', 'category' => 'Aksesoris', 'price' => 15000],
                'tali-kacamata' => ['name' => 'Tali Kacamata', 'category' => 'Aksesoris', 'price' => 25000],
                'cairan-pembersih-lensa' => ['name' => 'Cairan Pembersih Lensa', 'category' => 'Aksesoris', 'price' => 30000],
                'obeng-mini-kacamata' => ['name' => 'Obeng Mini Kacamata', 'category' => 'Aksesoris', 'price' => 20000],
            ],
        ];
>>>>>>> 2b8faee8b8c69a612160f21999c4fbe6f18f1ec5
    }
}
