    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">{{env('APP_NAME')}}</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#logoutmodal">
              <i class="fa fa-fw fa-sign-out"></i>
              Logout</a>
          </li>

        </ul>
        @include('template.applicant.segments.leftnav')
      </div>
    </nav>