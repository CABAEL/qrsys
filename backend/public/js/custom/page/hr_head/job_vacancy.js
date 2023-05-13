$.ajax({
    url: base_url('job'),
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
        div +='<td>'+value.name+'</td>';
        div +='<td>'+value.description+'</td>';
        div +='<td><button class="btn btn-sm btn-default delete_job" data-id="'+value.id+'"><i class="fa fa-trash"></i> Delete</button>&nbsp;<button class="btn btn-sm btn-default edit_job_vacancy" data-id="'+value.id+'"><i class="fa fa-edit"></i> Edit</button></td>';
        div +='</tr>';
        $('#JobListBody').html(div);
      });
      
      $( "#job-table").DataTable();

    },
    error: function(e){

    }
});

$(document).on("click",".delete_job",function(e) {
  show_loader();
  var id = $(this).data('id');
   $.ajax({
    url: base_url("job/"+id),
    type: 'DELETE', 
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(data) {
      console.log(data);
      alert(data.message);
      hide_loader();
      window.location.reload();

    },
    error: function(e){
      //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
      var element = $('#update_job_errors');
      var form = '#update_job_form'; 
      promt_errors(form,element,e);
      hide_loader();
    }
});
})

$(document).on("click","#update_job_vacancy",function(e) {
    var id = $(this).data('id');

      // Get form
      var form = $('#update_job_form');
      // FormData object 
      var formData = form.serialize();

  show_loader();
   $.ajax({
    url: base_url("job/"+id),
    type: 'PUT', 
    dataType: 'json',
    data:formData,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(data) {
      console.log(data);
      alert(data.message);
      hide_loader();
      window.location.reload();

    },
    error: function(e){
      //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
      var element = $('#update_job_errors');
      var form = '#update_job_form'; 
      promt_errors(form,element,e);
      hide_loader();
    }
});
});

$(document).on("click",".edit_job_vacancy",function(e) {

  var id = $(this).data('id');

  show_loader();
   $.ajax({
    url: base_url("job"),
    type: 'GET', 
    dataType: 'json',
    data:{id:id},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(data) {
      console.log(data);

      $('#update_name').val(data.name);
      $('#update_description').val(data.description);
      $('#update_job_vacancy').attr('data-id',id);

      hide_loader();
      $('#edit_job').modal('show');
    },
    error: function(e){

      var element = $('#update_job_errors');
      var form = '#update_job_form'; 
      promt_errors(form,element,e);
      hide_loader();
    }
});



});



$('#add_job_vacancy').on('click',function(event) {
    event.preventDefault();
    // Get form
    var form = $('#add_job_from');
    // FormData object 
    var formData = form.serialize();

  show_loader();
   $.ajax({
    url: base_url("job"),
    type: 'POST', 
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    data:formData,
    success: function(data) {
      console.log(data);
      alert('Job added successfully!');
      //promt_success(element,data)
      hide_loader();
      window.location.replace('/hr_head/job_vacancies');
    },
    error: function(e){
      //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
      var element = $('#add_job_errors');
      var form = '#add_job'; 
      promt_errors(form,element,e);
      hide_loader();
    }
});

});