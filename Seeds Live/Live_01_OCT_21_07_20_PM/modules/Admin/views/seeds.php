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
        
        <!-- Filter Form -->
        <?php
          $Crop = $this->input->get('Crop');
          $Variety = $this->input->get('Variety');
          $Supplier = $this->input->get('Supplier'); 
          $getStatus = $this->input->get('Status');
          $FromDate  = $this->input->get('FromDate');
          $ToDate  = $this->input->get('ToDate');

        ?>
        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/seeds" id="filterform">
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

                      <div class="col-md-2">
                        <select class="form-control select2box" id="Status" name="Status">
                            <option value="" <?php echo "selected" ?>>-- Select Status --</option>
                            <?php foreach ($statusall as $keystatus => $valuestatus){?>
                            <option value="<?php echo $keystatus; ?>" 

                              <?php if($getStatus != ''){
                                       if (@$getStatus == $keystatus ) echo 'selected' ; 
                                    } ?> 

                              ><?php echo $valuestatus; ?></option>
                            <?php } ?>
                          </select>
                      </div> 
                    
                    </div>
                    <div class="row" style="margin-top:15px;">
                      <div class="col-md-2">
                          <input type="text" class="form-control" id="FromDate" name="FromDate" placeholder="From Date" value="<?php if(isset($FromDate)){ echo $FromDate; } ?>" autocomplete="off">
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" id="ToDate" name="ToDate" placeholder="To Date" value="<?php if(isset($ToDate)){ echo $ToDate; } ?>" autocomplete="off">
                      </div>  

                      <div class="col-md-4">
                          <button type="submit" style="padding: 6px 20px;" class="btn btn-primary">Filter</button>
                      
                        <?php if($userrole=='1' || $userrole=='4' || in_array("export", $userpermission)){ ?>
                        <?php 
                          if ($Crop!='' || $Variety!='' || $Supplier!='' || $getStatus!='' || $FromDate!='' || $ToDate!=''){
                            $getdata = http_build_query($_GET, '', "&");
                            $exporturl = base_url()."admin/seedsexport?".$getdata;
                          }else{
                            $exporturl = base_url()."admin/seedsexport";
                          }  
                        ?>
                        <a href="<?php echo $exporturl; ?>"><button type="button" style="padding: 6px 20px;margin-left: 8px;" class="btn btn-primary btn-export">Export Data</button></a>
                      </div>
                      <?php } ?>
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
                    <th>Supplier</th>
                    <th>Variety</th>
                    <th>Date of recieved sample</th>
                    <th>Status</th>
                    <th>Added date</th>
                    <?php if($userrole=='1' || $userrole=='4' || $userrole=='2'){ ?>
                    <th>Action</th>
                    <?php  } ?>
                  </tr>

                  <?php if(count($seeds) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($seeds as $value) { ?>
                    <?php
                    if($value['Dateofrecivedsampel'] != ''){
                          $date = $value['Dateofrecivedsampel'];
                          $exdate = explode("/",$date);
                          @$newDate =   $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                          $Dateofrecivedsampel   =   date("d-F-Y", strtotime($newDate));
                       }else{
                          $Dateofrecivedsampel = '';
                       }
                      if($value['AddedDate'] != ''){ 
                        $newAddDate = $value['AddedDate'];
                        $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                      }
                    ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Crop']; ?></td>
                        <td><?php echo $value['Supplier']; ?></td>
                        <td><?php echo $value['Variety']; ?></td>
                        <td><?php echo $Dateofrecivedsampel; ?></td>
                        <td><?php echo $value['Status']; ?></td> 
                        <td><?php echo $newAddDate1; ?></td>                       
                        <td>
                          <?php 
                            if(isset($_GET['Crop'])){
                              $rediret_url = current_url().'?'.http_build_query($_GET);
                            }else{
                              $rediret_url = current_url();
                            }
                            $redireturl = urlencode($rediret_url);
                          ?>
                          <?php if($userrole=='1' || $userrole=='4' || $userrole=='2'){ ?>
                         <!--  <a href="<?php echo base_url(); ?>/admin/sampling?Variety=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">View Sampling</button></a> -->
                          <?php if($value['Status']=='Commercial or control variety'){ ?>
                          <button class="btn btn-default btn-sm add_label_btn" item-name="<?php echo $value['Crop']; ?>" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value['SeedID']; ?>" >Add Label</button>
                          <?php } ?>
                          <a href="<?php echo base_url(); ?>admin/seedsummary?SeedID=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">View Sampling</button></a>  
                          <a href="<?php echo base_url(); ?>admin/seedsadd?SeedID=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">Add Seeds</button></a> 
                          <a href="<?php echo base_url(); ?>admin/seedstatus?SeedID=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">Change Status</button></a> 
                          <a href="<?php echo base_url(); ?>admin/seedrecord?SeedID=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">View Records</button></a> 
                          <a href="<?php echo base_url(); ?>admin/seedview/?SeedID=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">View</button></a> 
                          <a href="<?php echo base_url(); ?>admin/seededit/?SeedID=<?php echo $value['SeedID']; ?>&rediret_url=<?php echo $redireturl; ?>"><button type="button" class="btn btn-default">Edit</button></a>
                          <!-- <a href="<?php echo base_url(); ?>/admin/seedsummary?SeedID=<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-default">Summary</button></a> -->
                          <?php } ?>
                          <?php if($userrole=='1' || $userrole=='4'){ ?>
                          <!-- <a href="<?php echo base_url(); ?>admin/deleteseed/<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->

                           <button class="test_btn btn btn-danger" onClick="return doconfirm();" data_id="<?php echo $value['SeedID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button>
                          <?php } ?>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restoreseed/<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                        </td>
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

      <!-- Add LAbel Modal -->
        <div id="myModal" class="modal fade imagemodal" role="dialog">
          <div class="modal-dialog">
            <?php $success = $this->session->flashdata('success');  ?>
              <?php if(isset($success)){ ?>
            <div class="alert alert-success alert-dismissible" id="success_msg_id">
              <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
              <h4 style="margin-bottom: 0;">
                <i class="icon fa fa-check"></i> Image Upload SuccessFully..
              </h4>
            </div>
            <?php } ?>
            <form method="post" id="SeedFormID" enctype="multipart/form-data"  accept-charset="utf-8">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <input type="hidden" name="SeedID" class="SeedIDClass">
                <input type="hidden" name="GetSeedPicture" class="" id="GetSeedPictureID">
                <table id="table" class="table2" width="100%" style="margin: 0 auto;">
                  <tbody>
                    <tr class="add_row">
                      <td width="70%">
                        <input class="coverimage" name="SeedPicture" type="file" id="files">
                      </td>
                      <td class="text-center" width="30%">
                        <div class="imagePreview" style=""></div>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>  
                    <tr>
                      <td colspan="10">
                        <!-- <button class="btn btn-success btn-sm" type="button" id="add" title="Add new">Add new</button> -->
                        <button class="btn btn-success btn-sm" type="submit" title="Upload Image">Upload Image</button>  
                      </td>                                  
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      <!-- Add LAbel Modal -->

    </div>

    <?php include('common/footer_content.php');?>

    <?php include('common/sidebar_control.php');?> 

</div>

<!-- ./wrapper -->

<?php include('common/footer.php');?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".add_label_btn").click(function(e){
      var SeedID = $(this).attr('data-id');
      var ItemName = $(this).attr('item-name');
      $('.SeedIDClass').val(SeedID);
      $('.modal-title').text(ItemName);   
    });
  });
</script>
<script type="text/javascript">
  $(function() {
    $( "#FromDate" ).datepicker({
        dateFormat: "yy-mm-dd",
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
  $('#Status').on('change', function() {
    $("#filterform").submit();
  });  
}); 
</script>
<script>
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deleteseed'); ?>',
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

<!-- Development -->


<script type="text/javascript">
  $(document).ready(function(){ 
    $("#SeedFormID").submit(function(){
        // console.log('Ajax Working');
        $('#SeedFormID .form-group').removeClass('has-error');
        $('#SeedFormID .help-block').html('');
        var formData = new FormData(this);
        $.ajax({
            url: '<?php echo base_url('admin/seed_images_edit'); ?>',
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#success_msg_id').show();
                window.location.href = '';
            }
        });
        return false; 
    }); 
  });
</script>
<script src="<?php echo base_url(); ?>adminasset/js/select2.min.js"></script>