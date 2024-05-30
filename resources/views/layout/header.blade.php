<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @php
        $favicon = \App\Models\Setting::getValue('favicon');
    @endphp

    @if ($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}" type="image/png">
    @endif

    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/slick.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/style.css')}}"> 
    <link rel="stylesheet" href="{{URL::to('css/style2.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ URL::to('css/datatables.min.css')}}">
    <script src="{{URL::to('js/jquery.min.js')}}"></script>
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('js/slick.min.js')}}"></script>
    <script src="{{URL::to('js/custom.js')}}"></script>
    <script src="{{URL::to('js/datatables.min.js')}}"></script>
    <script src="{{URL::to('js/toastr.min.js')}}"></script>
</head>
<div class="overlay"></div>
<header>
        <div class="col-sm-12 header_wrapper">
            <div class="col-sm-12 header_top">
                <div class="container">
                    <div class="col-sm-12 header_top_cover">
                        <div class="col-sm-12 header_top_section">
                            <div class="header_logo">
                                <a href="{{ URL::to('/') }}"><h2>SimpleCart</h2></a>
                            </div>
                        </div>
                        <div class="header_top_right">
                        @if(auth()->user())
                        <?php 
                        $user = auth()->user(); 
                        ?>
                        @if(!empty($user['profile_image']))  
                        <?php 
                        $profile = URL::to('storage/profile_image/' . $user['profile_image']);
                        ?>
                        <div class="dropdown">
                        <img src="{{$profile}}" class="my_account" alt="profile_img" id="profileDropdown">
                        <div class="dropdown-content" id="dropdownContent">
                            <a href="{{route('myaccount')}}">My Account</a>
                            <a href="{{route('logout')}}">Logout</a>
                        </div>
                        </div>
                        @else
                        <div class="dropdown">
                        <i class="fa fa-user-circle-o my_account" aria-hidden="true" id="profileDropdown"></i>

                        <div class="dropdown-content" id="dropdownContent">
                            <a href="{{route('myaccount')}}">My Account</a>
                            <a href="{{route('logout')}}">Logout</a>
                        </div>
                        </div>
                        @endif                           
                        @else
                        <a href="#" id="user_login" class="popup_func"><i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                        @endif
                            <a href="{{route('cart.show')}}" class="cart_btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span class="count">{{ $cartItems->count() }}</span>
                            </a>
                            <a href="{{route('wishlist')}}" class="cart_btn"><i class="fa fa-heart" aria-hidden="true"></i>
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-sm-12 header_bottom_section">
                <div class="container">
                    <div class="col-sm-2 header_menu">
                        <a>SHOP NOW </a>
                    </div>
                    <div class="col-sm-10 header_search_form">
                        <form id="search-form">
                            <input type="search" name="query" class="form-control rounded" placeholder="Search Products" aria-label="Search" aria-describedby="search-addon" />
                            <button type="button" class="btn btn-outline-primary" id="search-button">Search</button>
                        </form>
                    </div>
                </div>
           </div>
        </div>
        <!-- login and register form -->
        <div class="col-sm-12 login_form" id="login_form">
            <span class="signinclose_btn"><i class="fa fa-times" aria-hidden="true"></i>
            </span>
               
            <h2>Sign In</h2>
            <form method="post" action="">
              <div class="col-sm-12 form-group">
                 <input type="email" class="form-control" id="login_email" name="email" placeholder="Email" required>
              </div>
              <div class="col-sm-12 form-group">
                 <input type="password" class="form-control" id="login_password" name="password" placeholder="Password" required>
              </div>
              <div class="col-sm-12 form-group" id="forget_password">
                 <a href="#">Forget password?</a>
              </div>
              <div class="col-sm-12 form-group">
                <button class="login_submit" type="submit" id="login_submit" value="Submit">Sign in to Shopping</button>
            </div>
            <div class="col-sm-12 reg_form">
                <p>Don't have an account yet?
                <a href="#" id="register_form"> Create one</a></p>
            </div>
            <div class="col-sm-12 signin_or">
                <p>OR</p>
            </div>
            <div class="col-sm-12 signinother_login">
                <a href="{{ url('auth/google') }}" class="google_login">Sign in with Google</a>
            </div>
            </form>
        </div>
     
         <div class="col-sm-12 forget_password" id="forget_form">
            <span class="signinclose_btn"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="col-sm-12 forget_back">
                <a href="#" class="go_back">Back to Sign In</a>
             </div>
             <h2>Forgot your password?</h2>
             <p>Enter your email to receive instructions on how to reset your password.</p>
            
             <form>
                 <div class="col-sm-12 form-group">
                     <input type="email" class="form-control" name="email" placeholder="Email" id="forget_email" required>
                 </div>
                 <div class="col-sm-12 form-group">
                    <button class="forget_submit" id="forget_submit" type="submit"  value="Submit">Submit</button>
                </div>
             </form>
         </div>


         <div class="col-sm-12 regis_form" id="registration_form">
            <span class="signinclose_btn"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="col-sm-12 forget_back">
                <a href="#" class="go_back">Back to Sign In</a>
             </div>
            <h2>Registration</h2>
            <form method="post" action="">
              <div class="col-sm-12 form-group">
                 <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
              </div>
              <div class="col-sm-12 form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
             </div>
              <div class="col-sm-12 form-group">
                 <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
              </div>
              <div class="col-sm-12 form-group">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
             </div>
             <div class="col-sm-12 form-group">
                <input type="number" class="form-control" name="phone" id="phone" placeholder="91+" required>
             </div>
             <div class="col-sm-12 form-group">
                 <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
              </div>
              <div class="col-sm-12 form-group">
                <button class="register_submit" type="button" id="register_submit" value="Submit">Register Shopping</button>
            </div>
            </form>
         </div>

    </header>
        @yield('content')
    @include('layout.footer')
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>

