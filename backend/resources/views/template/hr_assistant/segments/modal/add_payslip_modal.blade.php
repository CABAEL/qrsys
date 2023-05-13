<div class="modal fade bd-example-modal-lg" id="add_payslip" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Upload Payslip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <center><div class="alert alert-danger" id="add_payslip_errors"></div></center>
                <div class="container-fluid">
                  <form id="add_payslip_form">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="fname">from</label>
                                <input type="date" class="form-control" id="from" name="from" autofocus/>
                            </div>
                            <div class="col-md-6">
                                <label for="fname">to</label>
                                <input type="date" class="form-control" id="to" name="to"/>
                            </div>
                    </div>

                    <div class="form-group">
                        <br>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="description">Select payslip pdf</label>
                                <input type="file" name="payslip" id="payslip" accept="application/pdf" class="form-control">
                            </div>
                        </div>
                    </div>
                
                  </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info btn-block" id="uploadPayslip">Add</button>
        </div>
    </div>
</div>
</div>