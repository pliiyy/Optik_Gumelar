<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Lens;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
