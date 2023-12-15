<?php include('common/header.php');?>
<style type="text/css">
  .select2-container{width: 100%!important;}
  .custom-model-main {
    text-align: center;
    overflow: hidden;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0; /* z-index: 1050; */
    -webkit-overflow-scrolling: touch;
    outline: 0;
    opacity: 0;
    -webkit-transition: opacity 0.15s linear, z-index 0.15;
    -o-transition: opacity 0.15s linear, z-index 0.15;
    transition: opacity 0.15s linear, z-index 0.15;
    z-index: -1;
    overflow-x: hidden;
    overflow-y: auto;
  }
  .model-open {
    z-index: 99999;
    opacity: 1;
    overflow: hidden;
  }
  .custom-model-inner {
    -webkit-transform: translate(0, -25%);
    -ms-transform: translate(0, -25%);
    transform: translate(0, -25%);
    -webkit-transition: -webkit-transform 0.3s ease-out;
    -o-transition: -o-transform 0.3s ease-out;
    transition: -webkit-transform 0.3s ease-out;
    -o-transition: transform 0.3s ease-out;
    transition: transform 0.3s ease-out;
    transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
    display: inline-block;
    vertical-align: middle;
    width: 600px;
    margin: 30px auto;
    max-width: 97%;
  }
  .custom-model-wrap {
    display: block;
    width: 100%;
    position: relative;
    background-color: #fff;
    border: 1px solid #999;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px;
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
    background-clip: padding-box;
    outline: 0;
    text-align: left;
    padding: 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    max-height: calc(100vh - 70px);
    overflow-y: auto;
  }
  .model-open .custom-model-inner {
    -webkit-transform: translate(0, 0);
    -ms-transform: translate(0, 0);
    transform: translate(0, 0);
    position: relative;
    z-index: 999;
  }
  .model-open .bg-overlay {
    background: rgba(0, 0, 0, 0.6);
    z-index: 99;
  }
  .bg-overlay {
    background: rgba(0, 0, 0, 0);
    height: 100vh;
    width: 100%;
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
    -webkit-transition: background 0.15s linear;
    -o-transition: background 0.15s linear;
    transition: background 0.15s linear;
  }
  .close-btn {
    position: absolute;
    right: 0;
    top: -30px;
    cursor: pointer;
    z-index: 99;
    font-size: 30px;
    color: #fff;
  }

  img.get_image {width: 100%;}
  @media screen and (min-width:800px){
    .custom-model-main:before {
      content: "";
      display: inline-block;
      height: auto;
      vertical-align: middle;
      margin-right: -0px;
      height: 100%;
    }
  }
  @media screen and (max-width:799px){
    .custom-model-inner{margin-top: 110px;}
  }
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

          <div class="col-md-12">
              <div class="box box-primary">
                <!-- form start -->
                <form role="form" id="trialreport" action="<?php echo base_url(); ?>admin/reporttrial/<?php echo $_GET['TrialID']; ?>" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group" >
                      <textarea name="editor1"><?php echo $editor1; ?></textarea>
                    </div>
                    <div class="box-body">
                    <div class="form-group" >
                      <label>Pictures</label>
                    </div> 
                    <?php
                      

                      if(count($Pictures_1)>0){
                        $i=1;
                        foreach($Pictures_1 as $Picture){
                        ?>
                        <div class="col-md-2">
                          <div class="boximgselect" id="boximgselectPicture_1_<?php echo $i; ?>">
                          <img src="<?php echo $Picture['thumbnail']; ?>" class="gallery_img" id="Picture_1_<?php echo $i; ?>">
                          <?php 
                            $newAddDate = $AddDate;
                            $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                            // $image_name = explode('_', $Picture['thumbnail']);
                            // // print_r($image_name);
                            // @$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
                          ?>
                          <p style="color: black; margin-top: 5px;"><?php echo @$newAddDate1; ?></p>
                          <input type="checkbox" name="Pictures_1[]" value="<?php echo $Picture['url']; ?>" class="Picture" id="chkPicture_1_<?php echo $i; ?>">
                          </div>  
                        </div>  
                        <?php
                          $i++;
                        }
                      }
                    ?>
                  </div>
                    <!-- <?php if($editor2!=''){ ?>
                      <div class="form-group" >
                        <label>Internal sample code control variety</label>
                        <textarea name="editor2"><?php echo $editor2; ?></textarea>
                      </div>
                    <?php } ?>
                  </div>  -->
                  <!-- <div class="box-body">
                    <div class="form-group" >
                      <label>Pictures</label>
                    </div> 
                    <?php

                      if(count($Pictures_2)>0){
                        $i=1;
                        foreach($Pictures_2 as $Picture){
                        ?>
                        <div class="col-md-2">
                          <div class="boximgselect" id="boximgselectPicture_2_<?php echo $i; ?>">
                          <img src="<?php echo $Picture['thumbnail']; ?>" class="gallery_img" id="Picture_2_<?php echo $i; ?>">
                          <input type="checkbox" name="Pictures_2[]" value="<?php echo $Picture['url']; ?>" class="Picture" id="chkPicture_2_<?php echo $i; ?>">
                          </div>  
                        </div>  
                        <?php
                          $i++;
                        }
                      }
                    ?>
                  </div> -->
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <a href="<?php echo base_url(); ?>admin/reporttrial/14"><i class="fa fa-file" aria-hidden="true" style="display: none;"></i></a>
                    <br>
                    <button type="submit" class="btn btn-primary" style="float: left;">Generate Report</button>
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
    <div class="custom-model-main">
        <div class="custom-model-inner">        
        <div class="close-btn">×</div>
            <div class="custom-model-wrap">
                <div class="pop-up-content-wrap">
                   <center>
                    <img class="get_image" src="">
                   </center>
                </div>
            </div>  
        </div>  
        <div class="bg-overlay"></div>
    </div>
    <?php include('common/footer_content.php');?>
    <?php include('common/sidebar_control.php');?> 
</div>
<!-- ./wrapper -->
<?php include('common/footer.php');?>
<script>
    CKEDITOR.replace( 'editor1' );
    CKEDITOR.replace( 'editor2' );
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.boximgselect').on('click', "img", function() {
      Picture = $(this).attr('id');      
      if($("#chk"+Picture).is(':checked')){
         $("#chk"+Picture).prop('checked', false);  
         $("#boximgselect"+Picture).removeClass('active');
      }else{
         $("#chk"+Picture).prop('checked', true);  
         $("#boximgselect"+Picture).addClass('active');
      }
  });  
}); 
</script>

<script type="text/javascript">
  //$(".gallery_img").on('click', function() { 
  /*$("body").on("click", ".gallery_img", function() {   
    $(".custom-model-main").addClass('model-open');
      var mysrc = $(this).attr('src');
      $('.get_image').attr('src', mysrc);
  }); */
  $(".close-btn, .bg-overlay").click(function(){
    $(".custom-model-main").removeClass('model-open');
  });
</script>