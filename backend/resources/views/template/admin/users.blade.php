<!DOCTYPE html>
<html lang="en">
@include('template.admin.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.admin.segments.navbar')
    <div class="content-wrapper">

      <div class="container-fluid">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">My Dashboard</li>
        </ol>

        <!-- Icon Cards -->
        <div class="row">
          <div class="col-xl-12 col-sm-12 mb-12">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">
                  26 New Messages!
                </div>
              </div>
              <a href="#" class="card-footer text-white clearfix small z-1">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        

        <button id="sendEmail" class="btn btn-success btn-lg">SEND EMAIL</button>


      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
  @include('template.admin.segments.footer')
  </body>

</html>
