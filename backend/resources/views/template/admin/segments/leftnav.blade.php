<?php
$currentURL = url()->current();
$exploded_url = explode('/',$currentURL);
$user_dir = $exploded_url[4];
?>
<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
            <a class="nav-link" href="/admin/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-home"></i>
              <span class="nav-link-text">
                Home</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-users"></i>
              <span class="nav-link-text">
              User Accounts</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseComponents">
              <li>
                <a class="leftnavtext" id="adduser">Add User</a>
              </li>
              <li>
                <a class="leftnavtext" href="/admin/deactivated_users">Deactivated User</a>
              </li>
            </ul>
          </li>

          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
            <br>
            
            <br>
            <br>
            <br>
            <a class="nav-link" href="/admin/chat_support" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-envelope"></i>
              <span class="nav-link-text">
                Chat</span>
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