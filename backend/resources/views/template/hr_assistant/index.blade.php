<!DOCTYPE html>
<html lang="en">
@include('template.hr_assistant.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.hr_assistant.segments.navbar')

    <div class="content-wrapper">
      <div class="container-fluid">

<!-- chart -->

<div class="card-header small text-muted">
  <i class="fa fa-bar-chart"></i>
  Applicants
</div>
<div class="card-body">
  <div class="row">
  
    <div class="col-sm-12 text-center my-auto">
      <div class="h4 mb-0 text-primary"></div>

    </div>

    <div class="col-sm-2 my-auto"></div>
    <div class="col-sm-8 my-auto">
    <iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1"></iframe>
    <div class="small text-muted">
      <input type="number" min="1900" max="2099" id="applicant_year" step="1"/>
      <button class="btn btn-sm btn-primary" id="ApplicantChart">Submit</button>
      </div>  
      <br>
    <canvas id="applicants" style="display: block; height: 196px; width: 392px;" width="980" height="490"></canvas>
    </div>
    <div class="col-sm-2 my-auto"></div>
  </div>
</div>
<div class="card-header small text-muted">
<i class="fa fa-bar-chart"></i>
  Active employees
</div>


<div class="card-body">
  <div class="row">
  
    <div class="col-sm-12 text-center my-auto">
      <div class="h4 mb-0 text-primary"></div>
    </div>


    <div class="col-sm-2 my-auto"></div>
    <div class="col-sm-8 my-auto">
    <iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1"></iframe>
    <div class="small text-muted">
      <input type="number" min="1900" max="2099" step="1" id="activeEmployeeYr" />
      <button class="btn btn-sm btn-primary" id="activeEmployeeBtn">Submit</button>
        <br>
        <br>
      </div>  
    <canvas id="active_employees" style="display: block; height: 196px; width: 392px;" width="980" height="490"></canvas>
    </div>
    <div class="col-sm-2 my-auto"></div>

  </div>
</div>


            


      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.hr_assistant.segments.footer')
  <script src="{{ asset('js/custom/chart.js') }}"></script>
  </body>

</html>
