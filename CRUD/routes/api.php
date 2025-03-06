<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\DeleteUserController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\UserListingController;
use App\Http\Controllers\CreateProductController;
use App\Http\Controllers\DeleteProductController;
use App\Http\Controllers\UpdateProductController;
use App\Http\Controllers\OrderController;

// Public Routes (No Authentication Required)
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Authentication)
Route::middleware('jwt.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/getallproducts', [ProductListingController::class, 'productsList']);
    Route::post('/place-order', [OrderController::class, 'store']);
    

    // User CRUD (Only accessible if the user is an admin)
    Route::middleware('admin')->group(function () {
        Route::get('/getallusers',[UserListingController::class,'usersList']);
        Route::post('/createuser',[CreateUserController::class,'createUser']);
        Route::post('/deleteuser/{id}',[DeleteUserController::class,'deleteUser']);
        Route::post('/updateuser/{id}',[UpdateUserController::class,'updateUser']);
        Route::post('/createproduct',[CreateProductController::class,'createProduct']);
        Route::post('/deleteproduct/{id}',[DeleteProductController::class,'deleteProduct']);
        Route::post('/updateproduct/{id}',[UpdateProductController::class,'updateProduct']);
    });
});
