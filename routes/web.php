<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});
Route::get('/tentang-kami', function () {
    return view('about');
});
Route::get('/kontak', function () {
    return view('contact');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/cabang', function () {
    return view('cabang');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('users', UserController::class);
});