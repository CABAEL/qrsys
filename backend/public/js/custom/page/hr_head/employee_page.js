var employee_id = window.location.pathname.split("/").pop();
show_loader();
$.ajax({
    url: base_url('employee/')+employee_id,
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      $('#uploadPayslip').attr('data-user_id',ret[0].id);
      $('#employee_id').html(ret[0].employee_id);
      $('#gender').html(ret[0].gender);
      $('#mobile').html(ret[0].mobile_number);
      $('#email').html(ret[0].email);
      if(ret[0].mname != null){
        mname = ret[0].mname;
      }else{
        mname = '';
      }
      $('#name').html(''+(ret[0].lname+', '+ret[0].fname+' '+mname).toUpperCase());


            //dtr ajax
            $.ajax({
              url: base_url('employee_get_dtr'),
              type: 'post',
              dataType: 'json',
              data:{user_id:ret[0].id},
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              success: function(ret) {
            
                var div = '';
            
                $.each(ret.data, function( index, value ) {
                  date = new Date(value.created_at);
                  year = date.getFullYear();
                  month = date.getMonth()+1;
                  dt = date.getDate();
                  display_date = year+"-"+month+"-"+dt;
            
                  var t_out = value.time_out;
                  if(t_out == null){
                    t_out = "Not set";
                  }
            
                  div +='<tr>'; 
                  div +='<td>'+display_date+'</td>';
                  div +='<td>'+value.time_in+'</td>';
                  div +='<td>'+t_out+'</td>';
                  div +='</tr>';
                  $('#DTRListBody').html(div);
                });
                
                $( "#dtr-table").DataTable();
            
              },
              error: function(e){
            
              }
            });
            
      //payslip ajax
      $.ajax({
        url: base_url('get_payslip/')+ret[0].id,
        type: 'get',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(ret) {
      
          var div = '';
      
          $.each(ret.data, function( index, value ) {

            div +='<tr>'; 
            div +='<td>'+value.from+'</td>';
            div +='<td>'+value.to+'</td>';
            div +='<td><a href="../../upload/payslip/'+value.filename+'" target="_blank">View Payslip</a></td>';
            div +='</tr>';
            $('#PayslipListBody').html(div);
          });
          
          $( "#payslip-table").DataTable();
      
        },
        error: function(e){
      
        }
      });

      console.log(ret);
      hide_loader();
    },
    error: function(e){

    }
});


$('#uploadPayslip').on('click',function(event){
  event.preventDefault();
  //var form = $('#applicant_details_form');
var user_id = $(this).data('user_id')
 // fd.append('file',files[0]);
 var formData = new FormData($('#add_payslip_form')[0]);
 files = $('#payslip');
 formData.append('file',files);
 formData.append('user_id',user_id);

  show_loader();
  $.ajax({
    type:'POST',
    url: base_url('add_payslip'),
    data:formData,
    cache:false,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success:function(data){
        //alert("application details added");
        $('#add_payslip_form')[0].reset();
        console.log(data.message);
        window.location.reload();
    },
    error: function(e){
      var element = $('#add_payslip_errors');
      var form = '#add_payslip_form'; 
      promt_errors(form,element,e);

      hide_loader();
    }
});  

});


