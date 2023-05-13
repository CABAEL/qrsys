$.ajax({
    url: base_url('job'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
     console.log(ret);
      var div = '';
      div +='<option value="">---</option>'; 
      $.each(ret.data, function( index, value ) {
        div +='<option value="'+value.id+'">'+value.name+'</option>'; 
        $('#position').html(div);
      });
      
      $( "#employee-table").DataTable();

    },
    error: function(e){

    }
});


$.ajax({
    url: base_url('user_applicant_details'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
     console.log(ret);
     var status = '';
     if(ret[0].status == 0){
       status = "Pending";
     }
     if(ret[0].status == 1){
       status = "Accepted";
     }
     if(ret[0].status == 2){
       status = "Rejected";
     }
     
     if(ret[0].status == 3){
       status = "Marked as failed";
       $('#ApplicationDetails').attr('disabled','disabled');
       $('#ApplicationDetails').css('cursor','disabled');
     }

     if(ret[0].resume_link != null){
      $('.btn-info').attr('disabled','disabled');
      $('.btn-info').css('cursor','disabled');
     }

     $('#application_status').html(status);
    },
    error: function(e){
     
    }
});


$('#ApplicationDetails').on('click',function(event){
  event.preventDefault();
  //var form = $('#applicant_details_form');
  var counter = $('#workexp').find('.expcontainer').length;
  console.log(counter);
if(counter >= 1){

  var error_flag = 0;

  jQuery('.prevcompany').each(function(k,v) {
    console.log(k);
    console.log($(this).val());
    if($(this).val() == ''){
      $(this).css('border','solid 1px red');
      error_flag += 1;
    }else{
      $(this).css('border','1px solid rgba(0,0,0,.15)');
      error_flag = 0;
    }
  });

  jQuery('.prevposition').each(function(k,v) {
    console.log(k);
    console.log($(this).val());
    if($(this).val() == ''){
      $(this).css('border','solid 1px red');
      error_flag += 1;
    }else{
      $(this).css('border','1px solid rgba(0,0,0,.15)');
      error_flag = 0;
    }
  });

  jQuery('.from_date').each(function(k,v) {
    console.log(k);
    console.log($(this).val());
    if($(this).val() == ''){
      $(this).css('border','solid 1px red');
      error_flag += 1;
    }else{
      $(this).css('border','1px solid rgba(0,0,0,.15)');
      error_flag = 0;
    }
  });

  jQuery('.to_date').each(function(k,v) {
    console.log(k);
    console.log($(this).val());
    if($(this).val() == ''){
      $(this).css('border','solid 1px red');
      error_flag += 1;
    }else{
      $(this).css('border','1px solid rgba(0,0,0,.15)');
      error_flag = 0;
    }
  });

  if(error_flag == 0){
 // fd.append('file',files[0]);
 var formData = new FormData($('#applicant_details_form')[0]);
 files = $('#resume_file');
 formData.append('file',files);

  show_loader();
  $.ajax({
    type:'POST',
    url: base_url('add_applicant_details'),
    data:formData,
    cache:false,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success:function(data){
        alert("Application details added");
        console.log(data);
        window.location.reload();
    },
    error: function(e){
      var element = $('#update_user_errors');
      var form = '#applicant_details_form'; 
      promt_errors(form,element,e);
      hide_loader();
    }
});
  }

}

else{
 // fd.append('file',files[0]);
 var formData = new FormData($('#applicant_details_form')[0]);
 files = $('#resume_file');
 formData.append('file',files);

  show_loader();
  $.ajax({
    type:'POST',
    url: base_url('add_applicant_details'),
    data:formData,
    cache:false,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success:function(data){
        alert("Application details added");
        console.log(data);
        window.location.reload();
    },
    error: function(e){
      var element = $('#update_user_errors');
      var form = '#applicant_details_form'; 
      promt_errors(form,element,e);
      hide_loader();
    }
});  
}



});



$(document).on('click','#add_workexp',function(event){
  var counter = $('#workexp').find('.expcontainer').length;
  
  //alert (counter);
  
  var div = '';
  div+= '<br><div style="border:solid 1px #888;padding:5px;" class="form-row expcontainer" id="expcontainer_'+counter+'">';
  div+= '<div class="col-md-6">';
  div+= '<input type="text" class="form-control prevcompany" placeholder="Company Name" name="prevcompany[]" required/><br>';
  div+= '</div>';
  div+= '<div class="col-md-6">';
  div+= '<input type="text" class="form-control prevposition" placeholder="Position" name="prevposition[]" required/>';
  div+= '</div>';
  div+= '<div class="col-md-12">';

  div+= '<label for="from">&nbsp;From:</label>';
  div+= '<input type="date" class="from_date" name="from_date[]" required>';
  div+= '<label for="to">&nbsp;to:</label>';
  div+= '<input type="date" class="to_date" name="to_date[]" required><a class="btn btn-sm remove_container" sytle="color:red;" data-container="expcontainer_'+counter+'"><i> Remove</i></a>';
  div+= '</div>';
  div+= '</div>';


  $('#workexp').append(div);

});

$(document).on('click','.remove_container',function(event){
  var remove = $(this).attr('data-container');
  $("#"+remove).remove();
});

$('#uploadResume').on('click',function(event){
  //console.log('sss');

  var fd = new FormData();
  var files = $('#resume_file')[0].files;
  
  console.log(files);

  show_loader();
  if(files.length > 0 ){
    fd.append('file',files[0]);

    $.ajax({
      url: base_url('upload_resume'),
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
       type: 'post',
       data: fd,
       contentType: false,
       processData: false,
       success: function(response){
        console.log(response);
        $('#resume_form')[0].reset();
        alert(response.message);
        //$('#upload_resume_modal').modal('hide');
        hide_loader();
        location.reload(); 
       },
    });
 }else{
    alert("Please select a file.");
 } 

});