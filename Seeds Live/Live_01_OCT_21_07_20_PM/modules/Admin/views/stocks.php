<?php include('common/header.php');?>
<style type="text/css">
  #Stockquantitydiv{background-color: #fff;min-height: 210px;width: 100%; float: left;margin:50px 0;padding: 15px;}
  #InputStockquantityfor label {
    margin-right: 10px;
  }
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
      

        <!-- Filter Form -->
        <?php
          $Crop = $this->input->get('Crop');
          $Variety = $this->input->get('Variety');
          $Supplier = $this->input->get('Supplier');
        ?>
        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/stocks" id="filterform">
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
                        <select class="form-control select2box" id="Variety" name="Variety">
                            <option value="">-- Select Variety --</option>
                            <?php foreach ($allseeds as $seed_val) { ?>
                            <option value="<?php echo $seed_val; ?>" <?php if (@$Variety == $seed_val ) echo 'selected' ; ?> ><?php echo $seed_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>

                      <div class="col-md-4">
                          <button type="submit" style="padding: 6px 20px;" class="btn btn-primary">Filter</button>
                          <a href="<?php echo base_url(); ?>admin/stocksexport"><button type="button" style="padding: 6px 20px;margin-left: 8px;" class="btn btn-primary btn-export">Export Data</button></a>
                      </div>
                    </div>
                  </form>
                </div>
            </div>          
        </div>
        
        <div class="row">
          <div class="col-md-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>Crop</th>
                    <th>Supplier</th>
                    <th>Variety</th>
                    <th>Available stock</th>
                    <th>Total Sampling done</th>
                    <th>No. of Sampling</th>
                  </tr>

                  <?php if(count($seeds) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($seeds as $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Crop']; ?></td>
                        <td><?php echo $value['Supplier']; ?></td>
                        <td><?php echo $value['Variety']; ?></td>
                        <td><?php echo $value['Stockquantity']; ?></td>
                        <td><?php echo $value['Samplingstock']; ?></td>
                        <td><?php echo $value['NoofSampling']; ?></td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="9"> Record Not Found </td>
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
          </div><!-- /.col -->
        </div><!-- /.row -->
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
  $('#Crop').on('change', function() {
    $("#filterform").submit();
  });
  $('#Supplier').on('change', function() {
    $("#filterform").submit();
  });
  $('#Variety').on('change', function() {
    $("#filterform").submit();
  });
});   
$(document).ready(function(){
  $("body").on("change", "#SeedID", function(){ 
    $('#Stockquantitydiv').html('');
    $('.StockUpdatemsg').html('');
    var SeedID = $("#SeedID").children("option:selected").val();
    if(SeedID!=''){
      data = {'SeedID':SeedID};
      $.ajax({
          url: '<?php echo base_url(); ?>admin/getstock',
          type: 'post',
          data: data,
          success: function(response) {
            $('#Stockquantitydiv').html(response);
            $('.StockUpdatemsg').html('');
          }
      });
    }  
  });  
}); 
$(document).ready(function(){ 
  $("#updateseed").submit(function(){ 
    var SeedID = $("#SeedID").children("option:selected").val();
    var Stockquantity = $("#Stockquantity").val();
    var Stockquantityfor = $("input[name='Stockquantityfor']:checked").val();
    data = {'SeedID':SeedID,'Stockquantity':Stockquantity,'Stockquantityfor':Stockquantityfor};
    $.ajax({
        url: '<?php echo base_url(); ?>admin/updateseed',
        type: 'post',
        data: data,
        success: function(response) {
          $('.StockUpdatemsg').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4 style="margin-bottom: 0;"><i class="icon fa fa-check"></i> Stock Update successfully</h4></div>');
        }
    });
    return false;
  });
}); 
</script>