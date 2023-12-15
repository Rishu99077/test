<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
</style>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo $heading_title; ?></h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12">
              <?php $success = $this->session->flashdata('success');  ?>
              <?php if(isset($success)){ ?>
              <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4 style="margin-bottom: 0;">
                    <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
                  </h4>
               </div>
              <?php  } ?>
          </div>
        </div> 
        <div class="row">

          <div class="col-md-6">
              <div class="box box-primary">
                <!-- form start -->
                <form role="form" id="supplieredit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group <?php if($error['Name']!=''){ echo 'has-error'; } ?>" id="InputName">
                      <label for="" class="required">Name</label>
                      <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" value="<?php echo $get_supplier['Name']; ?>">
                      <span class="help-block"><?php if($error['Name']!=''){ echo $error['Name']; } ?></span>
                    </div> 
                    <div class="form-group" id="InputNote">
                      <label for="" class="">Note</label>
                      <textarea class="form-control" id="Note" name="Note" placeholder="Note"><?php echo $get_supplier['Note']; ?></textarea>
                      <span class="help-block"></span>
                    </div> 
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" style="float: left;">Save</button>
                  </div>
                </form>
              </div>
              <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include('common/footer_content.php');?>
    <?php include('common/sidebar_control.php');?> 
</div>
<!-- ./wrapper -->
<?php include('common/footer.php');?>