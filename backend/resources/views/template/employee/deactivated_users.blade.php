<!DOCTYPE html>
<html lang="en">
@include('template.admin.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.admin.segments.navbar')


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
        <table class="table table-bordered" width="100%" id="deactivated" cellspacing="0">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>User level</th>
                    <th>---</th>
                  </tr>
                </thead>
               
                <tbody id="DeactivatedUserListBody"></tbody>
        </table>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.admin.segments.footer')
  <script src="{{ asset('js/custom/page/deactivated_user.js') }}"></script>
  

  <script>

  </script>

  </body>

</html>
