<script>
  
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
    
    $.ajax({
    url: base_url('active_client_users'),
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
       div +='<td>'+value.fname+' '+value.mname+' '+value.lname+'</td>';
       div +='<td><em style="color:'+color+'">'+status+'</em></td>';
       div +='<td>'+date+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewclientuser" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
       div +='</tr>';
       
     });
      
   
     $('#ClientUserListBody').html(div);

     $( "#users-table" ).DataTable({
      "order": [[ 3, "desc" ]], //or asc 
      "columnDefs" : [{"targets":3, "type":"date-eu"}],
     });
    
    },
    error: function(e){
    
    }
    });
    
    
    $(document).on('click','.viewclientuser',function(event) {
    event.preventDefault();
    var id = $(this).data('id');

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
        let hash_client_name = $.MD5(data.client_name);
         let client_logo_path = '/'+'{{ env("CLIENT_DIR_PATH") }}'+hash_client_name+'/user_pictures/'; 
         logo = client_logo_path+data.picture;
       }

       let Status_Btn_Toggle = "Deactivate";
       let toggle_class = "deactivate";
       if(data.status == 0){
        Status_Btn_Toggle = "Activate";
        toggle_class = "activate";
       }

       fetchAllFilegroups('#update_clientuser_form',data.file_group_id);
       
        $('#update_clientuser_form .updatelogoContainer').css('background-image','url('+logo+')');
        $('#update_clientuser_form').attr('data-id',data.id);
        $('#update_clientuser_form #fname').val(data.fname);
        $('#update_clientuser_form #mname').val(data.mname);
        $('#update_clientuser_form #lname').val(data.lname);
        $('#update_clientuser_form #address').val(data.address);
        $('#update_clientuser_form #email').val(data.email);
        $('#update_clientuser_form #username').val(data.username);
        $('#update_clientuser_form #contact_number').val(data.contact_no);
        $('#update_clientuser_form #description').val(data.description);
        $('#update_clientuser_form #password').val("");
        $('#update_clientuser_form #password_confirmation').val("");
   
        $('#update_clientuser_form #updatelogo').val("");
    
        $("#viewusermodal #updateAccount").attr('data-id',id);
        
        $("#viewusermodal .status_toggle").attr('data-id',id);
        $("#viewusermodal .status_toggle").addClass(toggle_class);
        $("#viewusermodal .status_toggle").html(Status_Btn_Toggle);
    
        $("#viewusermodal .delete").attr('data-id',id);
   
        hide_loader();
        $('#viewusermodal').modal('toggle');
      },
      error: function(e) {
        
        hide_loader();
      }
    });
    
    });
   
   
   // form submit
   
   function addUserSubmit(form){
    event.preventDefault();

    // Get form
     var form = $('#add_user_form')[0];
     var element = $('#add_user_errors');
    // FormData object
    var formData = new FormData(form);
    formData.append('image', $('input[type=file]')[0].files[0]);
    
    show_loader();
   
    $.ajax({
    url: base_url("add_user"),
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
   
       alert('User added successfully!');
       hide_loader();
       window.location.replace('/client/accounts');
   
     }else{

      if(error_check.image[0]){
        alert(error_check.image[0]);

        let logo = '/img/bg_logo.png';
       
        $('#adduser .logoContainer').css('background-image','url('+logo+')');
        $('#adduser .logoContainer').css('border','solid 3px red');

      }else{
        promt_errors(form,element,response);
      }

      hide_loader();

     }
   
    },
    error: function(e) {
      element = $('#add_user_errors');
      form = '#adduser'; 
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
      url: base_url("update_clientuser_data/"+client_id),
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
          window.location.replace('/client/accounts');
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



  $(document).on("click",".activate",function(e){
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
            window.location.replace('/client/accounts');
        },
        error: function(e){
    
        }
    });
})

$(document).on('click','#adduser_btn',function(e){
  event.preventDefault();
  fetchAllFilegroups('#adduser');
  $('#adduser').modal('show');

})

function fetchAllFilegroups(form,value = null) {
    const url = base_url('all_filegroups');
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {

      // Handle the response data here
      const selectElement = $(form + ' #filegroups')[0] // Replace with the ID of your <select> element
      let div = '';
      div += '<option value="">-----------------</option>';
      data.responseJSON.data.forEach(filegroup => {
        div += '<option value="'+filegroup.id+'">'+filegroup.group_name+'</option>';
      });
    console.log(div);
    selectElement.innerHTML = div;

      if(value != null){
        selectElement.value = value;
      }

        // Handle the response data here
        console.log(data);
      })
      .catch(error => {
        // Handle any errors that occur during the request
        console.error(error);
      });

  }
    
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
