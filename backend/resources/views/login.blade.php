<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{env('APP_NAME')}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('packages/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('packages/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

  </head>

  <body class="bg-dark">

    <div class="container">

      <div class="card card-login mx-auto mt-5">
        <div class="card-header">
          Login
        </br>
        {{Auth::user();}}
          </br>
        </div>
        <div class="card-body">
          <form id="loginForm">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" id="remember" value="remember" class="form-check-input">
                  Remember Password
                </label>
              </div>
            </div>
            <input type="hidden" value="{{ csrf_token() }}" id="csrf"/>
           
            <a class="btn btn-primary btn-block" id="loginBtn">Login</a>
          </form>
          <!--
          <center><span>Sign-in with: 
            <div class="g-signin2" data-onsuccess="onSignIn" style="width:35px;" alt="Google"></div>
          </span></center>
          <a href="#" onclick="signOut();">Sign out</a>-->
          <div class="text-center">
            <a class="d-block small mt-3" href="/register">Register an Account</a>
            <a class="d-block small" href="{{route('portal')}}">Portal</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('packages/popper/popper.min.js') }}"></script>
    <script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--custom js-->
    <script src="{{ asset('js/custom/custom.js') }}"></script>
<script>
$( document ).ready(function() {
  $('#loginBtn').on('click', function() {
  
  show_loader();
  var token = $('#csrf').val();
  $.ajax({
      url: base_url("login_post"),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data: {
        username: $('#username').val(),
        password: $('#password').val(),
        remember: $('#remember:checked').val(),
      },
      success: function(data) {
        console.log(data);
        
        if(data.flag == 1 ){
          hide_loader();
          window.location = (data.rdr);
        }else{
          alert("Login Failed!");
          hide_loader();
        }
      },
      error: function(e) {
        alert("Login Failed!");
        hide_loader();
      }
  });

}); 
});

</script>
<preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader>
<script src="{{ asset('js/custom/preloader.js') }}"></script>
</body>

</html>
