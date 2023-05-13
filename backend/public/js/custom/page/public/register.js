$('#registerBtn').on('click',function(event) {
    event.preventDefault();
    // Get form
    var form = $('#add_user_form');
    // FormData object 
    var formData = form.serialize();

  show_loader();
   $.ajax({
    url: base_url("add_user"),
    type: 'POST', 
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    data:formData,
    success: function(data) {
      console.log(data);
      alert('User added successfully!');
      //promt_success(element,data)
      hide_loader();
      window.location.replace('/login');
    },
    error: function(e) {
      //alert(e.responseJSON.message +"<br>"+e.responseJSON.errors);
      var element = $('#add_user_errors');
      var form = '#add_user_form'; 
      promt_errors(form,element,e);

      hide_loader();
    }
});

});