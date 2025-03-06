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

Route::get('/add-users', function () {
    return view('add_users');
});

Route::get('/admin-products-list', function () {
    return view('admin_products_list');
});

Route::get('/add-product', function () {
    return view('add_product');
});

Route::get('/manage-products', function () {
    return view('manage_products');
});

Route::get('/get-orders-for-admin', function () {
    return view('admin_order_history');
});
