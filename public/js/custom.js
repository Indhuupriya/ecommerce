$(document).ready(function(){
//   popup form
    $(".popup_func").on("click", function() {
        $("body").addClass("popup_part");
    });

    $(" .signinclose_btn").on("click", function() {
        $("body").removeClass("popup_part");
    });

    $('#user_login').on('click', function(e) {
		document.querySelector("#login_form").style.display = "block";
	});
    $('.signinclose_btn').on('click', function(e) {
		document.querySelector("#login_form").style.display = "none";
        document.querySelector("#forget_form").style.display = "none";
        document.querySelector("#registration_form").style.display = "none";
        document.querySelector("#providerss_feedback").style.display = "none";

	});
    $('#forget_password').on('click', function(e) {
		document.querySelector("#forget_form").style.display = "block";
        document.querySelector("#login_form").style.display = "none";
	});
	$('#register_form').on('click', function(e) {
        document.querySelector("#registration_form").style.display = "block";
        document.querySelector("#login_form").style.display = "none";
	});
    $('.forget_back').on('click', function(e) {
        document.querySelector("#login_form").style.display = "block";
        document.querySelector("#forget_form").style.display = "none";
        document.querySelector("#registration_form").style.display = "none";
	});
    /* Registration*/
    $(document).ready(function(){
        $("#register_submit").click(function(e){
            e.preventDefault();
            var name = $("#name").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            var phone = $("#phone").val();
            var address = $("#address").val();
            $.ajax({
                url: '/register',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: name,
                    email: email,
                    password: password,
                    confirm_password: confirm_password,
                    phone: phone,
                    address : address
                },
                success: function(response) {
                    toastr.success("Registeration Successfully ");
                    window.location.href = response.redirect_url;
                    
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if (response.errors) {
                        for (var key in response.errors) {
                            var errorMessages = response.errors[key];
                            toastr.info('Validation Error for ' + key + ': ' + errorMessages.join(', '));
                        }
                    }
                }
            });
        });
    });
    
    /* Login*/
    $(document).ready(function(){
        $("#login_submit").click(function(e){
            e.preventDefault();
            var email = $("#login_email").val();
            var password = $("#login_password").val();
            $.ajax({
                url: '/login',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    if (response.redirect_url) {
                        toastr.success("You have Successfully logged in");
                        window.location.href = response.redirect_url;
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if (response.message) {
                        toastr.error(response.message);
                    } else {
                        toastr.error("Invalid credentials");
                    }
                }
            });
        });
    });

    /** Forget submit**/
    $(document).ready(function(){
      $("#forget_submit").click(function(e){
         e.preventDefault();
         var forget_email = $('#forget_email').val();
         if(forget_email == ''){
            toastr.error('Enter your email address.');
            return false;
         }
         $.ajax({
            url : '/forget-password',
            type : 'POST',
            headers :{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                email : forget_email
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                var response = xhr.responseJSON;
                if (response && response.message) {
                    toastr.error(response.message);
                } else {
                    toastr.error('Invalid credentials');
                }
            }

         });
      });
    });
});

$(document).ready(function(){
    // Check if the current URL matches the "/login" URL
    var loginRouteUrl = "login";
    
    // Extract the host (hostname, protocol, and port) from the current URL
    var currentHost = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
    console.log("Current URL:", window.location.href);
    console.log("Expected URL:", currentHost + '/' + loginRouteUrl);
   
    if (window.location.href === currentHost + '/' + loginRouteUrl) {
        console.log("Login page detected.");
        // Use Laravel Toast to display a toast notification
        toastr.warning('Please login', 'Welcome!');
        $("body").addClass("popup_part");
        document.querySelector("#login_form").style.display = "block";

        // Prevent default navigation behavior
        $(document).on('click', 'a[href="/login"]', function(event){
            event.preventDefault();
        });
    }
});


