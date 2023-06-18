// const fileInput = $("#fileInput");  
  
const dropZone = $('.dropArea');
const fileInput = $('#fileInput');

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

}

dropZone.on('click', function(event) {
  event.preventDefault();
  fileInput.click();
});


  // Change event on the fileInput element
  fileInput.on('change',handleFileSelect);



  const file_arr = [];
  function handleFileSelect(e) {
    
    var existingFiles = $(this)[0].files;
    var allFiles = new DataTransfer();
    for (var i = 0; i < existingFiles.length; i++) {
      allFiles.items.add(existingFiles[i]);
    }
  
    $(this).prop('files', allFiles.files);


    file_arr.push(allFiles.files)

    var arrayContainer = [];
    Object.values(file_arr).forEach(function(k,v){

      arrayContainer.push(k[0]);

    })

    for (var i = 0; i < arrayContainer.length; i++) {
      // console.log(arrayContainer[i]);
      allFiles.items.add(arrayContainer[i]);
    }

    fileInput[0].files = allFiles.files;

    // console.log(arrayContainer);
    console.log("+++++++++++++++++++++++++++++++++");
    console.log(fileInput[0].files);
  }