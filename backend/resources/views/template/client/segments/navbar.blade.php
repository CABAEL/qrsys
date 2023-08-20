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
          <button class="btn btn-primary btn-sm" type="button" id="myaccountbtn" onclick="myAccount('{{\Auth::user()->id}}')" ><i class="fa fa-user"></i> &nbsp;My account</button>&nbsp;
        </li>
        <li class="nav-item">
          <a class="btn" data-toggle="modal" data-target="#logoutmodal">
            <i class="fa fa-fw fa-sign-out" style="color:#fff;"></i>
          </a>
        </li>
        </ul>
        @include('template.client.segments.leftnav')
      </div>

      <style>
          #searchResultDiv {
          position:absolute;
          visibility:visible;
          display:none;
          top: 100%;
          left: -1%;
          width:100%;
          height: 100vh !important;
          background-color: #fff;
          z-index: -100; 
        }

        #dynamic-iframe{
          width:100%;
          height: 100vh !important;
        }

        #iframe_btn{
          position: relative;
          right: 1px;
          margin-right: 3%;
        }
      </style>
      <div id="searchResultDiv" class="content-wrapper">
        <div id="resultWrapper" class="col-md-12">
          <button id="iframe_btn" onclick="closeSearch()" class="btn btn-default btn-lg"><i class="fa fa-arrow-left"></i></button>
          <iframe id="dynamic-iframe" frameborder="0"></iframe>
        </div>
      </div>
    </nav>
    
    @include('template.my_account_modal')