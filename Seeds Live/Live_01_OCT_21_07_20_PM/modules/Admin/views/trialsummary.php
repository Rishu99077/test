<?php include('common/header.php');?>
<style>
  .buttons_list{
    color: #fff;

    font-size: 20px;

    text-transform: uppercase;

    color: #12B13B;

    padding: 0px 15px;border: unset;
}
</style>
<div class="wrapper">

    <?php include('common/topbar.php');?>

    <?php include('common/left_sidebar.php');?>  

    <div class="content-wrapper">

      <!-- Content Header (Page header) -->

      <section class="content-header">
        <div class="row">
          <div class="col-md-11">
            <h1><?php echo $heading_title; ?></h1>
          </div>
          <div class="col-md-1">
            <div class="col-md-12 buttons_list"><button onclick="goBack()" style="background-color: #12B13B; color: #fff; width: 70px;" ><i class="fa fa fa-level-up" aria-hidden="true"></i>Back</button></div>
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

       <!--  <?php
          $Crop = $this->input->get('Crop');
          $Supplier = $this->input->get('Supplier');
          $Variety = $this->input->get('Variety');
          $Location = $this->input->get('Location');
          $Techncialteam  = $this->input->get('Techncialteam');
          $FromDate  = $this->input->get('FromDate');
          $ToDate  = $this->input->get('ToDate');
        ?> -->
       <!--  <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/trialsummary" id="filterform">
                    <div class="row">
                      <div class="col-md-2">
                          <select class="form-control select2box" id="Crop" name="Crop">
                            <option value="">-- Select Crop --</option>
                            <?php foreach ($crops as $crop_key => $crop_val) { ?>
                            <option value="<?php echo $crop_key; ?>" <?php if (@$Crop == $crop_key ) echo 'selected' ; ?> ><?php echo $crop_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <?php if($userrole=='1' || $userrole=='4'){ ?>
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
                      <?php } ?>
                      <div class="col-md-2">
                          <select class="form-control select2box" id="Location" name="Location">
                            <option value="">-- Select Location --</option>
                            <?php foreach ($locations as $val_locations) { ?>
                            <option value="<?php echo $val_locations; ?>" <?php if (@$Location == $val_locations) echo 'selected' ; ?> ><?php echo $val_locations; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      
                      <div class="col-md-2">
                        <select class="form-control select2box" id="Techncialteam" name="Techncialteam">
                            <option value="">-- Select Techncialteam --</option>
                            <?php foreach ($techncialteams as $techncialteam_key => $techncialteam_val) { ?>
                            <option value="<?php echo $techncialteam_key; ?>" <?php if (@$Techncialteam == $techncialteam_key ) echo 'selected' ; ?> ><?php echo $techncialteam_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="row" style="margin-top:15px;">  
                      <div class="col-md-2">
                          <input type="text" class="form-control"id="FromDate"  name="FromDate" placeholder="Date From" value="<?php if(isset($FromDate)){ echo $FromDate; } ?>" autocomplete="off">
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control"
                          id="ToDate" name="ToDate" placeholder="Date To" value="<?php if(isset($ToDate)){ echo $ToDate; } ?>" autocomplete="off">
                      </div>  
                      <div class="col-md-2">
                          <button type="submit" style="padding: 6px 20px;" class="btn btn-primary">Filter</button>
                      </div>  
                    </div>
                  </form>
                </div>
            </div>          
        </div> -->

        

        <div class="row">
          <div class="col-md-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>Supplier</th>
                   <!--  <th>Crop</th>
                    <th>Variety</th> -->
                    <th>Control variety</th>
                    <th>Location</th>
                    <th>Date of sowing</th>
                    <th>Date of Harvesting</th>
                    <?php if($userrole=='1' || $userrole=='4'){  ?>
                    <th>Generate Report</th>
                    <?php } ?>
                    <?php if($userrole=='1' || $userrole=='2' || $userrole=='4' || $userrole=='5' || $userrole=='7'){ ?>
                    <th>Action</th>
                    <?php  } ?>
                  </tr>

                  <?php if(count($trial) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($trial as $value) { ?>
                    <?php 
                      if($value['Dateofsowing'] != ''){
                        $newAddDate = $value['Dateofsowing'];
                        $NewDateofsowing = date("d-F-Y",strtotime($newAddDate));
                        }else{
                       $NewDateofsowing = '';
                      }
                      
                      if($value['Estimatedharvestingdate'] != ''){
                        $newAddDate = $value['Estimatedharvestingdate'];
                        $NewEstimatedharvestingdate = date("d-F-Y",strtotime($newAddDate));
                        }else{
                        $NewEstimatedharvestingdate = '';
                      }

                      // if(@$_GET['FromDate']=='' || @$_GET['ToDate']=='')
                      // {
                      //     if($value['Date'] != ''){
                      //     $date = $value['Date'];  
                      //     $exdate = explode("/",$date); 
                      //     @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                      //     $newDatetrail =   date("d-F-Y", strtotime($newDate));
                      //   }else{
                      //     $newDatetrail = '';
                      //   }
                      // }
                      // else
                      // {
                      //      if($value['Date'] != ''){
                      //       $date = $value['Date'];  
                      //       $exdate = explode("/",$date); 
                      //       @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                      //       $newDatetrail =   date("d-F-Y", strtotime($newDate));
                      //     }else{
                      //       $newDatetrail = '';
                      //       }
                      // }

                    ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['SupplierName']; ?></td>
                       <!--  <td><?php echo $value['CropTitle']; ?></td>
                        <td><?php echo $value['SeedVariety']; ?></td> -->
                        <td><?php echo $value['Controlvariety']; ?></td>
                        <td><?php echo $value['Location']; ?></td>
                        <td><?php echo $NewDateofsowing; ?></td>
                        <td><?php echo $NewEstimatedharvestingdate; ?></td>
                        <?php if($userrole=='1' || $userrole=='4'){  ?>
                        <td>
                          <a href="<?php echo base_url(); ?>admin/trialreport/?TrialID=<?php echo $value['TrialID']; ?>"><i class="fa fa-file" aria-hidden="true"></i></a>
                        </td>
                        <?php } ?>  
                        <td>
                          <?php if($userrole=='1' || $userrole=='2' || $userrole=='4' || $userrole=='5' || $userrole=='7'){ ?>
                          <a href="<?php echo base_url(); ?>admin/trialview/?TrialID=<?php echo $value['TrialID']; ?>"><button type="button" class="btn btn-default">View</button></a> 
                          <a href="<?php echo base_url(); ?>admin/trialedit/?TrialID=<?php echo $value['TrialID']; ?>"><button type="button" class="btn btn-default">Edit</button></a> 
                          <?php } ?>
                          <?php if($userrole=='1' || $userrole=='4'){ ?>
                          <!-- <a href="<?php echo base_url(); ?>admin/deletetrial/<?php echo $value['TrialID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->

                          <button class="test_btn btn btn-danger" onClick="return doconfirm();" data_id="<?php echo $value['TrialID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restoretrial/<?php echo $value['TrialID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                          <?php } ?>
                        </td>
                      </tr>
                  <?php $cnt++; } ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="12"> Record Not Found </td>
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
      </section><!-- /.content -->
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
}); 
</script>
<script>
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deletetrial'); ?>',
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