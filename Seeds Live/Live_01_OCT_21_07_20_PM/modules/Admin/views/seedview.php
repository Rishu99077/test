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
   .file_extention_class {margin-bottom: 15px;}
   .file_extention_class a {color: red;font-size: 52px;}
   .add_origin_row {margin-bottom: 15px;float: left;width: 100%;margin-left: -15px;margin-right: 15px;}
   .product_images_box {border: 1px solid #ccc;padding: 5px;}
</style>
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
      <?php
         if($get_seed['Dateofrecivedsampel'] != ''){
         
             $date = $get_seed['Dateofrecivedsampel'];  
         
            $exdate = explode("/",$date); 
         
            @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
         
            $newDate =   date("d-F-Y", strtotime($newDate));
         
           }else{
         
            $newDate = '';
         
           }
         
         ?>
      <section class="content">
         <div class="row">
            <div class="col-md-12">
               <div class="box box-primary">
                  <!-- form start -->
                  <form role="form" id="seededit" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                     <div class="box-body">
                        <div class="form-group <?php if($error['Crop']!=''){ echo 'has-error'; } ?>" id="InputCrop">
                           <label for="" class="required">Crop</label>
                           <?php foreach ($crops as $crop) { ?>
                           <?php if ($get_seed['Crop'] == $crop['CropID'] ){  ?>
                           <p class="viewonlyclass" ><?php echo $crop['Title']; ?></p>
                           <?php } ?>
                           <?php } ?>
                        </div>
                        <div class="form-group <?php if($error['Supplier']!=''){ echo 'has-error'; } ?>" id="InputSupplier">
                           <label for="" class="required">Supplier</label>
                           <?php foreach ($suppliers as $supplier) { ?>
                           <?php if ($get_seed['Supplier'] == $supplier['SupplierID'] ) { ?>
                           <p class="viewonlyclass" ><?php echo $supplier['Name']; ?></p>
                           <?php } ?>
                           <?php } ?>
                        </div>
                        <div class="form-group <?php if($error['Variety']!=''){ echo 'has-error'; } ?>" id="InputVariety">
                           <label for="" class="required">Variety</label><br>
                           <input type="text" readonly="readonly" class="form-control" id="Variety" name="Variety" placeholder="Variety" value="<?php echo $get_seed['Variety']; ?>" style="float: left;width: 100%;">
                        </div>
                        <!-- Image Label -->
                        <div class="form-group" style="margin-top: 40px;" id="InputImage">
                           <label class="">Seed Image Label</label>
                           <br /><br />
                           <div class="row" id="lightgallery_1">
                              <?php 
                                 if(!empty($get_seed_images)){
                                   foreach ($get_seed_images as $key => $value) { ?>
                              <div <?php 
                                 $file_extention = pathinfo($value['SeedImage'], PATHINFO_EXTENSION);
                                 if($file_extention != 'pdf' ){
                                 ?> class="col-md-2 lightgallery_items"   data-responsive="<?php echo base_url().'uploads/SeedPictures/'.$value['SeedImage']; ?> 375,<?php echo base_url().'uploads/SeedPictures/'.$value['SeedImage']; ?> 480, <?php echo base_url().'uploads/SeedPictures/'.$value['SeedImage']; ?> 800" data-src="<?php echo base_url().'uploads/SeedPictures/'.$value['SeedImage']; ?>" data-sub-html=""  <?php }else{ ?> class="col-md-2" <?php } ?>>
                                 <div class="product_images_box">
                                    <?php 
                                       $file_extention = pathinfo($value['SeedImage'], PATHINFO_EXTENSION);
                                       if($file_extention == 'pdf' ){
                                       ?>
                                    <div class="file_extention_class">
                                       <a  href="<?php echo base_url('uploads/SeedPictures/'.$value['SeedImage']); ?>">
                                       <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    </div>
                                    <?php 
                                       }else{
                                       ?>
                                    <a href="<?php echo base_url('uploads/SeedPictures/'.$value['SeedImage']); ?>">   
                                    <img style="width: 100%;" src="<?php echo base_url('uploads/SeedPictures/').$value['SeedImage']; ?>"></a>
                                    <?php } ?> 
                                 </div>
                              </div>
                              <?php }  } ?>
                           </div>
                        </div>
                        <!-- Image Label -->
                        <div class="form-group <?php if($error['Dateofrecivedsampel']!=''){ echo 'has-error'; } ?>" id="InputDateofrecivedsampel">
                           <label for="" class="required">Date of recived sampels</label>
                           <p class="viewonlyclass"><?php echo $newDate; ?></p>
                        </div>
                        <div class="form-group <?php if($error['Status']!=''){ echo 'has-error'; } ?>" id="InputStatus">
                           <label for="" class="required">Status</label>
                           <?php foreach ($Status as $key => $value) { ?>
                           <?php if ($get_seed['Status'] == $key ) {?> 
                           <p class="viewonlyclass"><?php echo $value; ?></p>
                           <?php } ?>
                           <?php } ?>
                        </div>
                        <div class="form-group <?php if($error['Stockquantityfor']!=''){ echo 'has-error'; } ?>" id="InputStockquantityfor">
                           <label for="" class="required">Stock quantity for</label>
                           <br>
                           <?php $cnt = 1; ?>
                           <?php foreach ($Stockquantityfor as $key => $value){ ?>
                           <?php 
                              if($cnt=='1' && $get_seed['Stockquantityfor']==''){
                              
                                $checked = 'checked="checked"';
                              
                              }elseif($get_seed['Stockquantityfor']==$key){
                              
                                $checked = 'checked="checked"';
                              
                              }else{
                              
                                $checked = '';
                              
                              }
                              
                              ?>
                           <input type="radio" class="formcontrol" id="Stockquantityfor<?php echo $key; ?>" name="Stockquantityfor" value="<?php echo $key; ?>" <?php echo $checked; ?>>
                           <label for="Stockquantityfor<?php echo $key; ?>"><?php echo $value; ?></label>
                           <?php $cnt++; ?>
                           <?php } ?>
                        </div>
                        <div class="form-group <?php if($error['Stockquantity']!=''){ echo 'has-error'; } ?>" id="InputStockquantity">
                           <label for="" class="required">Stock quantity</label>
                           <input type="text" readonly="readonly" class="form-control" id="Stockquantity" name="Stockquantity" placeholder="Stockquantity" value="<?php echo $get_seed['Stockquantity']; ?>">
                        </div>
                        <div class="form-group <?php if($error['Note']!=''){ echo 'has-error'; } ?>" id="InputNote">
                           <label for="" class="">Note</label>
                           <textarea class="form-control" readonly="readonly" id="Note" name="Note" placeholder="Note"><?php echo $get_seed['Note']; ?></textarea>
                        </div>
                        <div class="form-group <?php if($error['TechnicalData']!=''){ echo 'has-error'; } ?>" id="InputNote">
                           <label for="" class="">Technical Data</label>
                           <textarea class="form-control" readonly="readonly" id="TechnicalData" name="TechnicalData" placeholder="TechnicalData"><?php echo $get_seed['TechnicalData']; ?></textarea>
                        </div>
                        <div class="form-group" >
                           <label for="picture" class="">Attachments</label>
                        </div>
                        <div class="form-group" id="Inputpicture">
                           <div class="row">
                              <?php
                                 if($get_seed['Attachment']!=''){
                                 
                                 if(count($get_seed['Attachment'])>0){
                                 
                                 ?>
                              <div class="custom_box_gallery">
                                 <ul id="lightgallery" class="list-unstyled row">
                                    <?php    
                                       $Attachment = explode(",",$get_seed['Attachment']);  
                                        $i=1;
                                       foreach($Attachment as $Picture){
                                       $ext = pathinfo($Picture, PATHINFO_EXTENSION);
                                       ?>    
                                    <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="<?php echo base_url().'uploads/Seeds/'.$Picture; ?> 375,<?php echo base_url().'uploads/Seeds/'.$Picture; ?> 480, <?php echo base_url().'uploads/Seeds/'.$Picture; ?> 800" data-src="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>" data-sub-html="">
                                       <?php if($ext == 'pdf'){ ?>
                                       <a href="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>" style="text-decoration: none; color: #cc230e;" >
                                          <i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i>
                                          <p style="font-size: 18px; text-align: center; font-weight: 900;">PDF</p>
                                       </a>
                                       <?php }
                                          elseif ($ext == 'docx') {?>
                                       <a href="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>">
                                          <i class="fa fa-file-text-o fa-4x" aria-hidden="true"></i>
                                          <p style="font-size: 18px; text-align: center; font-weight: 900;">Docx</p>
                                       </a>
                                       <?php  }else{?>
                                       <a href="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>">
                                       <img class="img-responsive" aria-hidden="true" src="<?php echo base_url().'uploads/Seeds/'.$Picture; ?>">
                                       </a>
                                       <?php } ?>
                                    </li>
                                    <?php 
                                       $i++;
                                       
                                       }
                                       
                                       ?>
                                 </ul>
                              </div>
                              <?php      
                                 }
                                 
                                 }
                                 
                                 ?>
                           </div>
                        </div>
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
   // $(document).ready(function(){
   
   //     $('#lightgallery').lightGallery({
   
   //       share:false,
   
   //     });
   
   // });
   
   </script>
   <script type="text/javascript">
   $(document).ready(function(){
   
       $('#lightgallery_1').lightGallery({
   
         share:false,
   
       });
   
   });
   
   </script>
<script>
   function goBack() {
     window.history.back();
   }
</script>
<!-- <script type="text/javascript">
   $(document).ready(function(){
       $('#lightgallery').lightGallery({
         share:false,
         selector: '.lightgallery_items'
       });
   });
</script> -->