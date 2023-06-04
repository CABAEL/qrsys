@include('template.admin.segments.modal.add_user_modal')
@include('template.admin.segments.modal.view_user_modal')
<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
<script>
   $('.logoContainer').on('click',function(){
       $('#logo').trigger('click');
   });
   
   $('#logo').on('change',function(){
   
       var oFReader = new FileReader();
       oFReader.readAsDataURL(document.getElementById("logo").files[0]);
   
       oFReader.onload = function (oFREvent) {
           $('.logoContainer').css("background-image", "url('"+oFREvent.target.result+"')");
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
       div +='<td>Active</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewuser" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
       div +='</tr>';
       $('#UserListBody').html(div);
     });
     
     $( "#user-table" ).DataTable();
   
   },
   error: function(e){
   
   }
   });
   
   
   var myLineChart1 = new Chart(document.getElementById('myBarChart'), {
     type: 'bar',
       data: {
         labels: ['Monday', 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' , 'Sunday '],
         datasets: [
           {
             label: 'Client',
             data: [2112, 2343, 2545, 3423, 2365, 1985, 987],
             borderColor: '#36A2EB',
             backgroundColor: '#035fae',
           },
           {
             label: 'Users',
             data: [2112, 2343, 2545, 3423, 2365, 1985, 987],
             borderColor: '#36A2EB',
             backgroundColor: '#777',
           },
           {
             label: 'Uploads',
             data: [2112, 2343, 2545, 3423, 2365, 1985, 987],
             borderColor: '#16f4f0',
             backgroundColor: '#ace4ee',
           },
         ],
       },
     // options: {
     //   scales: {
     //     xAxes: [{
     //       time: {
     //         unit: 'month'
     //       },
     //       gridLines: {
     //         display: true
     //       },
     //       ticks: {
     //         maxTicksLimit: 12
     //       }
     //     }],
     //     yAxes: [{
     //       ticks: {
     //         min: 0,
     //         max: 100,
     //         maxTicksLimit: 10
     //       },
     //       gridLines: {
     //         display: true
     //       }
     //     }],
     //   },
     //   legend: {
     //     display: true
     //   }
     // }
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
   
       // $('#viewusermodal #update').attr('data-id',data.id);
       // $('#viewusermodal #update_fname').val(data.fname);
       // $('#viewusermodal #update_mname').val(data.mname);
       // $('#viewusermodal #update_lname').val(data.lname);
   
       // $('#viewusermodal #update_age').val(data.age);
       // $("#viewusermodal option[value="+data.gender+"]").attr('selected','selected');
       // $('#viewusermodal #update_birthday').val(data.birthday);
       // $('#viewusermodal #update_address').val(data.address);
   
       // $('#viewusermodal #update_email').val(data.email);
       // $('#viewusermodal #update_username').val(data.username);
       // $('#viewusermodal #update_mobile_number').val(data.mobile_number);
       // $("#viewusermodal option[value="+data.role+"]").attr('selected','selected');
   
       // $("#viewusermodal #updateAccount").attr('data-id',id);
       
       // $("#viewusermodal .deactivate").attr('data-id',id);
   
       // $("#viewusermodal .delete").attr('data-id',id);
   
       $('#viewusermodal').modal('toggle');
       console.log(data);
     },
     error: function(e) {
       
       hide_loader();
     }
   });
   
   });


// form submit

formSubmit = (form) => {
  event.preventDefault();
   // Get form
    var form = $('#add_client_form')[0];
   // FormData object 
   var formData = new FormData(form);

   formData.append('image', $('input[type=file]')[0].files[0]);
   
   //show_loader();
   $.ajax({
   url: base_url("add_client"),
   type: 'POST', 
   dataType: 'json',
   contentType: false,
   processData: false,
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
     var form = '#add_client_form'; 
     promt_errors(form,element,e);
   
     //hide_loader();
   }
   });
}
   
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>