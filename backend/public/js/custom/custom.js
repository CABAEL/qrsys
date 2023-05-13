var token = $('#csrf').val();

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

    var smpl = form+' .alert';
    element.css('visibility','visible');
    $(form+' .alert').css('visibility','visible');
    //console.log(smpl)
    
  
}

function promt_warning(form='',element,message,data_id){

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

function promt_success(element,e){
  div = '';
  div += '<h6><b>'+e.message+'</b></h6>';


  element.removeClass('alert-danger');
  element.removeClass('alert-warning');

  element.addClass('alert-success');
  element.html(div);
  $('.alert').css('visibility','visible');
}


function signOut() {
    //var auth2 = gapi.auth2.getAuthInstance();
    //auth2.disconnect().then(function () {
    var url = base_url("logout");
    location.replace(url);
    //console.log('User signed out.');
  //});
}

function viewpass() {
  var x = document.getElementById("password");

  if (x.type === "password") {
    x.type = "text";
    $('#viewpass').css('color','#ace');
  } else {
    x.type = "password";
    $('#viewpass').css('color','#000');
  }

} 

function view_retype_pass(){
  var x = document.getElementById("password_confirmation");

  if (x.type === "password") {
    x.type = "text";
    $('#view_retype_pass').css('color','#ace');
  } else {
    x.type = "password";
    $('#view_retype_pass').css('color','#000');
  }

}

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

function clear_modal_promt(modal) {
  $(modal+' .alert').css('visibility','hidden');
}

function clear(element) {

  return element.val('');

}

function copy_text(element) {

var copyText = $(element);

/* Select the text field */
copyText.select();
 /* Copy the text inside the text field */
navigator.clipboard.writeText(copyText.val());

}

$(document).on("click","#clear",function() {
  var pass = $('#viewusermodal #update_password');
  clear(pass);
});

$(document).on("click","#generate_pass",function() {
  element = $('#viewusermodal #update_password');
  random_text_generator(element);
});


$('#adduser').on('click',function(){
  $('#addusermodal').modal('show');
});


$(document).on("click",".deactivate",function(e) {
  e.preventDefault();
//$('#deactivate').on('click',function(){
  var data_id = $(this).data('id');

  var form = '#viewusermodal';
  var element = $('.alert');
  var message = "Are you sure that you want to deactivate this user?";

  promt_warning(form,element,message,data_id);
  //$('#confirmation').modal('toggle');
  console.log(data_id);

});


$(document).on("click",".delete",function(e) {
  var data_id = $(this).data('id');
  var form = '#viewusermodal';
  var element = $('.alert');
  var message = "Are you sure that you want to delete this user?";

  promt_warning_delete(form,element,message,data_id);
  //$('#confirmation').modal('toggle');
  console.log(data_id);

});

$(document).on("click",".deactivate_no",function(e) {
  $('.alert').css('visibility','hidden');
  $('.alert').css('height','0px');
  $('.alert').css('width','0px');
});

$('#viewusermodal').on('hidden.bs.modal', function (){
  $('.alert').css('visibility','hidden');
  $('.alert').css('height','0px');
  $('.alert').css('width','0px');
  $('.form-control').css('border','');
  $('#update_user_form')[0].reset();

  $('.deactivate').removeData('id');
  $('.delete').removeData('id');

  $('.deactivate_yes').removeData('id');
  $('.delete_yes').removeData('id');
})


