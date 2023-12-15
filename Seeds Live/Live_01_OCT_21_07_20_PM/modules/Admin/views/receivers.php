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
          $Name = $this->input->get('Name');
          $Province = $this->input->get('Province');
          $Mobile1 = $this->input->get('Mobile1');
        ?>
        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/receivers" id="filterform">
                    <div class="row">
                      <div class="col-md-2">
                          <select class="form-control select2box" id="Name" name="Name">
                            <option value="">-- Select Name --</option>
                            <?php foreach ($receivers_name as $receiver_name) { ?>
                            <option value="<?php echo $receiver_name; ?>" <?php if (@$Name == $receiver_name) echo 'selected' ; ?> ><?php echo $receiver_name; ?></option>
                            <?php } ?>
                          </select>
                      </div>

                      <div class="col-md-2">
                          <select class="form-control select2box" id="Province" name="Province">
                            <option value="">-- Select Province --</option>
                            <?php foreach ($receivers_province as $receiver_province) { ?>
                            <option value="<?php echo $receiver_province; ?>" <?php if (@$Province == $receiver_province) echo 'selected' ; ?> ><?php echo $receiver_province; ?></option>
                            <?php } ?>
                          </select>
                      </div>

                      <div class="col-md-2">
                          <select class="form-control select2box" id="Mobile1" name="Mobile1">
                            <option value="">-- Select Mobile1 --</option>
                            <?php foreach ($receivers_mobile1 as $receiver_mobile1) { ?>
                            <option value="<?php echo $receiver_mobile1; ?>" <?php if (@$Mobile1 == $receiver_mobile1) echo 'selected' ; ?> ><?php echo $receiver_mobile1; ?></option>
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
                    <th>Name</th>
                    <th>Activity</th>
                    <th>Province</th>
                    <th>Mobile 1</th>
                    <!-- <th>Address</th> -->
                    <th>Action</th>
                  </tr>

                  <?php if(count($receivers) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($receivers as $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Name']; ?></td>
                        <td><?php echo $value['Activity']; ?></td>
                        <td><?php echo $value['Province']; ?></td>
                        <td><?php echo $value['Mobile1']; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>admin/receiverview/?ReceiverID=<?php echo $value['ReceiverID']; ?>"><button type="button" class="btn btn-default">View</button></a> 
                          <a href="<?php echo base_url(); ?>admin/receiveredit/?ReceiverID=<?php echo $value['ReceiverID']; ?>"><button type="button" class="btn btn-default">Edit</button></a> 
                          <!-- <a href="<?php echo base_url(); ?>admin/deletereceiver/<?php echo $value['ReceiverID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a> -->
      
                          <button class="test_btn btn btn-danger" onClick="return doconfirm();" data_id="<?php echo $value['ReceiverID']; ?>"><?php if($userrole=='1'){ ?>Permanently <?php } ?>Delete </button>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restorereceiver/<?php echo $value['ReceiverID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>
                        </td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="10"> Record Not Found </td>
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
$(document).ready(function(){
  $('#Name').on('change', function() {
    $("#filterform").submit();
  });
  $('#Province').on('change', function() {
    $("#filterform").submit();
  });
  $('#Mobile1').on('change', function() {
    $("#filterform").submit();
  });
}); 
</script>
<script>
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deletereceiver'); ?>',
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