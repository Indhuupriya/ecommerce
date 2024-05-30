@extends('layout.header')
@section('content')

<?php 

$user= auth()->user();
$fname= $user->fname;
$lname = $user->lname;
$address = $user->address;
$city = $user->city;

?>
 <div class="col-sm-12 my_profile_section">
    <div class="container">
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

      <div class="page-header">
        </div>
         <div class="panel panel-default">
          <div class="panel-heading panel-heading-nav">
            <ul class="nav nav-tabs">
              <li role="presentation" class="active">
                 <a href="#one" aria-controls="one" role="tab" data-toggle="tab">Your Orders</a>
              </li>
              <li role="presentation">
                <a href="#two" aria-controls="two" role="tab" data-toggle="tab" id="account-info-tab">Account Info</a>
              </li>
              <li role="presentation">
                <a href="#three" aria-controls="three" role="tab" data-toggle="tab" id="address_tab">Addresses</a>
              </li>
              <li role="presentation">
                <a href="#six" aria-controls="six" role="tab" data-toggle="tab">Privacy Info</a>
              </li>
             
            </ul>
          </div>
          <div class="panel-body">
            <div class="tab-content">
                <!-- your orders part -->
<div role="tabpanel" class="tab-pane fade in active" id="one">
    <div class="col-sm-12 your_orders_section">
        <div class="container">
            <div class="col-sm-12 your_orders_top">
                <div class="col-sm-6 orders_count">
                     <p><span>{{ $orders->count() }}</span> Orders</p>
                </div>
                <div class="col-sm-6 show_order_list">
                    <label>Show Orders</label>
                    <select name="show_orders">
                        <option value="last_30">Last 30 days</option>
                        <option value="last_60">Last 60 days</option>
                        <option value="last_90">Last 90 days</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 your_order_part">
                @if($orders->isEmpty())
                    <p>None Found</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Payment Type</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->parent->iteration }}</th>
                                        <td>{{ $order->order_status }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>{{ $order->payment_type }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            @if($order->payment_status == 'completed')
                                                <a href="{{ route('download.invoice', $order->id) }}" target="_blank">Download Invoice</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>


                  <!-- Account info -->
                    <div role="tabpanel" class="tab-pane fade" id="two">
                      <div class="col-sm-12 account_info_part">
                          <div class="container">
                              <div class="col-sm-12 account_information">
                                  <h2>Account Info</h2>
                                  <div class="col-sm-12 account_info_form">
                                      <div class="col-sm-6 acc_form_part">
                                          <form id="update_profile" method="POST" action="{{URL::to('update_profile')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="success-message" style="display: none; color: green;"></div>
                              <div class="error-message" style="display: none; color: red;"></div>
                                        
                                            <div class="col-sm-12 profile_img">
                                              <div class="form-group">
                                              @if(!empty($user['profile_image']))

                                                <img src="{{URL::to('storage/profile_image/' . $user->profile_image)}}" alt="profile">
                                                @else
                                                <img src="{{URL::to('images/avatar.png')}}" alt="profile">
                                                @endif
                                              </div>
                                              <div class="form-group">
                                                <label for="exampleInputFile">Upload Profile</label>
                                                <input id="profile" name="profile_image" type="file">
                                              </div>
                                            </div>
                                            
                                              <div class="form-group">
                                                  <label for="name">Name</label>
                                                  <input class="form-control" id="name" value="{{$user->name}}" type="text" name="name">
                                                  <input type="hidden" class="form-controll" id="user_id" name="id" value="{{$user->id}}">
                                                  @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                                </div>
                                                <div class="form-group">
                                                  <label for="phone">Phone</label>
                                                  <input class="form-control" id="phone" value="{{$user->phone}}" name="phone" type="number"  >
                                                  @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                                </div>
                                              <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input class="form-control" id="email" value="{{$user->email}}" type="email" readonly>
                                              </div>
                                              @if(empty($user['google_id']))
                                              <div class="form-group">
                                                <label for="password">Password</label>
                                                <input class="form-control" id="password" type="password" value="******" readonly>
                                              </div>
                                              @else
                                              <div class="form-group">
                                                <p>Logged in using GoogleAccount</p>
                                              </div>
                                              @endif
                                                <button type="submit" class="btn btn-default">Update</button>
                                          </form>
                                      </div>
                                      @if(empty($user['google_id']))

                                      <div class="col-sm-6 acc_change_pwd">
                                          <a href="{{URL::to('/change-password')}}">Change Password</a>
                                      </div>

                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                        <!-- change password form -->

                      <div class="col-sm-12 change_pwd_whole_part" id="new_password_part">
                                                  <div class="container">
                                                      <div class="col-sm-12 changepwd_section">
                                                          <h2>New Password</h2>
                                                          <form method="POST" action="{{ route('password.change') }}">
                          @csrf
                                                          <div class="form-group">
                                                          <label for="current_password" class="form-label">Current Password</label>
                              <input type="password" name="current_password" id="current_password" class="form-control" required>
                              @error('current_password')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                                                            </div>
                                                            <div class="form-group">
                                                            <label for="password" class="form-label">New Password</label>
                              <input type="password" name="password" id="password" class="form-control" required>
                              @error('password')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                                                          </div>
                                                          <div class="form-group">
                                                          <label for="password_confirmation" class="form-label">Confirm New Password</label>
                              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                              @error('password_confirmation')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                                                          </div>
                                                          <button class="btn btn-default"><a href="{{route('myaccount')}}">Back</a></button>
                                                          <button type="submit" class="btn btn-default">Update</button>
                                                      </form>
                                                      </div>
                                                  </div>
                                              </div>




                                      <!-- your addresses part -->
                  <div role="tabpanel" class="tab-pane fade" id="three">
                        <div class="col-sm-12 addresses_section">
                        <div class="container">
                            <h2>Shipping Addresses</h2>
                      <div class="col-sm-12 addresses_part">
                            @if(isset($address_one) && empty($address_one->address))
                                <a href="{{route('add_address')}}" id="new_address">Add New Address</a>
                                @endif
                                <p><b>Default Address</b></p>
                                <p>{{$address}}</p>
                                @if(isset($address_one) && !empty($address_one->address))
                                <hr>
                                <p>
                                {{$address_one->address}}</p><hr>
                                <a href="{{route('add_address')}}" id="new_address" style="float:right">Change Address</a>
                                @endif 
                      </div>
                      <div class="col-sm-12 addresses_add">
                          <form method="POST" action="{{ route('add_address') }}" id="new_address_one">
                              @csrf <!-- Include the CSRF token -->
                              <div class="form-group">
                                  <label for="add_new_address" class="form-label">Add new address</label>
                                  <input type="text" name="address" id="address" class="form-control" >
                                  @error('address_1')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                  <input type="hidden" name="user_id" class="form-group" value="{{$user->id}}">
                              </div>
                              <button type="submit" class="btn btn-default">Add</button>
                          </form>
                      </div>
                     </div>
                    </div>
                 </div>
              <!-- privacyinfo part -->
              <div role="tabpanel" class="tab-pane fade" id="six">
                <div class="col-sm-12 privacyinfo_section">
                 <div class="container">
                    <h2>Privacy Info</h2>
                     <div class="col-sm-12 privacyinfo_part">
                         <h3>Your Choices</h3>
                         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus incidunt ab tempore iste inventore ratione rem, cum sapiente magni qui sit neque minima quis rerum laborum pariatur explicabo, reiciendis eos.</p>
                         <h3>Access, Correction and Deletion</h3>
                         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus incidunt ab tempore iste inventore ratione rem, cum sapiente magni qui sit neque minima quis rerum laborum pariatur explicabo, reiciendis eos.</p>
                         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus incidunt ab tempore iste inventore ratione rem, cum sapiente magni qui sit neque minima quis rerum laborum pariatur explicabo, reiciendis eos.</p>
                     </div>
                 </div>
                </div>
             </div>


              </div>
            </div>
          </div>
        </div>
      </div>
<script>



if (window.location.href.includes("/myaccount")) {
        // Activate the "Account Info" tab
        $('#account-info-tab').tab('show');
         $("#new_password_part").hide();
    }


    if (window.location.href.includes("/change-password")) {
        // Activate the "Account Info" tab
        $('#account-info-tab').tab('show');
        $("#new_password_part").show();
        $("#one").hide();
        $("#two").hide();
        $("#three").hide();
        $("#four").hide();
        $("#five").hide();
        
    }
    
    if (window.location.href.includes("/myaccount/add_address")) {
        // Activate the "Account Info" tab
        $('#address_tab').tab('show');
        $('.addresses_part').hide()
        $(".addresses_add").show();
        // $("#three").hide();
          $("#one").hide();
        $("#two").hide();
        // $("#three").hide();
        $("#four").hide();
        $("#five").hide();
    }

$(document).ready(function() {
    $('#phone').on('input', function() {
        var phoneNumber = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
       
        if (phoneNumber.length > 10) {
            phoneNumber = phoneNumber.substr(0, 10); // Limit to 10 digits
            $(this).val(phoneNumber);
        }

       
    });

     $('#phone').on('keypress', function(event) {
        var charCode = event.which;
        // Allow only numeric input (0-9) and control keys (e.g., Backspace)
        if (charCode < 48 || charCode > 57) {
            event.preventDefault();
        }
    });
});


// 

  </script>

@endsection