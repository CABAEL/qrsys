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
        <!-- Plugin CSS -->
        <link href="{{ asset('packages/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader>
    <body class="bg-dark">
        <div class="container">
            <div class="card card-register mx-auto mt-5">
                <div class="card-header">
                    Register an Account
                </div>
                <div class="card-body">
                    <form id="add_user_form">
                        <center>
                            <div class="alert alert-danger" id="add_user_errors"></div>
                        </center>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="fname">First name</label>
                                    <input type="text" class="form-control" id="fname" name="fname" autofocus/>
                                </div>
                                <div class="col-md-4">
                                    <label for="mname">Middle name</label>
                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Leave blank if N/A" >
                                </div>
                                <div class="col-md-4">
                                    <label for="lname">Last name</label>
                                    <input type="text" class="form-control" id="lname" name="lname" aria-describedby="nameHelp" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="fname">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" autofocus/>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">---</option>
                                        <option value="M">MALE</option>
                                        <option value="F">FEMALE</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="lname">Birth date</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" aria-describedby="nameHelp" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="fname">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" autofocus/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile_number">Mobile number</label>
                                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" aria-describedby="nameHelp">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                                </div>
                                <div class="col-md-6">
                                    <label for="retypePassword">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" />
                                        <div class="input-group-append" onclick="viewpass()">
                                            <i class="fa fa-eye" id="viewpass"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="password_confirmation">Retype Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
                                        <div class="input-group-append" onclick="view_retype_pass()">
                                            <i class="fa fa-eye" id="view_retype_pass"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <button class="btn btn-primary btn-block" id="registerBtn">Submit</button>
                        <br>
                        <a class="d-block small mt-3" href="/login">Login Page</a>
                        <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                </div>
            </div>
            <br>
            <br>
        </div>
        <!-- Bootstrap core JavaScript -->
        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('packages/popper/popper.min.js') }}"></script>
        <script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
        <!--custom js-->
        <script src="{{ asset('js/custom/custom.js') }}"></script>
        <script src="{{ asset('js/custom/page/public/register.js') }}"></script>
        <preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader>
        <script src="{{ asset('js/custom/preloader.js') }}"></script>
    </body>
</html>

