<?php include('common/header.php');?>
<style type="text/css">
   .select2-container{width: 100%!important;}
   table.table1 {
   border: 1px solid #ccc;
   }
   table.table1 td {
   padding: 10px;
   border: 1px solid #ccc;
   }
   table.table2 {
   border: 1px solid #ccc;
   }
   table.table2 td {
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
   if($get_single_evaluation['Dateofvisit'] != ''){
   $date = $get_single_evaluation['Dateofvisit'];  
   $exdate = explode("/",$date); 
   @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
    $newDate =   date("d-F-Y", strtotime($newDate));
   }else{
    $newDate = '';
   }
   
     if($get_single_evaluation['Dateofsowing'] != ''){
       $newAddDate = $get_single_evaluation['Dateofsowing'];
       $newDateofsowing = date("d-F-Y",strtotime($newAddDate));
       }else{
      $newDateofsowing = '';
     }
   
     if($get_single_evaluation['Dateoftransplanted'] != ''){
       $newAddDate = $get_single_evaluation['Dateoftransplanted'];
       $newDateoftransplanted = date("d-F-Y",strtotime($newAddDate));
       }else{
       $newDateoftransplanted = '';
     }
   
     if($get_single_evaluation['Estimatedharvestingdate'] != ''){
       $newAddDate = $get_single_evaluation['Estimatedharvestingdate'];
       $newEstimatedharvestingdate = date("d-F-Y",strtotime($newAddDate));
       }else{
       $newEstimatedharvestingdate = '';
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
                     <h1><?php echo "View Evaluation" ?></h1>
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
                  <form role="form" id="evaluationedit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                     <div class="box-body">
                        <div class="form-group <?php if($error['Internalsamplecode']!=''){ echo 'has-error'; } ?>" id="InputInternalsamplecode">
                           <label for="" class="required">Internal sample code</label>
                           <br>
                           <input type="text" class="form-control" id="Internalsamplecode" name="Internalsamplecode" placeholder="Internal seed code" value="<?php echo $get_single_evaluation['Internalsamplecode']; ?>" style="float: left;width: 75%;" <?php if($EvaluationID){ echo "readonly"; } ?>>
                           <?php if($EvaluationID==''){ ?>
                           <button type="button" class="btn btn-primary" style="float: right;width: 20%;" id="CheckInternalcodebtn">Check code</button>
                           <?php } ?>
                           <input type="hidden" name="CheckInternalcode" id="CheckInternalcode" value="<?php echo $get_single_evaluation['CheckInternalcode']; ?>">
                        </div>
                        <br>
                        <div class="form-group InputCheckInternalcode <?php if($error['Internalsamplecode']!=''){ echo 'has-error'; } ?>">  
                           <span class="help-block"><?php if($error['Internalsamplecode']!=''){ echo $error['Internalsamplecode']; } ?></span>
                        </div>
                        <?php if($cropview!=''){ ?>
                        <?php if($get_single_evaluation['Picture']!=''){ ?>
                        <div class="form-group" id="InputUser_profile_show" style="float: left;width: 100%;">
                           <img class="img-responsive" src="<?php echo base_url('uploads/Evaluation/thumbnail/'.$get_single_evaluation['Picture']); ?>">
                        </div>
                        <?php } ?>
                        <?php if($get_single_evaluation['Picture']==''){ ?>
                        <div class="form-group" id="Inputprofileimage">
                           <label for="picture" class="">Picture of lable  <?php //echo $cropview; ?></label>
                           <table id="table" width="100%" style="margin: 0 auto;">
                              <thead>
                              </thead>
                              <tbody>
                                 <tr class="add_row default_file">
                                    <td width="70%">
                                       <input class="coverimage" name='Picture' type='file' id="files" />
                                    </td>
                                    <td class="text-center" width="10%">
                                       <div class="imagePreview" style="display: none;"></div>
                                    </td>
                                    <td width="20%"></td>
                                 </tr>
                              </tbody>
                              <tfoot>
                              </tfoot>
                           </table>
                           <span class="help-block"></span>
                        </div>
                        <?php } ?> 
                        <?php if($get_single_evaluation['CheckInternalsamplecodecontrolvariety']!=''){ ?>
                        <div class="form-group <?php if($error['Internalsamplecodecontrolvariety']!=''){ echo 'has-error'; } ?>" 
                           id="InputInternalsamplecodecontrolvariety">
                           <label for="" class="required">Internal sample code control variety</label>
                           <input type="text" class="form-control" id="Internalsamplecodecontrolvariety" name="Internalsamplecodecontrolvariety" readonly placeholder="Internal sample code control variety" value="<?php echo $get_single_evaluation['Internalsamplecodecontrolvariety']; ?>">
                           <span class="help-block"><?php if($error['Internalsamplecodecontrolvariety']!=''){ echo $error['Friutlength']; } ?></span>
                        </div>
                        <?php } ?>  
                        <div class="form-group <?php if($error['Dateofvisit']!=''){ echo 'has-error'; } ?>" id="InputDateofvisit">
                           <label for="" class="required">Date of visit</label>
                           <input type="text" class="form-control" readonly id="Dateofvisit" name="Dateofvisit" placeholder="Date of visit" value="<?php echo $newDate; ?>">
                           <span class="help-block"><?php if($error['Dateofvisit']!=''){ echo $error['Dateofvisit']; } ?></span>
                        </div>
                        <!-- Development -->
                        <?php if ($userrole=='1' || $userrole=='4') { ?>
                        <div class="form-group <?php if($error['SupplierName']!=''){ echo 'has-error'; } ?>" id="InputSupplierName">
                           <label for="" class="required">SupplierName</label>
                           <input type="text" class="form-control" readonly id="SupplierName" name="SupplierName"  readonlyplaceholder="Supplier Name" value="<?php echo @$get_single_evaluation['SupplierName']; ?>">
                           <span class="help-block"><?php if($error['SupplierName']!=''){ echo $error['SupplierName']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                           <label for="" class="required">Variety Name</label>
                           <input type="text" class="form-control" readonly id="Variety" name="Variety" placeholder="Variety Name" value="<?php echo $get_single_evaluation['Variety']; ?>">
                           <span class="help-block"><?php if($error['Variety']!=''){ echo $error['Variety']; } ?></span>
                        </div>
                        <?php } ?>
                        <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                           <label for="" class="required">Crop</label>
                           <input type="text" class="form-control" readonly id="Crop" name="Crop" placeholder="Crop" value="<?php echo $get_single_evaluation['Crop']; ?>">
                           <span class="help-block"><?php if($error['Crop']!=''){ echo $error['Crop']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Location']!=''){ echo 'has-error'; } ?>" id="InputLocation">
                           <label for="" class="required">Location</label>
                           <input type="text" class="form-control" id="Location" readonly name="Location" placeholder="Location" value="<?php echo $get_single_evaluation['Location']; ?>">
                           <span class="help-block"><?php if($error['Location']!=''){ echo $error['Location']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Dateofsowing']!=''){ echo 'has-error'; } ?>" id="InputDateofsowing">
                           <label for="" class="required">Date of sowing</label>
                           <input type="text" class="form-control" readonly id="Dateofsowing" name="Dateofsowing" placeholder="Date of sowing" value="<?php echo $newDateofsowing; ?>">
                           <span class="help-block"><?php if($error['Dateofsowing']!=''){ echo $error['Dateofsowing']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Dateoftransplanted']!=''){ echo 'has-error'; } ?>" id="InputDateoftransplanted">
                           <label for="" class="required">Date of transplanted</label>
                           <input type="text" class="form-control" readonly id="Dateoftransplanted" name="Date of transplanted" placeholder="Dateoftransplanted" value="<?php echo $newDateoftransplanted; ?>">
                           <span class="help-block"><?php if($error['Dateoftransplanted']!=''){ echo $error['Dateoftransplanted']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Estimatedharvestingdate']!=''){ echo 'has-error'; } ?>" id="InputEstimatedharvestingdate">
                           <label for="" class="required">Date of Harvesting</label>
                           <input type="text" class="form-control" readonly id="Estimatedharvestingdate" name="Estimatedharvestingdate" placeholder="Date of Harvesting" value="<?php echo $newEstimatedharvestingdate; ?>">
                           <span class="help-block"><?php if($error['Estimatedharvestingdate']!=''){ echo $error['Estimatedharvestingdate']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Fullname']!=''){ echo 'has-error'; } ?>" id="InputFullname">
                           <label for="" class="required">Added By</label>
                           <input type="text" class="form-control" readonly id="Fullname" name="Fullname" placeholder="Added By" value="<?php echo $get_single_evaluation['Fullname']; ?>">
                           <span class="help-block"><?php if($error['Fullname']!=''){ echo $error['Fullname']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['AddedDate']!=''){ echo 'has-error'; } ?>" id="InputAddedDate">
                           <label for="" class="required">Added Date</label>
                           <input type="text" class="form-control" readonly id="AddedDate" name="AddedDate" placeholder="Added Date" value="<?php echo $get_single_evaluation['AddedDate']; ?>">
                           <span class="help-block"><?php if($error['AddedDate']!=''){ echo $error['AddedDate']; } ?></span>
                        </div>
                        <!--   <div class="form-group" >
                           <label for="picture" class="">Pictures</label>
                           
                           </div> -->
                        <!--  <div class="form-group" id="Inputpicture">
                           <table class="table1 custom_box_gallery" width="100%" style="margin: 0 auto;">
                           
                             <tbody id="lightgallery">
                           
                               <?php
                              if(!empty($get_single_evaluation['Pictures'])){
                              
                                  $Pictures = json_decode($get_single_evaluation['Pictures'],true); 
                              
                                  $i=1;
                              
                                foreach($Pictures as $keyPicture => $Picture){
                              
                                  if($Picture['type']=='2'){
                              
                                    $Picture_name_pathinfo =  pathinfo($Picture['name']); 
                              
                                    $Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
                              
                                  }else{
                              
                                    $Picture_name = $Picture['name'];
                              
                                  }
                              
                              ?>    
                           
                                   <?php if($Picture['type']=='2'){?>
                           
                                       <div style="display:none;" id="video<?php echo $i; ?>">
                           
                                           <video class="lg-video-object lg-html5" controls="" preload="none">
                           
                                             <source src="<?php echo base_url().'uploads/Evaluation/'.$Picture['name']; ?>">
                           
                                             Your browser does not support HTML5 video.
                           
                                           </video>
                           
                                       </div>
                           
                                   <?php } ?>
                           
                                   <?php if($Picture['type']=='2'){?>
                           
                                       <tr class="add_row video" data-html="#video<?php echo $i; ?>" data-poster="<?php echo base_url().'uploads/Evaluation/thumbnail/'.$Picture_name; ?>" >
                           
                                   <?php }else{ ?>
                           
                                       <tr class="add_row" data-responsive="<?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?> 375,<?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?> 480, <?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?> 800" data-src="<?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?>" data-sub-html="" >
                           
                                   <?php } ?>
                           
                                     <td width="70%">
                           
                                     <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[<?php echo $keyPicture; ?>][name]" value="<?php echo $Picture['name']; ?>">
                           
                                     <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[<?php echo $keyPicture; ?>][type]" value="<?php echo $Picture['type']; ?>">
                           
                                     <?php if($Picture['type']=='2'){?>
                           
                                       <a href="">
                           
                                         <img class="img-responsive" src="<?php echo base_url().'uploads/Evaluation/thumbnail/'.$Picture_name; ?>">
                                         <?php 
                              $image_name = explode('_', $Picture_name);
                              // print_r($image_name);
                              @$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
                              ?>
                                         <p style="color: black; margin-top: 5px;"><?php echo @$newimage_name; ?></p>
                           
                                         <div class="custom_box_gallery-poster">
                           
                                           <img src="<?php echo base_url().'adminasset/'; ?>img/play-button.png">
                           
                                         </div>
                           
                                       </a>
                           
                                     <?php }else{ ?>  
                           
                                     <a href="">
                           
                                       <img class="img-responsive" src="<?php echo base_url().'uploads/Evaluation/thumbnail/'.$Picture_name; ?>">
                                       <?php 
                              $image_name = explode('_', $Picture_name);
                              // print_r($image_name);
                              @$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
                              ?>
                                         <p style="color: black; margin-top: 5px;"><?php echo @$newimage_name; ?></p>
                                     </a>
                           
                                     <?php } ?> 
                           
                                     </td>
                           
                                     <td class="text-center" width="10%"></td><td class="text-center" width="20%"></td></tr>
                           
                               <?php
                              $i++;
                              
                              }
                              
                              }
                              
                              ?>                            
                           
                             </tbody>
                           
                           </table>  
                           
                           
                           
                           <span class="help-block"></span>
                           
                           </div> -->
                        <?php } ?>
                        <?php if($cropview!=''){ ?>
                        <?php //include('evaluation/common.php');?>
                        <?php include('evaluation/'.$cropview);?>
                        <?php } ?>
                        <?php if($cropview!=''){ ?>
                        <div class="form-group" >
                           <label for="picture" class="">Pictures</label>
                        </div>
                        <div class="form-group" id="Inputpicture">
                           <table class="table1 custom_box_gallery" width="100%" style="margin: 0 auto;">
                              <tbody id="lightgallery">
                                 <?php
                                    if(!empty($get_single_evaluation['Pictures'])){
                                    
                                        $Pictures = json_decode($get_single_evaluation['Pictures'],true); 
                                    
                                        $i=1;
                                    
                                      foreach($Pictures as $keyPicture => $Picture){
                                    
                                        if($Picture['type']=='2'){
                                    
                                          $Picture_name_pathinfo =  pathinfo($Picture['name']); 
                                    
                                          $Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
                                    
                                        }else{
                                    
                                          $Picture_name = $Picture['name'];
                                    
                                        }
                                    
                                    ?>    
                                 <?php if($Picture['type']=='2'){?>
                                 <div style="display:none;" id="video<?php echo $i; ?>">
                                    <video class="lg-video-object lg-html5" controls="" preload="none">
                                       <source src="<?php echo base_url().'uploads/Evaluation/'.$Picture['name']; ?>">
                                       Your browser does not support HTML5 video.
                                    </video>
                                 </div>
                                 <?php } ?>
                                 <?php if($Picture['type']=='2'){?>
                                 <tr class="add_row video" data-html="#video<?php echo $i; ?>" data-poster="<?php echo base_url().'uploads/Evaluation/thumbnail/'.$Picture_name; ?>" >
                                    <?php }else{ ?>
                                 <tr class="add_row" data-responsive="<?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?> 375,<?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?> 480, <?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?> 800" data-src="<?php echo base_url().'uploads/Evaluation/'.$Picture_name; ?>" data-sub-html="" >
                                    <?php } ?>
                                    <td width="70%">
                                       <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[<?php echo $keyPicture; ?>][name]" value="<?php echo $Picture['name']; ?>">
                                       <input type="hidden" id="img_exits_<?php echo $i; ?>" name="img_exits[<?php echo $keyPicture; ?>][type]" value="<?php echo $Picture['type']; ?>">
                                       <?php if($Picture['type']=='2'){?>
                                       <a href="">
                                          <img class="img-responsive" src="<?php echo base_url().'uploads/Evaluation/thumbnail/'.$Picture_name; ?>">
                                          <?php 
                                          $newAddDate = $get_single_evaluation['AddedDate'];
                                          $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                                             // $image_name = explode('_', $Picture_name);
                                             // // print_r($image_name);
                                             // @$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
                                             ?>
                                          <p style="color: black; margin-top: 5px;"><?php echo @$newAddDate1; ?></p>
                                          <div class="custom_box_gallery-poster">
                                             <img src="<?php echo base_url().'adminasset/'; ?>img/play-button.png">
                                          </div>
                                       </a>
                                       <?php }else{ ?>  
                                       <a href="">
                                          <img class="img-responsive" src="<?php echo base_url().'uploads/Evaluation/thumbnail/'.$Picture_name; ?>">
                                          <?php 
                                              $newAddDate = $get_single_evaluation['AddedDate'];
                                              $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                                             // $image_name = explode('_', $Picture_name);
                                             // // print_r($image_name);
                                             // @$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
                                             ?>
                                          <p style="color: black; margin-top: 5px;"><?php echo @$newAddDate1; ?></p>
                                       </a>
                                       <?php } ?> 
                                    </td>
                                    <td class="text-center" width="10%"></td>
                                    <td class="text-center" width="20%"></td>
                                 </tr>
                                 <?php
                                    $i++;
                                    
                                    }
                                    
                                    }
                                    
                                    ?>                            
                              </tbody>
                           </table>
                           <span class="help-block"></span>
                        </div>
                        <?php if($get_single_evaluation['CheckInternalsamplecodecontrolvariety']!=''){ ?>
                        <div class="form-group <?php if($error['Status']!=''){ echo 'has-error'; } ?>" id="InputStatus">
                           <label for="" class="required">Status</label>
                           <br>
                           <?php $cnt = 1; ?>
                           <?php foreach ($Status as $key => $value){ ?>
                           <?php 
                              if($cnt=='1' && $get_single_evaluation['Status']==''){
                              
                                $checked = 'checked="checked"';
                              
                              }elseif($get_single_evaluation['Status']==$value){
                              
                                $checked = 'checked="checked"';
                              
                              }else{
                              
                                $checked = '';
                              
                              }
                              
                              ?>
                           <input type="radio" class="formcontrol" id="Status<?php echo $key; ?>" name="Status" value="<?php echo $value; ?>" <?php echo $checked; ?>>
                           <label for="Status<?php echo $key; ?>"><?php echo $value; ?></label>
                           <?php $cnt++; ?>
                           <?php } ?>
                           <span class="help-block"><?php if($error['Status']!=''){ echo $error['Status']; } ?></span>
                        </div>
                        <?php 
                           $styleDropmessage = 'style="display: none;"';
                           
                           $styleByWhenmessage = 'style="display: none;"';
                           
                           $styleNumberofseedsmessage = 'style="display: none;"';
                           
                           if($get_single_evaluation['Status']==''){
                           
                              $styleDropmessage = '';
                           
                           }elseif($get_single_evaluation['Status']=='Drop'){
                           
                              $styleDropmessage = '';
                           
                           }elseif($get_single_evaluation['Status']=='Re-check'){
                           
                              $styleByWhenmessage = '';
                           
                              $styleNumberofseedsmessage = '';
                           
                           }  
                           
                           ?>  
                        <div class="form-group <?php if($error['Dropmessage']!=''){ echo 'has-error'; } ?>" id="InputDropmessage" <?php echo $styleDropmessage; ?> >
                           <label for="" class="">Drop message</label>
                           <textarea  type="text" readonly class="form-control" id="Dropmessage" name="Dropmessage" placeholder="Dropmessage" ><?php echo $get_single_evaluation['Dropmessage']; ?></textarea>
                           <span class="help-block"><?php if($error['Dropmessage']!=''){ echo $error['Dropmessage']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['ByWhen']!=''){ echo 'has-error'; } ?>" id="InputByWhen" <?php echo $styleByWhenmessage; ?>>
                           <label for="" class="required">By When</label>
                           <input type="text" class="form-control" readonly id="ByWhen" name="ByWhen" placeholder="By When" value="<?php echo $get_single_evaluation['ByWhen']; ?>">
                           <span class="help-block"><?php if($error['ByWhen']!=''){ echo $error['ByWhen']; } ?></span>
                        </div>
                        <div class="form-group <?php if($error['Numberofseeds']!=''){ echo 'has-error'; } ?>" id="InputNumberofseeds" <?php echo $styleNumberofseedsmessage; ?>>
                           <?php 
                              $NumberofseedsLabel = '';
                              
                              if($getsampling['Stockquantityfor']=='1'){
                              
                                $NumberofseedsLabel = '(in Kg)';
                              
                              }elseif($getsampling['Stockquantityfor']=='0'){
                              
                                $NumberofseedsLabel = '(in Gram)';
                              
                              }elseif($getsampling['Stockquantityfor']=='2'){
                              
                                $NumberofseedsLabel = '(in Seeds)';
                              
                              }
                              
                              ?>
                           <label for="" class="required">Number of seeds <?php echo $NumberofseedsLabel; ?></label>
                           <input type="text" readonly class="form-control" id="Numberofseeds" name="Numberofseeds" placeholder="Number of seeds" value="<?php echo $get_single_evaluation['Numberofseeds']; ?>">
                           <span class="help-block"><?php if($error['Numberofseeds']!=''){ echo $error['Numberofseeds']; } ?></span>
                        </div>
                        <?php } ?>
                        <?php } ?>  
                     </div>
                     <?php if($cropview!=''){ ?>  
                     <!-- /.box-body -->
                     <!-- <div class="box-footer">
                        <button type="button" id="submitbtn" class="btn btn-primary" style="float: left;">Save</button>
                        
                        </div> -->
                     <?php } ?> 
                  </form>
               </div>
               <!-- /.box -->
               <div>
                  <a href="<?php echo base_url(); ?>admin/evaluationreport/?EvaluationID=<?php echo $_GET['EvaluationID']; ?>"><button type="submit" class="btn btn-primary" style="float: left;">Generate Report</button></a>
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
   
     $( "#Dateofvisit" ).datepicker();
   
     $('.table2').on('click', "#add", function(e) {
   
         console.log("d");
   
         $('.table2 tbody').append('<tr class="add_row"><td width="70%"><input class="coverimage" name="files[]" type="file" id="files" /> </div></td><td class="text-center" width="10%"><div class="imagePreview"  style="display: none;"></td><td class="text-center" width="20%"><button type="button" class="btn btn-danger btn-sm" id="delete" title="Delete file">Delete file</button></td></tr>');
   
         e.preventDefault();
   
     });
   
   
   
     // Delete row
   
     $('.table1').on('click', "#delete", function(e) {
   
         if (!confirm("Are you sure you want to delete this file?"))
   
         return false;
   
         $(this).closest('tr').remove();
   
         e.preventDefault();
   
     });
   
     $('.table2').on('click', "#delete", function(e) {
   
         if (!confirm("Are you sure you want to delete this file?"))
   
         return false;
   
         $(this).closest('tr').remove();
   
         e.preventDefault();
   
     });
   
     //$('#Status').on('change', function() {
   
     $('input[name="Status"]').click(function() {  
   
       /*val = $(this).val();*/
   
       var val = $("input[name='Status']:checked").val();
   
       if(val=='Drop'){
   
         $("#InputDropmessage").show();
   
         $("#InputByWhen").hide();
   
         $("#InputNumberofseeds").hide();
   
       }else if(val=='Re-check'){
   
         $("#InputDropmessage").hide();
   
         $("#InputByWhen").show();
   
         $("#InputNumberofseeds").show();
   
       }else{
   
         $("#InputDropmessage").hide();
   
         $("#InputByWhen").hide();
   
         $("#InputNumberofseeds").hide();
   
       }
   
   
   
     });
   
   });  
   
   
   
</script>
<script type="text/javascript">
   $(document).ready(function(){ 
   
     $("#evaluationedit").submit(function(){ 
   
       $(".InputCheckInternalcode .help-block").html('');
   
       $(".InputCheckInternalcode").removeClass("has-error");
   
       var CheckInternalcode= $("#CheckInternalcode").val();
   
       if(CheckInternalcode==''){
   
         $(".InputCheckInternalcode .help-block").html('<p>Please Check Internal seed code.</p>');
   
         $(".InputCheckInternalcode").addClass("has-error");
   
         $("#Internalsamplecode").focus();
   
         return false;
   
       }
   
     });
   
   });
   
   $(document).ready(function(){ 
   
     $("#CheckInternalcodebtn").click(function(){
   
        $("#CheckInternalcode").val('');
   
       $(".InputCheckInternalcode .help-block").html('');
   
       $(".InputCheckInternalcode").removeClass("has-error");
   
       var Internalcode= $("#Internalsamplecode").val();
   
       if(Internalcode==''){
   
        $(".InputCheckInternalcode .help-block").html('<p>Please Check Internal seed code.</p>');
   
         $(".InputCheckInternalcode").addClass("has-error");
   
         $("#Internalsamplecode").focus();
   
         return false;
   
       }
   
       var data = {'Internalcode':Internalcode};
   
       $.ajax({
   
           url: '<?php echo base_url(); ?>admin/evaluationcheckinternalcode',
   
           type: 'post',
   
           data: data,
   
           success: function(res) {
   
             response = JSON.parse(res);
   
             if(response.message==''){
   
               $("#CheckInternalcode").val('1');
   
               $(".InputCheckInternalcode .help-block").html('<p style="color: green;">This Internal seed code exits.</p>');
   
               window.location.href = '<?php echo base_url(); ?>admin/evaluationedit/?Internalseedcode='+Internalcode;
   
             }else{
   
               $("#CheckInternalcode").val('');
   
               $(".InputCheckInternalcode .help-block").html('<p>'+response.message+'.</p>');
   
               $(".InputCheckInternalcode").addClass("has-error");
   
               $("#Internalsamplecode").focus();
   
             } 
   
           }
   
       }); 
   
     }); 
   
   });  
   
   $(document).ready(function(){
   
     $('#submitbtn').on('click', function() {
   
       $("#evaluationedit").submit();
   
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