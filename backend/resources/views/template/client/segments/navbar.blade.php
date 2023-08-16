    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">{{env('APP_NAME')}}</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

        <li class="nav-item">
        <form onsubmit="searchsubmit()">
              <div class="input-group">
                  <input class="form-control" type="text" placeholder="Search filename" aria-label="Search filename" aria-describedby="btnNavbarSearch">
                  <!-- <input type="submit" class="btn btn-primary" id="btnNavbarSearch" /> -->
                  <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
              </div>
          </form>
        </li>

        <li class="nav-item">
        &nbsp;
        </li>
        <li class="nav-item">
        &nbsp;
        </li>
        <li class="nav-item">
        &nbsp;
        </li>
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" type="button" id="myaccountbtn"><i class="fa fa-user"></i> &nbsp;My account</button>&nbsp;
        </li>
        <li class="nav-item">
          <a class="btn" data-toggle="modal" data-target="#logoutmodal">
            <i class="fa fa-fw fa-sign-out" style="color:#fff;"></i>
          </a>
        </li>
        </ul>
        @include('template.client.segments.leftnav')
      </div>
      <div id="searchResultDiv" class="content-wrapper">

        <div id="resultWrapper" class="col-md-12">
          <iframe id="dynamic-iframe" src="{{url_host('search_result')}}" frameborder="0"></iframe>
        </div>
        
      
      </div>
    </nav>