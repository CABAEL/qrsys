<div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="addadmin" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>Add New admin</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <form id="add_admin_form" onSubmit="addAdminSubmit(this.id)" enctype="multipart/form-data">
         <div class="modal-body">
            <center>
               <div class="alert alert-danger" id="add_admin_errors"></div>
            </center>
            <div class="container-fluid">
               <center>
                  <div class="logoContainer"></div>
               </center>
                  <input type="file" id="logo" name="logo" class="hidden" accept="image/png, image/jpg,image/IMG, image/jpeg" autocomplete="off"/>
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
                        <div class="col-md-12">
                           <label for="fname">Address</label>
                           <input type="text" class="form-control" id="address" name="address" autofocus autocomplete="off"/>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-6">
                           <label for="email">Email address</label>
                           <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                           <label for="description">Description</label>
                           <textarea class="form-control" name="description" autocomplete="off"></textarea>             
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-6">
                           <label for="contact_number">Contact Number</label>
                           <input type="number" class="form-control" id="contact_number" name="contact_number" aria-describedby="nameHelp" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                           <label for="username">Username</label>
                           <input type="text" class="form-control" id="username" name="username" aria-describedby="" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-row">
                        <div class="col-md-6">
                           <label for="retypePassword">Password</label>
                           <div class="input-group" id="show_hide_password">
                              <input class="form-control" name="password" id="password" type="password" autocomplete="off" required/>
                              <div class="input-group-addon">
                              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label for="password_confirmation">Retype Password</label>
                           <div class="input-group" id="show_hide_password2">
                              <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required/>
                              <div class="input-group-addon">
                              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
            <br>
            <div class="modal-footer">
               <button class="btn btn-primary" id="AddAccountSubmit">Submit</button>
            </div>
            <br>
            </form>
         </div>
      </div>
   </div>
</div>