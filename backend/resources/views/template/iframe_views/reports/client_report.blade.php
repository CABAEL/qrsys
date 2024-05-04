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

        canvas {
        page-break-inside: avoid;
        }
          @media print {
            body {
                transform: scale(0.5); /* Adjust the scaling factor as needed */
                transform-origin: top left; /* Set the scaling origin */
                margin: 5%;
                text-align:center;
            }
            td{
                margin: 50%;
            }
            @page {
                size: portrait; /* Set the page orientation to landscape */
            }
                        
            canvas {
                width: 100%;
                height: auto;
            }
            /* Add your print-specific styles here */
            .print-only {
                display: block;
            }

            /* Hide elements on print */
            .no-print {
                display: none;
            }
        }
    </style>
    </head>

    <body>

    <div class="container">
    <br>
    <h1 style="font-weight:bolder;">Intelodocs Client Report</h1>
    <?php 
        $today = date('Y-m-d');
        $from = !isset($_GET['from']) ? '': $_GET['from'];
        $to = !isset($_GET['to']) ? '': $_GET['to'];
        $url = route('download_client_report', ['from' => $from, 'to' => $to]);
    ?>
    <br>
        <br>
        <a href="{{$url}}"><button class="btn-sm no-print">Download Excel</button></a>

        <button onclick="window.print();" class="btn-sm no-print"> Print PDF</button>
        
        <div class="row">
            <div class="col-md-12">
                    <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="myLineChart" width="450" height="180" class="chartjs-render-monitor" style="display: block; width: 450px; height: 180px;"></canvas>
                    </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">
            <?php
                if(isset($_GET['from'])){ $from = $_GET['from'];}else{$from =  "";}
                if(isset($_GET['to'])){ $to = $_GET['to'];}else{$to =  "";}
            ?>
            </div>
            <div class="col-md-6" class="no-print">
                <form onsubmit="dateFilter()" class="form-row">
                    <div class="col-md-5">
                    <label for="name" class="no-print">From</label>
                        <input class="no-print" type="date" placeholder="FROM" class="form-control" id="from" name="from" value="{{$from}}" autofocus autocomplete="off"/>
                    </div>
                    <div class="col-md-5">
                    <label for="name" class="no-print">To</label>
                        <input class="no-print" type="date" placeholder="TO" class="form-control" id="to" name="to" value="{{$to}}" autofocus autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <!-- <input class="form-control" type="submit" value="submit"> -->
                        <button type="submit" class="form-control btn-sm"><i class="no-print fa fa-filter"></i></button>
                    </div>
                    </div>
                </form> 
            </div>
        <br/>

        <div class="print-only">
            <span><b>From:</b> {{$from}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To:</b> {{$to}}</span>
        </div>
        <br>
        <br>
    <div class="row" style="overflowX:scroll;width:80em;">
    <table cellspacing="0" style="width:80em !important;" class="" width="100%" id="files-table">
        <thead>
            <tr>
                <th></th>
                <th>CLIENT NAME</th>
                <th>DOCUMENT COUNT</th>
                <th>CREATED AT</th>
            </tr>
        </thead>
        <tbody id="FileListBody">
        @php
            $startIndex = ($clients->currentPage() - 1) * $clients->perPage();
        @endphp
        @foreach($clients as $index => $client)
        <tr>
            <td>{{ $startIndex + $loop->iteration }}</td>
            <td>{{ $client['client_name'] }}</td>
            <td>{{ $client['file_uploads_count'] }}</td>
            <td>{{ $client['created_at'] }}</td>
        </tr>
        @endforeach
        @if(count($clients) == 0)
        <tr>
            <td colspan="5"><center>No Data</center></td>
        </tr>
        @endif
        </tbody>
        <tfoot></tfoot>
    </table>
    </div>
        <br>
        <br>
    
    {{ $clients->appends(['from' => $from, 'to' => $to])->links() }} 
    <br/>
    <b>Total Items: {{ $clients->total() }}</b>
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
    <script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
    <script>
        var ctx = document.getElementById("myLineChart");
        var clientNames = @json($clientNames);
        const firstTenClients = clientNames.slice(0, 10);

        var uploadCounts = @json($uploadCounts);
        const firstTenuploadCounts = uploadCounts.slice(0, 10);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: firstTenClients,
                datasets: [{
                    label: 'File Upload Count',
                    data: firstTenuploadCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
             
        $('nav').addClass('no-print');
    </script>

     </div>
    </body>
</html>