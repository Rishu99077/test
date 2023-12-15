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

        <!-- Info boxes -->

        <?php
          $Crop = $this->input->get('Crop');
          $Supplier = $this->input->get('Supplier');
          $Variety = $this->input->get('Variety');
         
        ?>
        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/evaluationclose" id="filterform">
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
                          <button type="submit" style="padding: 6px 20px;" class="btn btn-primary">Filter</button>
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
                    <?php if($userrole=='1' || $userrole=='4'){ ?>
                    <th>Supplier Name</th>
                    <th>Variety Name</th>
                    <?php } ?>
                    <th>Crop</th>
                   
                    <?php if($userrole=='1' || $userrole=='4' || $userrole=='7'){ ?>
                  <!--   <?php if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("export", $userpermission)){ ?>
                    <th>Report Generate</th>
                    <?php } ?> -->
                    <?php } ?>
                    <?php if($userrole=='1' || $userrole=='4' || $userrole=='2' || $userrole=='7' || $userrole=='5'){ ?>
                    <?php  } ?>
                  </tr>

                  <?php if(count($evaluation) > 0) { ?>
                  <?php $cnt = 1;?>

                  <?php foreach ($evaluation as $value) { 
                       if($value['Dateofvisit'] != ''){
                          $date = $value['Dateofvisit'];
                          $exdate = explode("/",$date); 
                          $newDate       =   $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                          $newDate1   =   date("d-F-Y", strtotime($newDate));
                       }else{
                          $newDate1 = '';
                       }
                        
                        if(@$_GET['FromDate']=='' || @$_GET['ToDate']==''){
                            $newAddDate = $value['AddedDate'];
                            $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                          }
                        else{
                          $newAddDate = $value['evaluation_AddedDate'];
                          $newAddDate1 = date("d-F-Y",strtotime($newAddDate)); 
                        }

                  ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <?php if($userrole=='1' || $userrole=='4'){ ?>
                        <td><?php echo @$value['SupplierName'];  ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/viewcloseevaluation/?Variety=<?php echo $value['VarietyID']; ?>"><?php echo $value['Varity']; ?></a></td>
                        <?php } ?> 
                        <td><?php echo $value['Crop']; ?></td>
            
                        <?php if($userrole=='1' || $userrole=='4' || $userrole=='7'){ ?>
                        <!-- <?php if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("export", $userpermission)){ ?> 
                        <td>
                          <a href="<?php echo base_url(); ?>admin/evaluationreport/?EvaluationID=<?php echo $value['EvaluationID']; ?>"><i class="fa fa-file" aria-hidden="true"></i></a>
                        </td>  
                        <?php } ?> -->
                        <?php } ?>
                      
                       <!--  <td> -->
                          <!--  <?php if($userrole=='1' || $userrole=='2' || $userrole=='4' || $userrole=='5' || $userrole=='7'){ ?>
                          <a href="<?php echo base_url(); ?>admin/evaluationview/?EvaluationID=<?php echo $value['EvaluationID']; ?>"><button type="button" class="btn btn-default">View</button></a> 

                          <a href="<?php echo base_url(); ?>admin/evaluationedit/?EvaluationID=<?php echo $value['EvaluationID']; ?>"><button type="button" class="btn btn-default">Edit</button></a> 
                          <?php } ?>
                          <?php if($userrole=='1' || $userrole=='4'){ ?> -->

                          <!-- <a href="<?php //echo base_url(); ?>admin/deleteevaluation/<?php echo $value['EvaluationID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->
                          
                      <!--   <button class="test_btn btn btn-danger" onClick="return doconfirm();" data_id="<?php echo $value['EvaluationID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button>
                          <?php } ?>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restoreevaluation/<?php echo $value['EvaluationID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                        </td> -->
                      </tr>
                  <?php $cnt++; }  ?> 
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
     url:'<?php echo base_url('admin/deleteevaluation'); ?>',
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