<?php include('common/header_outer.php');?>
<div class="row">
    <div class="col-md-12 text-center">
        <img src="<?php echo base_url().'adminasset/images/shimiyazad.jpg'; ?>">
    </div>
</div>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><? echo $heading_title; ?></p>

    <form id="userlogin" action="" method="post">
      <div class="form-group" id="Inputusernamepassword">
        <span class="help-block"></span>
      </div>
      <div class="form-group" id="Inputusername">
        <label for="password" class="required">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        <span class="help-block"></span>
      </div>
      <div class="form-group" id="Inputpassword">
        <label for="password" class="required">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <span class="help-block"></span>
      </div>  
      <div class="form-group has-feedback">
        <div class="row">
          <div class="col-xs-8">
            <!-- <div class="checkbox icheck">
              <input type="checkbox" style="margin-left: 0;">
              <label style="margin-left: 20px;">
                Remember Me
              </label>
            </div> -->
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </div>
    </form>
    <!-- <a href="<?php //echo base_url('admin/forget'); ?>">I forgot my password</a> -->
  </div>
  <!-- /.login-box-body -->
</div>
<?php include('common/footer_outer.php');?>

