@extends('layout.header')

@section('content')
<div class="col-sm-12">
    <div class="container">
        <div class="col-sm-12 row checkoutprocess">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
            <!-- Left part -->
            <div class="col-sm-6 billing_address">
                <h3>Billing Address</h3>
                <form action="{{ route('checkout.saveAddress') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                        <input class="form-control" type="text" id="fname" name="firstname" placeholder="John M. Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                        <input class="form-control" type="text" id="adr" name="address" placeholder="542 W. 15th Street" required>
                    </div>
                    <div class="form-group">
                        <label for="city"><i class="fa fa-institution"></i> City</label>
                        <input class="form-control" type="text" id="city" name="city" placeholder="New York" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input class="form-control" type="text" id="state" name="state" placeholder="NY" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip</label>
                        <input class="form-control" type="text" id="zip" name="zip" placeholder="10001" required>
                    </div>
            </div>
             <!-- Right part -->
            <div class="col-sm-5 cart_section_right">
                <h3>Order Summary <span class="cart_count">({{ $cartItems->count() }} items)</span></h3>
                <table id="cart" class="table table-hover table-condensed">
                    <tbody>
                        <tr>
                            <td>Merchandise Subtotal</td>
                            <td>{{ number_format($subtotal, 2) }} USD</td>
                        </tr>
                        <tr>
                            <td>SimpleCart Shipping</td>
                            <td>{{ number_format($shipping, 2) }} USD</td>
                        </tr>
                        <tr>
                            <td>International Shipping</td>
                            <td>{{ number_format($shipping, 2) }} USD</td>
                        </tr>
                        <tr>
                            <td>Sales Tax</td>
                            <td>{{ number_format($tax, 2) }} USD</td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td class="total-amount">{{ number_format($total, 2) }} USD</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right">
                                <button type="submit" class="btn btn-success">Checkout</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection
