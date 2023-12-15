<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
  img.get_image {width: 100%;}
  table.table {
    border: 1px solid #ccc;
  }
  table.table td {
    padding: 10px;
    border: 1px solid #ccc;
  }
  ul.buttons_list { margin-top: 0;}
  ul.buttons_list li button {
    color: #fff;
    font-size: 20px;
    text-transform: uppercase;
    background: #12B13B;
    padding: 5px 15px;border: unset;
}
ul.buttons_list li button i {
    color: #fff;
    padding-right: 5px;
    font-size: 15px;
}
</style>
 <?php
  if($get_single_trial['Date'] != ''){
      $date = $get_single_trial['Date'];  
     $exdate = explode("/",$date); 
     @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
     $newDate =   date("d-F-Y", strtotime($newDate));
    }else{
     $newDate = '';
    }
?> 
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                  <h1><?php echo $heading_title; ?></h1>
                </div>
                <div class="col-md-6">
                  <ul class="buttons_list">
                    <li><button onclick="goBack()">
                        <i class="fa fa fa-level-up" aria-hidden="true"></i>
                        Back
                        </button>
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
                <form role="form" id="trialedit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group <?php if($error['Internalcode']!=''){ echo 'has-error'; } ?>" id="InputInternalcode">
                      <label for="" class="required">Internal code</label><br>
                      <input type="text" class="form-control" id="Internalcode" name="Internalcode" placeholder="Internal code" value="<?php echo $get_single_trial['Internalcode']; ?>" style="float: left;width: 75%;">
                      <button type="button" class="btn btn-primary" style="float: right;width: 20%;" id="CheckInternalcodebtn">Check code</button>
                      <input type="hidden" name="CheckInternalcode" name="CheckInternalcode" id="CheckInternalcode">
                    </div>  <br>
                    <div class="form-group InputCheckInternalcode <?php if($error['Internalcode']!=''){ echo 'has-error'; } ?>">
                      <span class="help-block"><?php if($error['Internalcode']!=''){ echo $error['Internalcode']; } ?></span>
                    </div>
                    <div class="form-group <?php if($error['Date']!=''){ echo 'has-error'; } ?>" id="InputDate">
                      <label for="" class="required">Date</label>
                      <input type="text" class="form-control" id="Date" name="Date" placeholder="Date" value="<?php echo $newDate; ?>">
                      <span class="help-block"><?php if($error['Date']!=''){ echo $error['Date']; } ?></span>
                    </div>
                    <div class="form-group" id="InputDescription">
                      <label for="" class="">Description</label>
                      <textarea class="form-control" id="Description" name="Description" placeholder="Description"><?php echo $get_single_trial['Description']; ?></textarea>
                      <span class="help-block"></span>
                    </div> 
                    <div class="form-group" >
                      <label for="picture" class="">Pictures</label>
                    </div>
                    <div class="form-group" id="Inputpicture">
                      <table class="table custom_box_gallery" width="100%" style="margin: 0 auto;">
                        <tbody id="lightgallery">
                          <?php
                            if(count($Pictures)>0){
                               $i=1;
                              foreach($Pictures as $keyPicture => $Picture){
                              ?>
                                <?php if($Picture['type']=='2'){?>
                                    <div style="display:none;" id="video<?php echo $i; ?>">
                                        <video class="lg-video-object lg-html5" controls="" preload="none">
                                          <source src="<?php echo $Picture['url']; ?>">
                                          Your browser does not support HTML5 video.
                                        </video>
                                    </div>
                                <?php } ?>
                                <?php if($Picture['type']=='2'){?>
                                    <tr class="add_row video" data-html="#video<?php echo $i; ?>" data-poster="<?php echo $Picture['thumbnail']; ?>" >
                                <?php }else{ ?>
                                    <tr class="add_row" data-responsive="<?php echo $Picture['url']; ?> 375,<?php echo $Picture['url']; ?> 480, <?php echo $Picture['url']; ?> 800" data-src="<?php echo $Picture['url']; ?>" data-sub-html="" >
                                <?php } ?>  
                                  <td width="70%"> 
                                    <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[<?php echo $keyPicture; ?>][name]" value="<?php echo $Picture['name']; ?>">
                                    <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[<?php echo $keyPicture; ?>][type]" value="<?php echo $Picture['type']; ?>">
                                    <?php if($Picture['type']=='2'){?>
                                      <a href="">
                                        <img class="img-responsive" src="<?php echo $Picture['thumbnail']; ?>">
                                        <div class="custom_box_gallery-poster">
                                          <img src="<?php echo base_url().'adminasset/'; ?>img/play-button.png">
                                        </div>
                                      </a>
                                    <?php }else{ ?>  
                                    <a href="">
                                      <img class="img-responsive" src="<?php echo $Picture['thumbnail']; ?>">
                                      <?php 
                                      $newAddDate = $get_single_trial['AddedDate'];
                                      $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                                      // $image_name = explode('_', $Picture['thumbnail']);
                                      // // print_r($image_name);
                                      // @$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
                                      ?>
                                      <p style="color: black; margin-top: 5px;"><?php echo @$newAddDate1; ?></p>
                                    </a>
                                    <?php } ?> 
                                  </td>
                                  </td>
                                 <td class="text-center" width="10%"></td><td class="text-center" width="20%"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></td>
                                </tr>
                              <?php
                                $i++;
                              }
                            }
                          ?>
                        </tbody>  
                      </table>  
                      <table class="table" width="100%" style="margin: 0 auto;"> 
                        <tbody class="tbody">
                          <tr class="add_row default_file">
                            
                            <td width="70%">
                              <input class="coverimage" name='files[]' type='file' id="files" />

                            </td>
                            <td class="text-center" width="10%">
                              <div class="imagePreview" style="display: none;"></div>
                            </td>
                            <td width="20%"></td>
                          </tr>
                        </tbody>   
                        <tfoot>
                          <tr>
                            <td colspan="4"><button class="btn btn-success btn-sm" type="button" id="add" title='Add new file'/>Add new file</button></td>
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
    $( "#Date" ).datepicker({ dateFormat: "dd/mm/yy" });
    $('.table').on('click', "#add", function(e) {
        $('.tbody').append('<tr class="add_row"><td width="70%"><input class="coverimage" name="files[]" type="file" id="files" /> </div></td><td class="text-center" width="10%"><div class="imagePreview"  style="display: none;"></td><td class="text-center" width="20%"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></td></tr>');
        e.preventDefault();
    });

    // Delete row
    $('.table').on('click', "#delete", function(e) {
        if (!confirm("Are you sure you want to delete this file?"))
        return false;
        $(this).closest('tr').remove();
        e.preventDefault();
    });
});  
</script>
<script type="text/javascript">
$(document).ready(function(){ 
  $("#trialedit").submit(function(){ 
    $(".InputCheckInternalcode .help-block").html('');
    $(".InputCheckInternalcode").removeClass("has-error");
    var CheckInternalcode= $("#CheckInternalcode").val();
    if(CheckInternalcode==''){
      $(".InputCheckInternalcode .help-block").html('<p>Please Check Internal code.</p>');
      $(".InputCheckInternalcode").addClass("has-error");
       $("#Internalcode").focus();
      return false;
    }
  });
});
$(document).ready(function(){ 
  $("#CheckInternalcodebtn").click(function(){
     $("#CheckInternalcode").val('');
    $(".InputCheckInternalcode .help-block").html('');
    $(".InputCheckInternalcode").removeClass("has-error");
    var Internalcode= $("#Internalcode").val();
    if(Internalcode==''){
     $(".InputCheckInternalcode .help-block").html('<p>Please Check Internal code.</p>');
      $(".InputCheckInternalcode").addClass("has-error");
      $("#Internalcode").focus();
      return false;
    }
    var data = {'Internalcode':Internalcode};
    $.ajax({
        url: '<?php echo base_url(); ?>admin/trialcheckinternalcode',
        type: 'post',
        data: data,
        success: function(response) {
          if(response=='This Internal code not exits'){
            $("#CheckInternalcode").val('');
            $(".InputCheckInternalcode .help-block").html('<p>'+response+'.</p>');
            $(".InputCheckInternalcode").addClass("has-error");
            $("#Internalcode").focus();
          }else{
            $("#CheckInternalcode").val('1');
            //$(".InputCheckInternalcode .help-block").html('<p style="color: green;">This Internal code exits.</p>');
            $(".InputCheckInternalcode .help-block").html('<p style="color: green;">'+response+'</p>');//Abhishek
          } 
        }
    }); 
  }); 
});  
</script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#lightgallery').lightGallery({
        share:false,
      });
  });
</script>
<script>
function goBack() {
  window.history.back();
}
</script>