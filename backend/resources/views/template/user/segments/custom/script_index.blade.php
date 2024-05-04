<script>
    fetchAllFilegroups('#uploadForm',value = null)

    function fetchAllFilegroups(form,value = null){
    const url = base_url('all_filegroups');
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(response => {

      // Handle the response data here
      const selectElement = $(form + ' #filegroups')[0] // Replace with the ID of your <select> element
      let div = '';
      div += '<option value="">-----------------</option>';
      response.data.forEach(filegroup => {
        div += '<option value="'+filegroup.id+'">'+filegroup.group_name+'</option>';
      });

    selectElement.innerHTML = div;

      if(value != null){
        selectElement.value = value;
      }
      })
      .catch(error => {
        // Handle any errors that occur during the request
        //console.error(error);
      });

  }

  // $('#SelectionList #file_group').off();

$(document).on('click','.viewqr',function(){
  let file_id = $(this).data('id');
  let fileViewerUrl = url_host('fileviewer')+'/'+file_id;

  $('#viewfile').modal('show');

  $('.iframe_viewfiles').attr('src', fileViewerUrl);


})
</script>
<script src="{{ asset('js/custom/general.js') }}"></script>
