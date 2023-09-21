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
    <!-- <preloader id="preloader"><img src="{{asset('img/loader/loader.gif')}}" class="loader_gif"></preloader> -->
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
                <form action="">
                    <div class="input-group">
                        <input class="form-control" type="text" name="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];}else{echo "";}?>" placeholder="Search filename" aria-label="Search for..." autocomplete="off">
                        <button class="btn btn-primary" id="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>

                </form>    
            </div>
        </div>
        <br>

    <table cellspacing="0" class="display table table-bordered table-responsive" width="100%" id="files-table" style="width:100%">
        <thead>
            <tr>
                <th>UPLOAD NAME</th>
                <th>UPLOADED BY</th>
                <th>DOCUMENT CODE</th>
                <th>DATE UPLOADED</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody id="FileListBody">
        @foreach($files as $file)
        <tr>
            <td>{{ $file->file_name }}</td>
            <td>{{ $file->username }}</td>
            <td>{{ $file->document_code }}</td>
            <td>{{ $file->created_at }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-default viewqr" data-id="<?php echo $file->id?>"><i class="fa fa-qrcode"></i> View</button>
                    <br>
                    <br>
                <button type="button" class="btn btn-sm btn-default viewupdate" data-id="<?php echo $file->id?>"><i class="fa fa-edit"></i> Edit</button>
                    <br>
                    <br>
                <button type="button" class="btn btn-sm btn-danger delete" data-id="<?php echo $file->id?>"><i class="fa fa-trash"></i> Delete</button>
            </td>
            <!-- Add more columns as needed -->
        </tr>
        @endforeach
        @if(count($files) == 0)
        <tr>
            <td colspan="5"><center>No Data</center></td>
        </tr>
        @endif
        </tbody>
    </table>
   


    <?php
        if(isset($_GET['search'])){ $search = $_GET['search'];}else{$search =  "";}
    ?>
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
    <script>

        $(document).on('click','.delete',function(){
        let file_id = $(this).data('id');
        let fileViewerUrl = url_host('fileviewer')+'/'+file_id;

        $('#delete_yes').data('id',file_id);
        $('#viewfile3').modal('show');


        });

        $(document).on('click','#delete_yes',function(){

        let file_id = $(this).data('id');

        
        $.ajax({
        url: url_host("view_file_delete/"+file_id),
        type: 'GET', 
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data){
            console.log(data);
            $('#viewfile3').modal('hide');
            window.location.reload();
        },
        error: function(e) {
            console.log(e);
            hide_loader();
        }
        });



        });

        $(document).on('click','.viewqr',function(){
        let file_id = $(this).data('id');
        let fileViewerUrl = url_host('fileviewer')+'/'+file_id;

        $('#viewfile').modal('show');

        $('.iframe_viewfiles').attr('src', fileViewerUrl);


        });

        
        SaveFileInfo = (saveForm) => {
            event.preventDefault();
            let file_id = $(saveForm).data('id');
            // Get form
            var element = $('#UpdateFileForm_errors');
            // FormData object
            var formData = new FormData(saveForm);

            $.ajax({
            url: url_host("save_file_data/"+file_id),
            type: 'POST',
            contentType: false,
            processData: false, 
            dataType: 'json',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data){
                console.log(data);
                window.location.reload();
            },
            error: function(e) {
                let element = $('#UpdateFileForm_errors');
                let form = '#UpdateFileForm'; 
                promt_errors(form,element,e);
            }
            });

            
        }

        $(document).on('click','.viewupdate',function(){


        let file_id = $(this).data('id');

        let fileViewerUrl = url_host('fileviewerupdate')+'/'+file_id;

        
        $.ajax({
        url: url_host("view_file_data/"+file_id),
        type: 'GET', 
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data){
            console.log(data);

            $('#viewfile2 #code').val(data.document_code);
            $('#viewfile2 #description').val(data.description);
            $('#viewfile2 #password').val(data.password);
            $('#viewfile2 #file_name').text(data.file_name);
            $('#viewfile2 #UpdateFileForm').attr('data-id',data.id);

            $('#viewfile2').modal('show');

            $('.iframeupdate_viewfiles').attr('src', fileViewerUrl);

            hide_loader();
        },
        error: function(e) {
            console.log(e);
            hide_loader();
        }
        });

        });

    </script>
     </div>
    </body>
</html>