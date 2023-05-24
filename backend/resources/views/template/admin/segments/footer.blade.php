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


@include('template.admin.segments.modal.add_user_modal')
@include('template.admin.segments.modal.view_user_modal')


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
<script src="{{ asset('js/custom/home.js') }}"></script>
<script src="{{ asset('js/custom/custom.js') }}"></script>
<script src="{{ asset('js/custom/ajax_request.js') }}"></script>

<script>
    $('#logoContainer').on('click',function(){
        $('#logo').trigger('click');
    });

    $('#logo').on('change',function(){

        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("logo").files[0]);

        oFReader.onload = function (oFREvent) {
            $('#logoContainer').css("background-image", "url('"+oFREvent.target.result+"')");
        };


        //$('#logoContainer').css("background-image", "url('"+$('#logo').val()+"')");
    });


    $(".show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('.show_hide_password input').attr("type") == "text"){
            $('.show_hide_password input').attr('type', 'password');
            $('.show_hide_password i').addClass( "fa-eye-slash" );
            $('.show_hide_password i').removeClass( "fa-eye" );
        }else if($('.show_hide_password input').attr("type") == "password"){
            $('.show_hide_password input').attr('type', 'text');
            $('.show_hide_password i').removeClass( "fa-eye-slash" );
            $('.show_hide_password i').addClass( "fa-eye" );
        }
    });
</script>


