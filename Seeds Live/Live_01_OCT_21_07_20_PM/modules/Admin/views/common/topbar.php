<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('admin'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><img src="<?php echo base_url().'adminasset/images/logoicon.png'; ?>"></b></span>
      <span class="logo-lg"><b><img src="<?php echo base_url().'adminasset/images/logo.png'; ?>"></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->

      <?php 
        if($this->session->userdata('image')!=''){
            $image = base_url().'uploads/UserProfile/thumbnail/'.$this->session->userdata('image');
        }else{
            $image =base_url().'adminasset/images/userlogo.png';
        }
      ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $image; ?>" class="user-image" >
              <span class="hidden-xs"><?php echo $this->session->userdata('name'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $image; ?>"  class="img-circle" >
                <p>
                  <?php echo $this->session->userdata('name'); ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('admin/editprofile/'); ?><?php //echo $this->session->userdata('UserID'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('admin/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>