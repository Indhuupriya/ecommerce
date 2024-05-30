<script src="{{URL::to('js/jquery.min.js')}}"></script>
<script>
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
        
        // window.location.href ='/';
        // toastr.warning('Please login', 'Welcome!');
        $("body").addClass("popup_part");
        document.querySelector("#login_form").style.display = "block";

        // Prevent default navigation behavior
        $(document).on('click', 'a[href="/login"]', function(event){
            event.preventDefault();
        });
    }
});
    </script>
