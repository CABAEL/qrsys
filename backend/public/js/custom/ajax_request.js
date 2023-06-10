

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