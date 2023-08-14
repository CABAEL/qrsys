<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <style>
      #dropArea{
         background-color:#eee;
         padding-top:5%;
         padding-bottom:5%;
      }
      #dropArea:hover{
         background-color:#ddd;
         cursor:pointer;
      }
      #dynamic-iframe {
    width: 100%;
    display: block;
    margin: 0;
    padding: 0;
    border: none;
    min-height: 700px; /* Set your desired minimum height here */
}
   </style>

   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.client.segments.navbar')
      <div class="content-wrapper">
         <!-- /.container-fluid -->
         <div class="container-fluid">


               <div class="col-xl-6">
                  <div class="row">
                     <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                           <div class="card-body">Total Uploads</div>
                           <div class="card-footer d-flex align-items-center justify-content-between">
                                 <h1 id="uploadcount">0</h1>
                              <div class="small text-white">
                                 <svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                                 </svg>
                                 <!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com -->
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-md-6">
                        <div class="card bg-black text-black mb-4">
                           <div class="card-body">Active Users</div>
                           <div class="card-footer d-flex align-items-center justify-content-between">
                              <h1 id="activeClients">0</h1>
                              <div class="small text-white">
                                 <svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                                 </svg>
                                 <!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>


               <div class="row">
               <div class="col-xl-12">
                  <div class="card mb-4">
                     <div class="card-body">
                        <!-- <div class="center" id="dropArea">
                           <h4 style="text-align:center;">Click/Drag and drop file here.</h4>
                        </div>
                        <br/>
                        <br/> -->
                        <div id="uploaded_list" class="">
                           <div class="alert alert-danger" id="upload_errors">
                     
                           </div>
                           
                        </div><!--uploadSection list-->   
                        
                        <form onsubmit="SubmitUpload(this)" id="uploadForm">
                           <div class="container-fluid">

                              <div class="row">
                              <table class="table table-responsive" width="100%" style="overflow-y:scroll">
                                 <tbody id="previewFile"></tbody>
                                 </table> 
                              </div>
                              <div class="row">
                              
                                 
                                 <div class="col-xl-4 col-md-4">
                                 
                                 <!-- <input type="file" id="fileInput1" class="hidden" name="files1[]" accept=".pdf" autocomplete="off" multiple/>
                                 <input type="file" id="fileInput2" class="hidden" name="files2[]" accept=".pdf" autocomplete="off" multiple/> -->
                                 </div>

                                 <div class="col-xl-4 col-md-4">

                                    <div class="form-group">
                                       <div class="col-md-12">
                                       <div class="progress">
                                       <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                       </div>
                                       <br/>
                                          <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" autocomplete="off"/>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="form-row">
                                          <div class="col-md-6">
                                             <label for="code">Code:</label>
                                             <input type="text" class="form-control" id="code" name="code" aria-describedby="code" autocomplete="off">
                                          </div>
                                          <div class="col-md-6">
                                             <label for="filegroups">File Groups:</label>
                                             <select class="form-control" id="filegroups" name="filegroups" aria-describedby="filegroups" autocomplete="off"></select>
                                          </div>
                                          <div class="col-md-12">
                                             <label for="username">Description</label>
                                             <textarea class="form-control" name="description" autocomplete="off"></textarea>  
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="form-row">
                                          <div class="col-md-12">
                                             <label for="filegroups">File(s) Password:</label>
                                             <input type="password" id="password" name="password" class="form-control" placeholder="Optional" autocomplete="off"/>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="form-row">
                                          <div class="col-md-12">
                                          <!-- <button class="btn btn-default" style="float:right;">Cancel</button> -->
                                          <span style="float:right;" >&nbsp;</span>
                                          <button id="uploadBtn" class="btn btn-primary" style="float:right;"><i class="fas fa fa-upload"></i> Upload</button>
                                          <a href="" id="refreshBtn" class="btn btn-default hidden" style="float:right;"><i class="fa fa-refresh"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>


                                 <div class="col-xl-4 col-md-4"></div>

                              </div>
                           </div>
                        </form>

                     </div>
                  </div>
               </div>

            </div>
         </div>

         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <b>UPLOAD LIST</b>
               </li>
            </ol>
            <hr/>
            <iframe id="dynamic-iframe" src="{{ url('file_list') }}" frameborder="0"></iframe>
         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.client.segments.custom.script_index')
      
      <script>
function adjustIframeHeight() {
    const iframe = document.getElementById('dynamic-iframe');
    if (iframe) {
        const newHeight = Math.max(iframe.contentWindow.document.body.scrollHeight, 500);
        iframe.style.height = newHeight + 'px';
    }
}

// Send a message to the iframe to request its content height
function requestIframeHeight() {
    const iframe = document.getElementById('dynamic-iframe');
    if (iframe) {
        iframe.contentWindow.postMessage('requestHeight', '*');
    }
}

// Listen for messages from the iframe
window.addEventListener('message', function(event) {
    if (event.data === 'sendHeight') {
        adjustIframeHeight();
    }
});
      </script>      
      <script>
         const FILE_ALLOWED_COUNT = "{{ env('ALLOWED_FILE_COUNT') }}";
      </script>
      <script src="{{asset('js/custom/file_upload.js')}}"></script>
   </body>
</html>