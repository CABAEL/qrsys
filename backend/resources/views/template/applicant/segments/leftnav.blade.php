<?php
$currentURL = url()->current();
$exploded_url = explode('/',$currentURL);
$user_dir = $exploded_url[4];
?>
<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
            <a class="nav-link" href="/hr_head/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-book"></i>
              <span class="nav-link-text">
                My Application</span>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>