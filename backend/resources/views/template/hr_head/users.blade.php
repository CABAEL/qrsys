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
            <b>USER LIST</b>
          </li>
        </ol>

        <!-- table list -->
        <!--<button class="btn btn-sm viewuser2">sample</button>-->
        <table class="table table-bordered" width="100%" id="user-table" cellspacing="0">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>User level</th>
                    <th>---</th>
                  </tr>
                </thead>
               
                <tbody id="UserListBody"></tbody>

        </table>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.hr_head.segments.footer')

  <script>

  </script>

  </body>

</html>