<script>
$(document).ready(function() {
    // Update item quantity
    $('.change-quantity').on('click', function() {
        var $row = $(this).closest('tr');
        var $quantityInput = $row.find('.quantity-input');
        var quantity = parseInt($quantityInput.val());
        var type = $(this).data('type');
        if (type === 'plus') {
            quantity++;
        } else if (type === 'minus' && quantity > 1) {
            quantity--;
        }
        $quantityInput.val(quantity);
        updateCart($row.data('id'), quantity);
    });

    // Handle quantity input change
    $('.quantity-input').on('change', function() {
        var $row = $(this).closest('tr');
        var quantity = parseInt($(this).val());
        if (quantity < 1) quantity = 1;
        $(this).val(quantity);
        updateCart($row.data('id'), quantity);
    });

    // Remove item from cart
    $('.remove-item').on('click', function() {
        var $row = $(this).closest('tr');
        var id = $row.data('id');
        $row.remove();
        removeItem(id);
        updateTotal();
    });

    // Function to update cart item
    function updateCart(id, quantity) {
        $.post("{{ route('cart.update') }}", {
            id: id,
            quantity: quantity,
            _token: "{{ csrf_token() }}"
        }, function(data) {
            if (data.success) {
                updateTotal();
                toastr.success(data.message);
                window.location.href="{{ URL::to('/cart') }}";
            } else {
                toastr.error(data.message);
            }
        }).fail(function() {
            toastr.error('Error updating cart. Please try again.');
        });
    }

    // Function to remove item
    function removeItem(id) {
        $.post("{{ route('cart.remove') }}", {
            id: id,
            _token: "{{ csrf_token() }}"
        }, function(data) {
            if (data.success) {
                updateTotal();
                toastr.success(data.message);
                window.location.href="{{ URL::to('/cart') }}";
            } else {
                toastr.error(data.message);
            }
        }).fail(function() {
            toastr.error('Error removing item. Please try again.');
        });
    }

    // Function to update total amount
    function updateTotal() {
        var total = 0;
        $('.item-total').each(function() {
            total += parseFloat($(this).text().replace('$', ''));
        });
        $('#total-amount').text('$' + total.toFixed(2));
    }
});
</script>



</body>
</html>