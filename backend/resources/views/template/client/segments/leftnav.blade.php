<?php
$currentURL = url()->current();
$exploded_url = explode('/',$currentURL);
$user_dir = $exploded_url[4];
?>
<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

          <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Home">
            <a class="nav-link" href="/admin/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-home"></i>
              <span class="nav-link-text">
              Home</span>
            </a>
          </li>
          <li class="nav-item inactive" data-toggle="tooltip" data-placement="right" title="Home">
            <a class="nav-link" href="/admin/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-user"></i>
              <span class="nav-link-text">
              Acount Management</span>
            </a>
          </li>          
          <li class="nav-item inactive" data-toggle="tooltip" data-placement="right" title="Home">
            <a class="nav-link" href="/admin/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-file"></i>
              <span class="nav-link-text">
              File Groups</span>
            </a>
          </li>          
          <li class="nav-item inactive" data-toggle="tooltip" data-placement="right" title="Home">
            <a class="nav-link" href="/admin/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-history"></i>
              <span class="nav-link-text">
              Logs</span>
            </a>
          </li>          
          <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Client Accounts">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-database"></i>
              <span class="nav-link-text">
              Client Accounts</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseComponents">
              <li>
                <a class="leftnavtext">Add Client</a>
              </li>
              <li>
                <a class="leftnavtext" href="/admin/deactivated_users">Deactivated Client</a>
              </li>
            </ul>
          </li> -->
        </ul>
        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>