<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\LensController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Frame;
use App\Models\Accessory;
use App\Models\Lens;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/tentang-kami', function () {
    return view('about');
});
Route::get('/kontak', function () {
    return view('contact');
});
Route::get('/cabang', function () {
    return view('cabang');
});
Route::get('/produk/frame', function () {
    $frames = Frame::latest()->get();

    return view('frame', compact('frames'));
});
Route::get('/produk/lensa', function () {
    $lenses = Lens::latest()->get();

    return view('lensa', compact('lenses'));
});
Route::get('/produk/aksesoris', function () {
    $accessories = Accessory::latest()->get();

    return view('aksesoris', compact('accessories'));
});

Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::post('/beli-sekarang', [CartController::class, 'buyNow'])->name('cart.buyNow');
Route::patch('/keranjang/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{key}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $totalUsers = User::count();
        $totalLenses = Lens::count();
        $totalFrames = Frame::count();
        $totalAccessories = Accessory::count();
        $totalProducts = $totalLenses + $totalFrames + $totalAccessories;

        $role = $user?->role ?? 'PELANGGAN';

        $customerOrders = $user && $user->role === 'PELANGGAN'
            ? \App\Models\Order::where('user_id', $user->id)->with(['lens', 'frame', 'accessory'])->latest()->get()
            : collect();

        $pendingOrders = $customerOrders->where('status', 'pending')->count();
        $completedOrders = $customerOrders->where('status', 'selesai')->count();
        $canceledOrders = $customerOrders->where('status', 'batal')->count();
        $branchOrder = $user && $user->role === 'PELANGGAN'
            ? \App\Models\Order::where('user_id', $user->id)->whereNotNull('branch_id')->latest()->first()
            : null;

        return view('dashboard', compact(
            'user',
            'role',
            'totalUsers',
            'totalLenses',
            'totalFrames',
            'totalAccessories',
            'totalProducts',
            'customerOrders',
            'pendingOrders',
            'completedOrders',
            'canceledOrders',
            'branchOrder'
        ));
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(RoleMiddleware::class . ':ADMIN')->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware(RoleMiddleware::class . ':KARYAWAN,ADMIN')->group(function () {
        Route::resource('lenses', LensController::class);
        Route::resource('frames', FrameController::class);
        Route::resource('accessories', AccessoryController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    Route::middleware(RoleMiddleware::class . ':PELANGGAN,KARYAWAN,ADMIN')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
        Route::post('/checkout', [OrderController::class, 'confirmCheckout'])->name('checkout.confirm');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    Route::middleware(RoleMiddleware::class . ':PELANGGAN')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{key}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{key}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    });
});