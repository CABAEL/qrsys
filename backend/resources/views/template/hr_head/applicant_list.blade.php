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
            <b>Applicant List</b>
          </li>
        </ol>

        <!-- table recommended list -->
        <h5 class="text-center">Recommended List</h5>
        <table class="table table-bordered" width="100%" id="recommended" cellspacing="0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Position applied</th>
              <th>Application Status</th>
              <th>Date Applied</th>
              <th>exp</th>
              <th>---</th>
            </tr>
          </thead>
          <tbody id="recommendedList"></tbody>
        </table>
        <br>
        <br>
        <br>
        <!--<button class="btn btn-sm viewuser2">sample</button>-->
        <table class="table table-bordered" width="100%" id="applicant-table" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Position applied</th>
                    <th>Application Status</th>
                    <th>Date Applied</th>
                    <th>---</th>
                  </tr>
                </thead>
               
                <tbody id="ApplicantListBody"></tbody>

        </table>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.hr_head.segments.footer')
  
  <script src="{{ asset('js/custom/page/hr_head/applicant_list.js') }}"></script>

  </body>

</html>
