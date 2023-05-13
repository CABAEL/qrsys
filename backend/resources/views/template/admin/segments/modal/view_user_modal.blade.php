<div class="modal fade bd-example-modal-lg" id="viewusermodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                  <form id="update_user_form">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="fname">First name</label>
                                <input type="text" class="form-control" id="update_fname" name="update_fname" autofocus/>
                            </div>
                            <div class="col-md-4">
                                <label for="mname">Middle name</label>
                                <input type="text" class="form-control" id="update_mname" name="update_mname" placeholder="Leave blank if N/A" >
                            </div>
                            <div class="col-md-4">
                                <label for="lname">Last name</label>
                                <input type="text" class="form-control" id="update_lname" name="update_lname" aria-describedby="nameHelp" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="fname">Age</label>
                                <input type="number" class="form-control" id="update_age" name="update_age" autofocus/>
                            </div>
                            <div class="col-md-4">
                                <label for="gender">Gender</label>
                                <select name="update_gender" class="form-control" id="update_gender">
                                  <option value="">---</option>
                                  <option value="M">MALE</option>
                                  <option value="F">FEMALE</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="update_birthday">Birth date</label>
                                <input type="date" class="form-control" id="update_birthday" name="update_birthday" aria-describedby="nameHelp" >
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="update_address" name="update_address" autofocus/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">                     
                        <div class="col-md-6">
                        <label for="update_email">Email address</label>
                        <input type="email" class="form-control" id="update_email" name="update_email" aria-describedby="emailHelp">
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
                          <label for="update_mobile_number">Mobile number</label>
                          <input type="text" class="form-control" id="update_mobile_number" name="update_mobile_number" aria-describedby="nameHelp">
                                                      
                        </div>    
                        <div class="col-md-6" style="visibility:hidden;">
                            <label for="update_role">Role</label>
                            <select class="form-control" id="update_role" name="update_role" aria-describedby="nameHelp">
                                <option value="">---</option>
                                <option value="hr_head">HR head</option>
                                <option value="hr_assistant">HR assistant</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>                     
                    
                    </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                          <div class="col-md-6">
                            <label for="retypePassword">Reset Password</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="update_password" name="update_password"/>
                              
                          </div>  
                          </div>

                        </div>
                    </div>
                  </form>

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