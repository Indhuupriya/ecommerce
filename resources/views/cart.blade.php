@extends('layout.header')
@section('content')
@if($cartItems->isNotEmpty())
<div class="col-sm-12 checkout_whole_section">
    <div class="container">
        <div class="col-sm-12 checkout_part">
            <div class="col-sm-12 cart_section">
                @if (session('success'))
                    <script>
                        toastr.success("{{ session('success') }}");
                    </script>
                @endif
                @if (session('error'))
                    <script>
                        toastr.error("{{ session('error') }}");
                    </script>
                @endif
                <h3>Your Cart: <span class="cart_count">{{ $cartItems->count() }} items</span></h3>
                
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $cartItem)
                            @php $total += $cartItem->product->price * $cartItem->quantity; @endphp
                            <tr data-id="{{ $cartItem->product_id }}">
                                <td><img src="{{ asset('storage/' . $cartItem->product->images) }}" width="50" height="50" alt="product"></td>
                                <td>{{ $cartItem->product->name }}</td>
                                <td>${{ number_format($cartItem->product->price, 2) }}</td>
                                <td>
                                    <div class="input-group quantity">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary btn-sm change-quantity" data-type="minus"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="number" name="quantity" class="form-control form-control-sm text-center quantity-input" value="{{ $cartItem->quantity }}" min="1">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-sm change-quantity" data-type="plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="item-total">${{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-item"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" align="right"><strong>Total:</strong></td>
                            <td><strong id="total-amount">${{ number_format($total, 2) }}</strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                    <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@else
<div class="col-sm-12 empty_cart"> 
    <div class="container">
        <div class="col-sm-12 empty_shopping_cart">
            <div class="col-sm-6 emptycart_img">
                <img src="{{ asset('images/home/emptycart1.webp') }}">
            </div>
            <div class="col-sm-6 emptycart_content">
                <h2> Your Cart is empty </h2>
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
            </div>
        </div>
    </div>
</div>        
@endif
@endsection
