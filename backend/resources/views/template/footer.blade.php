<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; {{env('APP_NAME')}} {{env('YEAR')}}</small>
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
                <a class="btn btn-primary" style="color:#fff" onclick="signOut();">Logout</a>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript -->
<script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('packages/popper/popper.min.js') }}"></script>
<script src="{{ asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Plugin JavaScript -->
<script src="{{ asset('packages/jquery-easing/jquery.easing.min.js') }}"></script>
<!--<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>-->
<script src="{{ asset('packages/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('packages/datatables/dataTables.bootstrap4.js') }}"></script>
<!-- Custom scripts for this template -->
<script src="{{ asset('js/sb-admin.min.js') }}"></script>
<!-- Custom js-->
<script src="{{ asset('js/custom/preloader.js') }}"></script>
<!-- <script src="{{ asset('js/custom/home.js') }}"></script>
<script src="{{ asset('js/custom/custom.js') }}"></script> -->
<!-- <script src="{{ asset('js/custom/ajax_request.js') }}"></script> -->

<script>
    var url_segment = window.location.pathname.split('/');
    var user_level_dir = url_segment[1];

    function base_url(append)
    {
        var base_url = window.location.origin;
        if(user_level_dir == ''){
            return base_url+"/"+append;
        }
        else{
            return base_url+"/"+user_level_dir+"/"+append;
        }
    }

    function signOut() {
        //var auth2 = gapi.auth2.getAuthInstance();
        //auth2.disconnect().then(function () {
        var url = base_url("logout");
        location.replace(url);
        //console.log('User signed out.');
        //});
    }
</script>


