<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <title>{{env('APP_NAME')}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('packages/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('packages/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader>


    </head>
    <body>
    <div class="container">
        <br>
        <br>
        <div class="form-row">
            <div class="col-md-4">
                <?php
                
                $download_link = url_host('uploads/system_files/clients_directory/').$data['client_folder']."/file_uploads"."/".$data['filename'];
                $logo_link = url_host('uploads/system_files/clients_directory/').$data['client_folder']."/logo"."/".$data['logo'];
                // print_r($download_link);
                ?>
            </div>
            <div class="col-md-4"><h4>SCAN QR CODE OR CLICK HERE TO DOWNLOAD</h4> <a href="">
                <center><a href="{{$download_link}}" target="_blank"><button class="btn btn-default">Download</button></a><center>
            </div>
            <div class="col-md-4"></div>
        </div>
        <br>

        <div class="form-row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
        <div class="qrcodeContainer">
            <div id="qrcodeCanvas"></div>
            <img src="{{$logo_link}}" width="65px" height="65px" class="center qr_logo"/>
        </div>
        </div>
        <div class="col-md-4">
        </div>
        </div>
    </div>    
    <br>
    <iframe src="https://docs.google.com/viewer?url={{$download_link}}&embedded=true" style="width:100vw; height:100vh;" frameborder="0"></iframe>
    

    <script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('packages/popper/popper.min.js') }}"></script>
    <script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Plugin JavaScript -->
    <script src="{{ asset('packages/jquery-easing/jquery.easing.min.js') }}"></script>
    <!--<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>-->
    <script src="{{ asset('packages/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('packages/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('packages/jquery.md5.min.js') }}"></script>
    <!-- Custom scripts for this template -->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <!-- Custom js-->
    <script src="{{ asset('js/custom/preloader.js') }}"></script>
    <!-- <script src="{{ asset('js/custom/home.js') }}"></script>
    <script src="{{ asset('js/custom/custom.js') }}"></script> -->
    <script src="{{ asset('js/custom/general.js') }}"></script>

    <script src="{{asset('packages/qrcode/jquery.qrcode.js')}}"></script>
    <script src="{{ asset('packages/qrcode/qrcode.js') }}"></script>
    <script>
        jQuery('#qrcodeCanvas').qrcode({
            text	: "{{$download_link}}"
        }); 
    </script>
    </body>
</html>