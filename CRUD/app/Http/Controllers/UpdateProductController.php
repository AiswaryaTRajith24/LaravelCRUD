<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



class UpdateProductController extends Controller
{
    public function updateProduct(Request $request, $id)
    {
        Log::info('Received product update request', [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image' => $request->hasFile('image') ? 'Image received' : 'No image received'
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'stock' => 'sometimes|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $product = Products::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/products'), $imageName);
            $product->image = 'assets/products/' . $imageName;
        }


        if($request->has('name')){
            $product->name = $request->name;
        }
        if($request->has('description')){
            $product->description = $request->description;
        }
        if($request->has('price')){
            $product->price = $request->price;
        }
        if($request->has('stock')){
            $product->stock = $request->stock;
        }

        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ], 200);
    }
}
