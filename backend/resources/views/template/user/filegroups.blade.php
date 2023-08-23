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
                  <b>FILEGROUP LIST</b>
               </li>
            </ol>
            <hr/>
            <button class="btn btn-sm" type="button" id="addfilegroup_btn" data-toggle="modal" data-target="#addfilegroup"> + File Group</button>
            <hr/>
            <table cellspacing="0" class="display table table-bordered table-responsive" width="100%" id="filegroup-table" style="width:100%">
               <thead>
                  <tr>
                     <th>FILE GROUP</th>
                     <th>DESCRIPTION</th>
                     <th>DATE CREATED</th>
                     <th>---</th>
                  </tr>
               </thead>
               <tbody id="FilegroupListBody">
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
      @include('template.client.segments.modal.add_filegroup_modal')
      @include('template.client.segments.modal.view_filegroup_modal')
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.client.segments.custom.script_filegroups')

   </body>
</html>