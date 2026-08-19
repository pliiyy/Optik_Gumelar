<?php

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
Route::get('/login', function () {
    return view('login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/cabang', function () {
    return view('cabang');
});
