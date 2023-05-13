<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; Your Website 2017</small>
        </div>
    </div>
</footer>
<!-- Scroll to Top Button -->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fa fa-angle-up"></i>
</a>
<!-- Logout Modal -->
<div class="modal fade" id="logoutmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" onclick="signOut();">Logout</a>
            </div>
        </div>
    </div>
</div>


@include('template.applicant.segments.modal.application_description')
@include('template.applicant.segments.modal.upload_resume')

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('packages/popper/popper.min.js') }}"></script>
<script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Plugin JavaScript -->
<script src="{{ asset('packages/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('packages/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('packages/datatables/dataTables.bootstrap4.js') }}"></script>
<!-- Custom scripts for this template -->
<!-- Custom js-->

<script src="{{ asset('js/custom/custom.js') }}"></script>
<script src="{{ asset('js/custom/page/applicant/home.js') }}"></script>
<script src="{{ asset('js/custom/preloader.js') }}"></script>



