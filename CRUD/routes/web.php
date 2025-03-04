<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/user-dashboard', function () {
    return view('product_list');
})->name('user-dashboard');

Route::get('/admin-dashboard', function () {
    return view('users_list');
})->name('admin-dashboard');

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/order-history', function () {
    return view('order_history');
});

Route::get('/invoice', function () {
    return view('invoice');
});

Route::get('/manage-users', function () {
    return view('manage_users');
});

