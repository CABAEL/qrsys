@include('template.admin.segments.modal.add_admin_modal')
@include('template.admin.segments.modal.view_admin_modal')
<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
<script>
  $.ajax({
    url: base_url('admin_list'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      var div = '';
    
   
       $.each(ret.data, function( index, value ) {

       let date = getFormattedDate(value.created_at);
       let status = "";
       let color = "red";
       let name = value.fname+" "+value.mname+" "+value.lname;

       if(value.status == 1){
        status = "Active";
        color = "green";
       }else{
        status = "Inactive";
        color = "red";
       }
   
       div +='<tr>'; 
       div +='<td>'+name+'</td>';
       div +='<td><em style="color:'+color+'">'+status+'</em></td>';
       div +='<td>'+date+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewadmin" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
       div +='</tr>';
       
     });
      
   
     $('#ClientListBody').html(div);
     $( "#clients-table" ).DataTable({
      "order": [[ 3, "desc" ]], //or asc 
      "columnDefs" : [{"targets":3, "type":"date-eu"}],
     });
    
    },
    error: function(e){
    
    }
  });

  $(document).on('click','#addadmin_btn',function(){
    $('#addadmin').modal('show');
  });


  function addAdminSubmit(form){
    event.preventDefault();

    // Get form
     var form = $('#add_admin_form')[0];
     var element = $('#add_admin_errors');
    // FormData object
    var formData = new FormData(form);
    formData.append('image', $('input[type=file]')[0].files[0]);
    
    show_loader();
   
    $.ajax({
    url: base_url("add_admin"),
    type: 'POST', 
    dataType: 'json',
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    data:formData,
    success: function(response) {
   
     let error_check = response.errors;
     if(error_check == null || error_check.length == 0){
   
       alert('Administrator added successfully!');
       hide_loader();
       window.location.replace('/admin/adminaccounts');
   
     }else{

      if(error_check.image[0]){
        alert(error_check.image[0]);

        let logo = '/img/bg_logo.png';
       
        $('#addadmin .logoContainer').css('background-image','url('+logo+')');
        $('#addadmin .logoContainer').css('border','solid 3px red');

      }else{
        promt_errors(form,element,response);
      }

      hide_loader();

     }
   
    },
    error: function(e) {
      element = $('#add_admin_errors');
      form = '#addadmin'; 
      promt_errors(form,element,e);
      hide_loader();
    }
    });
  }


  $('.logoContainer').on('click',function(){
        $('#logo').trigger('click');
    });
    
    $('#logo').on('change',function(){

        $('.logoContainer').css('border','none');
    
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("logo").files[0]);
    
        oFReader.onload = function (oFREvent) {
            $('.logoContainer').css("background-image", "url('"+oFREvent.target.result+"')");
        };
    });
   
   
    $('.updatelogoContainer').on('click',function(){
        $('#updatelogo').trigger('click');
    });
   
   $('#updatelogo').on('change',function(){
    
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("updatelogo").files[0]);
   
    oFReader.onload = function (oFREvent) {
        $('.updatelogoContainer').css("background-image", "url('"+oFREvent.target.result+"')");
    };
   });  

   $(document).on('click','.viewadmin',function(event) {
    event.preventDefault();
    var id = $(this).data('id');
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
        console.log(data);
        $('.alert').css('height','0px');
        $('.alert').css('overflow','hidden');
        $('.alert').css('visibility','hidden');


        let logo = '/img/bg_logo.png';
        
       if(data.picture){
         let client_logo_path = '/'+'{{ env("ADMIN_DIR_PATH") }}'+'admin_pictures/'; 
         logo = client_logo_path+data.picture;
       }

       let Status_Btn_Toggle = "Deactivate";
       let toggle_class = "deactivate";
       if(data.status == 0){
        Status_Btn_Toggle = "Activate";
        toggle_class = "activate";
       }
       
        $('#update_adminuser_form .updatelogoContainer').css('background-image','url('+logo+')');
        $('#update_adminuser_form').attr('data-id',data.id);
        $('#update_adminuser_form #fname').val(data.fname);
        $('#update_adminuser_form #mname').val(data.mname);
        $('#update_adminuser_form #lname').val(data.lname);
        $('#update_adminuser_form #address').val(data.address);
        $('#update_adminuser_form #email').val(data.email);
        $('#update_adminuser_form #username').val(data.username);
        $('#update_adminuser_form #contact_number').val(data.contact_no);
        $('#update_adminuser_form #description').val(data.description);
        $('#update_adminuser_form #password').val("");
        $('#update_adminuser_form #password_confirmation').val("");
   
        $('#update_adminuser_form #updatelogo').val("");
    
        $("#viewadminmodal #updateAccount").attr('data-id',id);
        
        $("#viewadminmodal .status_toggle").attr('data-id',id);
        $("#viewadminmodal .status_toggle").addClass(toggle_class);
        $("#viewadminmodal .status_toggle").html(Status_Btn_Toggle);
    
        $("#viewadminmodal .delete").attr('data-id',id);
   
        hide_loader();
        $('#viewadminmodal').modal('toggle');
      },
      error: function(e) {
        
        hide_loader();
      }
    });
    
    });


    function updateAdminUserSubmit (){
    event.preventDefault();

     // Get form
     var form = $('#update_adminuser_form')[0];
     // FormData object 
    //  var formData = form.serialize();
     var client_id = $('#update_adminuser_form').data('id');

    var formData = new FormData(form);


    $.ajax({
      url: base_url("update_adminuser_data/"+client_id),
      type: 'post', 
      dataType: 'json',
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data:formData,
      success: function(data) {
        let error_check = data.errors;
        if(error_check == null || error_check.length == 0){
      
          alert('User updated successfully!');
          hide_loader();
          window.location.replace('/admin/adminaccounts');
      
        }else{

          if(error_check.image[0]){

            alert(error_check.image[0]);

          }else{
            promt_errors(form,element,response);
          }

          hide_loader();

        }
      },
      error: function(e) {
        //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
        var element = $('#update_adminuser_errors');
        var form = '#viewadminmodal'; 
        promt_errors(form,element,e);
  
        hide_loader();
      }
    });

  }


</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
