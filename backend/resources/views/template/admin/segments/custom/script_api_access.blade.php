@include('template.admin.segments.modal.add_api_access_modal')
@include('template.admin.segments.modal.edit_api_access_modal')
<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
<script>
  $.ajax({
    url: base_url('api_key_list'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      var div = '';
    
   
       $.each(ret, function( index, value ) {
        console.log(value);
       div +='<tr>'; 
       div +='<td>'+value.client_name+'</td>';
       div +='<td>'+value.appkey+'</td>';
       div +='<td>'+value.appsecret+'</td>';
       div +='<td>'+value.description+'</td>';
       div +='<td>'+getFormattedDate(value.created_at)+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default editApikeys" data-id="'+value.id+'"><i class="fa fa-gear"></i></button></td>';
       div +='</tr>';
       
     });
      
   
     $('#apiListBody').html(div);
     
     $( "#apikeys-table" ).DataTable({
      "order": [[ 4, "desc" ]], //or asc 
      "columnDefs" : [{"targets":3, "type":"date-eu"}],
     });
    
    },
    error: function(e){
    
    }
  });

  $(document).on('click','#addApi_btn',function(){
    $('#addApi').modal('show');
  });


  $('.select_client').select2({
      dropdownParent: $("#addApi"),
      ajax: {
            url: '{{ base_url("search_clients") }}', // Assuming you've defined a named route for the URL
            dataType: 'json',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processResults: function(data) {
              return {
                  results: data.map(function(item) {
                    return {
                        id: item.client_id,
                        text: item.client_name
                    };
                })
              };
            }
      }
  });

    // Listen for changes in the Select2 input
    $('.select_client').on('change', function() {

      var selectedValue = $(this).val(); // This will be the selected ID
      console.log('Selected ID:', selectedValue);
      let id = "{{Auth::user()->id}}";
      const appSecret = generateRandomString(id,32); // 32 characters
      const appKey = generateRandomNumericString(id,16);    // 16 characters

      $('#appsecret').val(appSecret);
      $('#appkey').val(appKey);

    });


    $(document).on('click','.editApikeys', function() {

      let id = $(this).data('id');

      show_loader();
      $.ajax({
        url: base_url('show_app_key')+'/'+id,
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(res) {
          console.log(res);


          $('#edit_client').val(res.client_name);
          $('#edit_appkey').val(res.appkey);
          $('#edit_appsecret').val(res.appsecret);
          $('#edit_description').val(res.description);

          $('#genereteNewAppkey').data('id',res.id);
          $('#genereteNewAppSecret').data('id',res.id);
          $('#updateSubmit').data('id',res.id);
          $('.delete').data('id',res.id);

          
          hide_loader();
          $('#EditApi').modal('show');
        
        },
        error: function(e){
        
        }
      });



    });

  $(document).on("click","#EditApi .delete",function(e) {
    event.preventDefault();
    var data_id = $(this).data('id');
    var form = '#EditApi';
    var element = $('#EditApi #Edit_key_errors');
    var message = "Are you sure that you want to delete this access?";
    
    promt_warning_delete(form,element,message,data_id);
    //$('#confirmation').modal('toggle');
    //  console.log(data_id);
   
  });


  $(document).on("click","#EditApi .delete_yes",function(e){
  event.preventDefault();
  var id = $(this).data('id');
  show_loader();
  $.ajax({
      url: base_url("confirm_delete_api_access/"+id),
      type: 'DELETE', 
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function(data) {
        console.log(data);
        alert(data.message);
        //promt_success(element,data)
        hide_loader();
        window.location.replace('/admin/api_access');
      },
      error: function(e){
        console.log(e);
        //alert(emessage +"<br>"+eerrors);
        // var element = $('#add_user_errors');
        // var form = '#addusermodal'; 
        // promt_errors(form,element,e);
        // hide_loader();
      }
  });
});





$('#add_key_form').submit(function(event) 
{
  event.preventDefault(); // Prevent actual form submission
  let form = this.id;

  var formData = new FormData(this);

  show_loader();
  $.ajax({
    url: base_url("add_access_key"),
    type: 'POST',
    data:formData, 
    dataType: 'json',
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(response) {
      alert(response.message);
       hide_loader();
       window.location.replace('/admin/api_access');
      hide_loader();
    },
    error: function(e) {
      element = $('#add_key_errors');
      form = '#'+form; 
      promt_errors(form,element,e);
      hide_loader();
    }
  });
  
});

$(document).on('click','#genereteNewAppkey',function(){
  event.preventDefault();
  let id = $(this).data('id');
  const appKey = generateRandomNumericString(id,16);    // 16 characters

  $('#edit_appkey').val(appKey);
});

$(document).on('click','#genereteNewAppSecret',function(){
  event.preventDefault();
  let id = $(this).data('id');
  const appSecret = generateRandomString(id,32); // 32 characters
  $('#edit_appsecret').val(appSecret);
});

$(document).on('click','#updateSubmit',function(){
  
  event.preventDefault();
  let id = $(this).data('id');

  let form = $('#Edit_key_form')[0];
  var formData = new FormData(form);
  
  show_loader();
  $.ajax({
    url: base_url("update_access_key")+'/'+id,
    type: 'POST',
    data:formData, 
    dataType: 'json',
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(response) {
      alert(response.message);
       hide_loader();
       window.location.replace('/admin/api_access');
      hide_loader();
    },
    error: function(e) {
      element = $('#add_key_errors');
      form = '#'+form; 
      promt_errors(form,element,e);
      hide_loader();
    }
  });

});


</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
