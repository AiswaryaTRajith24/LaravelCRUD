<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.count' => 'required|integer|min:1',
            'products.*.total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Calculate grand total
        $grandTotal = array_sum(array_column($request->products, 'total'));

        // Create order
        $order = Order::create([
            'user_id' => $request->user_id,
            'grand_total' => $grandTotal,
        ]);

        // Insert multiple order items
        foreach ($request->products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'count' => $product['count'],
                'total' => $product['total'],
            ]);
        }

        Invoice::create([
            'order_id' => $order->id,
            'grand_total' => $grandTotal,
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order->load('orderItems', 'invoice')
        ], 201);
    }
}
