<div class="modal fade bd-example-modal-lg" id="edit_job" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Job details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <center><div class="alert alert-danger" id="update_job_errors"></div></center>
                <div class="container-fluid">
                  <form id="update_job_form">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="fname">Name</label>
                                <input type="text" class="form-control" id="update_name" name="update_name" autofocus/>
                            </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="description">Job description</label>
                                <textarea name="update_description" id="update_description" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                
                  </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info btn-block" id="update_job_vacancy">Update</button>
            </div>
    </div>
</div>
</div>