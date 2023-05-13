$.ajax({
    url: base_url('deactivated_list'),
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
        div +='<td><button class="btn btn-sm btn-info activate_user" data-id="'+value.id+'"><i class="fa fa-power-off"></i> Activate</button></td>';
        div +='</tr>';
        $('#DeactivatedUserListBody').html(div);
      });
      
      $( "#deactivated" ).DataTable();

    },
    error: function(e){

    }
});

$(document).on("click",".activate_user",function(e) {
//$('.activate_user').on('click',function() {

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
            window.location.replace('/admin/deactivated_users');
        },
        error: function(e){
    
        }
    });
})