const fileInput = $("#fileInput");  
  
  // Prevent the default browser behavior for drag-and-drop
  $(document).on('dragenter', function(e) {
    e.stopPropagation();
    e.preventDefault();
  });
  
  $(document).on('dragover', function(e) {
    e.stopPropagation();
    e.preventDefault();
  });
  
  $(document).on('drop', function(e) {
    e.stopPropagation();
    e.preventDefault();
  });
  
  // Handle the drop event
  $('#dropArea').on('drop', function(e) {
    e.preventDefault();
    
    // Get the files from the dropped event
    var files = e.originalEvent.dataTransfer.files;
    
    // Process the files
    handleFiles(files);
  });
  
  // Function to handle the uploaded files
  function handleFiles(files) {
    // You can perform further processing with the files here
    // For example, you can upload them to a server using AJAX
    // or display file information to the user
    
    // Here, we simply display the file names

    fileInput.prop("files", files);

    $('#SelectionList').removeClass('hidden');
    $('#dropArea').addClass('hidden');
    var fileNames = [];
    for (var i = 0; i < files.length; i++) {
      fileNames.push(files[i].name);
    }
    
    // Display the file names
    alert('Uploaded files: ' + fileNames.join(', '));
  }


