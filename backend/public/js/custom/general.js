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

    $('#searchResultDiv').removeClass('hidden');
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
    });

  }

  function closeSearch(){
    $('#searchResultDiv').addClass('hidden');
  }


  // Function to clear password input fields on page load
  // function clearPasswordInputs() {
  //   const passwordInputs = document.querySelectorAll('input[type="password"]');
  //   passwordInputs.forEach(input => {
  //       input.value = null;
  //   });
  // }

  // // Call the function when the page loads
  // window.addEventListener('DOMContentLoaded', clearPasswordInputs);

