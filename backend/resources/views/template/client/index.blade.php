<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <style>
      #dropArea:hover{
      background-color:red;
      cursor:pointer;
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
                                 <h1>3000</h1>
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
                              <h1 id="activeClients">3000</h1>
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
                        <div id="dropArea" class="center">
                        <p style="text-align:center;">Click/Drag and drop files here.</p>
                        </div>


                     <div id="SelectionList" class="hidden">
                        <div class="row">
                           
                           <div class="col-xl-4 col-md-4">
                           <input type="file" id="fileInput" autocomplete="off" multiple/>
                              Filename: <br/>
                              Filesize: <br/>
                              Filetype: <br/>
                           </div>

                           <div class="col-xl-2 col-md-2">
                              <div class="form-group">
                                 <div class="form-row">
                                    <div class="col-md-12">
                                       <label for="contact_number">Document Code:</label>
                                       <input type="text" class="form-control" id="code" name="code" aria-describedby="code" autocomplete="off">
                                    </div>
                                    <div class="col-md-12">
                                       <label for="username">Description</label>
                                       <textarea class="form-control" name="description" autocomplete="off"></textarea>  
                                    </div>
                                 </div>
                              </div>
                           </div>

                        </div>
                     </div><!--section list-->

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
            <table cellspacing="0" class="display table table-bordered" width="100%" id="clients-table" style="width:100%">
               <thead>
                  <tr>
                     <th>UPLOAD NAME</th>
                     
                     <th>TYPE</th>
                     <th>UPLOADED BY</th>
                     <th>DATE CREATED</th>
                     <th>---</th>
                  </tr>
               </thead>
               <tbody id="ClientListBody">
                  <tr>
                     <td colspan="5">
                        <center>Loading...</center>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.client.segments.custom.script_index')
      <script src="{{asset('js/custom/file_upload.js')}}"></script>
   </body>
</html>