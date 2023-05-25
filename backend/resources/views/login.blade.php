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
    <div class="container" style="margin-top: 15%;">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">
        <span style="font-size:10px;">Welcome to</span> <span style="font-family:tahoma;color:#032c45;font-weight:bolder;">Intellidocs</span>
        </div>
        <div class="card-body">
          <form id="loginForm">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" required>
            </div>
            <div class="form-group">
            <label>Password</label>
            <div class="input-group" id="show_hide_password">
              <input class="form-control" id="password" type="password" required/>
              <div class="input-group-addon">
              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
              </div>
            </div>
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
           
            <input type="submit" class="btn btn-primary btn-block" id="loginBtn" values="Login"></input>
            <br>
            <a href="/" style=" float:right;"><< Portal</a>
          </form>
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

  $('#loginForm').on('submit',function(event){
    event.preventDefault();
    show_loader();
    var token = $('#csrf').val();
    $.ajax({
        url: "{{route('login_post')}}",
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
          console.log(data.rdr);
          
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

  $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });


});

</script>
<preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader>
<script src="{{ asset('js/custom/preloader.js') }}"></script>
</body>

</html>
