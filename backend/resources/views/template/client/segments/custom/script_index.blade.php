<script>
   //upon load functions
   activeUsers();

   function activeUsers () {
     // alert("pasok");
     fetch(base_url('active_client_users'))
       .then(response => response.json())
       .then(data => {
         let client_count = data.responseJSON.data.length;
         $('#activeClients').html(client_count)
       })
       .catch(error => {
         console.error(error);
     });
   }

   
   $.ajax({
    url: base_url('clientfiles'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      var div = '';
    
      var count = 0;
       $.each(ret.responseJSON.data, function( index, value ) {
       let date = getFormattedDate(value.created_at);
   
       div +='<tr>'; 
       div +='<td><pre>'+value.file_name+'</pre></td>';
       div +='<td>'+value.username+'</td>';
       div +='<td>'+value.document_code+'</td>';
       div +='<td>'+date+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewqr" data-id="'+value.id+'"><i class="fa fa-qrcode"></i></button></td>';
       div +='</tr>';
       count ++;
     });
      
   
     $('#FileListBody').html(div);
     $('#uploadcount').html(count);

     $( "#files-table" ).DataTable({
      "order": [[ 3, "desc" ]], //or asc 
      "columnDefs" : [{"targets":3, "type":"date-eu"}],
     });
    
    },
    error: function(e){
    
    }
    });


    fetchAllFilegroups('#uploadForm',value = null)

    function fetchAllFilegroups(form,value = null){
    const url = base_url('all_filegroups');
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {

      // Handle the response data here
      const selectElement = $(form + ' #filegroups')[0] // Replace with the ID of your <select> element
      let div = '';
      div += '<option value="">-----------------</option>';
      data.responseJSON.data.forEach(filegroup => {
        div += '<option value="'+filegroup.id+'">'+filegroup.group_name+'</option>';
      });

    selectElement.innerHTML = div;

      if(value != null){
        selectElement.value = value;
      }
      })
      .catch(error => {
        // Handle any errors that occur during the request
        console.error(error);
      });

  }

  // $('#SelectionList #file_group').off();

$(document).on('click','.viewqr',function(){
  let file_id = $(this).data('id');
  let fileViewerUrl = url_host('fileviewer')+'/'+file_id;

  $('#viewfile').modal('show');

  $('.iframe_viewfiles').attr('src', fileViewerUrl);


})
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
