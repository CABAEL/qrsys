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
      div +='<td><button type="button" class="btn btn-sm btn-default viewclient" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
      div +='</tr>';
      
    });
     

    $('#UserListBody').html(div);
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
   
   
   $(document).on('click','.viewclient',function(event) {
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
      
      let logo = '/img/bg_logo.png';
      
      if(data.logo){
        let hash_client_name = $.MD5(data.client_name);
        let client_logo_path = '/'+'{{ env("CLIENT_DIR_PATH") }}'+hash_client_name+'/logo/'; 
        logo = client_logo_path+data.logo;
      }
      
       $('#viewclientmodal .logoContainer').css('background-image','url('+logo+')');

       $('#update_client_form #update').attr('data-id',data.id);
       $('#update_client_form #client_name').val(data.client_name);
       $('#update_client_form #address').val(data.address);
       $('#update_client_form #email').val(data.email);
       $('#update_client_form #username').val(data.username);
       $('#update_client_form #mobile_number').val(data.contact_no);
       $('#update_client_form #description').val(data.description);
       $('#update_client_form #password').val("");
       $('#update_client_form #password_confirmation').val("");
   
       $("#viewclientmodal #updateAccount").attr('data-id',id);
       
       $("#viewclientmodal .deactivate").attr('data-id',id);
   
       $("#viewclientmodal .delete").attr('data-id',id);

       hide_loader();
       $('#viewclientmodal').modal('toggle');
       console.log(data);
     },
     error: function(e) {
       
       hide_loader();
     }
   });
   
   });


// form submit

addClientSubmit = (form) => {
  event.preventDefault();
   // Get form
    var form = $('#add_client_form')[0];
    var element = $('#add_user_errors');
   // FormData object 
   var formData = new FormData(form);

   formData.append('image', $('input[type=file]')[0].files[0]);
   
   show_loader();

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
   success: function(response) {

    let error_check = response.responseJSON.errors.length;

    if(error_check == 0){

      alert('User added successfully!');
      hide_loader();
      window.location.replace('/login');

    }

   },
   error: function(e) {
     var element = $('#add_user_errors');
     var form = '#add_client_form'; 
     promt_errors(form,element,e);
     hide_loader();
   }
   });
}


$(document).on("click","#generate_pass",function(event) {
  event.preventDefault();
  element = $('#viewclientmodal #password');
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


$(document).on("click","#update_client_form #clear",function() {
  event.preventDefault();

  var pass = $('#update_client_form #password');
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


$(document).on("click","#viewclientmodal .delete",function(e) {
  var data_id = $(this).data('id');
  var form = '#viewclientmodal';
  var element = $('#viewclientmodal #add_user_errors');
  var message = "Are you sure that you want to delete this user?";

  promt_warning_delete(form,element,message,data_id);
  //$('#confirmation').modal('toggle');
  console.log(data_id);

});


$(document).on("click","#viewclientmodal .delete_yes",function(e) {
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
          console.log(e);
          //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
          // var element = $('#add_user_errors');
          // var form = '#addusermodal'; 
          // promt_errors(form,element,e);
          // hide_loader();
        }
    });
  });
   
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>