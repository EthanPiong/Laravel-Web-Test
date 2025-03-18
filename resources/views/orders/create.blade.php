@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Checkout</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Delivery Details</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="delivery_address">Delivery Address:</label>
                            <textarea name="delivery_address" id="delivery_address" class="form-control @error('delivery_address') is-invalid @enderror" rows="3" required>{{ Auth::user()->address }}</textarea>
                            @error('delivery_address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_phone">Contact Phone:</label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ Auth::user()->phone }}" required>
                            @error('contact_phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check"></i> Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0">Order Summary</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item['menu_item']->name }} x {{ $item['quantity'] }}
                                <span>${{ number_format($item['menu_item']->price * $item['quantity'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">
                    <h4 class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection