// const fileInput = $("#fileInput");  
const dropZone = $('.dropArea');
const fileInput = $('#fileInput');
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

    var existingFiles = fileInput[0].files;
    var allFiles = new DataTransfer();

    for (var i = 0; i < existingFiles.length; i++) {
      allFiles.items.add(existingFiles[i]);
    }

    for (var j = 0; j < files.length; j++) {
        allFiles.items.add(files[j]);
    }

    fileInput[0].files = allFiles.files;

    handleListFiles(fileInput[0].files);


}

dropZone.on('click', function(event) {
    event.preventDefault();
    fileInput.click();
});


// Change event on the fileInput element
fileInput.on('change', handleFileSelect);

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


    fileInput[0].files = allFiles.files;

    console.log(fileInput[0].files);

}

fileInput.on('change', () => {
    var files = fileInput[0].files;

    handleListFiles(files);

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

function SubmitUpload() {
    event.preventDefault();

    var file = fileInput[0].files;

    var formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: base_url('file_upload'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {

        },
        error: function(e) {
          element = $('#upload_errors');
          form = '#SelectionList'; 
          display_errors(form,element,e);

            console.log('Error:', errorThrown);
        }
    });

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