<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; {{env('APP_NAME')}} 2022</small>
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



@include('template.employee.segments.modal.view_user_modal')


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
<script src="{{ asset('js/custom/custom.js') }}"></script>
<script src="{{ asset('js/custom/page/employee/home.js') }}"></script>

<script>
    $(document).on('click','#viewuser',function(event) {
      event.preventDefault();
      var id = "{{Auth::user()->id}}";
      //alert(base_url("user_info/"+id));
      show_loader();
      $.ajax({
        url: base_url("user_info/"+id),
        type: 'GET', 
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data){
    
          hide_loader();
    
          $('#viewusermodal #update').attr('data-id',data.id);
          $('#viewusermodal #update_fname').val(data.fname);
          $('#viewusermodal #update_mname').val(data.mname);
          $('#viewusermodal #update_lname').val(data.lname);
    
          $('#viewusermodal #update_age').val(data.age);
          $("#viewusermodal option[value="+data.gender+"]").attr('selected','selected');
          $('#viewusermodal #update_birthday').val(data.birthday);
          $('#viewusermodal #update_address').val(data.address);
    
          $('#viewusermodal #update_email').val(data.email);
          $('#viewusermodal #update_username').val(data.username);
          $('#viewusermodal #update_mobile_number').val(data.mobile_number);
          $("#viewusermodal option[value="+data.role+"]").attr('selected','selected');
    
          $("#viewusermodal #updateAccount").attr('data-id',id);
          
          $("#viewusermodal .deactivate").attr('data-id',id);
    
          $("#viewusermodal .delete").attr('data-id',id);
    
          $('#viewusermodal').modal('toggle');
          $('#viewusermodal :input').attr('disabled', 'true');
          console.log(data);
        },
        error: function(e) {
          
          hide_loader();
        }
      });
    
    });
    </script>




