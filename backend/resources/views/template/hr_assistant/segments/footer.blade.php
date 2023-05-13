<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; {{env('APP_NAME')}} 2022</small>
        </div>
    </div>
    @include('template.hr_assistant.segments.modal.edit_job_modal')    
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

@include('template.hr_assistant.segments.modal.view_applicant_details_modal')
@include('template.hr_assistant.segments.modal.add_job_modal')




<!-- Bootstrap core JavaScript -->
<script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('packages/popper/popper.min.js') }}"></script>
<script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Plugin JavaScript -->
<script src="{{ asset('packages/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('packages/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('packages/datatables/dataTables.bootstrap4.js') }}"></script>
<!-- Custom scripts for this template -->
<script src="{{ asset('js/sb-admin.min.js') }}"></script>
<!-- Custom js-->

<script src="{{ asset('js/custom/preloader.js') }}"></script>
<script src="{{ asset('js/custom/home.js') }}"></script>
<script src="{{ asset('js/custom/custom.js') }}"></script>
<script src="{{ asset('js/custom/ajax_request.js') }}"></script>

<script src="{{ asset('packages/tinymce/jquery.tinymce.min.js') }}"></script>
<script src="{{ asset('packages/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/custom/page/hr_head/event_announcement.js') }}"></script>



