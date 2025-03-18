@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Order #{{ $order->id }}</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Order Items</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->menuItem->name }}</td>
                                        <td>${{ number_format($item->price_per_unit, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    @if($order->status === 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="fas fa-times"></i> Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0">Order Details</h3>
                </div>
                <div class="card-body">
                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0">Delivery Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong><br>{{ $order->delivery_address }}</p>
                    <p><strong>Phone:</strong> {{ $order->contact_phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection