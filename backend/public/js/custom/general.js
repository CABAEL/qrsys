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

function signOut() {
    //var auth2 = gapi.auth2.getAuthInstance();
    //auth2.disconnect().then(function () {
    var url = base_url("logout");
    location.replace(url);
    //console.log('User signed out.');
    //});
}


function promt_errors(form='',element,e){
  
    div = '';
    div += '<h6><b>'+e.responseJSON.message+'</b></h6>';
    $.each(e.responseJSON.errors,function(k,v) {
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
    //console.log(smpl)
}



