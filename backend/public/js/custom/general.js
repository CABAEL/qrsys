var url_segment = window.location.pathname.split('/');
var user_level_dir = url_segment[1];

function base_url(append)
{
    var base_url = window.location.origin;
    if(user_level_dir == ''){
        return base_url+"/"+append;
    }
    else{
        return base_url+"/"+user_level_dir+"/"+append;
    }
}

function url_host(append)
{
    var base_url = window.location.origin;

    return base_url+"/"+append;

}

function signOut() {
    //var auth2 = gapi.auth2.getAuthInstance();
    //auth2.disconnect().then(function () {
    var url = base_url("logout");
    location.replace(url);
    //console.log('User signed out.');
    //});
}


function promt_errors(form='',element,err){

  let e = JSON.parse(err.responseText);
  
    div = '';
    div += '<h6><b>'+e.message+'</b></h6>';
    $.each(e.errors,function(k,v) {
    $(form+' #'+k).css('border','solid 1px red');
      div += '<i>* </i>'+v+'<br>';
    });
  
    element.removeClass('alert-success');
    element.removeClass('alert-danger');

    element.addClass('alert-danger');
    $('.alert').css('height','auto');
    $('.alert').css('width','100%');
  
    element.html(div);

    element.css('visibility','visible');
    $(form+' .alert').css('visibility','visible');
}

function display_errors(form='',element,e){
  
    div = '';
    div += '<h6><b>'+e.message+'</b></h6>';
    $.each(e.errors,function(k,v) {
      div += '<i>* </i>'+v+'<br>';
    });
  
    element.removeClass('alert-success');
    element.removeClass('alert-danger');

    element.addClass('alert-danger');
    $('.alert').css('height','auto');
    $('.alert').css('width','100%');
  
    element.html(div);

    element.css('visibility','visible');
    $(form+' .alert').css('visibility','visible');
}


parseError = (response,form,element) => {

    if(response.errors.length > 0){ 

        promt_errors(form,element,response);

    }

}


$(':input').on('keypress change',function(){
    $(this).css('border','1px solid rgba(0, 0, 0, .15)');
    // $('.alert').css('visibility','hidden');
    // $('.alert').css('height','0px');
    // $('.alert').css('width','auto');
});


function random_char(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}


function random_text_generator(element) {

    var value = random_char(10);
    
    return element.val(value);
    
}

function clear(element) {

    return element.val('');
  
}

function promt_warning_delete(form='',element,message,data_id){
    div = '';
    div += '<h6><b>'+message+'</b></h6>';
    div += '<button class="btn btn-sm btn-default delete_no">NO</button>&nbsp;';
    div += '<button class="btn btn-sm btn-warning delete_yes" data-id='+data_id+'>YES</button>';

    element.removeClass('alert-danger');
    element.removeClass('alert-success');

    element.addClass('alert-warning');
    $('.alert').css('height','auto');
    $('.alert').css('width','100%');
  
    element.html(div);
    $(form+' .alert').css('visibility','visible');
  
}

function promt_warning_deactivate(form='',element,message,data_id){

    div = '';
    div += '<h6><b>'+message+'</b></h6>';
    div += '<button class="btn btn-sm btn-default deactivate_no">NO</button>&nbsp;';
    div += '<button class="btn btn-sm btn-warning deactivate_yes" data-id='+data_id+'>YES</button>';

    element.removeClass('alert-danger');
    element.removeClass('alert-success');

    element.addClass('alert-warning');
    $('.alert').css('height','auto');
    $('.alert').css('width','100%');
  
    element.html(div);
    $(form+' .alert').css('visibility','visible');
  
}

