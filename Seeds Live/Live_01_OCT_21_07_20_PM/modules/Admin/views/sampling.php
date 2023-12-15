<?php include('common/header.php');?>

<div class="wrapper">

    <?php include('common/topbar.php');?>

    <?php include('common/left_sidebar.php');?>  

    <div class="content-wrapper">

      <?php
        $Crop = $this->input->get('Crop');
        $Variety = $this->input->get('Variety');
        $Supplier = $this->input->get('Supplier');
        $Location = $this->input->get('Location');
        $Receiver  = $this->input->get('Receiver');
        $Techncialteam  = $this->input->get('Techncialteam');
        $FromDate  = $this->input->get('FromDate');
        $ToDate  = $this->input->get('ToDate');

        $SowingFromDate  = $this->input->get('SowingFromDate');
        $SowingToDate  = $this->input->get('SowingToDate');

        $HarvestFromDate  = $this->input->get('HarvestFromDate');
        $HarvestToDate  = $this->input->get('HarvestToDate');

        $TransplantFromDate  = $this->input->get('TransplantFromDate');
        $TransplantToDate  = $this->input->get('TransplantToDate');

        $DeliveryFromDate  = $this->input->get('DeliveryFromDate');
        $DeliveryToDate  = $this->input->get('DeliveryToDate');

        $Internalsamplingcode  = $this->input->get('Internalsamplingcode');

          $filters = array(
            '0' => 'Added Date',
            '1' => 'Sowing Date',
            '2' => 'Harvesting Date',
            '3' => 'Transplant Date',
            '4' => 'Delivery Date',
          );
        ?>

      <!-- Content Header (Page header) -->

      <section class="content-header">
        <div class="row">
          <div class="col-md-6">
              <h1><?php echo $heading_title; ?></h1>
          </div>
          <div class="col-md-6">
              <?php if($userrole=='1' || $userrole=='4' || in_array("export", $userpermission)){ ?>
                <?php 
                  if ($Crop!='' || $Variety!='' || $Supplier!='' || $Location!='' || $Receiver!=''  || $Techncialteam!='' || $FromDate!='' || $ToDate!='' || $Internalsamplingcode!=''){
                    $getdata = http_build_query($_GET, '', "&");
                    $exporturl = base_url()."admin/samplingsexport?".$getdata;
                  }else{
                    $exporturl = base_url()."admin/samplingsexport";
                  }  
                ?>
                <a href="<?php echo $exporturl; ?>" style="float: right;"><button type="button" style="padding: 6px 20px;" class="btn btn-primary btn-export">Export Data</button></a>
              <?php } ?>
          </div>
        </div>
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

        <!-- Filter Form -->        
        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter" style="padding-bottom: 0px;">
                  <form method="get" action="<?php echo base_url(); ?>admin/sampling" id="filterform">
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
                            <?php foreach ($seeds as $seedkey=>$seedval) { ?>
                            <option value="<?php echo $seedkey; ?>" <?php if (@$Variety == $seedkey ) echo 'selected' ; ?> ><?php echo $seedval; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-2">
                          <select class="form-control select2box" id="Location" name="Location">
                            <option value="">-- Select Location --</option>
                            <?php foreach ($locations as $val_locations) { ?>
                            <option value="<?php echo $val_locations; ?>" <?php if (@$Location == $val_locations) echo 'selected' ; ?> ><?php echo $val_locations; ?></option>
                            <?php } ?>
                          </select>
                      </div>                      
                      <div class="col-md-2">
                        <select class="form-control select2box" id="Receiver" name="Receiver">
                            <option value="">-- Select Receiver --</option>
                            <?php foreach ($receivers as $receiver_key => $receiver_val) { ?>
                            <option value="<?php echo $receiver_key; ?>" <?php if (@$Receiver == $receiver_key ) echo 'selected' ; ?> ><?php echo $receiver_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-2">
                        <select class="form-control select2box" id="Techncialteam" name="Techncialteam">
                            <option value="">-- Select Techncial Team --</option>
                            <?php foreach ($techncialteams as $techncialteam_key => $techncialteam_val) { ?>
                            <option value="<?php echo $techncialteam_key; ?>" <?php if (@$Techncialteam == $techncialteam_key ) echo 'selected' ; ?> ><?php echo $techncialteam_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>                      
                    </div>
                    <div class="row" style="margin-top:15px;">
                      <div class="col-md-2">
                           <select class="form-control select2box"  name="Filter" id="Filter">
                              <?php foreach ($filters as $key => $value) { ?>
                                  <option value="<?php echo $key ?>"
                                    <?php if ($this->input->get('Filter') == $key ) echo 'selected' ; ?>><?php echo $value ?>
                                  </option>
                              <?php } ?>
                          </select>
                      </div>  
                    
                      <?php if(@$_GET['Filter']==0){ ?>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="FromDate"  name="FromDate" placeholder="Date From" value="<?php if(isset($FromDate)){ echo $FromDate; } ?>" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="ToDate" name="ToDate" placeholder="Date To" value="<?php if(isset($ToDate)){ echo $ToDate; } ?>" autocomplete="off">
                        </div>
                      <?php } ?>
                       <?php if(@$_GET['Filter']==1){ ?>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="SowingFromDate"  name="SowingFromDate" placeholder="Date From" value="<?php if(isset($SowingFromDate)){ echo $SowingFromDate; } ?>" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="SowingToDate" name="SowingToDate" placeholder="Date To" value="<?php if(isset($SowingToDate)){ echo $SowingToDate; } ?>" autocomplete="off">
                        </div>
                      <?php } ?>
                       <?php if(@$_GET['Filter']==2){ ?>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="HarvestFromDate"  name="HarvestFromDate" placeholder="Date From" value="<?php if(isset($HarvestFromDate)){ echo $HarvestFromDate; } ?>" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="HarvestToDate" name="HarvestToDate" placeholder="Date To" value="<?php if(isset($HarvestToDate)){ echo $HarvestToDate; } ?>" autocomplete="off">
                        </div>
                      <?php } ?>
                       <?php if(@$_GET['Filter']==3){ ?>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="TransplantFromDate"  name="TransplantFromDate" placeholder="Date From" value="<?php if(isset($TransplantFromDate)){ echo $TransplantFromDate; } ?>" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="TransplantToDate" name="TransplantToDate" placeholder="Date To" value="<?php if(isset($TransplantToDate)){ echo $TransplantToDate; } ?>" autocomplete="off">
                        </div>
                      <?php } ?>
                      <?php if(@$_GET['Filter']==4){ ?>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="DeliveryFromDate"  name="DeliveryFromDate" placeholder="Date From" value="<?php if(isset($DeliveryFromDate)){ echo $DeliveryFromDate; } ?>" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="DeliveryToDate" name="DeliveryToDate" placeholder="Date To" value="<?php if(isset($DeliveryToDate)){ echo $DeliveryToDate; } ?>" autocomplete="off">
                        </div>
                      <?php } ?>
                      <div class="col-md-4">
                          <button type="submit" style="padding: 6px 20px;" class="btn btn-primary">Filter</button>
                      </div>
                    </div>
                  </form>
                </div>
            </div>          
        </div>

        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/sampling" id="filterform">
                    <div class="row">  
                      <div class="col-md-2">
                          <input type="text" class="form-control"id="Internalsamplingcode"  name="Internalsamplingcode" placeholder="Internal sampling code" value="<?php if(isset($Internalsamplingcode)){ echo $Internalsamplingcode; } ?>" autocomplete="off">
                      </div>
                      <div class="col-md-4">
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
                    <th>Internalsamplingcode</th>
                    <th>Crop</th>
                    <th>Variety</th>
                    <th>Control variety</th>
                    <th>Location</th>
                    <th>Date of sowing</th>
                    <th>Date of transplanted</th>
                    <th>Estimated harvesting date</th>
                    <th>Deliverydate</th>
                    <th>Description</th>
                    <th>Technicalnotes</th>
                     <?php if($userrole=='1' || $userrole=='4' || $userrole=='2'){ ?>
                    <th>Action</th>
                    <?php  } ?>
                  </tr>

                  <?php if(count($samplings) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($samplings as $value) {

                    ?>

                    <?php 
                      // if($value['Dateofsowing'] != ''){
                      //   $date = $value['Dateofsowing'];  
                      //  $exdate = explode("/",$date); 
                      //  $newDate = $exdate[0].'-'.$exdate[1].'-'.$exdate[2];
                      //  $NewDateofvisit   =   date("d-F-Y", strtotime($newDate));
                      // }else{
                      //  $NewDateofvisit = '';
                      // }
                      if($value['Dateofsowing'] != ''){
                        $newAddDate = $value['Dateofsowing'];
                        $NewDateofvisit = date("d-F-Y",strtotime($newAddDate));
                        }else{
                       $NewDateofvisit = '';
                      }

                      // if($value['Dateoftransplanted'] != ''){
                      //   $date = $value['Dateoftransplanted'];  
                      //  $exdate = explode("/",$date); 
                      //  $newDate = $exdate[0].'-'.$exdate[1].'-'.$exdate[2];
                      //  $NewDateoftransplanted =   date("d-F-Y", strtotime($newDate));
                      // }else{
                      //  $NewDateoftransplanted = '';
                      // }

                      if($value['Dateoftransplanted'] != ''){
                        $newAddDate = $value['Dateoftransplanted'];
                        $NewDateoftransplanted = date("d-F-Y",strtotime($newAddDate));
                        }else{
                        $NewDateoftransplanted = '';
                      }

                  
                      // if($value['Estimatedharvestingdate'] != ''){
                      //   $date = $value['Estimatedharvestingdate'];  
                      //  $exdate = explode("/",$date); 
                      //  $newDate = $exdate[0].'-'.$exdate[1].'-'.$exdate[2];
                      //  $NewEstimatedharvestingdate =   date("d-F-Y", strtotime($newDate));
                      // }else{
                      //  $NewEstimatedharvestingdate = '';
                      // }

                      if($value['Estimatedharvestingdate'] != ''){
                        $newAddDate = $value['Estimatedharvestingdate'];
                        $NewEstimatedharvestingdate = date("d-F-Y",strtotime($newAddDate));
                        }else{
                        $NewEstimatedharvestingdate = '';
                      }

                      if($value['Deliverydate'] != ''){
                        $newAddDate = $value['Deliverydate'];
                        $NewDeliverydate = date("d-F-Y",strtotime($newAddDate));
                        }else{
                        $NewDeliverydate = '';
                      }

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Internalsamplingcode']; ?></td>
                        <td><?php echo $value['get_crop']['Title']; ?></td>
                        <td><?php echo $value['Seed']; ?></td>
                        <td><?php echo $value['Controlvariety']; ?></td>
                        <td><?php echo $value['Location']; ?></td>
                        <td><?php echo $NewDateofvisit; ?></td>
                        <td><?php echo $NewDateoftransplanted; ?></td>
                        <td><?php echo $NewEstimatedharvestingdate; ?></td>
                        <td><?php echo $NewDeliverydate; ?></td>
                        <td><?php echo $value['Description']; ?></td>
                        <td><?php echo $value['Technicalnotes']; ?></td>
                        <td>
                          <?php if($userrole=='1' || $userrole=='4' || $userrole=='2'){ ?>
                          <a href="<?php echo base_url(); ?>admin/samplingview/?SamplingID=<?php echo $value['SamplingID']; ?>"><button type="button" class="btn btn-default" style="margin-bottom: 10px; width: 100%;">View</button></a> 
                          <a href="<?php echo base_url(); ?>admin/trial/?Internalsamplingcode=<?php echo $value['Internalsamplingcode']; ?>"><button type="button" class="btn btn-default" style="margin-bottom: 10px; width: 100%;">View Trial</button></a>
                           <a href="<?php echo base_url(); ?>admin/evaluation/?Internalsamplingcode=<?php echo $value['Internalsamplingcode']; ?>"><button type="button" class="btn btn-default" style="margin-bottom: 10px; width: 100%;">View Evaluation</button></a> 
                          <?php 
                            if(isset($_GET['Crop'])){
                              $rediret_url = current_url().'?'.http_build_query($_GET);
                            }else{
                              $rediret_url = current_url();
                            }
                            $redireturl = urlencode($rediret_url);
                          ?>
                          <a href="<?php echo base_url(); ?>admin/samplingedit/?SamplingID=<?php echo $value['SamplingID']; ?>&rediret_url=<?php echo $redireturl; ?>"><button type="button" class="btn btn-default" style="margin-bottom: 10px; width: 100%;">Edit</button></a> 
                          <?php } ?>
                          <?php if($userrole=='1' || $userrole=='4'){ ?>
                          <!-- <a href="<?php echo base_url(); ?>admin/deletesampling/<?php echo $value['SamplingID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();" style="width: 100%;"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->

                          <button class="test_btn btn btn-danger" onClick="return doconfirm();" style="width: 100%;" data_id="<?php echo $value['SamplingID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button>
                          <?php } ?>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restoresampling/<?php echo $value['SamplingID']; ?>"><button style="margin-top: 10px; width: 100%;" type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                        </td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="13"> Record Not Found </td>
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
$(function() {
    $( "#FromDate" ).datepicker({
        dateFormat:"yy-mm-dd",
    });
    $( "#ToDate" ).datepicker({
      dateFormat: "yy-mm-dd",
    });
});  
$(function() {
    $( "#SowingFromDate" ).datepicker({
        dateFormat:"yy-mm-dd",
    });
    $( "#SowingToDate" ).datepicker({
     dateFormat:"yy-mm-dd",
    });
});  

$(function() {
    $( "#HarvestFromDate" ).datepicker({
        dateFormat:"yy-mm-dd",
    });
    $( "#HarvestToDate" ).datepicker({
     dateFormat:"yy-mm-dd",
    });
});  

$(function() {
    $( "#TransplantFromDate" ).datepicker({
        dateFormat:"yy-mm-dd",
    });
    $( "#TransplantToDate" ).datepicker({
     dateFormat:"yy-mm-dd",
    });
});

$(function() {
    $( "#DeliveryFromDate" ).datepicker({
        dateFormat:"yy-mm-dd",
    });
    $( "#DeliveryToDate" ).datepicker({
     dateFormat:"yy-mm-dd",
    });
});  

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
  $('#Location').on('change', function() {
    $("#filterform").submit();
  });
  $('#Techncialteam').on('change', function() {
    $("#filterform").submit();
  });
  $('#Filter').on('change', function() {
    $("#filterform").submit();
  });
  
}); 
</script>
<script>
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deletesampling'); ?>',
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
<script>

function goBack() {

  window.history.back();

}

</script>
<script>
  $(".clear").click(function() {
    $(this).closest('form').find(".clear_data").val("");
  });
</script>