$.ajax({
    url: base_url('employee_list'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      var div = '';

      $.each(ret.data, function( index, value ) {
       // console.log( index + ": " + value.username );
        if(value.mname == null){
          mname="";
        }
        else{
          mname = value.mname.toUpperCase()
        }
        div +='<tr>'; 
        div +='<td>'+value.employee_id+'</td>';
        div +='<td>'+value.lname.toUpperCase()+', '+value.fname.toUpperCase()+' '+mname+'</td>';
        div +='<td><a target="_blank" href="'+base_url('employee_id/'+value.employee_id+'')+'"><button class="btn btn-sm btn-default" data-id="'+value.id+'"><i class="fa fa-book"></i> View Employee data</button></a></td>';
        div +='</tr>';
        $('#EmployeeListBody').html(div);
      });
      
      $( "#employee-table").DataTable();

    },
    error: function(e){

    }
});