function getFormattedDate(date) {
    var date_format = new Date(date);
    var year = date_format.getFullYear();
  
    var month = (1 + date_format.getMonth()).toString();
    month = month.length > 1 ? month : '0' + month;
  
    var day = date_format.getDate().toString();
    day = day.length > 1 ? day : '0' + day;
    
    return month + '/' + day + '/' + year;
  }


  $(document).on("click",".deactivate_no",function(e) {
    event.preventDefault();
    $('.alert').css('height','0px');
    $('.alert').css('overflow','hidden');
    $('.alert').css('visibility','hidden');
  });


  $(document).on("click",".delete_no",function(e) {
    event.preventDefault();
    $('.alert').css('height','0px');
    $('.alert').css('overflow','hidden');
    $('.alert').css('visibility','hidden');
  });



  function formatSizeUnits(bytes) {
    if (bytes >= 1073741824) {
      bytes = (bytes / 1073741824).toFixed(2) + ' GB';
    } else if (bytes >= 1048576) {
      bytes = (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
      bytes = (bytes / 1024).toFixed(2) + ' KB';
    } else if (bytes > 1) {
      bytes = bytes + ' bytes';
    } else if (bytes == 1) {
      bytes = bytes + ' byte';
    } else {
      bytes = '0 bytes';
    }
  
    return bytes;
  }

  function searchsubmit(){

    //$('#searchResultDiv').removeClass('hidden');
    

    
    event.preventDefault();
    console.log("sample");
    var iframe = $('#dynamic-iframe');
    var search = $('#search_value').val();
    var currentSrc = url_host('search_result')+"?"+"search="+search;

    iframe.attr('src',currentSrc)

    // Attach a load event listener to the iframe
    show_loader();
    var iframeContents = iframe.contents(); // Get the iframe's document object
    iframeContents.ready(function() {
      // This will be executed when the iframe's content is fully loaded
      hide_loader();
      $("#searchResultDiv")
      .css({
          left: '-100%', // Start off-screen
          display: 'block' // Display the element
      })
      .animate({
          opacity: 1,
          left: '0%' // Slide in from the left
      }, 'slow');
    });

  }

  function closeSearch(){
      //$('#searchResultDiv').addClass('hidden');
      $("#searchResultDiv")
      .css("left", "0%") // Reset the left position
      .fadeIn("slow") // Fade in
      .animate({
          opacity: 0,
          left: '-100%' // Slide out to the left
      }, "slow", function() {
          $(this).css("display", "none"); // Hide after animation
      });
      $('#search_value').val(null);
  }


  // $(document).on('click','#myaccountbtn',function(){


  // });

  function myAccount(id){
    show_loader();
    $.ajax({
      url: url_host("my_account_view/"+id),
      type: 'GET', 
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function(data){
        console.log(data);
        hide_loader();

        $('#myaccount .alert').css('height','0px');
        $('#myaccount .alert').css('overflow','hidden');
        $('#myaccount .alert').css('visibility','hidden');

        let logo = '/img/bg_logo.png';

        //for client
        if(data.data.data.role == 'client'){
          $('#my_account_form #client_name').val(data.data.data.client_name);
          let img_path = data.data.img_path;
          logo = url_host(img_path+'/'+data.data.data.logo);
        }
        if(data.data.data.role == 'user'){
          $('#my_account_form #fname').val(data.data.data.fname);
          $('#my_account_form #mname').val(data.data.data.mname);
          $('#my_account_form #lname').val(data.data.data.lname);
        }
        

        $('#my_account_form').attr('data-id',data.data.data.id);
        
        $('#my_account_form .logoContainer').css('background-image','url('+logo+')');

        $('#my_account_form #address').val(data.data.data.address);
        $('#my_account_form #email').val(data.data.data.email);
        $('#my_account_form #username').val(data.data.data.username);
        $('#my_account_form #contact_number').val(data.data.data.contact_no);
        $('#my_account_form #description').val(data.data.data.description);
        $('#my_account_form #password').val("");
        $('#my_account_form #password_confirmation').val("");
   
        $('#my_account_form #updatelogo').val("");

        $('#my_account_modal').modal('show');


      },
      error: function(e) {
        hide_loader();
      }
    });
  }

  updateMyAcc2 = async (event) => {
    event.preventDefault();

    const form = document.getElementById('my_account_form');
    const formData = new FormData(form);
    let element = '#update_myacc_errors';

    try {
        var updateUrl = url_host('update_my_acc');

        const response = await fetch(updateUrl, {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            const jsonResponse = await response.json();
            if (jsonResponse.success) {
                // Data updated successfully, display success message
                alert(jsonResponse.message);
            } else {
                // Display error message from server
                alert(jsonResponse.message);
            }
        } else {
          const jsonResponse = await response.json();
            // Handle errors or validation issues
            promt_errors(form,element,jsonResponse);
            console.error('Data update failed');
        }
    } catch (error) {
        console.error('An error occurred:', error);
    }
}

  updateMyAcc = async (event) => {
    event.preventDefault();

    // Get form
     var form = $('#my_account_form')[0];
     var element = $('#update_myacc_errors');
    // FormData object
    var formData = new FormData(form);
    
    show_loader();
   
    $.ajax({
    url: url_host('update_my_acc'),
    type: 'POST', 
    dataType: 'json',
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    data:formData,
    success: function(response) {

      alert(response.message);
      hide_loader();
      window.location.reload();
   
    },
    error: function(e) {
      element = $('#update_myacc_errors');
      form = '#my_account_form'; 
      promt_errors(form,element,e);
      hide_loader();
    }
    });
}


$('#my_account_form .logoContainer').on('click',function(){
  $('#my_account_form #updatelogo').trigger('click');
});

$('#my_account_form #updatelogo').on('change',function(){
    
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("updatelogo").files[0]);
 
  oFReader.onload = function (oFREvent) {
      $('#my_account_form .logoContainer').css("background-image", "url('"+oFREvent.target.result+"')");
  };
 }); 


 function generateRandomString($id,length) {
  const characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  let currentTimestamp = Math.floor(Date.now() / 1000);
  let id_mask = btoa(currentTimestamp+$id);

  let result = '';
  for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      result += characters.charAt(randomIndex);
  }
  return result+id_mask;
}

function generateRandomNumericString($id,length) {
  const characters = '0123456789';
  let currentTimestamp = Math.floor(Date.now() / 1000);
  let id_mask = currentTimestamp+$id;

  let result = '';
  for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      result += characters.charAt(randomIndex);
  }
  return result+id_mask;
}
