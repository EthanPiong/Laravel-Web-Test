<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.menuItem')->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_address' => 'required|string',
            'contact_phone' => 'required|string',
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.special_instructions' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $total = 0;
        $items = [];
        
        foreach ($request->items as $item) {
            $menuItem = MenuItem::findOrFail($item['menu_item_id']);
            $subtotal = $menuItem->price * $item['quantity'];
            $total += $subtotal;
            
            $items[] = [
                'menu_item_id' => $menuItem->id,
                'quantity' => $item['quantity'],
                'price_per_unit' => $menuItem->price,
                'subtotal' => $subtotal,
                'special_instructions' => $item['special_instructions'] ?? null
            ];
        }
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'delivery_address' => $request->delivery_address,
            'contact_phone' => $request->contact_phone
        ]);
        
        foreach ($items as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'order_id' => $order->id,
            'data' => $order->load('items.menuItem')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::where('user_id', Auth::id())
        ->with('items.menuItem')
        ->findOrFail($id);
        
        return response()->json([
        'status' => 'success',
        'data' => $order
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if (!in_array($order->status, ['pending', 'confirmed'])) 
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Order cannot be modified at this stage'
            ], 400);
        }
        
        $validator = Validator::make($request->all(), [
            'delivery_address' => 'sometimes|required|string',
            'contact_phone' => 'sometimes|required|string'
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $order->update($request->only(['delivery_address', 'contact_phone']));
        
        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'data' => $order->load('items.menuItem')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if ($order->status !== 'pending') 
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Only pending orders can be cancelled'
            ], 400);
        }
        
        $order->status = 'cancelled';
        $order->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Order cancelled successfully'
        ]);
    }
}
