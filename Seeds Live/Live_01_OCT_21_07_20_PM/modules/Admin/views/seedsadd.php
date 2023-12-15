<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
  table.table1 {
    border: 1px solid #ccc;
  }
  table.table1 td {
    padding: 10px;
    border: 1px solid #ccc;
  }
  table.table2 {
    border: 1px solid #ccc;
  }
  table.table2 td {
    padding: 10px;
    border: 1px solid #ccc;
  }
   ul.buttons_list { margin-top: 0;}
  ul.buttons_list li button {
    color: #fff;
    font-size: 20px;
    text-transform: uppercase;
    background: #12B13B;
    padding: 5px 15px;border: unset;
}
ul.buttons_list li button i {
    color: #fff;
    padding-right: 5px;
    font-size: 15px;
}
</style>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                  <h1><?php echo $heading_title; ?></h1>
                </div>
                <div class="col-md-6">
                  <ul class="buttons_list">
                    <li><button onclick="goBack()">
                        <i class="fa fa fa-level-up" aria-hidden="true"></i>
                        Back
                        </button>
                    </li>
                  </ul>
                </div>
            </div>
          </div>
          
        </div>
      </section>
       <?php
      if($get_seed['Dateofrecivedsampel'] != ''){
          $date = $get_seed['Dateofrecivedsampel'];  
         $exdate = explode("/",$date); 
         @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
         $newDate =   date("d-F-Y", strtotime($newDate));
        }else{
         $newDate = '';
        }
     ?> 
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
                <form role="form" id="seededit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                      <label for="" class="required">Crop</label>
                      <?php foreach ($crops as $crop) { ?>
                       <?php if ($get_seed['Crop'] == $crop['CropID'] ){  ?>
                       <p class="viewonlyclass" ><?php echo $crop['Title']; ?></p>
                       <?php } ?>
                       <?php } ?>
                      <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                    </div>


                    <div class="form-group <?php if($error['Supplier']!=''){ echo 'has-error'; } ?>" id="InputSupplier" >
                      <label for="" class="required">Supplier</label>
                       <?php foreach ($suppliers as $supplier) { ?>
                       <?php if ($get_seed['Supplier'] == $supplier['SupplierID'] ) { ?>
                       <p class="viewonlyclass" ><?php echo $supplier['Name']; ?></p>
                       <?php } ?>
                       <?php } ?>
                      <span class="help-block"><?php if($error['Supplier']!=''){ echo $error['Supplier']; } ?></span>
                    </div>
                          

                    <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                       <label for="" class="required">Variety</label><br>
                       <input type="text" readonly="readonly" class="form-control" id="Variety" name="Variety" placeholder="Variety" value="<?php echo $get_seed['Variety']; ?>" style="float: left;width: 100%;">
                    </div>

                    <div class="form-group InputCheckVariety <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety" style="float: left;width: 100%;">
                      <span class="help-block"><?php if($error['Variety']!=''){ echo $error['Variety']; } ?></span>
                    </div>  

                    <div class="form-group <?php if($error['Dateofrecivedsampel']!=''){ echo 'has-error'; } ?>" id="InputDateofrecivedsampel">
                      <label for="" class="required">Date of recived sampels</label>
                      <input type="text"  class="form-control" id="Dateofrecivedsampel" name="Dateofrecivedsampel" placeholder="Date of recived sampel" value="<?php echo $get_seed['Dateofrecivedsampel']; ?>">
                      <span class="help-block"><?php if($error['Dateofrecivedsampel']!=''){ echo $error['Dateofrecivedsampel']; } ?></span>
                    </div> 

                    <div class="form-group <?php if($error['Stockquantityfor']!=''){ echo 'has-error'; } ?>" id="InputStockquantityfor">
                      <label for="" class="required">Stock quantity for</label>
                      <br>
                      <?php $cnt = 1; ?>
                      <?php foreach ($Stockquantityfor as $key => $value){ ?>
                        <?php 
                          if($cnt=='1' && $get_seed['Stockquantityfor']==''){
                            $checked = 'checked="checked"';
                          }elseif($get_seed['Stockquantityfor']==$key){
                            $checked = 'checked="checked"';
                          }else{
                            $checked = '';
                          }
                        ?>
                      <input type="radio" class="formcontrol" id="Stockquantityfor<?php echo $key; ?>" name="Stockquantityfor" value="<?php echo $key; ?>" <?php echo $checked; ?>>
                      <label for="Stockquantityfor<?php echo $key; ?>"><?php echo $value; ?></label>
                      <?php $cnt++; ?>
                      <?php } ?>

                      <span class="help-block"><?php if($error['Stockquantityfor']!=''){ echo $error['Stockquantityfor']; } ?></span>
                    </div> 

                    <div class="form-group <?php if($error['Stockquantity']!=''){ echo 'has-error'; } ?>" id="InputStockquantity">
                      <label for="" class="required">Stock quantity</label>
                      <input type="text" class="form-control" id="Stockquantity" name="Stockquantity" placeholder="Add Stockquantity">
                      <span class="help-block"><?php if($error['Stockquantity']!=''){ echo $error['Stockquantity']; } ?></span>
                    </div> 

                  </div>

                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="button" id="submitbtn" class="btn btn-primary" style="float: left;">Submit</button>
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
<script>
$(function() {
    $( "#Dateofrecivedsampel" ).datepicker({ dateFormat: "dd/mm/yy" });
});

