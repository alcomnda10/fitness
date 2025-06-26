<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        $order = Order::create([
            'items' => $request->items,  
            'total' => $request->total,
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'items' => 'sometimes|array',
            'items.*.product_id' => 'required_with:items|integer|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'total' => 'sometimes|required|numeric',
        ]);

        if ($request->has('items')) {
            $order->items = $request->items; 
        }
        if ($request->has('total')) {
            $order->total = $request->total;
        }

        $order->save();

        return response()->json($order, 200);
    }
}
