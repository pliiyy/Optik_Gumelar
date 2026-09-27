<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Lens;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'PELANGGAN') {
            $orders = Order::where('user_id', $user->id)->with(['lens', 'frame'])->latest()->get();
        } else {
            $orders = Order::with(['user', 'lens', 'frame'])->latest()->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function checkout(Request $request)
    {
        $product = $request->session()->get('direct_buy');
        $items = $product ? [$product] : array_values($request->session()->get('cart', []));

        if (count($items) === 0) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk terlebih dahulu.');
        }

        $total = collect($items)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('checkout', compact('items', 'total'));
    }

    public function confirmCheckout(Request $request)
    {
        $request->validate([
            'terms' => 'accepted',
            'notes' => 'nullable|string|max:500',
        ], [
            'terms.accepted' => 'Anda harus menyetujui syarat pembelian terlebih dahulu.',
        ]);

        $directBuy = $request->session()->get('direct_buy');
        $items = $directBuy ? [$directBuy] : array_values($request->session()->get('cart', []));

        if (count($items) === 0) {
            return redirect()->route('cart.index')->with('error', 'Sesi pembelian sudah berakhir.');
        }

        $transactionCode = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5));

        foreach ($items as $item) {
            Order::create([
                'user_id' => Auth::id(),
                'product_type' => $item['product_type'],
                'product_id' => null,
                'product_key' => $item['product_key'],
                'product_name' => $item['name'],
                'product_category' => $item['category'],
                'transaction_code' => $transactionCode,
                'quantity' => $item['quantity'],
                'notes' => $request->notes ?: 'Harus datang ke toko untuk konfirmasi pesanan.',
                'status' => 'pending',
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        $request->session()->forget('direct_buy');
        $request->session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat. Status: Pending. Harus datang ke toko untuk proses selanjutnya.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_type' => 'required|in:lens,frame',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $modelClass = $request->product_type === 'lens' ? Lens::class : Frame::class;
        $product = $modelClass::findOrFail($request->product_id);

        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_type' => $request->product_type,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'notes' => $request->notes ?: 'Harus datang ke toko untuk konfirmasi pesanan.',
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat. Status: Pending. Harus datang ke toko untuk proses selanjutnya.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,selesai,batal',
        ]);

        $statusData = [
            'status' => $request->status,
        ];

        if ($order->transaction_code) {
            Order::where('transaction_code', $order->transaction_code)->update($statusData);
        } else {
            $order->update($statusData);
        }

        return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
