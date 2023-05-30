<div class="modal fade bd-example-modal-lg" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add New Client/Organization</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
            <center><div class="alert alert-danger" id="add_user_errors"></div></center>
                <div class="container-fluid">
                  <center>
                    <div id="logoContainer">Click to add image.</div>
                  </center>
                  <form id="add_user_form">
                    <input type="file" id="logo" name="logo" class="hidden" accept="image/png, image/jpg,image/IMG, image/jpeg"/>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="name">Client/Organization Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" autofocus/>
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
                          <textarea class="form-control" name="description"></textarea>             
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
                            <div class="input-group" class="show_hide_password">
                              <input class="form-control" id="password" type="password">
                              <div class="input-group-addon" onclick="viewpass()">
                              <i class="fa fa-eye-slash" id="viewpass" aria-hidden="true"></i>
                            </div>    
                          </div>  
                            </div>
                            <div class="col-md-6">
                            <label for="password_confirmation">Retype Password</label>
                            <div class="input-group" class="show_hide_password">
                              <input class="form-control" id="password_confirmation" type="password">
                              <div class="input-group-addon"  onclick="view_retype_pass()">
                              <i class="fa fa-eye-slash" id="view_retype_pass" aria-hidden="true"></i>
                            </div>  
                            </div>
                        </div>
                    </div>
                  </form>
                  
                </div>
            </div>
            <br>
            <div class="modal-footer">
              <button class="btn btn-primary btn-block" id="AddAccountSubmit">Submit</button>
            </div>
            <br>
        </div>
    </div>
</div>