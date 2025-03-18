@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Orders</h1>
    
    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            You haven't placed any orders yet. <a href="{{ route('menu.index') }}">Browse our menu</a> to place an order.
        </div>
    @endif
</div>
@endsection