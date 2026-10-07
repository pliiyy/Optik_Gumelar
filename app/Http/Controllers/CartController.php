<?php

namespace App\Http\Controllers;

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
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
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
    }

    public function update(Request $request, string $key)
    {
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
    }
}
