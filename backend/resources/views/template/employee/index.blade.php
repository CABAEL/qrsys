<!DOCTYPE html>
<html lang="en">
@include('template.employee.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.employee.segments.navbar')


    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <b>Daily Time Record</b>
          </li>
        </ol>
        <br>
        <label for="time">
          <div id="time" class="" value=""></div>
        </label>
        <br>
        <!-- table list -->
        <button class="btn btn-lg btn-primary" id="punch_time" data-user_id={{Auth::user()->id;}}>Punch Time</button>
        <br>
        <br>

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
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.employee.segments.footer')

  <script>

  </script>

  </body>

</html>
