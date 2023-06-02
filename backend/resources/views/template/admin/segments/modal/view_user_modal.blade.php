<div class="modal fade" id="viewusermodal" tabindex="-1" role="dialog" aria-labelledby="viewusermodal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">User info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <center><div class="alert alert-danger" id="update_user_errors"></div></center>
                <div class="container-fluid">
                <center>
                    <div id="logoContainer">Click to add image.</div>
                  </center>
                  <form id="update_user_form">
                    <input type="file" id="logo" name="logo" class="hidden" accept="image/png, image/jpg,image/IMG, image/jpeg"/>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="update_name">Client/Organization Name</label>
                                <input type="text" class="form-control" id="update_fname" name="update_fname" autofocus/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="update_address">Address</label>
                                <input type="text" class="form-control" id="update_address" name="update_address" autofocus/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">                     
                        <div class="col-md-6">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="update_email" name="update_email" aria-describedby="emailHelp">
                      </div> 
                      <div class="col-md-6">
                          <label for="update_mobile_number">Description</label>
                          <textarea class="form-control" name="update_description"></textarea>             
                        </div>                    
                    
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="mobile_number">Mobile number</label>
                          <input type="text" class="form-control" id="update_mobile_number" name="update_mobile_number" aria-describedby="nameHelp">
                                                      
                        </div>                    
                        <div class="col-md-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="update_username" name="update_username" aria-describedby="emailHelp">
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

                  <button class="btn btn-sm" id="generate_pass"><i class="fa fa-recycle"></i> Generate</button>
                  <button class="btn btn-sm btn-default" id="copy" onclick="copy_text('#update_password')"><i class="fa fa-copy"></i> Copy</button> 
                  <button class="btn btn-sm btn-info" id="clear"><i class="fa fa-clear"></i> Clear</button>

                </div>
            </div>
            <div class="modal-footer">

                <button class="btn btn-primary btn-block" id="updateAccount">Update</button>
                <br>
                <button class="btn btn-default btn-block deactivate">Deactivate</button>
                <br>
                <button class="btn btn-danger btn-block delete">Delete</button>

        </div>
    </div>
</div>