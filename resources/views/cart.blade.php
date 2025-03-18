@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Your Cart</h1>
    
    @if(session('cart') && count(session('cart')) > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Instructions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr>
                            <td>{{ $details['name'] }}</td>
                            <td>${{ number_format($details['price'], 2) }}</td>
                            <td>{{ $details['quantity'] }}</td>
                            <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                            <td>{{ $details['instructions'] ?? 'None' }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td colspan="3"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-right mt-4">
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
            
            @auth
                <a href="{{ route('orders.create') }}" class="btn btn-success">
                    <i class="fas fa-check"></i> Proceed to Checkout
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login to Checkout
                </a>
            @endauth
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('menu.index') }}">Browse our menu</a> to add items.
        </div>
    @endif
</div>
@endsection