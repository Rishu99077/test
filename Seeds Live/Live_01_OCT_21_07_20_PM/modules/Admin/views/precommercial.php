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

        <?php
          $Crop = $this->input->get('Crop');
          $Supplier = $this->input->get('Supplier');
        ?>
        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/precommercial" id="filterform">
                    <div class="row">
                      <div class="col-md-2">
                          <select class="form-control select2box" id="Crop" name="Crop">
                            <option value="">-- Select Crop --</option>
                            <?php foreach ($crops as $crop_key => $crop_val) { ?>
                            <option value="<?php echo $crop_key; ?>" <?php if (@$Crop == $crop_key ) echo 'selected' ; ?> ><?php echo $crop_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>

                      <div class="col-md-2">
                        <select class="form-control select2box" id="Supplier" name="Supplier">
                            <option value="">-- Select Supplier --</option>
                            <?php foreach ($suppliers as $supplier_key => $supplier_val) { ?>
                            <option value="<?php echo $supplier_key; ?>" <?php if (@$Supplier == $supplier_key ) echo 'selected' ; ?> ><?php echo $supplier_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-2">
                            <button type="submit" style="padding: 6px 20px;" class="btn btn-primary">Filter</button>
                      </div> 

                    </div>
                   
                  </form>
                </div>
            </div>          
        </div> 

        <!-- Info boxes -->

        <div class="row">
          <div class="col-md-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>Crop</th>
                    <th>Variety</th>
                    <th>Supplier</th>
                    <th>Numebr of seeds requast</th>
                    <th>By when</th>
                    <th>Action</th>
                  </tr>

                  <?php if(count($precommercial) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($precommercial as $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Crop']; ?></td>
                        <td><?php echo $value['Variety']; ?></td>
                        <td><?php echo $value['Supplier']; ?></td>
                        <td><?php echo $value['Numebrofseedsrequast']; ?></td>
                        <td><?php echo $value['Bywhen']; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>admin/precommercialedit/?PrecommercialID=<?php echo $value['PrecommercialID']; ?>"><button type="button" class="btn btn-default">Edit</button></a> 
                         <!--  <a href="<?php echo base_url(); ?>admin/deleteprecommercial/<?php echo $value['PrecommercialID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->
                         <button class="test_btn btn btn-danger" onClick="return doconfirm();" data_id="<?php echo $value['PrecommercialID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restoreprecommercial/<?php echo $value['PrecommercialID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                        </td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="7"> Record Not Found </td>
                    </tr>
                  <?php } ?>  

                </table>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="total_rows"><?php echo $result_count; ?></div>
                </div>
                <div class="col-md-6">
                  <div class="pagination_main"><?php echo $links; ?></div>
                </div>
              </div>
              
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
<script>
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deleteprecommercial'); ?>',
     method: 'post',
     data: {DeleteID: DeleteID},
     dataType: 'json',
     success: function(result){
      location.reload();
  
     }
  });
 });
});
$(document).ajaxStop(function() {
        setInterval(function() {
            location.reload();
        }, 500);
    });
</script>