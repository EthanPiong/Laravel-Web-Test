<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = Order::with('user');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $orders = $query->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders', 'status'));
    }
    
    public function show(Order $order)
    {
        $order->load('items.menuItem', 'user');
        return view('admin.orders.show', compact('order'));
    }
    
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled'
        ]);
        
        $order->update([
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}