@include('template.admin.segments.modal.add_api_access_modal')
<script src="{{ asset('packages/chart.js/Chart.min.js') }}"></script>
<script>
  $.ajax({
    url: base_url('admin_list'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      var div = '';
    
   
       $.each(ret.data, function( index, value ) {

       let date = getFormattedDate(value.created_at);
       let status = "";
       let color = "red";
       let name = value.fname+" "+value.mname+" "+value.lname;

       if(value.status == 1){
        status = "Active";
        color = "green";
       }else{
        status = "Inactive";
        color = "red";
       }
   
       div +='<tr>'; 
       div +='<td>'+name+'</td>';
       div +='<td><em style="color:'+color+'">'+status+'</em></td>';
       div +='<td>'+date+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewadmin" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
       div +='</tr>';
       
     });
      
   
     $('#ClientListBody').html(div);
     $( "#clients-table" ).DataTable({
      "order": [[ 3, "desc" ]], //or asc 
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


</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
