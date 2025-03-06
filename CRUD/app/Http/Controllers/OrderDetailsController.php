<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function getOrderDetails(int $orderId): JsonResponse
    {
        try {
            $order = Order::with([
                'User:name,email,address', 
                'orderItems:order_id,product_id,count,total', 
                'orderItems.Product:name,price', 
                'invoice:order_id,grand_total,created_at', 
            ])->find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            $formattedOrder = [
                'order_id' => $order->id,
                'user' => $order->user,
                'grand_total' => $order->grand_total,
                'order_items' => $order->orderItems->map(function ($item) {
                    return [
                        'item_id' => $item->id,
                        'product' => $item->product, 
                        'count' => $item->count,
                        'total' => $item->total,
                    ];
                }),
                'invoice' => $order->invoice,
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedOrder,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
            ], 500);
        }
    }
}
