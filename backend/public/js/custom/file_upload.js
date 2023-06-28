// const fileInput = $("#fileInput");  
const dropZone = document.getElementById('dropArea');
const fileInput1 = document.getElementById('fileInput1');
const fileInput2 = document.getElementById('fileInput2');



// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  dropZone.addEventListener(eventName, preventDefaults, false);
  document.body.addEventListener(eventName, preventDefaults, false);
});

// Handle dropped files
dropZone.addEventListener('drop', handleDrop, false);
dropZone.addEventListener('change', handleDrop, false);

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

function handleDrop(e) {
  let files = e.dataTransfer.files;
  // Append dropped files to existing input value

  let existingFiles = fileInput2.files;
  let allFiles = new DataTransfer();

  for (const existingFile of existingFiles) {
    allFiles.items.add(existingFile);
  }

  for (const file of files) {
      allFiles.items.add(file);
  }

  fileInput2.files = allFiles.files;

  handleListFiles();

}


$(dropZone).on('click', function(event) {
    event.preventDefault();
    fileInput1.click();
});


let arr_holder = [];
// Change event on the fileInput element
$(fileInput1).on('change', (e) => {
  event.preventDefault();

  let existingFiles = fileInput1.files;
  let input1allFiles = new DataTransfer();
  
  for(let input1_count = 0; input1_count < existingFiles.length; input1_count++){
    arr_holder.push(existingFiles[input1_count])
  }

  for(let arr_holder_count = 0; arr_holder_count < arr_holder.length; arr_holder_count++){
    input1allFiles.items.add(arr_holder[arr_holder_count]);
  }

  fileInput1.files = input1allFiles.files;

  handleListFiles();

});

function SubmitUpload(e) {
    event.preventDefault();

    var formData = new FormData($(e)[0]);
    formData.append('file_upload', true);
    
    var files1 = $('input[name="files1[]"]')[0].files;
    var files2 = $('input[name="files2[]"]')[0].files;
    var errors = [];
    
    var imageAllowedSize = parseInt("{{ env('IMAGE_ALLOWED_SIZE') }}");
    var documentAllowedSize = parseInt("{{ env('DOCUMENT_ALLOWED_SIZE') }}");
    
    // File validation for files1[]
    for (var i = 0; i < files1.length; i++) {
      var file = files1[i];
      var allowedSize = file.type.startsWith('image/') ? imageAllowedSize : documentAllowedSize;
      if (file.size > allowedSize * 1024 * 1024) {
        errors.push('File size exceeds the maximum limit of ' + allowedSize + 'MB for files1[].');
      }
    
      // Image formats
      if (file.type.startsWith('image/')) {
        var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
          errors.push('Invalid file extension for files1[]. Only ' + allowedExtensions.join(', ').toUpperCase() + ' image files are allowed.');
        }
      }
    
      // Document formats
      if (file.type.startsWith('application/')) {
        var allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pub', 'xlsb', 'xlsm', 'pptm', 'docm'];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
          errors.push('Invalid file extension for files1[]. Only ' + allowedExtensions.join(', ').toUpperCase() + ' document files are allowed.');
        }
      }
    }
    
    // File validation for files2[]
    for (var j = 0; j < files2.length; j++) {
      var file = files2[j];
      var allowedSize = file.type.startsWith('image/') ? imageAllowedSize : documentAllowedSize;
      if (file.size > allowedSize * 1024 * 1024) {
        errors.push('File size exceeds the maximum limit of ' + allowedSize + 'MB for files2[].');
      }
    
      // Image formats
      if (file.type.startsWith('image/')) {
        var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
          errors.push('Invalid file extension for files2[]. Only ' + allowedExtensions.join(', ').toUpperCase() + ' image files are allowed.');
        }
      }
    
      // Document formats
      if (file.type.startsWith('application/')) {
        var allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pub', 'xlsb', 'xlsm', 'pptm', 'docm'];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
          errors.push('Invalid file extension for files2[]. Only ' + allowedExtensions.join(', ').toUpperCase() + ' document files are allowed.');
        }
      }
    }
    
    if (errors.length > 0) {
      // Display validation errors
      var errorMessages = errors.join('\n');
      alert(errorMessages);
    } else {
      // Proceed with AJAX request
      show_loader();
      $.ajax({
        url: base_url('file_upload'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        enctype: "multipart/form-data",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('Files Uploaded!');
            hide_loader();
            window.location.replace('/login');
          // Handle success response
        },
        error: function(e) {
          element = $('#upload_errors');
          form = '#SelectionList';
          display_errors(form, element, e);
          hide_loader();
        }
      });
    }
    


}

function acceptedFormat(file) {
    const isImage = [
        '.jpg',
        '.jpeg',
        '.png'
    ];

    const isDocument = [
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'ppt',
        'pptx',
        'pub',
        'xlsb',
        'xlsm',
        'pptm',
        'docm'
    ];

    if (isImage.includes(file)) {
        return "image";
    } else if (isDocument.includes(file)) {
        return "document";
    } else {
        return false;
    }
}



function removeFileAndUpdateInput(fileName) {
  event.preventDefault();
  let filesArray1 = Array.from(fileInput1.files);
  let filesArray2 = Array.from(fileInput2.files);
  // let filesContainer = [];

  // Remove file from filesArray1 if found
  const updatedFilesArray1 = filesArray1.filter(file => file.name !== fileName);
  //override array holder for input1
  arr_holder = [];
  if (updatedFilesArray1.length !== filesArray1.length) {
      filesContainer = [...updatedFilesArray1, ...filesArray2];
      fileInput1.files = createFileList(updatedFilesArray1);
  } else {
      // Remove file from filesArray2 if found
      const updatedFilesArray2 = filesArray2.filter(file => file.name !== fileName);
      if (updatedFilesArray2.length !== filesArray2.length) {
          filesContainer = [...filesArray1, ...updatedFilesArray2];
          fileInput2.files = createFileList(updatedFilesArray2);
      }
  }

  handleListFiles(filesContainer);
  
}



function createFileList(fileArray) {
  const fileList = new ClipboardEvent('').clipboardData || new DataTransfer();
  fileArray.forEach(file => fileList.items.add(file));
  return fileList.files;
}

function handleListFiles() {
  let filesArray1 = Array.from(fileInput1.files);
  let filesArray2 = Array.from(fileInput2.files);
  let files = filesArray1.concat(filesArray2);

  showOrHideForm(files.length);
  
  let div = '';

  files.forEach((file, index) => {
    div += '<tr>';
    div += '<td class="fileDetails">' + file.name + '</p>';
    div += '<td class="fileDetails">' + formatSizeUnits(file.size) + '</p>';
    div += '<td class="fileDetails">' + file.type + '</p>';
    div += '<td class="fileDetails"><button class="btn btn-danger btn-sm" onclick="removeFileAndUpdateInput(\'' + file.name + '\')">Remove</button></p>';
    div += '</tr>';
  });

  $('#previewFile').html(div);
}


function showOrHideForm(file_count){
  if(file_count > 0){
    $('#SelectionList').removeClass('hidden');
  }
  else{
    $('#SelectionList').addClass('hidden');
    $('#SelectionList .alert').css('visibility','hidden');
  }
}

