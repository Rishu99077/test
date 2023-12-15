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

        <!-- Info boxes -->

        <div class="row">
          <div class="col-md-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>Title</th>
                    <th>Action</th>
                  </tr>

                  <?php if(count($controlvariety) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($controlvariety as $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Title']; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>admin/controlvarietyedit/?ControlvarietyID=<?php echo $value['ControlvarietyID']; ?>"><button type="button" class="btn btn-default">Edit</button></a> 
                          <a href="<?php echo base_url(); ?>admin/deletecontrolvariety/<?php echo $value['ControlvarietyID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();"><?php if($userrole=='1'){ ?>Permanently <?php } ?> Delete</button></a>
                          <?php if($userrole=='1' AND $value['is_deleted']=='1'){ ?>
                            <a href="<?php echo base_url(); ?>admin/restorecontrolvariety/<?php echo $value['ControlvarietyID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                          <?php } ?>  
                        </td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="3"> Record Not Found </td>
                    </tr>
                  <?php } ?> 

                </table>
              </div>
              <div class="pagination_main"><?php echo $links; ?></div>
          </div> <!-- /.col -->
        </div><!-- /.row -->
      </section>
      <!-- /.content -->
    </div>

    <?php include('common/footer_content.php');?>

    <?php include('common/sidebar_control.php');?> 

</div>

<!-- ./wrapper -->

<?php include('common/footer.php');?>