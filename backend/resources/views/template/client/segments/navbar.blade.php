    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">{{env('APP_NAME')}}</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

        <li class="nav-item">
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch">
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </form>
        </li>

        <li class="nav-item">
          <a class="btn" data-toggle="modal" data-target="#logoutmodal">
            <i class="fa fa-fw fa-sign-out" style="color:#fff;"></i>
          </a>
        </li>

          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-user"></i>
              <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning">6 New</span>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="alertsDropdown">

              <div class="dropdown-divider"></div>

              <a class="dropdown-item btn text-info" data-toggle="modal" data-target="#logoutmodal">
              <i class="fa fa-fw fa-user"></i>
              My Account<br>
              </a>



              <div class="dropdown-divider"></div>
            </div>
          </li> -->

        </ul>
        @include('template.client.segments.leftnav')
      </div>
    </nav>