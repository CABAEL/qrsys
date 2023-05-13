$( document ).ready(function() {
    $('#sendEmail').on('click',function(){

        $.ajax({
            url: "http://localhost:8000/sendEmail",
            type: 'POST',
            dataType: 'json',
            headers : {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{
                emailto:'vallesmark15@gmail.com',
            },
          success: function (data){

            console.log(data);
  
          },
  
          error: function (e) {
            console.log(e);
          }
          });

    });

});