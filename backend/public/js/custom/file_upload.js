// const fileInput = $("#fileInput");  
const dropZone = $('.dropArea');
const fileInput1 = document.getElementById('fileInput1');
const fileInput2 = document.getElementById('fileInput2');
const array_collection = [];


// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone[0].addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

// Handle dropped files
dropZone[0].addEventListener('drop', handleDrop, false);

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function handleDrop(e) {
    var files = e.dataTransfer.files;
    // Append dropped files to existing input value

    var existingFiles = fileInput2.files;
    var allFiles = new DataTransfer();

    for (var i = 0; i < existingFiles.length; i++) {
      allFiles.items.add(existingFiles[i]);
    }

    for (var j = 0; j < files.length; j++) {
        allFiles.items.add(files[j]);
    }

    fileInput2.files = allFiles.files;

    $(fileInput2).trigger('change');

}

dropZone.on('click', function(event) {
    event.preventDefault();
    fileInput1.click();
});


// Change event on the fileInput element
$(fileInput1).on('change', handleFileSelect);

function handleFileSelect(e) {

    var existingFiles = $(this)[0].files;

    var allFiles = new DataTransfer();

    // allFiles.clearData();
    Object.values(existingFiles).forEach((k, v) => {
        array_collection.push(k);
    })


    Object.values(array_collection).forEach((k, v) => {
        allFiles.items.add(k);
    });


    fileInput1.files = allFiles.files;

    console.log(fileInput1.files);

}

$(document).on('change','.inputFiles', () => {

    let filesArray1 = fileInput1.files;
    let filesArray2 = fileInput2.files;
    var allFiles = new DataTransfer();

    let fileContainer = [];

    for(let i = 0; i < filesArray1.length; i++){
        fileContainer.push(filesArray1[i]);
    }

    for(let j=0; j < filesArray2.length; j++){
        fileContainer.push(filesArray2[j]);
    }


    handleListFiles(fileContainer);

});

function handleListFiles(files) {

    let div = '';

    Object.values(files).forEach((k, v) => {
        div += '<tr>';
        div += '<td class="fileDetails">' + k.name + '</p>';
        div += '<td class="fileDetails">' + formatSizeUnits(k.size) + '</p>';
        div += '<td class="fileDetails">' + k.type + '</p>';
        div += '</tr>';

    });

    $('#previewFile').html(div);

}

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
    
          console.log('Error:', e);
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