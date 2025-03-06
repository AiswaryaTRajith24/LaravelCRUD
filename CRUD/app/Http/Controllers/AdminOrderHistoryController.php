<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class AdminOrderHistoryController extends Controller
{
    public function getOrdersForAdmin(): JsonResponse
    {
        try {
            $orders = Order::with([
                'User:name,email,address,phone_number',
                'orderItems:order_id,product_id,count,total',
                'orderItems.Product:name,price',
                'invoice:order_id,grand_total,created_at',
            ])->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No orders found.',
                ], 404);
            }

            $formattedOrders = $orders->map(function ($order) {
                return [
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
                    'created_at' => $order->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedOrders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch orders: ' . $e->getMessage(),
            ], 500);
        }
    }
    }
