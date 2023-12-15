<?php include('common/header.php');?>
<style type="text/css">
   .select2-container{width: 100%!important;}
   .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
   background-color: #fefefe;border: unset;}
   textarea {border: 1px solid #fefefe;}
   .viewonlyclass {
   padding: 6px 12px;
   background: #fefefe;
   }
   ul.buttons_list {margin-top: 30px;padding: 0;list-style: none;text-align: right;}
   ul.buttons_list li {display: inline-block;}
   ul.buttons_list li a {color: #fff;font-size: 20px;text-transform: uppercase;background: #12B13B;padding: 5px 15px;}
   ul.buttons_list li a i {color: #fff;padding-right: 5px;font-size: 15px;}
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
   
     if($get_single_trial['Dateofsowing'] != ''){
       $newAddDate = $get_single_trial['Dateofsowing'];
       $NewDateofsowing = date("d-F-Y",strtotime($newAddDate));
       }else{
      $NewDateofsowing = '';
     }
     if($get_single_trial['Dateoftransplanted'] != ''){
       $newAddDate = $get_single_trial['Dateoftransplanted'];
       $NewDateoftransplanted = date("d-F-Y",strtotime($newAddDate));
       }else{
       $NewDateoftransplanted = '';
     }
     if($get_single_trial['Estimatedharvestingdate'] != ''){
       $newAddDate = $get_single_trial['Estimatedharvestingdate'];
       $NewEstimatedharvestingdate = date("d-F-Y",strtotime($newAddDate));
       }else{
       $NewEstimatedharvestingdate = '';
     }
   
   
   ?>
<div class="wrapper">
<?php include('common/topbar.php');?>
<?php include('common/left_sidebar.php');?>  
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-9">
                  <h1><?php echo $heading_title; ?></h1>
               </div>
               <div class="col-md-3">
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
            <div class="box box-primary">
               <div class="box-body">
                  <div class="form-group" id="InputInternalcode">
                     <label for="" class="required">Internal code</label><br>
                     <input type="text" readonly="readonly" class="form-control" id="Internalcode" name="Internalcode" placeholder="Internal code" value="<?php echo $get_single_trial['Internalcode']; ?>" style="float: left;width: 100%;">
                  </div>

                  <div class="form-group" >
                      <label for="" class="required">Date of Visit </label>
                      <input type="text" readonly="readonly" class="form-control"  placeholder="Date of Visit" value="<?php echo $get_single_trial['Date']; ?>">
                  </div>

                  <?php if($userrole=='1' || $userrole=='4'){ ?>
                  <div class="form-group" id="InputSupplier">
                     <label for="" class="required">Supplier Name</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Supplier" placeholder="Supplier" value="<?php echo $get_single_trial['SupplierName']; ?>">
                  </div>
                  <div class="form-group" id="InputVariety">
                     <label for="" class="required">Variety Name</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Variety" placeholder="Variety" value="<?php echo $get_single_trial['SeedVariety']; ?>">
                  </div>
                  <?php } ?>
                  <div class="form-group" id="InputCrop">
                     <label for="" class="required">Crop</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Crop" placeholder="Crop" value="<?php echo $get_single_trial['CropTitle']; ?>">
                  </div>
                  <div class="form-group" id="InputLocation">
                     <label for="" class="required">Location</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Location" placeholder="Location" value="<?php echo $get_single_trial['Location']; ?>">
                  </div>
                  <div class="form-group" id="InputDateofsowing">
                     <label for="" class="required">Date of sowing</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Dateofsowing" placeholder="Dateofsowing" value="<?php echo $NewDateofsowing; ?>">
                  </div>
                  <div class="form-group" id="InputDateoftransplanted">
                     <label for="" class="required">Date of Transplanted</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Dateoftransplanted" placeholder="Dateoftransplanted" value="<?php echo $NewDateoftransplanted; ?>">
                  </div>
                  <div class="form-group" id="InputDateofharvesting">
                     <label for="" class="required">Date of Harvesting</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Dateofharvesting" placeholder="Dateofharvesting" value="<?php echo $NewEstimatedharvestingdate; ?>">
                  </div>
                  <!-- <div class="form-group" id="InputDate">
                     <label for="" class="required">Date</label>
                     
                     <input type="text" readonly="readonly" class="form-control" id="" name="Date" placeholder="Date" value="<?php echo $newDate; ?>">
                     
                     </div> -->
                  <div class="form-group" id="InputDescription">
                     <label for="" class="">Description</label>
                     <textarea class="form-control" readonly="readonly" id="Description" name="Description" placeholder="Description"><?php echo $get_single_trial['Description']; ?></textarea>
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="InputAddedby">
                     <label for="" class="required">Added By</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="Addedby" placeholder="Addedby" value="<?php echo $get_single_trial['Fullname']; ?>">
                  </div>
                  <div class="form-group" id="InputAddedDate">
                     <label for="" class="required">Added Date</label>
                     <input type="text" readonly="readonly" class="form-control" id="" name="AddedDate" placeholder="AddedDate" value="<?php echo $get_single_trial['AddedDate']; ?>">
                  </div>
                  <div class="form-group" >
                     <label for="picture" class="">Pictures</label>
                  </div>
                  <div class="form-group" id="Inputpicture">
                     <div class="row">
                        <?php
                           if(count($Pictures)>0){
                             $i=1; 
                             foreach($Pictures as $Picture){
                               if($Picture['type']=='2'){?>
                        <div style="display:none;" id="video<?php echo $i; ?>">
                           <video class="lg-video-object lg-html5" controls="" preload="none">
                              <source src="<?php echo $Picture['url']; ?>">
                              Your browser does not support HTML5 video.
                           </video>
                        </div>
                        <?php
                           }
                           $i++;
                           }
                           }
                           ?>
                        <?php
                           if(count($Pictures)>0){
                           ?>
                        <div class="custom_box_gallery">
                           <ul id="lightgallery" class="list-unstyled row">
                           <?php      
                              $i=1;
                              foreach($Pictures as $Picture){
                                if($Picture['type']=='2'){?>    
                           <li class="video" data-html="#video<?php echo $i; ?>"
                              data-poster="<?php echo $Picture['thumbnail']; ?>">
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
                                 <div class="custom_box_gallery-poster">
                                    <img src="<?php echo base_url().'adminasset/'; ?>img/play-button.png">
                                 </div>
                              </a>
                           </li>
                           <?php  }else{ ?>
                           <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="<?php echo $Picture['url']; ?> 375,<?php echo $Picture['url']; ?> 480, <?php echo $Picture['url']; ?> 800" data-src="<?php echo $Picture['url']; ?>" data-sub-html="">
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
                           </li>
                           <?php  } ?>      
                           <?php
                              $i++;
                              }
                              ?>
                           <?php       
                              }
                              ?>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.box -->
            </div>
            <!-- /.col -->
            <div>
               <a href="<?php echo base_url(); ?>admin/trialreport/?TrialID=<?php echo $_GET['TrialID']; ?>"><button type="submit" class="btn btn-primary" style="float: left;">Generate Report</button></a>
            </div>
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