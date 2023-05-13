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
    <body>
        <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="text-center breadcrumb-item">
                    <h3>{{env('APP_NAME')}}</h3>
                </li>
            </ol>
            <div class="row">
                <div class="col-sm-1 text-left my-auto">&nbsp;</div>
                <div class="col-sm-3 text-left my-auto">
                    <b>Employee ID: </b><span id="employee_id"></span><br><br>
                    Name: 
                    <span id='name'></span><br>
                    Gender:
                    <span id='gender'></span><br>
                    Mobile number:
                    <span id='mobile'></span><br>
                    Email: 
                    <span id='email'></span>
                </div>
                <div class="col-sm-7 my-auto">
                  <h4 class="text-center">Payslip History</h4>
                  <table class="table table-bordered" width="100%" id="payslip-table" cellspacing="0">
                      <thead>
                          <tr>
                              <th>from</th>
                              <th>to</th>
                              <th><button class="btn btn-default btn-sm" data-toggle="modal" data-target="#add_payslip">Add Payslip</button></th>
                          </tr>
                      </thead>
                      <tbody id="PayslipListBody"></tbody>
                  </table>
              </div>
              <div class="col-sm-1 text-left my-auto">&nbsp;</div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-2 my-auto"></div>
                <div class="col-sm-8 my-auto">
                    <h4 class="text-center">DTR</h4>
                    <table class="table table-bordered" width="100%" id="dtr-table" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time-in</th>
                                <th>Time-out</th>
                            </tr>
                        </thead>
                        <tbody id="DTRListBody"></tbody>
                    </table>
                </div>
                <div class="col-sm-2 my-auto"></div>
            </div>
        </div>
        <br>
        <br>
        @include('template.hr_head.segments.modal.add_payslip_modal')
        <!-- /.content-wrapper -->
        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('packages/popper/popper.min.js') }}"></script>
        <script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- Plugin JavaScript -->
        <script src="{{ asset('packages/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('packages/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('packages/datatables/dataTables.bootstrap4.js') }}"></script>
        <!-- Custom scripts for this template -->
        <script src="{{ asset('js/sb-admin.min.js') }}"></script>
        <!-- Custom js-->
        <script src="{{ asset('js/custom/preloader.js') }}"></script>
        <script src="{{ asset('js/custom/home.js') }}"></script>
        <script src="{{ asset('js/custom/custom.js') }}"></script>
        <script src="{{ asset('js/custom/ajax_request.js') }}"></script>
        <script src="{{ asset('js/custom/page/hr_head/employee_page.js') }}"></script>
    </body>
</html>

