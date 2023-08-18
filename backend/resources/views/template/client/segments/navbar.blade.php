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
                  <input class="form-control" id="search_value" type="text" placeholder="Search filename" aria-label="Search filename" aria-describedby="btnNavbarSearch" autocomplete="off">
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

      <div id="searchResultDiv" class="hidden content-wrapper">
        <div id="resultWrapper" class="col-md-12">
          <button id="iframe_btn" onclick="closeSearch()" class="btn btn-default btn-sm">Close</button>
          <iframe id="dynamic-iframe" frameborder="0"></iframe>
        </div>
        
      </div>
    </nav>