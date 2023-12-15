<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
</style>
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

          <div class="col-md-8">
              <div class="box box-primary">
                <!-- form start -->
                <form role="form" id="precommercialedit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formVariety">
                  <div class="box-body">
                    <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                      <label for="" class="required">Crop</label>
                      <?php if($get_single_precommercial['EvaluationID']!='' && $get_single_precommercial['EvaluationID']!='0'){ ?>
                        <?php foreach ($crops as $crop) { ?>
                        <?php if ($get_single_precommercial['Crop'] == $crop['CropID'] ) echo '<br/>'.$crop['Title'] ; ?>
                        <?php } ?>
                      <?php } ?>  
                      <select class="form-control" id="Crop" name="Crop"  <?php if($get_single_precommercial['EvaluationID']!='' && $get_single_precommercial['EvaluationID']!='0'){ echo 'style="display: none;"'; } ?> >
                        <?php foreach ($crops as $crop) { ?>
                        <option value="<?php echo $crop['CropID']; ?>" <?php if ($get_single_precommercial['Crop'] == $crop['CropID'] ) echo 'selected' ; ?> ><?php echo $crop['Title']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                      <label for="" class="required">Variety</label>
                      <?php if($get_single_precommercial['EvaluationID']!='' && $get_single_precommercial['EvaluationID']!='0'){ ?>
                        <?php echo '<br/>'.$get_single_precommercial['Variety'] ; ?>
                      <?php } ?> 
                      <input type="text" class="form-control" id="Variety" name="Variety" placeholder="Variety" value="<?php echo $get_single_precommercial['Variety']; ?>" <?php if($get_single_precommercial['EvaluationID']!='' && $get_single_precommercial['EvaluationID']!='0'){ echo 'style="display: none;"'; } ?> >
                      <span class="help-block"><?php if($error['Variety']!=''){ echo $error['Variety']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Supplier']!=''){ echo 'has-error'; } ?>" id="InputSupplier">
                      <label for="" class="required">Supplier</label>
                      <?php if($get_single_precommercial['EvaluationID']!='' && $get_single_precommercial['EvaluationID']!='0'){ ?>
                        <?php foreach ($suppliers as $supplier) { ?>
                          <?php if ($get_single_precommercial['Supplier'] == $supplier['SupplierID'] ){ ?>
                              <?php echo '<br/>'.$supplier['Name'] ; ?>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?> 
                      <select class="form-control" id="Supplier" name="Supplier" <?php if($get_single_precommercial['EvaluationID']!='' && $get_single_precommercial['EvaluationID']!='0'){ echo 'style="display: none;"'; } ?>>
                        <?php foreach ($suppliers as $supplier) { ?>
                        <option value="<?php echo $supplier['SupplierID']; ?>" <?php if ($get_single_precommercial['Supplier'] == $supplier['SupplierID'] ) echo 'selected' ; ?> ><?php echo $supplier['Name']; ?></option>
                        <?php } ?>
                      </select>
                      <span class="help-block"><?php if($error['Supplier']!=''){ echo $error['Supplier']; } ?></span>
                    </div> 
                    <div class="form-group <?php if($error['Marketsize']!=''){ echo 'has-error'; } ?>" id="InputMarketsize">
                      <label for="" class="required">Market size</label>
                      <input type="text" class="form-control" id="Marketsize" name="Marketsize" placeholder="Market size" value="<?php echo $get_single_precommercial['Marketsize']; ?>">
                      <span class="help-block"><?php if($error['Marketsize']!=''){ echo $error['Marketsize']; } ?></span>
                    </div>
                    <div class="form-group" >
                      <label for="picture" class="">Competitors</label>
                      <?php 
                        if($get_single_precommercial['Competitors']!=''){
                          $get_Competitors = json_decode($get_single_precommercial['Competitors']);
                        }else{
                          $get_Competitors = array();
                        }
                      ?>
                      <table id="table" class="table1" width="100%" style="margin: 0 auto;">
                        <thead>
                        </thead>
                        <tbody class="tbodyCompetitor">
                          <?php 
                          foreach($get_Competitors as $value){ ?>
                            <tr class="add_row"><td ><input  name="Competitorsname[]" type="text" id="Competitorsname" placeholder="Name" value="<?php echo $value->Name; ?>" /></td><td ><input  name="Competitorsprices[]" type="text" id="Competitorsprices" placeholder="Prices" value="<?php echo $value->Prices; ?>" /></td><td ><input  name="Competitorspagaking[]" type="text" id="Competitorspagaking" placeholder="Pagaking" value="<?php echo $value->Pagaking; ?>" /></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Remove">Remove</button></td></tr>
                          <?php  } ?>
                        </tbody>
                        <tfoot>  
                          <tr>
                            <td colspan="4"><button class="btn btn-success btn-sm" type="button" id="add" title='Add new'/>Add new</button></td>
                          </tr>
                        </tfoot>  
                      </table>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group <?php if($error['Numebrofseedsrequast']!=''){ echo 'has-error'; } ?>" id="InputNumebrofseedsrequast">
                      <label for="" class="required">Numebr of seeds requast</label>
                      <input type="number" class="form-control" id="Numebrofseedsrequast" name="Numebrofseedsrequast" placeholder="Numebr of seeds requast" value="<?php echo $get_single_precommercial['Numebrofseedsrequast']; ?>">
                      <span class="help-block"><?php if($error['Numebrofseedsrequast']!=''){ echo $error['Numebrofseedsrequast']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Bywhen']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                      <label for="" class="required">By when</label>
                      <input type="text" class="form-control" id="Bywhen" name="Bywhen" placeholder="By when" value="<?php echo $get_single_precommercial['Bywhen']; ?>" >
                      <span class="help-block"><?php if($error['Bywhen']!=''){ echo $error['Bywhen']; } ?></span>
                    </div> 
                    <div class="form-group" >
                      <label for="picture" class="">Suggested commerical</label>
                      <?php 
                        if($get_single_precommercial['Suggestedcommerical']!=''){
                          $get_Suggestedcommerical = json_decode($get_single_precommercial['Suggestedcommerical']);
                        }else{
                          $get_Suggestedcommerical = array();
                        }
                      ?>
                      <table id="table" class="table1" width="100%" style="margin: 0 auto;">
                        <thead>
                        </thead>
                        <tbody class="tbodySuggestedcommerical">
                          <?php 
                          foreach($get_Suggestedcommerical as $value){ ?>
                            <tr class="add_row"><td ><input  name="Suggestedcommericalname[]" type="text" id="Suggestedcommericalname" placeholder="Name" value="<?php echo $value->Name; ?>" /></td><td width="30%"><td class="text-center" width="10%"><?php if($value->Image!=''){ ?><img class="img-responsive" src="<?php echo base_url('uploads/Suggestedcommericalfiles/'.$value->Image); ?>"><?php } ?>
                              <input type="hidden" id="" name="img_exits[]" value="<?php echo $value->Image; ?>">
                            </td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Remove">Remove</button></td></tr>
                          <?php  } ?>
                        </tbody>
                        <tfoot>  
                          <tr>
                            <td colspan="4"><button class="btn btn-success btn-sm" type="button" id="addSuggestedcommericalname" title='Add new'/>Add new</button></td>
                          </tr>
                        </tfoot>  
                      </table>
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" style="float: left;">Save</button>
                  </div>
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
    $("#add").click(function(){
        $('.tbodyCompetitor').append('<tr class="add_row"><td ><input  name="Competitorsname[]" type="text" id="Competitorsname" placeholder="Name" /></td><td ><input  name="Competitorsprices[]" type="text" id="Competitorsprices" placeholder="Prices" /></td><td ><input  name="Competitorspagaking[]" type="text" id="Competitorspagaking" placeholder="Pagaking" /></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Remove">Remove</button></td></tr>');
    });

    $("#addSuggestedcommericalname").click(function(){ 
        $('.tbodySuggestedcommerical').append('<tr class="add_row"><td ><input  name="Suggestedcommericalname[]" type="text" id="Suggestedcommericalname" placeholder="Name" /></td><td width="30%"><input class="coverimage" name="Suggestedcommericalfiles[]" type="file" id="files" /></td><td class="text-center" width="10%"><div class="imagePreview" style="display: none;"></div></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Remove">Remove</button></td></tr>');
    });

    // Delete row
    $('.table1').on('click', "#delete", function(e) {
        if (!confirm("Are you sure you want to delete this file?"))
        return false;
        $(this).closest('tr').remove();
    });
  });  
</script>
<script type="text/javascript">
  $(function() {
    $( "#Bywhen" ).datepicker({
        dateFormat:"yy-mm-dd",
    });
});  
</script>