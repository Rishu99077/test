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
                      <select class="form-control select2box" id="Crop" name="Crop">
                        <?php foreach ($crops as $crop) { ?>
                        <option value="<?php echo $crop['CropID']; ?>" <?php if ($get_seed['Crop'] == $crop['CropID'] ) echo 'selected' ; ?> ><?php echo $crop['Title']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['Supplier']!=''){ echo 'has-error'; } ?>" id="InputSupplier">
                      <label for="" class="required">Supplier</label>
                      <select class="form-control select2box" id="Supplier" name="Supplier">
                        <?php foreach ($suppliers as $supplier) { ?>
                        <option value="<?php echo $supplier['SupplierID']; ?>" <?php if ($get_seed['Supplier'] == $supplier['SupplierID'] ) echo 'selected' ; ?> ><?php echo $supplier['Name']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Supplier']!=''){ echo $error['Supplier']; } ?></span>
                    </div>  
                    
                    <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                      <label for="" class="required">Variety</label><br>
                      <input type="text" class="form-control" id="Variety" name="Variety" placeholder="Variety" value="<?php echo $get_seed['Variety']; ?>" style="float: left;width: 75%;"><button type="button" class="btn btn-primary" style="float: right;width: 20%;" id="CheckVarietybtn">Check Variety</button>
                      <input type="hidden" name="CheckVariety" name="CheckVariety" id="CheckVariety">
                      <input type="hidden" name="SeedID" name="SeedID" id="SeedID" value="<?php echo $get_seed['SeedID']; ?>">
                    </div>
                    <div class="form-group InputCheckVariety <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety" style="float: left;width: 100%;">
                    <span class="help-block"><?php if($error['Variety']!=''){ echo $error['Variety']; } ?></span>
                    </div>  
                    <div class="form-group <?php if($error['Dateofrecivedsampel']!=''){ echo 'has-error'; } ?>" id="InputDateofrecivedsampel">
                      <label for="" class="required">Date of recived sampels</label>
                      <input type="text"  class="form-control" id="Dateofrecivedsampel" name="Dateofrecivedsampel" placeholder="Date of recived sampel" value="<?php echo $get_seed['Dateofrecivedsampel']; ?>">
                      <span class="help-block"><?php if($error['Dateofrecivedsampel']!=''){ echo $error['Dateofrecivedsampel']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Status']!=''){ echo 'has-error'; } ?>" id="InputStatus">
                      <label for="" class="required">Status</label>
                      <select class="form-control" id="Status" name="Status">
                        <?php foreach ($Status as $key => $value) { ?>
                          <option value="<?php echo $key; ?>" <?php if ($get_seed['Status'] == $key ) echo 'selected' ; ?> ><?php echo $value; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Status']!=''){ echo $error['Status']; } ?></span>
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
                      <input type="text" class="form-control" id="Stockquantity" name="Stockquantity" placeholder="Stockquantity" value="<?php echo $get_seed['Stockquantity']; ?>">
                      <span class="help-block"><?php if($error['Stockquantity']!=''){ echo $error['Stockquantity']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Note']!=''){ echo 'has-error'; } ?>" id="InputNote">
                      <label for="" class="">Note</label>
                      <textarea class="form-control" id="Note" name="Note" placeholder="Note"><?php echo $get_seed['Note']; ?></textarea>
                      <span class="help-block"><?php if($error['Note']!=''){ echo $error['Note']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['TechnicalData']!=''){ echo 'has-error'; } ?>" id="InputNote">
                      <label for="" class="">Technical data</label>
                      <textarea class="form-control" id="TechnicalData" name="TechnicalData" placeholder="Technical Data"><?php echo $get_seed['TechnicalData']; ?></textarea>
                      <span class="help-block"><?php if($error['TechnicalData']!=''){ echo $error['TechnicalData']; } ?></span>
                    </div>

                    <div class="form-group" >
                      <label for="picture" class="">Attachments</label>
                    </div>
                    <div class="form-group" id="Inputpicture">
                      <table class="table1 custom_box_gallery" width="100%" style="margin: 0 auto;">
                        <tbody id="lightgallery">
                          <?php
                            if(!empty($get_seed['Attachment'])){
                                $Attachment = explode(",",$get_seed['Attachment']); 
                                $i=1;
                              foreach($Attachment as $Picture){
                          ?>
                              <tr class="add_row" data-responsive="<?php echo base_url().'uploads/Seeds/'.$Picture; ?> 375,<?php echo base_url().'uploads/Seeds/'.$Picture; ?> 480, <?php echo base_url().'uploads/Seeds/'.$Picture; ?> 800" data-src="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>" data-sub-html="" >
                                <td width="70%">
                                  <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[]" value="<?php echo $Picture; ?>">
                                  <a href="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>">
                                    <img class="img-responsive" src="<?php echo base_url().'uploads/Seeds/thumbnail/'.$Picture; ?>">
                                  </a>
                                </td> 
                                <td class="text-center" width="10%"></td><td class="text-center" width="20%"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></td>
                              </tr>
                          <?php
                                $i++;
                              }
                            }
                          ?>                          
                        </tbody>
                      </table>  
                      <table class="table2" width="100%" style="margin: 0 auto;">
                        <tbody>
                          <tr class="add_row default_file">
                            
                            <td width="70%">
                              <input class="coverimage" name='files[]' type='file' id="files" />

                            </td>
                            <td class="text-center" width="10%">
                              <div class="imagePreview" style="display: none;"></div>
                            </td>
                            <td width="20%"></td>
                          </tr>
                        </tbody>  
                        <tfoot>
                          <tr>
                            <td colspan="4"><button class="btn btn-success btn-sm" type="button" id="add" title='Add new file'/>Add new file</button></td>
                          </tr>
                        </tfoot>  
                      </table>
                      <span class="help-block"></span>
                    </div> 

                  </div>

                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="button" id="submitbtn" class="btn btn-primary" style="float: left;">Save</button>
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