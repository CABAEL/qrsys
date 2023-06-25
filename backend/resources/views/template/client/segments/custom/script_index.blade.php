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
    url: base_url('user_list'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      var div = '';
    
   
       $.each(ret.data, function( index, value ) {
       // console.log( index + ": " + value.username );

       let date = getFormattedDate(value.created_at);
       let status = "";
       let color = "red";

       if(value.status == 1){
        status = "Active";
        color = "green";
       }else{
        status = "Inactive";
        color = "red";
       }
   
       div +='<tr>'; 
       div +='<td>'+value.client_name+'</td>';
       div +='<td>200</td>';
       div +='<td><em style="color:'+color+'">'+status+'</em></td>';
       div +='<td>'+date+'</td>';
       div +='<td><button type="button" class="btn btn-sm btn-default viewclient" data-id="'+value.id+'"><i class="fa fa-user-circle"></i></button></td>';
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

    
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
