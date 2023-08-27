<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <style>
.iframe-container {
    position: relative;
    overflow: hidden;
}
   </style>
   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.admin.segments.navbar')
      <div class="content-wrapper">

         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="">CLIENT REPORTS</a>
                  <button id="downloadButton">Download PDF</button>
               </li>
            </ol>



            <div class="row">
               <div class="col-xl-12">
                  <div class="card mb-12">
                     <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        CLIENT UPLOAD 
                     </div>
                     <div class="iframe-container">
                        <iframe id="iframe_viewfiles" height="100%" width="100%" src="{{ route('client_report') }}" frameborder="0"></iframe>
                     </div>

                  </div>
               </div>
            </div>

         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.admin.segments.custom.script_adminaccounts')
      <script>

         show_loader();   
         function resizeFrame() {
               var frame = document.getElementById("iframe_viewfiles");
               if (frame) {
                  frame.style.height = (frame.contentWindow.document.body.scrollHeight) + "px";
               }
            hide_loader();
         }

      // Call the function whenever the content inside the iframe changes
      document.getElementById("iframe_viewfiles").onload = resizeFrame();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById("downloadButton").addEventListener("click", function() {
         var iframe = $('#iframe_viewfiles')[0];
         var iframeContent = iframe.contentWindow.document.body.innerHTML;

               var opt = {
                  margin:       10,
                  filename:     'content.pdf',
                  image:        { type: 'jpeg', quality: 0.98 },
                  html2canvas:  { scale: 10 },
                  jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
               };

               html2pdf().from(iframeContent).set(opt).save();
      });
  </script>
   </body>
</html>