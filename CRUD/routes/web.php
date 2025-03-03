<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/products', function () {
    return view('product_list');
})->name('products');

Route::get('/checkout', function(){
    return view('checkout');
});

Route::get('/order-history', function(){
    return view('order_history');
});

Route::get('/invoice', function(){
    return view('invoice');
});

Route::get('/user-dashboard', function(){
    return view('user_dashboard');
})->name('user-dashboard');