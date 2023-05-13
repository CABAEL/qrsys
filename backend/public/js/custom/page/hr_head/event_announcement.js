$('textarea').tinymce({
    height: 100,
    menubar: false,
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
});

//$( document ).ready(function() {
  show_loader();
  $.ajax({
    url: base_url('event'),
    type: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret){
       console.log(ret);
       
       var eventdiv = '';
       $.each(ret,function(event_k,event_v) {
       
       var d1 = new Date(event_v.date);
       var d2 = new Date(event_v.created_at);
       var datestring1 = d1.toLocaleString('en-US', { timeZone: 'Asia/Manila' });
       var datestring2 = d2.toLocaleString('en-US', { timeZone: 'Asia/Manila' });
       
        eventdiv += "<div class='event_div'>";
        eventdiv += "<i class='fa fa-fw fa-close pull-right close DeleteEvent' data-id='"+event_v.id+"'></i>";
        eventdiv += '<h6><b>'+event_v.title+' <span style="color:red;">(Event Date: '+datestring1+')</span></b></h6>';
        eventdiv += '<p style="font-size:12px;">Posted on: '+datestring2+'</p>';
        eventdiv += '<hr>';
        eventdiv += '<div class="post_decriptions">'+event_v.description+'</div>';
        eventdiv += '<br><button><i class="fa fa fa-edit close updateEvent" data-id="'+event_v.id+'"></i></button><br>';
        eventdiv += "</div>";
  
       });
  
       $('#events_cont').html(eventdiv);
       hide_loader();
  
       //$('#events-table').DataTable();
    },
    error: function(e){
  
      alert('Error on events table!');
  
    }
  });
  
  $.ajax({
    url: base_url('announcement'),
    type: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret){
       console.log(ret);
  
  
       var announcementdiv = '';
       $.each(ret,function(announcement_k,announcement_v){
        var d = new Date(announcement_v.created_at);
        var datestring = d.toLocaleString('en-US', { timeZone: 'Asia/Manila' });
  
        announcementdiv += "<div class='announcement_div'>";
        announcementdiv += "<i class='fa fa-fw fa-close pull-right close DeleteAnnouncement' data-id='"+announcement_v.id+"'></i>";
        announcementdiv += '<center><h6><b>'+announcement_v.title+'</b></h6>';
        announcementdiv += '<p style="font-size:12px;">Posted on: '+datestring+'</p></center>';
        announcementdiv += '<hr>';
        announcementdiv += '<div class="post_decriptions">'+announcement_v.description+'</div>';
        announcementdiv += '<br><button><i class="fa fa fa-edit close updateAnnouncement" data-id="'+announcement_v.id+'"></i></button><br>';
        announcementdiv += "</div>";
  
       });
  
       $('#announcement_cont').html(announcementdiv);
       hide_loader();
    },  
    error: function(e){
  
      alert('Error on events table!');
  
    }
  });



$(document).on('click','#cancelEventUpdate',function() {
  var form = $('#event-form');
  $(this).css('visibility','hidden');
  $('#eventBtn').text('Add Event');
  form[0].reset();
  $('#event-form').css('border','none');
  $('#event_id').val('');
 
  
});

$(document).on('click','.updateEvent',function() {
  var id = $(this).data('id');

  $.ajax({
    url: base_url('event/')+id,
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
       console.log(ret);
       $('#event-form').css('border','solid 3px #dce39d');
       var eventname = $('#event_id').val(ret[0].id);
       var eventname = $('#event_name').val(ret[0].title);
       var event_date = $('#event_date').val(ret[0].date);
       var event_description = tinyMCE.get('event_description').setContent(ret[0].description);
      $('#cancelEventUpdate').css('visibility','visible');
      $('#eventBtn').text('Update');
    },
    error: function(e){
        hide_loader();
    }
  });

});

