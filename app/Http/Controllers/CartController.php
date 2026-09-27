<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
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
    }

    public function update(Request $request, string $key)
    {
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
    }
}
