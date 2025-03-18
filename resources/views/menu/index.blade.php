@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Our Menu</h1>
    
    @foreach($categories as $category)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">{{ $category->name }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($category->menuItems as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text">{{ $item->description }}</p>
                                    <p class="card-text"><strong>${{ number_format($item->price, 2) }}</strong></p>
                                    
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                        <div class="form-group">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="instructions">Special Instructions:</label>
                                            <textarea name="instructions" id="instructions" class="form-control" rows="2"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection