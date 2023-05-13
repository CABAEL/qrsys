<!DOCTYPE html>
<html lang="en">
@include('template.hr_head.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.hr_head.segments.navbar')
    <style>
      .from,.to{
        padding: 10px;
        border:solid 1px #000;
        margin-top:10px;
        font-size:20px;
        border-radius: 20px;
      }
      .from{
        background-color:#fff;
      }
      .to{
        background-color:#e0fbff;
      }
    </style>
    <div class="content-wrapper">
      <div class="container-fluid">


      <div class="row">
        <div id="message_cont" style="height:350px;width:100%;background-color:#ace;padding:20px;overflow-y:scroll">

        </div>
      </div>
      <div class="row">
       <div class="container">
         <br>
        <input type="text" id="msg" class="form-control"><br><button class="btn btn-lg btn-default pull-right" id="send">Send</button>
       </div>
      </div>
      <br>



      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.hr_head.segments.footer')

  <script>
  setInterval(function () {
  $.ajax({
    url: base_url('chat'),
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret){
       console.log(ret);

       var chats = '';
       var user = "{{Auth::user()->id}}";
       var pull ='';

       $.each(ret,function(k,v){

        var d1 = new Date(v.created_at);
        var datestring1 = d1.toLocaleString('en-US', { timeZone: 'Asia/Manila' });

         if(v.from == user){
          pull = 'from pull-right';
         }else{
          pull = 'to pull-left';
         }


        chats += '<div class="chat_cont '+pull+'">';
        chats += ''+v.msg+'<p style="font-size:9px;">'+v.username+': '+datestring1+'</p>';
        chats += '</div><p class=""><p><br><br><br><br>';

       });

      $('#message_cont').html(chats);
  
    },
    error: function(e){
  
    }
  });
 }, 300);



  $(document).on('click','#send',function(){
    var msg = $('#msg').val();

    if(msg == ''){
      alert("Message required!");
    }else{
    
    show_loader();
    $.ajax({
    url: base_url('chat'),
    type: 'POST',
    dataType: 'json',
    data:{msg:msg},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret){
       console.log(ret);
  
       $('#msg').val('');

       hide_loader();
  
    },
    error: function(e){
  
    }
  });

  }


  });


  </script>

  </body>

</html>
