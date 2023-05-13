<div class="modal fade bd-example-modal-lg" id="viewApplicant" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                  <form id="">
                    <div class="form-group">
                        <div class="form-row">
                            Position applied: 
                            <span id="applicant_position_applied"></span>
                        </div>
                        <br>
                        <div class="form-row">
                            Name: 
                            <span id="applicant_name"></span>
                        </div>
                        <br>
                        <div class="form-row">
                            Mobile number: 
                            <a id="applicant_mobile_number"></a>
                        </div>
                        <br>
                        <div class="form-row">
                            Email: 
                            <a id="applicant_email"></a>
                        </div>
                        <br>
                        <div class="form-row">
                            Resume Link: 
                            <a id="applicant_resume_link"></a>
                        </div>
                        <br>
                        <!--<div class="form-row">
                            About self: 
                            <span id="applicant_about_self"></span>
                        </div>-->
                        <br>

                    </div>

                  </form>   
                </div>
            </div>
            <div class="modal-footer" id="applicant_action">
                <button class="btn btn-primary btn-block" id="accept_application">Accept</button>
                <br>
                <button class="btn btn-default btn-block" id="decline_application">Decline</button>
                <br>
                
            </div>
    </div>
</div>
</div>