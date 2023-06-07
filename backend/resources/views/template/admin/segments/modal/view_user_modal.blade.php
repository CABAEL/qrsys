<div class="modal fade" id="viewclientmodal" tabindex="-1" role="dialog" aria-labelledby="viewusermodal" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="">Add New Client/Organization</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <center>
               <div class="alert alert-danger" id="add_user_errors"></div>
            </center>
            <div class="container-fluid">
               <center>
                  <div class="logoContainer"></div>
               </center>
               <form id="update_client_form">
                  <input type="file" id="logo" name="logo" class="hidden" accept="image/png, image/jpg,image/IMG, image/jpeg"/>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="name">Client/Organization Name</label>
                           <input type="text" class="form-control" id="client_name" name="client_name" autofocus/>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-12">
                           <label for="fname">Address</label>
                           <input type="text" class="form-control" id="address" name="address" autofocus/>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-6">
                           <label for="email">Email address</label>
                           <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        </div>
                        <div class="col-md-6">
                           <label for="mobile_number">Description</label>
                           <textarea class="form-control" id="description" name="description"></textarea>             
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-6">
                           <label for="mobile_number">Mobile number</label>
                           <input type="text" class="form-control" id="mobile_number" name="mobile_number" aria-describedby="nameHelp">
                        </div>
                        <div class="col-md-6">
                           <label for="username">Username</label>
                           <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-6">
                           <label for="retypePassword">Password</label>
                           <div class="input-group" id="show_hide_password">
                              <input class="form-control" id="password" type="password" required/>
                              <div class="input-group-addon">
                              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>
                           </div>

                        </div>
                        <div class="col-md-6">
                           <label for="password_confirmation">Retype Password</label>
                           <div class="input-group" id="show_hide_password2">
                              <input class="form-control" id="password_confirmation" type="password" required/>
                              <div class="input-group-addon">
                              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="container">
                           <button class="btn btn-sm" id="generate_pass"><i class="fa fa-recycle"></i> Generate</button>
                           <button class="btn btn-sm btn-default" id="copy" onclick="copy_text('#update_client_form #password')"><i class="fa fa-copy"></i> Copy</button> 
                           <button class="btn btn-sm btn-info" id="clear"><i class="fa fa-clear"></i> Clear</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <br>
            <div class="modal-footer">
               <button class="btn btn-primary btn-block" id="updateAccount">Update</button>
               <br>
               <button class="btn btn-default btn-block deactivate">Deactivate</button>
               <br>
               <button class="btn btn-danger btn-block delete">Delete</button>
            </div>
            <br>
         </div>
      </div>
   </div>
</div>