<div class="modal fade bd-example-modal-lg" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add New User</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
            <center><div class="alert alert-danger" id="add_user_errors"></div></center>
                <div class="container-fluid">
                  <form id="add_user_form">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="fname">First name</label>
                                <input type="text" class="form-control" id="fname" name="fname" autofocus/>
                            </div>
                            <div class="col-md-4">
                                <label for="mname">Middle name</label>
                                <input type="text" class="form-control" id="mname" name="mname" placeholder="Leave blank if N/A" >
                            </div>
                            <div class="col-md-4">
                                <label for="lname">Last name</label>
                                <input type="text" class="form-control" id="lname" name="lname" aria-describedby="nameHelp" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="fname">Age</label>
                                <input type="number" class="form-control" id="age" name="age" autofocus/>
                            </div>
                            <div class="col-md-4">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-control" id="gender">
                                  <option value="">---</option>
                                  <option value="M">MALE</option>
                                  <option value="F">FEMALE</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lname">Birth date</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" aria-describedby="nameHelp" >
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
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                      </div>                      
                    </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="mobile_number">Mobile number</label>
                          <input type="text" class="form-control" id="mobile_number" name="mobile_number" aria-describedby="nameHelp">
                                                      
                        </div>    
                        <div class="col-md-6" >
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" aria-describedby="nameHelp">
                                <option value="">---</option>
                                <option value="hr_head">HR head</option>
                                <option value="hr_assistant">HR assistant</option>
                            </select>
                        </div>                      
                    </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                          <div class="col-md-6">
                            <label for="retypePassword">Password</label>
                            <div class="input-group">
                              <input type="password" class="form-control" id="password" name="password" />
                              <div class="input-group-append" onclick="viewpass()">
                                <i class="fa fa-eye" id="viewpass"></i>
                              </div>
                          </div>  
                            </div>
                            <div class="col-md-6">
                            <label for="password_confirmation">Password</label>
                            <div class="input-group">
                              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
                              <div class="input-group-append" onclick="view_retype_pass()">
                                <i class="fa fa-eye" id="view_retype_pass"></i>
                              </div>
                            </div>  
                            </div>
                        </div>
                    </div>
                  </form>
                  
                </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary btn-block" id="AddAccountSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>