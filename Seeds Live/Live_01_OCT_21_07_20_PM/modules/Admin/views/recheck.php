<?php include('common/header.php');?>

<div class="wrapper">

    <?php include('common/topbar.php');?>

    <?php include('common/left_sidebar.php');?>  

    <div class="content-wrapper">

      <!-- Content Header (Page header) -->

      <section class="content-header">
        <h1><?php echo $heading_title; ?></h1>
      </section>

      <?php 
        $Request_arr = array('1'=>'Request to supplier','2'=>'Received the seeds','3'=>'Close');
      ?>
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
                  <form method="get" action="<?php echo base_url(); ?>admin/recheck" id="filterform">
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
                    <th>Total number of seeds</th>
                    <!-- <th>By when</th> -->
                    <th>Requested Count</th>
                    <th>Requested Date</th>
                    <th>Received Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  <?php if(count($recheck) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($recheck as $value) { ?>
                    <?php 
                      // if(@$value['requestDate'] != ''){
                      //   $date = $value['requestDate'];  
                      //   $exdate = explode("/",$date); 
                      //   @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                      //   $NewrequestDate   =   date("d-F-Y", strtotime($newDate));
                      // }else{
                      //   $NewrequestDate = '';
                      // }

                       if($value['receivedDate'] != ''){
                        $date = $value['receivedDate'];  
                        $exdate = explode("/",$date); 
                        @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                        $NewreceivedDate   =   date("d-F-Y", strtotime($newDate));
                      }else{
                        $NewreceivedDate = '';
                      }
                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Crop']; ?></td>
                        <td><?php echo $value['Variety']; ?></td>
                        <td><?php echo $value['Supplier']; ?></td>
                        <td><?php echo $value['ttl_Numberofseeds']; ?></td>
                        <!-- <td><?php echo $value['Bywhen']; ?></td> -->
                        <td><?php echo $value['request_count']; ?></td>
                        <td><?php echo $value['requestDate']; ?></td>
                        <td><?php echo $NewreceivedDate; ?></td>
                        <td>
                          <form method="post" id="statusform" action="" style="text-align: center;">
                                
                                <?php foreach ($Request_arr as $Requestkey => $Requestvalue) { ?>
                                  <div style="text-align: left;">
                            
                                    <input type="radio" id="recheckstatus" class="recheck_class" data-toggle="modal" data-target=".recheckstatus_<?php echo $Requestkey.$cnt ?>" name="recheckstatus" value="<?php echo $Requestkey; ?>" <?php if ($value['recheckstatus'] == $Requestkey ) echo 'selected' ; ?> style = "margin-right: 10px;"><?php echo $Requestvalue; ?>

                                  </div>
                                  
                                <?php } ?>
                            
                                <!--  <select class="form-control" id="recheckstatus" name="recheckstatus" >
                                  <option value="">Please Select status</option>
                                  <?php foreach ($Request_arr as $Requestkey => $Requestvalue) { ?>
                                  <option value="<?php echo $Requestkey; ?>"  <?php if ($value['recheckstatus'] == $Requestkey ) echo 'selected' ; ?> ><?php echo $Requestvalue; ?></option>
                                  <?php } ?>
                                </select> -->

                                <br/>
                                <!-- Received -->
                                 <div class="modal fade recheckstatus_2<?php echo $cnt; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel">Are you sure you received all seeds</h3>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="addMenu" style="display: none; margin: 10px;">
                                          <label>How Many seeds you received</label>
                                          <div class="row">
                                            <div class="col-md-10" style="margin-left: 25px;">
                                              <input type="text" id="receivedStatus" name="receivedStatus" class="form-control">
                                            </div>
                                            <div class="col-md-1" align="right" style="align-content: right;">
                                              <button class="btn btn-success">ok</button>
                                            </div> 
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
                                          <button type="button" class="btn btn-warning notRecieved" >No</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <!-- Close -->
                                  <div class="modal fade recheckstatus_3<?php echo $cnt; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel">Please Select the status of that seed</h3>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <label>Select status </label>
                                          <select name ="closeStatus" class="form-control" id="closeStatus">
                                            <option value="drop">Drop</option>
                                            <option value="recheck">Re-check</option>
                                            <option value="precommercial">Pre-commercial</option>
                                          </select>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-warning" data-dismiss="modal">Ok</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              <button type="button" style="padding: 6px 20px;" class="form_btn btn btn-primary" data_id="<?php echo $value['RecheckID']; ?>">Update</button>
                          </form>
                        </td>
                        <td>
                          <a href="<?php echo base_url(); ?>admin/recheckedit/?RecheckID=<?php echo $value['RecheckID']; ?>"><button type="button" class="btn btn-default">Edit</button></a> 
                          <!-- <a href="<?php echo base_url(); ?>admin/deleterecheck/<?php echo $value['RecheckID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->
                          <a href="<?php echo base_url(); ?>/admin/rechecksummary?SeedID=<?php echo @$value['SeedID']; ?>&Variety=<?php echo @$value['Variety']; ?>"><button type="button" class="btn btn-default">Summary</button></a>

                          <button class="test_btn btn btn-danger" onClick="return doconfirm();" data_id="<?php echo $value['RecheckID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restorerecheck/<?php echo $value['RecheckID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                        </td>
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

          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div>

    <?php include('common/footer_content.php');?>

    <?php include('common/sidebar_control.php');?> 

</div>

<!-- ./wrapper -->

<?php include('common/footer.php');?>

<script>
  $(document).ready(function(){
 
 $('.form_btn').click(function(){
     var RecheckID = $(this).attr('data_id');
     var recheckstatus = $(this).closest('tr').find("input[name='recheckstatus']:checked").val();
     // alert(receivedStatus);

     // return false;
   $.ajax({
     url:'<?php echo base_url('admin/recheckstatus'); ?>',
     type: 'POST',
     dataType: 'json',
     data: {RecheckID: RecheckID,recheckstatus:recheckstatus},
     success: function(result){
      location.reload();
      // alert(result);
     }
  });
    return false;
 });
});
$(document).ajaxStop(function() {
        setInterval(function() {
            location.reload();
        }, 500);
    });
</script>

<script>
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deleterecheck'); ?>',
     method: 'post',
     data: {DeleteID: DeleteID},
     dataType: 'json',
     success: function(result){
      location.reload();
  
     }
  });
 });
});
// $(document).ajaxStop(function() {
//         setInterval(function() {
//             location.reload();
//         }, 500);
//     });
</script>
<script>
  $(document).ready(function(){
    $(".notRecieved").click(function(){
      $(".addMenu").toggle("slow");
    });
  });
</script>

