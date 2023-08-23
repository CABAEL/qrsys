<div class="modal fade" id="viewusermodal" tabindex="-1" role="dialog" aria-labelledby="viewusermodal" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>Update User</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <form id="update_clientuser_form" onSubmit="updateClientUserSubmit()" enctype="multipart/form-data">
            <div class="modal-body">
         
            <center>
               <div class="alert alert-danger" id="update_clientuser_errors"></div>
            </center>
            <div class="container-fluid">
            <center>
                  <div class="updatelogoContainer"></div>
               </center>
                  <input type="file" id="updatelogo" name="updatelogo" class="hidden" accept="image/png, image/jpg,image/IMG, image/jpeg" autocomplete="off"/>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-4">
                           <label for="name">First Name</label>
                           <input type="text" class="form-control" id="fname" name="fname" autofocus autocomplete="off"/>
                        </div>
                        <div class="col-md-4">
                           <label for="name">Middle Name</label>
                           <input type="text" class="form-control" id="mname" name="mname" autofocus autocomplete="off"/>
                        </div>
                        <div class="col-md-4">
                           <label for="name">Last Name</label>
                           <input type="text" class="form-control" id="lname" name="lname" autofocus autocomplete="off"/>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-3">
                           <label for="filegroups">File Group</label>
                           <select id="filegroups" name="filegroups" class="form-control">
                              <option value=""></option>
                           </select>
                        </div>
                        <div class="col-md-9">
                           <label for="fname">Address</label>
                           <input type="text" class="form-control" id="address" name="address" autofocus autocomplete="off"/>
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
                           <input type="text" class="form-control" id="contact_number" name="contact_number" aria-describedby="nameHelp">
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
                              <input class="form-control" id="password" name="password" type="password"/>
                              <div class="input-group-addon">
                              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label for="password_confirmation">Retype Password</label>
                           <div class="input-group" id="show_hide_password2">
                              <input class="form-control" id="password_confirmation" name="password_confirmation" type="password"/>
                              <div class="input-group-addon">
                              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="container">
                           <button class="btn btn-sm" id="generate_pass"><i class="fa fa-recycle"></i> Generate</button>
                           <button class="btn btn-sm btn-default" id="copy" onclick="copy_text('#update_clientuser_form #password')"><i class="fa fa-copy"></i> Copy</button> 
                           <button class="btn btn-sm btn-info" id="clear"><i class="fa fa-clear"></i> Clear</button>
                        </div>
                     </div>
                  </div>
               
            </div>
            <br>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-block">Update</button>
               <br>
               <button class="btn btn-default btn-block status_toggle">Deactivate</button>
               <br>
               <button class="btn btn-danger btn-block delete">Delete</button>
            </div>
            <br>
         </form>
         </div>
      </div>
   </div>
</div>