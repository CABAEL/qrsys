
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
    <style>
      #time{
        font-family:Tahoma;
        font-size: 50px;
        font-weight: bold;
      }
    </style>
  </head>
  <preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader>
  <?php
      date_default_timezone_set('Asia/Manila');
  ?>