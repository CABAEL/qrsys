<div class="modal fade" id="EditApi" tabindex="-1" role="dialog" aria-labelledby="EditApi" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>New access key</b></h5>
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
                           <label for="name">Select client:</label>
                           <select style="width:100%;" id="select_client" name="select_client" class="form-control select_client"></select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="appkey">Appkey</label>
                           <input type="text" class="form-control" id="appkey" name="appkey" autofocus autocomplete="off" readonly/>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="appsecret">Appsecret</label>
                           <input type="text" class="form-control" id="appsecret" name="appsecret" aria-describedby="appsecret" autocomplete="off" readonly>
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
               <button class="btn btn-primary btn-block" id="EditkeySubmit">Submit</button>
            </div>
            <br>
            </form>
         </div>
      </div>
   </div>
</div>