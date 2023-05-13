$.ajax({
    url: base_url('applicant_details'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },

    success: function(ret) {
      var div = '';
      $.each(ret.data, function( index, value ) {

        var status = '';
        if(value.status == 0){
          status = "Pending";
        }
        if(value.status == 1){
          status = "Accepted";
          var applicant_action = ''
          //applicant_action +='<button class="btn btn-info btn-block" data-id="'+value.user_id+'" id="hire_applicant">Hire</button>'
          //$('#applicant_action').html(applicant_action);
        }
        if(value.status == 2){
          status = "Rejected";
        }
        if(value.status == 3){
          status = "Marked as failed";
        }

        if(value.status == 4){
          status = "hired";
        }

        const d = value.created_at;
        
        var actual_date= d.substring(0, 10);

        div +='<tr>'; 
        div +='<td>'+value.lname+' '+value.fname+'</td>';
        div +='<td>'+value.name+'</td>';
        div +='<td>'+status+'</td>';
        div +='<td>'+actual_date+'</td>';
        div +='<td><button class="btn btn-sm btn-default viewApplicationDetails" data-id="'+value.user_id+'">View Application Details</button></td>';
        div +='</tr>';
        $('#ApplicantListBody').html(div);
      });
      
      $( "#applicant-table").DataTable();

    },
    error: function(e){

    }
});

$.ajax({
    url: base_url('recommendedlist'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
     //console.log(ret);
      var div = '';
      $.each(ret.user_data, function( index, value ) {

        var status = '';
        if(value.status == 0){
          status = "Pending";
        }
        if(value.status == 1){
          status = "Accepted";
          var applicant_action = ''
          //applicant_action +='<button class="btn btn-info btn-block" data-id="'+value.user_id+'" id="hire_applicant">Hire</button>'
          //$('#applicant_action').html(applicant_action);
        }
        if(value.status == 2){
          status = "Rejected";
        }
        if(value.status == 3){
          status = "Marked as failed";
        }

        if(value.status == 4){
          status = "hired";
        }


        const d = value.created_at;
        
        var actual_date= d.substring(0, 10);

        div +='<tr>'; 
        div +='<td>'+value.lname+' '+value.fname+'</td>';
        div +='<td>'+value.name+'</td>';
        div +='<td>'+status+'</td>';
        div +='<td>'+actual_date+'</td>';
        div +='<td>'+ret.exp[value.user_id]['count']+'</td>';
        div +='<td><button class="btn btn-sm btn-default viewApplicationDetails" data-id="'+value.user_id+'">View Application Details</button></td>';
        div +='</tr>';
        $('#recommendedList').html(div);


      });
      
     //$( "#recommended").DataTable();
     var recommended_table = $('#recommended').DataTable({
      "ordering": true,
      "bFilter": false,
      "aoColumnDefs": [{ "bVisible": false, "aTargets": [4] }]
      });

      recommended_table.order( [ 5, 'asc' ] ).draw();
      
    },
    error: function(e){

    }
});


$(document).on("click",".viewApplicationDetails",function(e) {

  var id = $(this).data('id');
  $.ajax({
    url: base_url('applicant_details'),
    type: 'GET',
    dataType: 'json',
    data:{id:id},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {

      var name = "&nbsp;"+ret.data[0].lname+", "+ret.data[0].fname;
      var resume_link = '&nbsp;<a href="../upload/resume/'+ret.data[0].resume_link+'" target="_blank">View Resume</a>';
      var email = "&nbsp;"+ret.data[0].email;
      var mobile_number = "&nbsp;"+ret.data[0].mobile_number;
      var position = "&nbsp;"+ret.data[0].name;
      var self = "&nbsp;"+ret.data[0].about_self;
      var id = ret.data[0].user_id;

      var applicant_action = ''
      if(ret.data[0].application_status == 1){
        applicant_action +='<button class="btn btn-info btn-block" data-id="'+ret.data[0].user_id+'" id="hire_applicant">Hire</button><br><button class="btn btn-danger btn-block" id="mark_as_failed">Mark as failed</button>'
        $('#applicant_action').html(applicant_action);
      }



      if(ret.data[0].resume_link == null){
        resume_link = '&nbsp;<a href="../upload/no_resume.pdf" target="_blank">View Resume</a>';
        $('#accept_application').attr('disabled','disabled');
        $('#decline_application').attr('disabled','disabled');
        $('#mark_as_failed').attr('disabled','disabled');
        alert('No resume uploaded!');
      }

      $('#applicant_name').html(name);
      $('#applicant_resume_link').html(resume_link);
      $('#applicant_email').html(email);
      $('#applicant_mobile_number').html(mobile_number);
      $('#applicant_position_applied').html(position);
      $('#applicant_about_self').html(self);

      $('#accept_application').attr('data-id',id);
      $('#decline_application').attr('data-id',id);
      $('#mark_as_failed').attr('data-id',id);

      $('#viewApplicant').modal('toggle');
      id = '';
    },
    error: function(e){

    }
});

});

$(document).on("click","#accept_application",function(e) {
  var id = $(this).data('id');
  //alert(id);

  $.ajax({
    url: base_url('accept_applicant'),
    type: 'POST',
    dataType: 'json',
    data:{id:id},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      alert(ret.message);
      window.location.reload();

    },
    error: function(e){

    }
  });



});

$(document).on("click","#decline_application",function(e) {
  var id = $(this).data('id');
  //alert(id);

  $.ajax({
    url: base_url('decline_applicant'),
    type: 'POST',
    dataType: 'json',
    data:{id:id},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      alert(ret.message);
      window.location.reload();

    },
    error: function(e){

    }
  });


});

$(document).on("click","#mark_as_failed",function(e) {
  var id = $(this).data('id');

  $.ajax({
    url: base_url('failed_applicant'),
    type: 'POST',
    dataType: 'json',
    data:{id:id},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      alert(ret.message);
      window.location.reload();

    },
    error: function(e){

    }
  });


});

$(document).on("click","#hire_applicant",function(e) {
  var id = $(this).data('id');

  $.ajax({
    url: base_url('hire_applicant'),
    type: 'POST',
    dataType: 'json',
    data:{id:id},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      alert(ret.message);
      window.location.reload();

    },
    error: function(e){

    }
  });

});