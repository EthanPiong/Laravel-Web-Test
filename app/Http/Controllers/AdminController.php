<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalOrders', 
            'pendingOrders', 
            'totalUsers', 
            'totalRevenue', 
            'recentOrders'
        ));
    }
}
