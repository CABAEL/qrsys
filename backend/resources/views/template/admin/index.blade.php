<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.admin.segments.navbar')
      <div class="content-wrapper">
         <div class="container-fluid">
            <div class="row">

            </div>
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <b>DEMOGRAPHICS</b>
               </li>
            </ol>
            <hr/>
         </div>
         <!-- /.container-fluid -->
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-6">
                  <div class="card mb-4">
                     <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        System usage graph
                     </div>
                     <div class="card-body">
                        <div class="chartjs-size-monitor">
                           <div class="chartjs-size-monitor-expand">
                              <div class=""></div>
                           </div>
                           <div class="chartjs-size-monitor-shrink">
                              <div class=""></div>
                           </div>
                        </div>
                        <canvas id="myBarChart" width="450" height="180" class="chartjs-render-monitor" style="display: block; width: 450px; height: 180px;"></canvas>
                     </div>
                  </div>
               </div>

               <div class="col-xl-6">
                  <div class="row">
                     <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                           <div class="card-body">Total Upload</div>
                           <div class="card-footer d-flex align-items-center justify-content-between">
                                 <h1 id ="totaluploads">0</h1>
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
                           <div class="card-body">Active Clients</div>
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

            </div>
         </div>

         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <b>CLIENT LIST</b>
               </li>
            </ol>
            <hr/>
            <button class="btn btn-sm" type="button" id="addclient_btn" data-toggle="modal" data-target="#addclient"> + Client</button>
            <hr/>
            <table cellspacing="0" class="display table table-bordered table-responsive" width="100%" id="clients-table" style="width:100%;">
               <thead>
                  <tr>
                     <th>CLIENT NAME</th>
                     <th>DOCUMENT COUNT</th>
                     <th>STATUS</th>
                     <th>DATE CREATED</th>
                     <th>---</th>
                  </tr>
               </thead>
               <tbody id="ClientListBody">
                  <tr>
                     <td colspan="4">
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
      @include('template.admin.segments.custom.script_index')
   </body>
</html>