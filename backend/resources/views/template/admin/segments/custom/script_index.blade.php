
@include('template.admin.segments.modal.add_user_modal')
@include('template.admin.segments.modal.view_user_modal')
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
        div +='<td>'+value.client_name+'</td>';
        div +='<td>200</td>';
        div +='<td><button class="btn btn-sm btn-default viewuser" data-id="'+value.id+'"><i class="fa fa-folder-open"></i></button></td>';
        div +='</tr>';
        $('#UserListBody').html(div);
      });
      
      $( "#user-table" ).DataTable();

    },
    error: function(e){

    }
});

$('#adduser').on('click',function(){
  $('#addusermodal').modal('show');
});


$('#AddAccountSubmit').on('click',function(event) {
    event.preventDefault();
    // Get form
    var form = $('#add_user_form');
    // FormData object 
    var formData = form.serialize();

  show_loader();
   $.ajax({
    url: base_url("add_client"),
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
</script>
