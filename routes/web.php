<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\LensController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Frame;
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
    return view('frame');
});
Route::get('/produk/lensa', function () {
    return view('lensa');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $totalUsers = User::count();
        $totalLenses = Lens::count();
        $totalFrames = Frame::count();
        $totalProducts = $totalLenses + $totalFrames;

        $role = $user?->role ?? 'PELANGGAN';

        $customerOrders = $user && $user->role === 'PELANGGAN'
            ? \App\Models\Order::where('user_id', $user->id)->with(['lens', 'frame'])->latest()->get()
            : collect();

        $pendingOrders = $customerOrders->where('status', 'pending')->count();
        $completedOrders = $customerOrders->where('status', 'selesai')->count();
        $canceledOrders = $customerOrders->where('status', 'batal')->count();

        return view('dashboard', compact(
            'user',
            'role',
            'totalUsers',
            'totalLenses',
            'totalFrames',
            'totalProducts',
            'customerOrders',
            'pendingOrders',
            'completedOrders',
            'canceledOrders'
        ));
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(RoleMiddleware::class . ':ADMIN')->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware(RoleMiddleware::class . ':KARYAWAN,ADMIN')->group(function () {
        Route::resource('lenses', LensController::class);
        Route::resource('frames', FrameController::class);
    });

    Route::middleware(RoleMiddleware::class . ':PELANGGAN,KARYAWAN,ADMIN')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
});