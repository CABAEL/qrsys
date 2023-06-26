<script>
    
    $.ajax({
    url: base_url('file_groups'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret.responseJSON);
      var div = '';
    
   
       $.each(ret.responseJSON.data, function( index, value ) {
       let date = getFormattedDate(value.created_at);
       let status = "";
       let color = "red";

       if(value.status == 1){
        status = "Active";
        color = "green";
       }else{
        status = "Inactive";
        color = "red";
       }
   
       div +='<tr>'; 
       div +='<td>'+value.group_name+'</td>';
       div +='<td><pre>'+value.description+'</pre></td>';
       div +='<td>'+date+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewfilegroup" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
       div +='</tr>';
       
     });
      
   
     $('#FilegroupListBody').html(div);

     $( "#filegroup-table" ).DataTable({
      "order": [[ 3, "desc" ]], //or asc 
      "columnDefs" : [{"targets":3, "type":"date-eu"}],
     });
    
    },
    error: function(e){
    
    }
    });
    
    
    $(document).on('click','.viewfilegroup',function(event) {
    event.preventDefault();
    var id = $(this).data('id');
    //alert(base_url("user_info/"+id));
    show_loader();
    $.ajax({
      url: base_url("show_filegroup/"+id),
      type: 'GET', 
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function(data){

        let response = data.responseJSON;
        console.log(data);
        $('.alert').css('height','0px');
        $('.alert').css('overflow','hidden');
        $('.alert').css('visibility','hidden');
       
       let Status_Btn_Toggle = "Deactivate";
       let toggle_class = "deactivate";
       if(data.status == 0){
        Status_Btn_Toggle = "Activate";
        toggle_class = "activate";
       }

        $('#update_filegroup_form').attr('data-id',response.data.id);
        $('#update_filegroup_form #group_name').val(response.data.group_name);
        $('#update_filegroup_form #description').val(response.data.description);
    
        $("#viewfilegroup .delete").attr('data-id',response.data.id);
   
        hide_loader();
        $('#viewfilegroup').modal('toggle');
      },
      error: function(e) {
        
        hide_loader();
      }
    });
    
    });
   
   
   // form submit
   
   function updateFilegroupSubmit(form){
    event.preventDefault();

    // Get form
     var form = $('#add_filegroup_form')[0];
     var element = $('#add_filegroup_errors');
    // FormData object 
    var formData = new FormData(form);
    
    show_loader();
   
    $.ajax({
    url: base_url("add_filegroup"),
    type: 'POST', 
    dataType: 'json',
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    data:formData,
    success: function(response) {
      
     let error_check = response.responseJSON.errors;
     if(error_check == null || error_check.length == 0){
   
       alert(response.responseJSON.message);
       hide_loader();
       window.location.replace('/client/filegroups');
   
     }else{

      if(error_check.image[0]){
        alert(error_check.image[0]);

        let logo = '/img/bg_logo.png';
       
        $('#addclient .logoContainer').css('background-image','url('+logo+')');
        $('#addclient .logoContainer').css('border','solid 3px red');

      }else{
        promt_errors(form,element,response);
      }

      hide_loader();

     }
   
    },
    error: function(e) {
      element = $('#add_client_errors');
      form = '#addclient'; 
      promt_errors(form,element,e);
      hide_loader();
    }
    });
   }
   
   
   $(document).on("click","#generate_pass",function(event) {
   event.preventDefault();
   element = $('#viewusermodal #password');
   random_text_generator(element);
   });
   
   function copy_text(element) {
   event.preventDefault();
   
   
   var copyText = $(element);
   
   /* Select the text field */
   copyText.select();
   /* Copy the text inside the text field */
   navigator.clipboard.writeText(copyText.val());
   
   }
   
   
   $(document).on("click","#update_clientuser_form #clear",function() {
   event.preventDefault();
   
   var pass = $('#update_clientuser_form #password');
   clear(pass);
   clear(pass);
   });
   
   
   $("#show_hide_password a").on('click', function(event) {
         event.preventDefault();
         if($('#show_hide_password input').attr("type") == "text"){
             $('#show_hide_password input').attr('type', 'password');
             $('#show_hide_password i').addClass( "fa-eye-slash" );
             $('#show_hide_password i').removeClass( "fa-eye" );
         }else if($('#show_hide_password input').attr("type") == "password"){
             $('#show_hide_password input').attr('type', 'text');
             $('#show_hide_password i').removeClass( "fa-eye-slash" );
             $('#show_hide_password i').addClass( "fa-eye" );
         }
   });
   
   $("#show_hide_password2 a").on('click', function(event) {
         event.preventDefault();
         if($('#show_hide_password2 input').attr("type") == "text"){
             $('#show_hide_password2 input').attr('type', 'password');
             $('#show_hide_password2 i').addClass( "fa-eye-slash" );
             $('#show_hide_password2 i').removeClass( "fa-eye" );
         }else if($('#show_hide_password2 input').attr("type") == "password"){
             $('#show_hide_password2 input').attr('type', 'text');
             $('#show_hide_password2 i').removeClass( "fa-eye-slash" );
             $('#show_hide_password2 i').addClass( "fa-eye" );
         }
   });
   
   
  $(document).on("click","#viewusermodal .delete",function(e) {
  event.preventDefault();
   var data_id = $(this).data('id');
   var form = '#viewusermodal';
   var element = $('#viewusermodal #update_clientuser_errors');
   var message = "Are you sure that you want to delete this user?";
   
   promt_warning_delete(form,element,message,data_id);
   //$('#confirmation').modal('toggle');
  //  console.log(data_id);
   
   });
   
   
   $(document).on("click","#viewusermodal .delete_yes",function(e) {
    event.preventDefault();
     var id = $(this).data('id');
     show_loader();
     $.ajax({
         url: base_url("confirm_delete/"+id),
         type: 'DELETE', 
         dataType: 'json',
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function(data) {
           console.log(data);
           alert('User deleted!');
           //promt_success(element,data)
           hide_loader();
           window.location.replace('/client/accounts');
         },
         error: function(e){
           console.log(e);
           //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
           // var element = $('#add_user_errors');
           // var form = '#addusermodal'; 
           // promt_errors(form,element,e);
           // hide_loader();
         }
     });
   });
   
   
   updateClientUserSubmit = () => {
    event.preventDefault();

     // Get form
     var form = $('#update_clientuser_form')[0];
     // FormData object 
    //  var formData = form.serialize();
     var client_id = $('#update_clientuser_form').data('id');

    var formData = new FormData(form);
   
    $.ajax({
      url: base_url("update_user_data/"+client_id),
      type: 'post', 
      dataType: 'json',
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data:formData,
      success: function(data) {
        let error_check = data.responseJSON.errors;
        if(error_check == null || error_check.length == 0){
      
          alert('User updated successfully!');
          hide_loader();
          window.location.replace('/client/accounts');
      
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
        var element = $('#update_clientuser_errors');
        var form = '#viewusermodal'; 
        promt_errors(form,element,e);
  
        hide_loader();
      }
    });

  }

  $(document).on("click",".deactivate",function(e) {
  e.preventDefault();
    var data_id = $(this).data('id');

    var form = '#viewusermodal';
    var element = $('#update_clientuser_form .alert');
    var message = "Are you sure that you want to deactivate this client?";

    promt_warning_deactivate(form,element,message,data_id);
    console.log(data_id);

  });

  $(document).on("click",".deactivate_yes",function(e) {
    event.preventDefault();
    var id = $(this).data('id');
    show_loader();
    $.ajax({
        url: base_url("confirm_deactivate/"+id),
        type: 'PUT', 
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
          console.log(data);
          alert('User deactivated!');
          //promt_success(element,data)
          hide_loader();
          window.location.replace('/login');
        },
        error: function(e){
          //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
          var element = $('#update_clientuser_errors');
          var form = '#viewusermodal'; 
          promt_errors(form,element,e);
          hide_loader();
        }
    });
  });



  $(document).on("click",".activate",function(e) {
    event.preventDefault();

    show_loader();
    var data_id = $(this).data('id');

    $.ajax({
        url: base_url('activate_user/'+data_id),
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(ret) {
            console.log(ret);
            alert('Activated successfully!');
            //promt_success(element,data)
            hide_loader();
            window.location.replace('/admin/home');
        },
        error: function(e){
    
        }
    });
})

    
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
