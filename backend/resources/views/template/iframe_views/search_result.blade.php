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
    <style>
        p{
            word-wrap: break-word;
            color:#777;
        }
        .highlight {
            background-color: yellow; /* You can adjust the highlight style as needed */
            font-weight: bold;
        }
    </style>
    </head>

    <body>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-3"> 
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <br>
        
        <div class="container-fluid">
        @foreach($files as $file)
            <div style="border:solid 0.5px #aaa;margin-top:2%;padding:1%;">
                <!-- Breadcrumbs -->
                <ol class="breadcrumb">

                @php
                    $fileName = $file->file_name;
                    $search = preg_quote($search, '/'); // Quote the search term for use in the regular expression
                    $highlightedFileName = preg_replace('/' . $search . '/i', '<span class="highlight">$0</span>', $fileName);
                @endphp

                <li class="breadcrumb-item filename">
                    <p>{!! $highlightedFileName !!}</p>
                </li>
                {{ base64_decode($file->blob_qr) }}
                </ol>
                <em>Created at: {{ $file->created_at }}</em>
                <button type="button" class="btn btn-sm btn-default viewqr" data-id="{{ $file->id }}"><i class="fa fa-qrcode"></i> View QR</button>
                <hr>
                
                <p><?php if($file->description != ''){echo $file->description;}else{echo "No Description.";}?></p>
            </div>
        @endforeach
        <?php if(count($files) == 0){ ?>
            <div style="margin-top:2%;padding:1%;">
                <!-- Breadcrumbs -->
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <b>No data found.</b>
                </li>
                </ol>
            </div>
        <?php }?>    
        </div>



    <?php
        if(isset($_GET['search'])){ $search = $_GET['search'];}else{$search =  "";}
    ?>
    <br>
    {{ $files->appends(['search' => $search])->links() }}
    @include('template.client.segments.modal.view_file_modal')

    <script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('packages/popper/popper.min.js') }}"></script>
    <script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('packages/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('packages/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('packages/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('packages/jquery.md5.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

    <!-- Custom js-->
    <script src="{{ asset('js/custom/preloader.js') }}"></script>
    <script src="{{ asset('js/custom/general.js') }}"></script>
     </div>
     <br>
     <br>
     <br>
     <br>
     <br>
     <script>
        $(document).on('click','.viewqr',function(){
            let id = $(this).data('id');
            window.open(url_host('fileviewer/'+id), '_blank');
        })
     </script>
    </body>
</html>