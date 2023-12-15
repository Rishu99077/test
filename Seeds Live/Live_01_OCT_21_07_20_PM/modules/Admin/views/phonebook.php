<?php include('common/header.php');?>

<div class="wrapper">

    <?php include('common/topbar.php');?>

    <?php include('common/left_sidebar.php');?>  

    <div class="content-wrapper">
        <?php
          $Name = $this->input->get('Name');
          $Email = $this->input->get('Email');
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
                  if ($Name!='' || $Email!=''){
                    $getdata = http_build_query($_GET, '', "&");
                    $exporturl = base_url()."admin/phonebookexport?".$getdata;
                  }else{
                    $exporturl = base_url()."admin/phonebookexport";
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

        <div class="row">
            <div class="col-md-12">
               <div class="samples-filter">
                  <form method="get" action="<?php echo base_url(); ?>admin/phonebook" id="filterform">
                    <div class="row">
                      <div class="col-md-2">
                          <select class="form-control select2box" id="Name" name="Name">
                            <option value="">-- Select Name --</option>
                            <?php foreach ($names as $name_key => $name_val) { ?>
                            <option value="<?php echo $name_val; ?>" <?php if (@$Name == $name_val ) echo 'selected' ; ?> ><?php echo $name_val; ?></option>
                            <?php } ?>
                          </select>
                      </div>

                      <div class="col-md-2">
                        <select class="form-control select2box" id="Email" name="Email">
                            <option value="">-- Select Email --</option>
                            <?php foreach ($emails as $email_key => $email_val) { ?>
                            <option value="<?php echo $email_val; ?>" <?php if (@$Email == $email_val ) echo 'selected' ; ?> ><?php echo $email_val; ?></option>
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
                  <tr class="bg-info">
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Family Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postcode</th>
                    <th>Email</th>
                    <th>Issue</th>
                    <th>Action</th>
                  </tr>
                  <?php if(count($phonebook) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($phonebook as $key => $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['family_name']; ?></td>
                        <td><?php echo $value['mobile1']; ?></td>
                        <td><?php echo $value['address']; ?></td>
                        <td><?php echo $value['city']; ?></td>
                        <td><?php echo $value['postcode']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td><?php echo $value['issue']; ?></td>
                        <td>
                           <a href="<?php echo base_url(); ?>admin/phonebookedit/<?php echo $value['PhonebookID']; ?>"> 
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                          </a> 
                         <a href="<?php echo base_url(); ?>admin/deletephonebook/<?php echo $value['PhonebookID']; ?>"> 
                            <i class="fa fa-trash-o" aria-hidden="true" onClick="return doconfirm();"></i> 
                          </a>
                        </td>
                      </tr>
                      <?php $cnt++; } ?>
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
  $(document).ready(function(){
 
 $('.test_btn').click(function(){
     var DeleteID = $(this).attr('data_id');
   $.ajax({
     url:'<?php echo base_url('admin/deleteprecommercial'); ?>',
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