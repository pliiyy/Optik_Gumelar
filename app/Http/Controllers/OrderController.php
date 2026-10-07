<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Lens;
use App\Models\Order;
use App\Services\CatalogProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'PELANGGAN') {
            $orders = Order::where('user_id', $user->id)->with(['lens', 'frame', 'accessory'])->latest()->get();
        } else {
            $orders = Order::with(['user', 'lens', 'frame', 'accessory'])->latest()->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function invoice(Order $order)
    {
        $user = Auth::user();

        abort_unless($user->role !== 'PELANGGAN' || $order->user_id === $user->id, 403);

        $orders = $order->transaction_code
            ? Order::where('transaction_code', $order->transaction_code)
                ->where('user_id', $order->user_id)
                ->with('user')
                ->orderBy('id')
                ->get()
            : Order::whereKey($order->id)->with('user')->get();

        $branch = config('branches.' . $order->branch_id);

        return view('orders.invoice', [
            'orders' => $orders,
            'customer' => $order->user,
            'transactionCode' => $order->transaction_code ?: 'TRX-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            'branch' => $branch,
            'issuedAt' => $order->created_at,
        ]);
    }

    public function checkout(Request $request)
    {
        $product = $request->session()->get('direct_buy');
        $items = $product ? [$product] : array_values($request->session()->get('cart', []));

        if (count($items) === 0) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk terlebih dahulu.');
        }

        $total = collect($items)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $branches = config('branches');

        return view('checkout', compact('items', 'total', 'branches'));
    }

    public function confirmCheckout(Request $request, CatalogProductService $catalogProducts)
    {
        $request->validate([
            'terms' => 'accepted',
            'notes' => 'nullable|string|max:500',
            'branch_id' => ['required', 'string', Rule::in(array_keys(config('branches')))],
            'buyer_latitude' => 'required|numeric|between:-90,90',
            'buyer_longitude' => 'required|numeric|between:-180,180',
        ], [
            'terms.accepted' => 'Anda harus menyetujui syarat pembelian terlebih dahulu.',
            'branch_id.required' => 'Pilih cabang sebelum membuat pesanan.',
            'buyer_latitude.required' => 'Izinkan akses lokasi untuk menghitung jarak ke cabang.',
            'buyer_longitude.required' => 'Izinkan akses lokasi untuk menghitung jarak ke cabang.',
        ]);

        $directBuy = $request->session()->get('direct_buy');
        $items = $directBuy ? [$directBuy] : array_values($request->session()->get('cart', []));

        if (count($items) === 0) {
            return redirect()->route('cart.index')->with('error', 'Sesi pembelian sudah berakhir.');
        }

        $transactionCode = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5));
        $branch = config('branches.' . $request->branch_id);
        $distance = $this->distanceInKilometers(
            (float) $request->buyer_latitude,
            (float) $request->buyer_longitude,
            $branch['latitude'],
            $branch['longitude']
        );

        DB::transaction(function () use ($items, $transactionCode, $branch, $distance, $request, $catalogProducts) {
            foreach ($items as $item) {
                $product = $catalogProducts->ensureExists($item);

                Order::create([
                    'user_id' => Auth::id(),
                    'product_type' => $item['product_type'],
                    'product_id' => $product->id,
                    'product_key' => $item['product_key'],
                    'product_name' => $item['name'],
                    'product_category' => $item['category'],
                    'transaction_code' => $transactionCode,
                    'branch_id' => $request->branch_id,
                    'branch_name' => $branch['name'],
                    'branch_distance_km' => $distance,
                    'buyer_latitude' => $request->buyer_latitude,
                    'buyer_longitude' => $request->buyer_longitude,
                    'quantity' => $item['quantity'],
                    'notes' => $request->notes ?: 'Harus datang ke toko untuk konfirmasi pesanan.',
                    'status' => 'pending',
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
            }
        });

        $request->session()->forget('direct_buy');
        $request->session()->forget('cart');

        return redirect('/dashboard')->with('success', 'Pesanan berhasil dibuat. Cabang pilihan: ' . $branch['name'] . ' (' . number_format($distance, 2) . ' km dari lokasi Anda).');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_type' => 'required|in:lens,frame',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'planned_visit_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $modelClass = $request->product_type === 'lens' ? Lens::class : Frame::class;
        $product = $modelClass::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->withErrors([
                'quantity' => 'Jumlah pesanan melebihi stok yang tersedia.',
            ])->withInput();
        }

        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_type' => $request->product_type,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'planned_visit_date' => $request->planned_visit_date,
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

    private function distanceInKilometers(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo): float
    {
        $earthRadius = 6371;
        $latitudeDelta = deg2rad($latitudeTo - $latitudeFrom);
        $longitudeDelta = deg2rad($longitudeTo - $longitudeFrom);
        $a = sin($latitudeDelta / 2) ** 2
            + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * sin($longitudeDelta / 2) ** 2;

        return round($earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a)), 2);
    }
}
