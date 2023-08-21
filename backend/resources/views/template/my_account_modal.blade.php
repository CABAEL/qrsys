<div class="modal fade" id="my_account_modal" tabindex="-1" role="dialog" aria-labelledby="my_account_modal" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id=""><b>Update User</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <form id="my_account_form" onSubmit="updateMyAcc(event)" enctype="multipart/form-data">
            <div class="modal-body">
         
            <center>
               <div class="alert alert-danger" id="update_myacc_errors"></div>
            </center>
            <div class="container-fluid">
            <center>
                  <div class="logoContainer"></div>
               </center>
                  <input type="file" id="updatelogo" name="updatelogo" class="hidden" accept="image/png, image/jpg,image/IMG, image/jpeg" autocomplete="off"/>
                  <div class="form-group">
                  @if(Auth::user()->role == 'user')
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
                  @endif
                  
                  @if(Auth::user()->role == 'client')
                     <div class="form-group">
                        <div class="form-row">
                           <div class="col-md-12">
                              <label for="name">Client/Organization Name</label>
                              <input type="text" class="form-control" id="client_name" name="client_name" autofocus autocomplete="off"/>
                           </div>
                        </div>
                     </div>
                  @endif

                     
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
                     <?php
                       $id = \Auth::user()->id;
                     ?>
                     <a class="btn btn-warning" onClick="window.open('<?php echo url_host('change_my_password/'.$id);?>', '_blank')">Change Password</a>
                  </div>
               
            </div>
            <br>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
            <br>
         </form>
         </div>
      </div>
   </div>
</div>