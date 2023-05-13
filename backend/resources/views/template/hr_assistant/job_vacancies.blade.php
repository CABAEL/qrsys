<!DOCTYPE html>
<html lang="en">
@include('template.hr_head.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.hr_head.segments.navbar')

    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <b>Job list</b>
          </li>
        </ol>

        <!-- table list -->
        <!--<button class="btn btn-sm viewuser2">sample</button>-->
        <br>
        <center><button class="btn btn-primary" data-toggle="modal" data-target="#add_job">Add job vacancy</button></center>
        <br>
        <table class="table table-bordered" width="100%" id="job-table" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>---</th>
                  </tr>
                </thead>
               
                <tbody id="JobListBody"></tbody>

        </table>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
  @include('template.hr_head.segments.footer')
  <script src="{{ asset('js/custom/page/hr_head/job_vacancy.js') }}"></script>
  </body>

</html>