$(document).ready(function(){
  $('.table2').on('click', "#add", function(e) {
        console.log("d");
        $('.table2 tbody').append('<tr class="add_row"><td width="70%"><input class="coverimage" name="files[]" type="file" id="files" /> </div></td><td class="text-center" width="10%"><div class="imagePreview"  style="display: none;"></td><td class="text-center" width="20%"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></td></tr>');
        e.preventDefault();
    });

    // Delete row
    $('.table1').on('click', "#delete", function(e) {
        if (!confirm("Are you sure you want to delete this file?"))
        return false;
        $(this).closest('tr').remove();
        e.preventDefault();
    }); 
    $('.table2').on('click', "#delete", function(e) {
        if (!confirm("Are you sure you want to delete this file?"))
        return false;
        $(this).closest('tr').remove();
        e.preventDefault();
    });
  $("#seededit").submit(function(){ 
    $(".InputCheckVariety .help-block").html('');
    $(".InputCheckVariety").removeClass("has-error");
    var CheckVariety= $("#CheckVariety").val();
    if(CheckVariety==''){
      $(".InputCheckVariety .help-block").html('<p>Please Check Variety.</p>');
      $(".InputCheckVariety").addClass("has-error");
      return false;
    }
  });
});  
$(document).ready(function(){ 
  $("#CheckVarietybtn").click(function(){
    $(".InputCheckVariety .help-block").html('');
    $(".InputCheckVariety").removeClass("has-error");

    var SeedID= $("#SeedID").val();
    var Variety= $("#Variety").val();
    var Crop= $("#Crop").children("option:selected").val();
    var Supplier= $("#Supplier").children("option:selected").val();
    if(Variety==''){
     $(".InputCheckVariety .help-block").html('<p>Please Check Variety.</p>');
      $(".InputCheckVariety").addClass("has-error");
      return false;
    }
    var data = {'SeedID':SeedID,'Variety':Variety,'Crop':Crop,'Supplier':Supplier};
    $.ajax({
        url: '<?php echo $baseurl; ?>/admin/checkvariety',
        type: 'post',
        data: data,
        success: function(response) {
          $("#CheckVariety").val('1');
          $(".InputCheckVariety .help-block").html('<p>'+response+'.</p>');
          $(".InputCheckVariety").addClass("has-error");
        }
    }); 
  }); 
});
$("#Crop").on("change", function (){
    $("#CheckVariety").val('');
});
$("#Supplier").on("change", function (){
    $("#CheckVariety").val('');
});
$("#Variety").keyup(function () {
  $("#CheckVariety").val('');
});  


$(document).ready(function(){
  $('#submitbtn').on('click', function() {
    $("#seededit").submit();
  });
}); 
</script>
<!-- <script type="text/javascript">
  $(document).ready(function(){
      $('#lightgallery').lightGallery({
        share:false,
      });
  });
</script> -->
<script>
function goBack() {
  window.history.back();
}
</script>