<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
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

<?php
  if($get_single_sampling['Deliverydate'] != ''){
    $newAddDate = $get_single_sampling['Deliverydate'];
    $NewDeliverydate = date("d-F-Y",strtotime($newAddDate));
    }else{
   $NewDeliverydate = '';
  }

  if($get_single_sampling['Dateofsowing'] != ''){
    $newAddDate = $get_single_sampling['Dateofsowing'];
    $NewDateofsowing = date("d-F-Y",strtotime($newAddDate));
    }else{
   $NewDateofsowing = '';
  }
 if($get_single_sampling['Dateoftransplanted'] != ''){
    $newAddDate = $get_single_sampling['Dateoftransplanted'];
    $NewDateoftransplanted = date("d-F-Y",strtotime($newAddDate));
    }else{
    $NewDateoftransplanted = '';
  }
 if($get_single_sampling['Estimatedharvestingdate'] != ''){
    $newAddDate = $get_single_sampling['Estimatedharvestingdate'];
    $NewEstimatedharvestingdate = date("d-F-Y",strtotime($newAddDate));
    }else{
    $NewEstimatedharvestingdate = '';
  }

?>

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
                <form role="form" id="samplingedit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formLocation" <?php if($SamplingID==''){ ?> onsubmit="return samplingeditsubmit()" <?php } ?>>
                  <div class="box-body">
                    <div class="form-group <?php if($error['Receiver']!=''){ echo 'has-error'; } ?>" id="InputReceiver">
                      <label for="" class="required">Receiver</label>
                      <select class="form-control select2box" id="Receiver" name="Receiver">
                        <option value="">Please Select Receiver</option>
                        <?php foreach ($receivers as $receiver) { ?>
                        <option value="<?php echo $receiver['ReceiverID']; ?>" <?php if ($get_single_sampling['Receiver'] == $receiver['ReceiverID'] ) echo 'selected' ; ?> ><?php echo $receiver['Name']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Receiver']!=''){ echo $error['Receiver']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['Location']!=''){ echo 'has-error'; } ?>" id="InputLocation">
                      <label for="" class="required">Location</label>
                      <div class="locationbox"></div>
                      <span class="help-block"><?php if($error['Location']!=''){ echo $error['Location']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Techncialteam']!=''){ echo 'has-error'; } ?>" id="InputTechncialteam">
                      <label for="" class="required">Techncial team</label>
                      <select class="form-control" id="Techncialteam" name="Techncialteam">
                        <?php foreach ($techncial_team as $techncialteam) { ?>
                        <option value="<?php echo $techncialteam['TechncialteamID']; ?>" <?php if ($get_single_sampling['Techncialteam'] == $techncialteam['TechncialteamID'] ) echo 'selected' ; ?> ><?php echo $techncialteam['Name']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Techncialteam']!=''){ echo $error['Techncialteam']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                      <label for="" class="required">Crop</label>
                      <select class="form-control select2box " id="Crop" name="Crop">
                         <option value="">Please Select Crop</option>
                        <?php foreach ($crops as $crop) { ?>
                        <option value="<?php echo $crop['CropID']; ?>" <?php if ($get_single_sampling['Crop'] == $crop['CropID'] ) echo 'selected' ; ?> ><?php echo $crop['Title']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                    </div>
                    
                    <div class="form-group <?php if($error['Seed']!=''){ echo 'has-error'; } ?>" id="InputSeed">
                      <label for="" class="required">Seed</label>
                      <div class="Seedbox"></div>

                      <span class="help-block"><?php if($error['Seed']!=''){ echo $error['Seed']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Stockquantityfor']!=''){ echo 'has-error'; } ?>" id="InputStockquantityfor">
                      <label for="" class="required">Stock quantity for</label>
                      <div class="Stockquantityforbox"></div>

                      <span class="help-block"><?php if($error['Stockquantityfor']!=''){ echo $error['Stockquantityfor']; } ?></span>
                    </div>

                    <div class="form-group <?php if($error['Stockquantity']!=''){ echo 'has-error'; } ?>" id="InputStockquantity">
                      <label for="" class="required">Stock quantity</label>
                      <input type="text" class="form-control" id="Stockquantity" name="Stockquantity" placeholder="Stock quantity" value="<?php echo $get_single_sampling['Stockquantity']; ?>">
                      <span class="help-block"><?php if($error['Stockquantity']!=''){ echo $error['Stockquantity']; } ?></span>
                    </div>


                    <div class="form-group <?php if($error['Sendingmethod']!=''){ echo 'has-error'; } ?>" id="InputSendingmethod">
                      <label for="" class="required">Sending method</label>
                      <br>
                      <?php $cnt = 1; ?>
                      <?php foreach ($Sendingmethod as $key => $value){ ?>
                        <?php 
                          if($cnt=='1' && $get_single_sampling['Sendingmethod']==''){
                            $checked = 'checked="checked"';
                          }elseif($get_single_sampling['Sendingmethod']==$value){
                            $checked = 'checked="checked"';
                          }else{
                            $checked = '';
                          }
                        ?>
                      <input type="radio" class="formcontrol" id="Sendingmethod<?php echo $key; ?>" name="Sendingmethod" value="<?php echo $value; ?>" <?php echo $checked; ?>>
                      <label for="Sendingmethod<?php echo $key; ?>"><?php echo $value; ?></label>
                      <?php $cnt++; ?>
                      <?php } ?>
                      <span class="help-block"><?php if($error['Sendingmethod']!=''){ echo $error['Sendingmethod']; } ?></span>
                    </div>
                    <div class="form-group <?php //if($error['Deliverydate']!=''){ echo 'has-error'; } ?>" id="InputDeliverydate">
                      <label for="" class="">Delivery date</label>
                      <input type="text" class="form-control" id="Deliverydate" name="Deliverydate" placeholder="Delivery date" value="<?php echo $NewDeliverydate; ?>" autocomplete="off" >
                      <span class="help-block"><?php //if($error['Deliverydate']!=''){ echo $error['Deliverydate']; } ?></span>
                    </div>
                    <div class="form-group <?php //if($error['Dateofsowing']!=''){ echo 'has-error'; } ?>" id="InputDateofsowing">
                      <label for="" class="">Date of sowing</label>
                      <input type="text" class="form-control" id="Dateofsowing" name="Dateofsowing" placeholder="Date of sowing" value="<?php echo $NewDateofsowing; ?>" autocomplete="off" >
                      <span class="help-block"><?php //if($error['Dateofsowing']!=''){ echo $error['Dateofsowing']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Dateoftransplanted']!=''){ echo 'has-error'; } ?>" id="InputDateoftransplanted">
                      <label for="" class="">Date of transplanted</label>
                      <input type="text" class="form-control" id="Dateoftransplanted" name="Dateoftransplanted" placeholder="Date of transplanted" value="<?php echo $NewDateoftransplanted; ?>" autocomplete="off" >
                      <span class="help-block"><?php if($error['Dateoftransplanted']!=''){ echo $error['Dateoftransplanted']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Estimatedharvestingdate']!=''){ echo 'has-error'; } ?>" id="InputEstimatedharvestingdate">
                      <label for="" class="">Estimated harvesting date</label>
                      <input type="text" class="form-control" id="Estimatedharvestingdate" name="Estimatedharvestingdate" placeholder="Estimated harvesting date" value="<?php echo $NewEstimatedharvestingdate; ?>" autocomplete="off" >
                      <span class="help-block"><?php if($error['Estimatedharvestingdate']!=''){ echo $error['Estimatedharvestingdate']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Internalsamplingcode']!=''){ echo 'has-error'; } ?>" id="InputInternalsamplingcode">
                      <label for="" class="required">Internal sampling code</label>
                      <br>
                      <input type="text" class="form-control" id="Internalsamplingcode" name="Internalsamplingcode" placeholder="Internal sampling code" value="<?php echo $get_single_sampling['Internalsamplingcode']; ?>" style="font-weight: bold;font-size: 22px; float: left;width: 90%;" readonly>
                        <?php if($SamplingID==''){ ?>
                        <a href="javascript:void(0);" style="margin:5px 10px;float: left;" id="refreshInternalsamplingcode"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        <?php } ?>
                      <br/>
                      <span style="float: left;width: 100%;"  class="help-block"><?php if($error['Internalsamplingcode']!=''){ echo $error['Internalsamplingcode']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Controlvariety']!=''){ echo 'has-error'; } ?>" id="InputControlvariety">
                      <div class="Controlvarietybox"></div>
                      <span class="help-block"><?php if($error['Controlvariety']!=''){ echo $error['Controlvariety']; } ?></span>
                    </div>
                    <div class="form-group" id="InputDescription">
                      <label for="" class="">Description</label>
                      <textarea class="form-control" id="Description" name="Description" placeholder="Description"><?php echo $get_single_sampling['Description']; ?></textarea>
                      <span class="help-block"></span>
                    </div> 
                    <div class="form-group" id="InputTechnicalnotes">
                      <label for="" class="">Technical notes</label>
                      <textarea class="form-control" id="Technicalnotes" name="Technicalnotes" placeholder="Technical notes"><?php echo $get_single_sampling['Technicalnotes']; ?></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="button" class="btn btn-primary" id="submitbtn" style="float: left;">Save</button>
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
    $( "#Deliverydate" ).datepicker({ dateFormat:"yy-mm-dd" });
    $( "#Dateofsowing" ).datepicker({ dateFormat:"yy-mm-dd" });
    $( "#Dateoftransplanted" ).datepicker({ dateFormat:"yy-mm-dd" });
    $( "#Estimatedharvestingdate" ).datepicker({ dateFormat:"yy-mm-dd" });
});
$(document).ready(function(){  
  $("#Receiver").on("change", function (){
      get_location('');
  });
});  
function get_location(Locationselect){
    var Receiver= $("#Receiver").children("option:selected").val();
    var data = {'Receiver':Receiver,'Locationselect':Locationselect};
    $.ajax({
        url: '<?php echo $baseurl; ?>/admin/location',
        type: 'post',
        data: data,
        success: function(response) {
          $(".locationbox").html(response);
        }
    });
}
$(document).ready(function(){  
  $("#Crop").on("change", function (){
    get_seed('');
    $(".Stockquantityforbox").html('');
  });
});  
function get_seed(Seedselect){
    var Crop= $("#Crop").children("option:selected").val();
    var data = {'Crop':Crop,'Seedselect':Seedselect};
    $.ajax({
        url: '<?php echo $baseurl; ?>/admin/seed',
        type: 'post',
        data: data,
        success: function(response) {
          var res = JSON.parse(response);
          $(".Seedbox").html(res.seed);
          $('.select2box').select2();
        }
    });
}

$(document).ready(function(){ 
  $("body").on("change", "#Seed", function(){ 
    get_seed_stock('','');

  });
});  
function get_seed_stock(Seedselect,Controlvarietyselect){
    
    var Crop= $("#Crop").children("option:selected").val();
    if(Seedselect==''){
      var Seed = $("#Seed").children("option:selected").val();
    }else{
      var Seed = Seedselect;
    }  
    if(Seed==''){
      $(".Stockquantityforbox").html('');
    }else{  
      var data = {'Seed':Seed,'Crop':Crop,'Controlvarietyselect':Controlvarietyselect};
      $.ajax({
          url: '<?php echo $baseurl; ?>/admin/seedstock',
          type: 'post',
          data: data,
          success: function(response) {
            var res = JSON.parse(response);
            $(".Stockquantityforbox").html(res.Stockquantityforbox);
            $(".Controlvarietybox").html(res.controlvariety);
            $('.select2box').select2();
          }
      });
    }
}
</script>
<?php if($get_single_sampling['SeedID']!=''){ ?>
<script type="text/javascript">
$(document).ready(function(){  
  get_seed("<?php echo $get_single_sampling['SeedID']; ?>");
}); 
</script>
<?php } ?>

<?php if($get_single_sampling['SeedID']!='' && $get_single_sampling['Crop']!=''){ ?>
<script type="text/javascript">
$(document).ready(function(){  
  get_seed_stock("<?php echo $get_single_sampling['SeedID']; ?>","<?php echo $get_single_sampling['Crop']; ?>");
}); 
</script>
<?php } ?>

<?php if($get_single_sampling['Location']!=''){ ?>
<script type="text/javascript">
$(document).ready(function(){  
    get_location("<?php echo $get_single_sampling['Location']; ?>");
}); 
</script>
<?php } ?>
<?php if($SamplingID==''){ ?>
<script type="text/javascript">
$(document).ready(function(){
  $("#refreshInternalsamplingcode").click(function(){
    $('#InputInternalsamplingcode').removeClass('has-error');
    $('#InputInternalsamplingcode .help-block').html('');
    data = {};
    $.ajax({
        url: '<?php echo $baseurl; ?>/admin/refreshInternalsamplingcode',
        type: 'post',
        data: data,
        success: function(response) {
          var res = JSON.parse(response);
          if(res.status){
            $('#InputInternalsamplingcode').addClass('has-error');
            $('#InputInternalsamplingcode .help-block').html(res.message);
          }
          $('#Internalsamplingcode').val(res.code);
        }
    });
  });  
});  
function samplingeditsubmit (){
  var retValue = false;
  var Internalsamplingcode = $('#Internalsamplingcode').val();
  data = {'Internalsamplingcode':Internalsamplingcode};
  $.ajax({
      url: '<?php echo $baseurl; ?>/admin/check_Internalsamplingcode',
      type: 'post',
      global: false,
      async: false, //blocks window close
      data: data,
      success: function(response) {
        var res = JSON.parse(response);
        if(res.status){
          $('#InputInternalsamplingcode').addClass('has-error');
          $('#InputInternalsamplingcode .help-block').html(res.message);
          $('#Internalsamplingcode').focus();
          retValue = false;
        }else{
          retValue = true;
        }
      }
  });   
  return retValue;
}
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
  $('#submitbtn').on('click', function() {
    $("#samplingedit").submit();
  });
});
</script>
<script>
function goBack() {
  window.history.back();
}
</script>