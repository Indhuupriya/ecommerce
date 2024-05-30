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
            <!-- Payment Method Selection -->
            <div class="col-sm-12">
                <h3>Select Payment Method</h3>
                <form action="{{ route('checkout.processPayment') }}" method="POST" id="payment-form">
                    @csrf
                    <!-- <div class="form-group">
                        <label for="payment-method">Choose a payment method:</label>
                        <select name="payment_method" id="payment-method" class="form-control" required>
                            <option value="stripe">Stripe</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div> -->
                    <div class="form-group payment_sec">
                        <div class="form-check stripe_pay">
                            <input class="form-check-input" type="radio" name="payment_method" id="stripe"value="stripe">
                            <label class="form-check-label" for="stripe">
                                <img src="{{URL::to('images/home/strip.png')}}" alt="stripe">
                            </label>
                        </div>
                        <div class="form-check paypal_pay">
                            <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                            <label class="form-check-label" for="paypal">
                                <img src="{{URL::to('images/home/paypal.jpg')}}" alt="paypal">
                            </label>
                        </div>
                    </div>

                    <!-- Add hidden inputs for totals if needed -->
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                    <input type="hidden" name="tax" value="{{ $tax }}">
                    <input type="hidden" name="total" value="{{ $total }}">
                    <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- JavaScript for Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    var elements = stripe.elements();

    var card = elements.create('card');
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Insert the token ID into the form so it gets submitted to the server
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    });
</script>
