<div class="modal fade" id="viewfile" tabindex="-1" role="dialog" aria-labelledby="adduser" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>SCAN QRCODE</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <iframe class="iframe_viewfiles" src="" width="100%" height="1000px" style="border:solid 1px #000;" frameborder="0"></iframe>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="viewfile2" tabindex="-1" role="dialog" aria-labelledby="adduser" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>FILE INFORMATION</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>

         <div class="container-fluid mt-12">
        <div class="row">
            <div class="col-md-12 offset-md-6">
               <center>
                     <div class="alert alert-danger" id="UpdateFileForm_errors"></div>
               </center>
               <br>
               <center><b id="file_name"></b></center>
               <br>
                <form id="UpdateFileForm" onsubmit="SaveFileInfo(this)">
                    <!-- Code Input -->
                    <div class="form-group">
                        <label for="code">Code:</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter code" required>
                    </div>

                    <!-- Description Textarea -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"></textarea>
                    </div>

                    <!-- Old Password Input -->
                    <div class="form-group">
                        <label for="oldPassword">Password:</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="saveEdit" style="float:right" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </form>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>

         <!-- <iframe class="iframe_viewfiles" src="" width="100%" height="1000px" style="border:solid 1px #000;" frameborder="0"></iframe> -->
         </div>
      </div>
   </div>
</div>



<div class="modal fade" id="viewfile3" tabindex="-1" role="dialog" aria-labelledby="adduser" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b></b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
            <center>
               <br>

               Are you sure you want to delete this file?
               <button class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
               <button class="btn btn-sm btn-danger" id="delete_yes">Yes</button>
               <br>
               <br>
            </center>
         <br>
         <br>
         </div>


      </div>
   </div>
</div>