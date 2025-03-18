<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id()->findOrFail($id));
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $cart = session()->get('cart',[]);
        $cartItrms = [];
        $total = 0;

        foreach($cart as $id => $details)
        {
            $menuItem = MenuItem::find($id);
            if($menuItem)
            {
                $cartItrms[] = [
                    'menu_item' => $menuItem,
                    'quantity' =>$details['quantity']
                ];
                $total += $menuItem->price * $details['quantity'];
            }  
        }

        return view('orders.create', compact('cartItrms', 'total'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required',
            'contact_phone' => 'required'
        ]);

        $cart = session()->get('cart',[]);
        if(empty($cart))
        {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach($cart as $id => $details)
        {
            $menuItem = MenuItem::find($id);
            if($menuItem)
            {
                $total += $menuItem->price * $details['quantity'];
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'delivery_address' => $request->delivery_address,
            'contact_phone' => $request->contact_phone
        ]);

        foreach($cart as $id => $details)
        {
            $menuItem = MenuItem::find($id);
            if($menuItem)
            {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_per_unit' => $menuItem->price,
                    'subtotal' => $menuItem->price * $details['quantity'],
                    'special_instructions' => $details['instructions'] ?? null
                ]);
            }
        }

        session()->forget('cart');

        return redirect()->route('order.show',$order->id)->with('success','Order placed successfully');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|numeric|min:1'
        ]);
        
        $id = $request->menu_item_id;
        $menuItem = MenuItem::findOrFail($id);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) 
        {
            $cart[$id]['quantity'] += $request->quantity;
        } 
        else 
        {
            $cart[$id] = [
                'name' => $menuItem->name,
                'quantity' => $request->quantity,
                'price' => $menuItem->price,
                'instructions' => $request->instructions
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart!');
    }
    
    public function cart()
    {
        return view('cart');
    }
    
    public function removeFromCart(Request $request)
    {
        if ($request->id) 
        {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) 
            {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

}