$(document).on('click','.DeleteEvent',function(){
  var id = $(this).data('id');
  var form = $('#event-form');
  if(confirm("Are you sure you want to delete this event?")){
    show_loader();
    $.ajax({
      url: base_url('event/')+id,
      type: 'DELETE',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function(ret) {
         console.log(ret);
          form[0].reset();
          hide_loader();
          location.reload();

      },
      error: function(e){
          hide_loader();
      }
    });
  }else{
   //do nothing
  }
});


$('#eventBtn').on('click',function() {
    show_loader();
      // Get form
    var form = $('#event-form');
    var event_id_value = $('#event_id').val();
    var eventname = $('#event_name').val();
    var event_date = $('#event_date').val();
    var event_description = tinyMCE.get('event_description').getContent();
    var request_type = "POST";

    var event_id = "";
    var append_id = '';
      if(event_id_value != ''){
        request_type = "PUT";
        event_id = event_id_value;
        append_id = '/'+event_id;
      }

      $.ajax({
        url: base_url('event')+append_id,
        type: request_type,
        dataType: 'json',
        data:{event_name:eventname,event_date:event_date,event_description:event_description,event_id},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(ret) {
           console.log(ret);
            alert(ret.message);
            form[0].reset();
            hide_loader();
            location.reload();

        },
        error: function(e){
            
            alert('Input required!');
            var element = $('');
            var form = '#event-form'; 
            promt_errors(form,element,e);
            $.each(e.responseJSON.errors,function(k,v) {
                $(form+' #'+k).css('border','solid 1px red');
              });
            hide_loader();

        }
      });

});



$(document).on('click','#cancelUpdateannouncementBtn',function() {
  var form = $('#annoucement');
  form[0].reset();

  $('#announcement_id').val('');
  $(this).css('visibility','hidden');
  $('#annoucement').css('border','none');
  $('#announcementBtn').text('Add Announcement');
});


$(document).on('click','.DeleteAnnouncement',function(){
  var id = $(this).data('id');
  var form = $('#annoucement');
  if(confirm("Are you sure you want to delete this announcement?")){
    show_loader();
    $.ajax({
      url: base_url('announcement/')+id,
      type: 'DELETE',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function(ret) {
         console.log(ret);
          //form[0].reset();
          hide_loader();
          location.reload();
      },
      error: function(e){
          hide_loader();
      }
    });
  }else{
   //do nothing
  }
});

$(document).on('click','.updateAnnouncement',function() {
  var id = $(this).data('id');

  $.ajax({
    url: base_url('announcement/')+id,
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
       console.log(ret);
       $('#annoucement').css('border','solid 3px #ace');
       var announcement_id = $('#announcement_id').val(ret[0].id);
       var announcement_name = $('#announcement_name').val(ret[0].title);
       var event_description = tinyMCE.get('announcement_description').setContent(ret[0].description);
      $('#cancelUpdateannouncementBtn').css('visibility','visible');
      $('#announcementBtn').text('Update');

    },
    error: function(e){
        hide_loader();
    }
  });

});


$('#announcementBtn').on('click',function() {

    show_loader();
      // Get form
    var form = $('#annoucement');
    var announcement_id_value = $('#announcement_id').val();
    var announcement_name = $('#announcement_name').val();
    var announcement_description = tinyMCE.get('announcement_description').getContent();
    
    var request_type = "POST";

    var announcement_id = "";
    var append_id = '';

      if(announcement_id_value != ''){
        request_type = "PUT";
        announcement_id = announcement_id_value;
        append_id = '/'+announcement_id;
      }


      $.ajax({
        url: base_url('announcement')+append_id,
        type: request_type,
        dataType: 'json',
        data:{announcement_name:announcement_name,announcement_description:announcement_description,announcement_id},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(ret){
           console.log(ret);
            alert(ret.message);
            form[0].reset();
            hide_loader();
            location.reload();
        },
        error: function(e){
            
            alert('Input required!');
            var element = $('');
            var form = '#annoucement'; 
            promt_errors(form,element,e);

            $.each(e.responseJSON.errors,function(k,v) {
                $(form+' #'+k).css('border','solid 1px red');
                
            //alert(form+' #'+k);
              });
            hide_loader();

        }
      });

});


