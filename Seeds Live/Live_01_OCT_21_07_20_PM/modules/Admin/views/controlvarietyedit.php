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
                <form role="form" id="controlvarietyedit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                      <label for="" class="required">Crop</label>
                      <select class="form-control select2box" id="Crop" name="Crop">
                        <?php foreach ($crops as $crop) { ?>
                        <option value="<?php echo $crop['CropID']; ?>" <?php if ($get_controlvariety['Crop'] == $crop['CropID'] ) echo 'selected' ; ?> ><?php echo $crop['Title']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                      <label for="" class="required">Variety</label>
                      <select class="form-control select2box" id="Variety" name="Variety">
                        <?php foreach ($seeds as $seed) { ?>
                        <option value="<?php echo $seed['SeedID']; ?>" <?php if ($get_controlvariety['Variety'] == $seed['SeedID'] ) echo 'selected' ; ?> ><?php echo $seed['Variety']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Variety']!=''){ echo $error['Variety']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['title']!=''){ echo 'has-error'; } ?>" id="Inputtitle">
                      <label for="" class="required">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $get_controlvariety['Title']; ?>">
                      <span class="help-block"><?php if($error['title']!=''){ echo $error['title']; } ?></span>
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