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
                  <b>API ACCESS LIST</b>
               </li>
            </ol>
            <hr/>
            <button class="btn btn-sm" type="button" id="addApi_btn" data-toggle="modal" data-target="#addclient"> + Access Key</button>
            <hr/>
            <table cellspacing="0" class="display table table-bordered table-responsive" width="100%" id="clients-table" style="width:100%;">
               <thead>
                  <tr>
                     <th>ADMIN NAME</th>
                     <th>STATUS</th>
                     <th>DATE CREATED</th>
                     <th>---</th>
                  </tr>
               </thead>
               <tbody id="ClientListBody">
                  <tr>
                     <td colspan="4">
                        <center>Loading...</center>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
      <link href="{{ asset('packages/select2/select2.min.css') }}" rel="stylesheet">
      <script src="{{ asset('packages/select2/select2.min.js') }}"></script>
      @include('template.admin.segments.custom.script_api_access')
   </body>
</html>