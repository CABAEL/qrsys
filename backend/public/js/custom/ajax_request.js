$.ajax({
    url: base_url('user_list'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
     // console.log(ret);
      var div = '';

      $.each(ret.data, function( index, value ) {
       // console.log( index + ": " + value.username );

        div +='<tr>'; 
        div +='<td>'+value.username+'</td>';
        div +='<td>'+value.role+'</td>';
        div +='<td><button class="btn btn-sm btn-default viewuser" data-id="'+value.id+'"><i class="fa fa-user"></i></button></td>';
        div +='</tr>';
        $('#UserListBody').html(div);
      });
      
      $( "#user-table" ).DataTable();

    },
    error: function(e){

    }
});

$(document).on('click','.viewuser',function(event) {
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
        console.log(data);
      },
      error: function(e) {
        
        hide_loader();
      }
    });
  
});    

  $('#updateAccount').on('click',function(event) {
    //event.preventDefault();
    // Get form
    var form = $('#update_user_form');
    // FormData object 
    var formData = form.serialize();
    var user_data = $(this).data('id');

     $.ajax({
      url: base_url("update_user_data/"+user_data),
      type: 'put', 
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data:formData,
      success: function(data) {
        console.log(data);
        alert('Updated successfully!');
        //promt_success(element,data)
        hide_loader();
        window.location.replace('/login');
      },
      error: function(e) {
        //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
        var element = $('#details_error');
        var form = '#viewusermodal'; 
        promt_errors(form,element,e);
  
        hide_loader();
      }
  });
});

  $('#AddAccountSubmit').on('click',function(event) {
    event.preventDefault();
    // Get form
    var form = $('#add_user_form');
    // FormData object 
    var formData = form.serialize();

  show_loader();
   $.ajax({
    url: base_url("add_user"),
    type: 'POST', 
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    data:formData,
    success: function(data) {
      console.log(data);
      alert('User added successfully!');
      //promt_success(element,data)
      hide_loader();
      window.location.replace('/login');
    },
    error: function(e) {
      //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
      var element = $('#add_user_errors');
      var form = '#addusermodal'; 
      promt_errors(form,element,e);

      hide_loader();
    }
});

});


$(document).on("click",".deactivate_yes",function(e) {
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
          var element = $('#add_user_errors');
          var form = '#addusermodal'; 
          promt_errors(form,element,e);
          hide_loader();
        }
    });
  });


$(document).on("click",".delete_yes",function(e) {
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
          window.location.replace('/login');
        },
        error: function(e){
          //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
          var element = $('#add_user_errors');
          var form = '#addusermodal'; 
          promt_errors(form,element,e);
          hide_loader();
        }
    });
  });