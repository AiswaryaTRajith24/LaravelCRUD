<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function productsList(){
        $products = Products::all();
        return response()->json($products);
    }
}
