<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fefefe;border: unset;}
  textarea {border: 1px solid #fefefe;}
  ul.buttons_list {margin-top: 30px;padding: 0;list-style: none;text-align: right;}
  ul.buttons_list li {display: inline-block;}
  ul.buttons_list li a {color: #fff;font-size: 20px;text-transform: uppercase;background: #12B13B;padding: 5px 15px;}
  ul.buttons_list li a i {color: #fff;padding-right: 5px;font-size: 15px;}
</style>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-9">
                  <h1><?php echo $heading_title; ?></h1>
                </div>
                <div class="col-md-3">
                  <ul class="buttons_list">
                    <li><a href="<?php echo base_url('admin/receivers'); ?>">
                        <i class="fa fa fa-level-up" aria-hidden="true"></i>
                        Back
                        </a>
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
                <form role="form" id="receiveredit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group <?php if($error['Name']!=''){ echo 'has-error'; } ?>" id="InputName">
                      <label for="" class="required">Name</label>
                      <input type="text" readonly="readonly" class="form-control" id="Name" name="Name" placeholder="Name" value="<?php echo $get_receiver['Name']; ?>">
                      <span class="help-block"><?php if($error['Name']!=''){ echo $error['Name']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Activity']!=''){ echo 'has-error'; } ?>" id="InputActivity">
                      <label for="" class="required">Activity</label>
                      <input type="text" readonly="readonly" class="form-control" id="Activity" name="Activity" placeholder="Activity" value="<?php echo $get_receiver['Activity']; ?>">
                      <span class="help-block"><?php if($error['Activity']!=''){ echo $error['Activity']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Province']!=''){ echo 'has-error'; } ?>" id="InputProvince">
                      <label for="" class="required">Province</label>
                      <input type="text" readonly="readonly" class="form-control" id="Province" name="Province" placeholder="Province" value="<?php echo $get_receiver['Province']; ?>">
                      <span class="help-block"><?php if($error['Province']!=''){ echo $error['Province']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Telphone1']!=''){ echo 'has-error'; } ?>" id="InputTelphone1">
                      <label for="" class="">Telphone 1</label>
                      <input type="text" readonly="readonly" class="form-control" id="Telphone1" name="Telphone1" placeholder="Telphone 1" value="<?php echo $get_receiver['Telphone1']; ?>">
                      <span class="help-block"><?php if($error['Telphone1']!=''){ echo $error['Telphone1']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Telphone2']!=''){ echo 'has-error'; } ?>" id="InputTelphone2">
                      <label for="" class="">Telphone 2</label>
                      <input type="text" readonly="readonly" class="form-control" id="Telphone2" name="Telphone2" placeholder="Telphone 2" value="<?php echo $get_receiver['Telphone2']; ?>">
                      <span class="help-block"><?php if($error['Telphone2']!=''){ echo $error['Telphone2']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Mobile1']!=''){ echo 'has-error'; } ?>" id="InputMobile1">
                      <label for="" class="required">Mobile 1</label>
                      <input type="text" readonly="readonly" class="form-control" id="Mobile1" name="Mobile1" placeholder="Mobile 1" value="<?php echo $get_receiver['Mobile1']; ?>">
                      <span class="help-block"><?php if($error['Mobile1']!=''){ echo $error['Mobile1']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Mobile2']!=''){ echo 'has-error'; } ?>" id="InputMobile2">
                      <label for="" class="">Mobile 2</label>
                      <input type="text" readonly="readonly" class="form-control" id="Mobile2" name="Mobile2" placeholder="Mobile 2" value="<?php echo $get_receiver['Mobile2']; ?>">
                      <span class="help-block"><?php if($error['Mobile2']!=''){ echo $error['Mobile2']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Address']!=''){ echo 'has-error'; } ?>" >
                      <label for="picture" class="">Address</label>
                      <?php 
                        if($get_receiver['Address']!=''){
                          $get_Address = json_decode($get_receiver['Address']);
                        }else{
                          $get_Address = array();
                        }
                      ?>
                      <table id="table" class="table1" width="100%" style="margin: 0 auto;">
                        <thead>
                        </thead>
                        <tbody class="tbodyAddress">
                          <?php 
                          foreach($get_Address as $value){ ?>
                            <tr class="add_row"><td ><textarea  name="Address[]" type="text" readonly="readonly" id="Address" placeholder="Address" /><?php echo $value; ?></textarea></td></tr>
                          <?php  } ?>
                        </tbody> 
                      </table>
                      <span class="help-block"><?php if($error['Address']!=''){ echo $error['Address']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Location']!=''){ echo 'has-error'; } ?>" >
                      <label for="picture" class="required">Location</label>
                      <?php 
                        if($get_receiver['Location']!=''){
                          $get_Location = json_decode($get_receiver['Location']);
                        }else{
                          $get_Location = array();
                        }
                      ?>
                      <table id="table" class="table1" width="100%" style="margin: 0 auto;">
                        <thead>
                        </thead>
                        <tbody class="tbodyLocation">
                          <?php 
                          foreach($get_Location as $value){ ?>
                            <tr class="add_row"><td ><textarea  name="Location[]" type="text" readonly="readonly" id="Location" placeholder="Location"/><?php echo $value; ?></textarea></td></tr>
                          <?php  } ?>
                        </tbody>  
                      </table>
                      <span class="help-block"><?php if($error['Location']!=''){ echo $error['Location']; } ?></span>
                    </div>
                    <div class="form-group" id="InputNote">
                      <label for="" class="">Note</label>
                      <textarea class="form-control"  readonly="readonly"id="Note" name="Note" placeholder="Note"><?php echo $get_receiver['Note']; ?></textarea>
                      <span class="help-block"></span>
                    </div> 
                  </div>
                  <!-- /.box-body -->
                  
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
<script type="text/javascript">
  $(document).ready(function(){
    $("#addLocation").click(function(){
        $('.tbodyLocation').append('<tr class="add_row"><td ><textarea  name="Location[]" type="text" id="Location" placeholder="Location" /></textarea></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Remove">Remove</button></td></tr>');
    });

    $("#addAddress").click(function(){
        $('.tbodyAddress').append('<tr class="add_row"><td ><textarea  name="Address[]" type="text" id="Address" placeholder="Address" /></textarea></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Remove">Remove</button></td></tr>');
    });

    // Delete row
    $('.table1').on('click', "#delete", function(e) {
        if (!confirm("Are you sure you want to delete this file?"))
        return false;
        $(this).closest('tr').remove();
    });
  });  
</script>