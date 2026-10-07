<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Frame;
use App\Models\Lens;
use App\Models\Order;
use App\Services\CatalogProductService;
use App\Services\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'product_key' => 'required_without:product_id|nullable|string|max:100',
            'product_id' => 'required_without:product_key|nullable|integer',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $productKey = $validated['product_key'] ?? 'db-' . $validated['product_id'];
        $product = $this->catalog()[$validated['product_type']][$productKey] ?? null;
        abort_unless($product, 404);

        $cart = $request->session()->get('cart', []);
        $key = $validated['product_type'] . '-' . $productKey;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $validated['quantity'];
        } else {
            $cart[$key] = [
                'product_type' => $validated['product_type'],
                'product_key' => $productKey,
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
            'product_key' => 'required_without:product_id|nullable|string|max:100',
            'product_id' => 'required_without:product_key|nullable|integer',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $productKey = $validated['product_key'] ?? 'db-' . $validated['product_id'];
        $product = $this->catalog()[$validated['product_type']][$productKey] ?? null;
        abort_unless($product, 404);

        $request->session()->put('direct_buy', [
            'product_type' => $validated['product_type'],
            'product_key' => $productKey,
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

    public function checkout(Request $request, CatalogProductService $catalogProducts)
    {
        $validated = $request->validate([
            'planned_visit_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = $request->session()->get('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        DB::transaction(function () use ($cart, $validated, $catalogProducts) {
            foreach ($cart as $item) {
                $product = $catalogProducts->ensureExists($item);

                Order::create([
                    'user_id' => Auth::id(),
                    'product_type' => $item['product_type'],
                    'product_id' => $product->id,
                    'product_key' => $item['product_key'],
                    'product_name' => $item['name'],
                    'product_category' => $item['category'],
                    'quantity' => $item['quantity'],
                    'planned_visit_date' => $validated['planned_visit_date'],
                    'notes' => $validated['notes'] ?: 'Harus datang ke toko untuk konfirmasi pesanan.',
                    'status' => 'pending',
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
            }
        });

        $request->session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dikirim. Status: Pending.');
    }

    private function catalog(): array
    {
        $catalog = ProductCatalog::items();

        foreach ([
            'lens' => Lens::class,
            'frame' => Frame::class,
            'accessory' => Accessory::class,
        ] as $type => $modelClass) {
            foreach ($modelClass::all() as $product) {
                $key = $product->catalog_key ?: 'db-' . $product->id;
                $catalog[$type][$key] = [
                    'name' => $product->name,
                    'category' => $product->category,
                    'price' => $product->price,
                    'description' => $product->description,
                ];
            }
        }

        return $catalog;
    }
}