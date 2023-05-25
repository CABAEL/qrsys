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
            <b>CLIENT LIST</b>
          </li>
        </ol>

      <hr/>
      <button class="btn btn-sm" id="adduser"> + Client</button>
      <hr/>
        <table cellspacing="0" class="display table table-bordered" width="100%" id="user-table" style="width:100%">
        <thead>
            <tr>
            <th>CLIENT NAME</th>
            <th>DOCUMENT COUNT</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody id="UserListBody">
          <tr>
            <td colspan="2"><center>Loading...</center></td>
          </tr>
        </tbody>
        </table>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.footer')
  @include('template.admin.segments.custom.script_index')

  <script>

  </script>

  </body>

</html>
