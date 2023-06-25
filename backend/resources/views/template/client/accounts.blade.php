<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.client.segments.navbar')
      <div class="content-wrapper">
         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <b>USER LIST</b>
               </li>
            </ol>
            <hr/>
            <button class="btn btn-sm" type="button" id="adduser_btn" data-toggle="modal" data-target="#adduser"> + User</button>
            <hr/>
            <table cellspacing="0" class="display table table-bordered" width="100%" id="users-table" style="width:100%">
               <thead>
                  <tr>
                     <th>USER NAME</th>
                     <th>STATUS</th>
                     <th>DATE CREATED</th>
                     <th>---</th>
                  </tr>
               </thead>
               <tbody id="ClientUserListBody">
                  <tr>
                     <td colspan="3">
                        <center>Loading...</center>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <!-- /.container-fluid -->
      </div>
      @include('template.client.segments.modal.add_user_modal')
      @include('template.client.segments.modal.view_user_modal')
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.client.segments.custom.script_accounts')

   </body>
</html>