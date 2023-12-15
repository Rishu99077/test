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
                <form role="form" id="recheckedit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <!-- <div class="form-group <?php if($error['Internalcode']!=''){ echo 'has-error'; } ?>" id="InputInternalcode">
                      <label for="" class="required">Internal code</label><br>
                      <input type="text" class="form-control" id="Internalcode" name="Internalcode" placeholder="Internal code" value="<?php echo $get_single_recheck['Internalcode']; ?>" style="float: left;width: 75%;">
                      <button type="button" class="btn btn-primary" style="float: right;width: 20%;" id="CheckInternalcodebtn">Check code</button>
                      <input type="hidden" name="CheckInternalcode" name="CheckInternalcode" id="CheckInternalcode">
                    </div>  <br>
                    <div class="form-group InputCheckInternalcode <?php if($error['Internalcode']!=''){ echo 'has-error'; } ?>">
                      <span class="help-block"><?php if($error['Internalcode']!=''){ echo $error['Internalcode']; } ?></span>
                    </div> -->
                    <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                      <label for="" class="required">Crop</label>
        
                        <select class="form-control select2box" id="Crop" name="Crop" <?php if($get_single_recheck['EvaluationID']!='' && $get_single_recheck['EvaluationID']!='0'){ echo 'style="display: none;"'; } ?>  >
                          <option readonly>Select Crop</option>
                          <?php foreach ($crops as $crop) { ?>
                          <option value="<?php echo $crop['CropID']; ?>" <?php if ($get_single_recheck['Crop'] == $crop['CropID'] ) echo 'selected' ; ?> ><?php echo $crop['Title']; ?></option>
                          <?php } ?>
                        </select>                    
                      <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                    </div>


                    <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                      <label for="" class="required">Variety</label>
                      <div class="Seedbox" id="Variety"></div>

                      <span class="help-block"><?php if($error['Variety']!=''){ echo $error['Variety']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['Supplier']!=''){ echo 'has-error'; } ?>" id="InputSupplier">
                      <label for="" class="required">Supplier</label>
                      <div class="Supplierbox"></div>

                      <span class="help-block"><?php if($error['Supplier']!=''){ echo $error['Supplier']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['Numebrofseedsrequast']!=''){ echo 'has-error'; } ?>" id="InputNumebrofseedsrequast">
                      <label for="" class="required">Number of seeds request</label>
                      <input type="number" class="form-control" id="Numebrofseedsrequast" name="Numebrofseedsrequast" placeholder="Number of seeds request" value="<?php echo $get_single_recheck['Numebrofseedsrequast']; ?>" >
                      <span class="help-block"><?php if($error['Numebrofseedsrequast']!=''){ echo $error['Numebrofseedsrequast']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Bywhen']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                      <label for="" class="required">By when</label>
                      <input type="text" class="form-control" id="Bywhen" name="Bywhen" placeholder="By when" value="<?php echo $get_single_recheck['Bywhen']; ?>" >
                      <span class="help-block"><?php if($error['Bywhen']!=''){ echo $error['Bywhen']; } ?></span>
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

<script type="text/javascript">
$(document).ready(function(){ 
  $("#recheckedit").submit(function(){ 
    $(".InputCheckInternalcode .help-block").html('');
    $(".InputCheckInternalcode").removeClass("has-error");
    var CheckInternalcode= $("#CheckInternalcode").val();
    if(CheckInternalcode==''){
      $(".InputCheckInternalcode .help-block").html('<p>Please Check Internal code.</p>');
      $(".InputCheckInternalcode").addClass("has-error");
       $("#Internalcode").focus();
      return false;
    }
  });
});
$(document).ready(function(){ 
  $("#CheckInternalcodebtn").click(function(){
     $("#CheckInternalcode").val('');
    $(".InputCheckInternalcode .help-block").html('');
    $(".InputCheckInternalcode").removeClass("has-error");
    var Internalcode= $("#Internalcode").val();
    if(Internalcode==''){
     $(".InputCheckInternalcode .help-block").html('<p>Please Check Internal code.</p>');
      $(".InputCheckInternalcode").addClass("has-error");
      $("#Internalcode").focus();
      return false;
    }
    var data = {'Internalcode':Internalcode};
    $.ajax({
        url: '<?php echo base_url(); ?>admin/trialcheckinternalcode',
        type: 'post',
        data: data,
        success: function(response) {
          if(response=='This Internal code not exits'){
            $("#CheckInternalcode").val('');
            $(".InputCheckInternalcode .help-block").html('<p>'+response+'.</p>');
            $(".InputCheckInternalcode").addClass("has-error");
            $("#Internalcode").focus();
          }else{
            $("#CheckInternalcode").val('1');
            //$(".InputCheckInternalcode .help-block").html('<p style="color: green;">This Internal code exits.</p>');
            $(".InputCheckInternalcode .help-block").html('<p style="color: green;">'+response+'</p>');//Abhishek
          } 
        }
    }); 
  }); 
});  
</script>  

<script type="text/javascript">
$(document).ready(function(){  
  $("#Crop").on("change", function(){
    get_seed('');
  });
}); 
</script>
<script>
function get_seed(Seedselect){
    var Crop= $("#Crop").children("option:selected").val();
    var data = {'Crop':Crop,'Seedselect':Seedselect};
    $.ajax({
        url: '<?php echo base_url(); ?>/admin/seed_recheck',
        type: 'post',
        data: data,
        success: function(response) {
          var res = JSON.parse(response);
          $(".Seedbox").html(res.seed);
          $('.select2box').select2();
        }
    });
}
</script>
<script type="text/javascript">
$(document).ready(function(){  
  $("#Variety").on("change", function(){
    get_supplier('');
  });
}); 
</script>
<script>
function get_supplier(Seedselect,Variety){
    var Variety= $("#Variety_drop").children("option:selected").val();
    var data = {'Variety':Variety,'Seedselect':Seedselect};
    $.ajax({
        url: '<?php echo base_url(); ?>/admin/supplier_recheck',
        type: 'post',
        data: data,
        success: function(response) {
          var res = JSON.parse(response);
          $(".Supplierbox").html(res.supplier);
          $('.select2box').select2();
        }
    });
}
</script>
<script>
$(function() {
    $( "#Bywhen" ).datepicker({ dateFormat: "dd/mm/yy" });
});
</script>

</script>
<?php if(@$get_single_recheck['SeedID']!=''){ ?>
<script type="text/javascript">
$(document).ready(function(){  
  get_seed("<?php echo $get_single_recheck['SeedID']; ?>");
}); 
</script>
<?php } ?>

</script>
<?php if(@$get_single_recheck['Supplier']!=''){ ?>
<script type="text/javascript">
$(document).ready(function(){  
  get_supplier("<?php echo $get_single_recheck['Supplier']; ?>");
}); 
</script>


<?php } ?>
