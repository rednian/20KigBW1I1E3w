<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="img img-responsive center-block" src="<?php echo base_url('assets/img/web/sms-logo-sm.fw.png') ?>">
      </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li id="menu_gen_info" class="page_menu active">
          <a href="<?php echo base_url('gen_info') ?>">
            <center><i class="fa fa-edit fa-2x"></i></center>
            <small>Gen. Information</small>
          </a>
        </li>
        <li id="menu_curriculum" class="page_menu">
          <a href="<?php echo base_url('curriculum') ?>">
            <center><i class="fa fa-search fa-2x"></i></center>
            <small>Curriculum</small>
          </a>
        </li>
        <li id="menu_course_sched" class="page_menu">
          <a href="<?php echo base_url('course') ?>">
            <center><i class="fa fa-book fa-2x"></i></center>
            <small>Course Schedule</small>
          </a>
        </li>
        <li id="menu_course_load" class="page_menu">
          <a href="<?php echo base_url('instructor') ?>">
            <center><i class="fa fa-user fa-2x"></i></center>
            <small>Inst. Course Loading</small>
          </a>
        </li>
        <li id="menu_cpanel" class="page_menu">
          <a href="<?php echo base_url('cpanel') ?>">
            <center><i class="fa fa-gears fa-2x"></i></center>
            <small>C-Panel</small>
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right hidden-xs">
        <li class="hidden-sm hidden-md hidden-xs">
          <a style="padding-top:25px">
            <span class="day"></span> <span class="date"></span> <span class="time"></span>
          </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="pull-left p-r-10" style="border-right:1px solid #FFF">
              <p style="margin-bottom:0px">
                <small>Welcome:</small> <?php echo $this->userInfo->fullName('f l'); ?> </p>
              <center><?php echo $this->userInfo->user_position; ?></center>
            </div>
            <img src="<?php echo base_url('assets/img/profile_image/' . $this->userInfo->user_image) ?>" class="img img-responsive pull-right m-l-10"
                 style="height:40px;width:40px">
          </a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="$('#modalChangePic').modal('show')"><i class="fa fa-image"></i> Change Profile Image</a></li>
            <li><a href="settings"><i class="fa fa-gear"></i> Account Settings</a></li>
            <li><a href="<?php echo base_url('login/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>