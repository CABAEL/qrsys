<?php
$currentURL = url()->current();
$exploded_url = explode('/',$currentURL);
$user_dir = $exploded_url[4];


?>
<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

          <li class="nav-item <?php echo ($user_dir == "home")? "active":'';?>" data-toggle="tooltip" data-placement="right" title="Home">
            <a class="nav-link" href="/admin/home" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-home"></i>
              <span class="nav-link-text">
              Home</span>
            </a>
          </li>
          <li class="nav-item <?php echo ($user_dir == "accounts")? "active":'';?>" data-toggle="tooltip" data-placement="right" title="Acount Management">
            <a class="nav-link" href="/client/accounts" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-user"></i>
              <span class="nav-link-text">
              Acount Management</span>
            </a>
          </li>          
          <li class="nav-item <?php echo ($user_dir == "filegroups")? "active":'';?>" data-toggle="tooltip" data-placement="right" title="File Groups">
            <a class="nav-link" href="/client/filegroups" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-file"></i>
              <span class="nav-link-text">
              File Groups</span>
            </a>
          </li>                   
          <li class="nav-item <?php echo ($user_dir == "logs")? "active":'';?>" data-toggle="tooltip" data-placement="right" title="Logs">
            <a class="nav-link" href="/client/logs" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-history"></i>
              <span class="nav-link-text">
              Logs</span>
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