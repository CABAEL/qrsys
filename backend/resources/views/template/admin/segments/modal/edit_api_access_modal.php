<div class="modal fade" id="EditApi" tabindex="-1" role="dialog" aria-labelledby="EditApi" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>Edit access key</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <form id="Edit_key_form">
         <div class="modal-body">
            <center>
               <div class="alert alert-danger" id="Edit_key_errors"></div>
            </center>
            <div class="container-fluid">
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="name">Client:</label>
                           <input type="text" style="width:100%;" id="edit_client" name="edit_client" class="form-control" readonly></input>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="appkey">Appkey</label>
                           <input type="text" class="form-control" id="edit_appkey" name="edit_appkey" autofocus autocomplete="off" readonly/>
                           <button class="btn btn-sm" id="genereteNewAppkey"><i class="fa fa-recycle"></i> Generate</button>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="edit_appsecret">Appsecret</label>
                           <input type="text" class="form-control" id="edit_appsecret" name="edit_appsecret" aria-describedby="edit_appsecret" autocomplete="off" readonly>
                           <button class="btn btn-sm" id="genereteNewAppSecret"><i class="fa fa-recycle"></i> Generate</button>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="description">Description</label>
                           <textarea class="form-control" id="edit_description" name="edit_description" autocomplete="off"></textarea>             
                        </div>
                     </div>
                  </div>
            </div>
            <br>
            <div class="modal-footer">
            &nbsp;
               <button class="btn btn-danger delete">Delete</button>
               <button class="btn btn-default" id="updateSubmit"><i class="fa fa-save"></i> Save</button>
            </div>
            <br>
            </form>
         </div>
      </div>
   </div>
</div>