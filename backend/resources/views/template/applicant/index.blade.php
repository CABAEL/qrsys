<!DOCTYPE html>
<html lang="en">
@include('template.applicant.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.applicant.segments.navbar')

    <div class="content-wrapper">
      <div class="container-fluid">
<!-- chart -->


<div class="card-header small text-muted">
  <i class="fa fa-alert"></i>
  Application status : <span id="application_status"></span>
</div>
<br>
<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#career_profile">Add Application Description</button>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.applicant.segments.footer')
  <script>

  </script>

  </body>

</html>
