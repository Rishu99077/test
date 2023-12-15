<?php include('common/header.php');?>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="float: left;"><?php echo $heading_title; ?></h1>
        <a style="float: right; margin-top: 10px;" href="<?php echo base_url(); ?>admin/clearlogs">clear all logs</a>
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
        <div class="row">
          
          <div class="col-md-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>User Name</th>
                    <th>IP Address</th>
                    <th>Source</th>
                    <th>Module</th>
                    <th>Activity</th>
                    <th>Title</th>
                    <th>Date</th>
                  </tr>

                  <?php if(count($logs) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($logs as $key => $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['username']; ?></td>
                        <td><?php echo $value['ipaddress']; ?></td>
                        <td><?php echo $value['Source']; ?></td>
                        <td><?php echo $value['Module']; ?></td>
                        <td><?php echo $value['Activity']; ?></td>
                        <td><?php echo $value['Title']; ?></td>
                        <td><?php echo $value['Createdate']; ?></td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="8"> Record Not Found </td>
                    </tr>
                  <?php } ?>

                </table>
              </div>
              <?php if(count($logs)>0){ ?> 
              <div class="row">
                <div class="col-md-6">
                  <div class="total_rows"><?php echo $result_count; ?></div>
                </div>
                <div class="col-md-6">
                  <div class="pagination_main"><?php echo $links; ?></div>
                </div>
              </div>
              <?php } ?>
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