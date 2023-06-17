var token = $('#csrf').val();


function promt_success(element,e){
  div = '';
  div += '<h6><b>'+e.message+'</b></h6>';


  element.removeClass('alert-danger');
  element.removeClass('alert-warning');

  element.addClass('alert-success');
  element.html(div);
  $('.alert').css('visibility','visible');
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



function clear_modal_promt(modal) {
  $(modal+' .alert').css('visibility','hidden');
}


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


