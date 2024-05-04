<div class="modal fade" id="viewfilegroup" tabindex="-1" role="dialog" aria-labelledby="adduser" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>ADD FILE GROUP</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <form id="update_filegroup_form" onSubmit="updateFilegroupSubmit(this.id)" enctype="multipart/form-data">
         <div class="modal-body">
            <center>
               <div class="alert alert-danger" id="update_filegroup_errors"></div>
            </center>
            <div class="container-fluid">
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="name">Name</label>
                           <input type="text" class="form-control" id="group_name" name="group_name" autofocus autocomplete="off"/>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="description">Description</label>
                           <textarea class="form-control" id="description" name="description" autocomplete="off"></textarea>             
                        </div>
                     </div>
                  </div>
            </div>
            <br>
            <div class="modal-footer">
            <br>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-block">Update</button>
               <br>
               <button class="btn btn-danger btn-block delete">Delete</button>
            </div>
            <br>
            </div>
            <br>
            </form>
         </div>
      </div>
   </div>
</div>