$.ajax({
    url: base_url('get_dtr'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
     
      var div = '';

      $.each(ret.data, function( index, value ) {
        date = new Date(value.created_at);
        year = date.getFullYear();
        month = date.getMonth()+1;
        dt = date.getDate();
        display_date = year+"-"+month+"-"+dt;

        var t_out = value.time_out;
        if(t_out == null){
          t_out = "Not set";
        }

        div +='<tr>'; 
        div +='<td>'+display_date+'</td>';
        div +='<td>'+value.time_in+'</td>';
        div +='<td>'+t_out+'</td>';
        div +='</tr>';
        $('#DTRListBody').html(div);
      });
      
      $( "#dtr-table").DataTable();

    },
    error: function(e){

    }
});
function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var seconds = date.getSeconds();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ':'+ seconds +" "+ ampm;
  return strTime;
}

setInterval(function(){ 
  var time = formatAMPM(new Date);
  $('#time').html(time);
  $('#time').attr('value',time);
}, 100);

$(document).on('click','#punch_time',function (){
  var punched_time = $('#time').attr('value');
  //alert(punched_time);
    $.ajax({
    url: base_url('employee_dtr'),
    type: 'post',
    dataType: 'json',
    data:{time:punched_time},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret) {
      console.log(ret);
      window.location.reload();
    },
    error: function(e){
      alert('DTR for today already exist!');
    }
  });

});

