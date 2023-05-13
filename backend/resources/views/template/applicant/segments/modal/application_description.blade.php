<div class="modal fade bd-example-modal-lg" id="career_profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Application details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <center><div class="alert alert-danger" id="details_error"></div></center>
                <div class="container-fluid">
                  <form id="applicant_details_form">
                    <div class="form-group">
                        
                        <div class="form-row">
                        <div class="col-md-12">
                          Resume file:
                          <input type="file" id="resume_file" name="resume_file" class="form-control" accept="application/pdf" value=""/>
                          </div>
                        </div>
                        <br>
                        <div class="form-row">
                          <div class="col-md-12">
                                <label for="position">Position Applied for</label>
                                <select class="form-control" name="position" id="position">
                                  
                                </select>
                          </div>
                        </div>
                        <br>
                        <label for="position">Work Experiences&nbsp;<a class="btn btn-sm btn-default" id="add_workexp"><i class="fa fa-plus"></i></a></label>
                        
                        <div class="form-row" style="" id="workexp">

                        </div>

                        <!--<div class="form-row">
                              <div class="col-md-12">
                                <label for="lname">Write something about yourself</label>
                                <textarea name="about_self" id="about_self" class="form-control" cols="30" rows="10"></textarea>
                              </div>
                        </div>-->
                    </div>
                  </form>
                  
                </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary btn-block" id="ApplicationDetails">Submit</button>
            </div>
        </div>
    </div>
</div>