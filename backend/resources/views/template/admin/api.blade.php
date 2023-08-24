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
                  <b>ADMINISTRATOR LIST</b>
               </li>
            </ol>
            <hr/>
            <button class="btn btn-sm" type="button" id="addadmin_btn" data-toggle="modal" data-target="#addclient"> + Administrator</button>
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
      @include('template.admin.segments.custom.script_adminaccounts')
   </body>
</html>