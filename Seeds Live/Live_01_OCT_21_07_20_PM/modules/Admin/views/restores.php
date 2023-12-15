<?php include('common/header.php');?>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo $heading_title; ?></h1>
      </section>
      <!-- Main content -->
      <?php           
          $module = @$_GET['module'];
      ?>
      <section class="content">
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
          <div class="col-md-12">
            <form method="get" action="<?php echo base_url(); ?>admin/restores" id="filterform">
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-control select2box" id="module" name="module">
                          <option value="">-- Select Module --</option>
                          <?php foreach ($modules as $key => $value) { ?>
                            <option value="<?php echo $key; ?>" <?php if ($module == $key ) echo 'selected' ; ?> ><?php echo $value; ?></option>
                          <?php } ?>                       
                        </select>
                    </div>
                  </div>
            </form>
          </div>
        </div>    
        <?php if (array_key_exists($module,$modules)){ ?>
        <?php include('restores/'.$module.'.php');?>
      <?php } ?>
      </section>
      <!-- /.content -->
    </div>
    <?php include('common/footer_content.php');?>
    <?php include('common/sidebar_control.php');?> 
</div>
<!-- ./wrapper -->
<?php include('common/footer.php');?>
<script type="text/javascript">
$(document).ready(function(){
    $('#module').on('change', function() {
      $("#filterform").submit();
    });
});
</script>