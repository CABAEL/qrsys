<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.admin.segments.navbar')
      <div class="content-wrapper">

         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <b>System Logs</b>
               </li>
            </ol>
            <div class="container-fluid">

            <div class="row">
               <div class="col-md-8">
               <?php
                  if(isset($_GET['from'])){ $from = $_GET['from'];}else{$from =  "";}
                  if(isset($_GET['to'])){ $to = $_GET['to'];}else{$to =  "";}
               ?>
               </div>
               <div class="col-md-4" class="no-print">
                  <br>
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
            </div>
            <br>
            <table cellspacing="0" class="display table table-bordered table-responsive" width="100%" id="logs-table" style="width:100%;">
               <thead>
                  <tr>
                     <th>LOG</th>
                     <th>DESCRIPTION</th>
                     <th>DATE CREATED</th>
                  </tr>
               </thead>
               <tbody id="LogsListBody">
                  @foreach($logs as $log) 
                  <tr>
                     <td>{{$log['report_name']}}</td>
                     <td>{{$log['description']}}</td>
                     <td>{{$log['created_at']->format('Y-m-d h:i:s A')}}</td>
                  </tr>
                  @endforeach
                  @if(count($logs) == 0)
                  <tr>
                        <td colspan="3"><center>No Data</center></td>
                  </tr>
                  @endif
               </tbody>
            </table>
            <br>
            {{ $logs->appends(['from' => $from, 'to' => $to])->links() }} 
            </div>

         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.admin.segments.custom.script_adminaccounts')
   </body>
</html>