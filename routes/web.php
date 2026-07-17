<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/kategori_lensa', function () {
    return view('kategori_lensa');
});
Route::get('/users', function () {
    return view('users');
});
Route::get('/kategori_frame', function () {
    return view('kategori_frame');
});
 
