@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">{{$data['heading']}}</h3>
         </div>
         <div class="">
            <a href="#" class="rec_btn">All Product categorie </a>
         </div>
      </div>
      <div class="add_inve_main">
        <?php if (!empty($get_product_categorie)) { ?>
                 
         <form method="post" id="validate_signup_form">
            @csrf 
              
           
              <div class="row">
                 <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputproduct_type_id">
                    <div class="add_inve_box ">
                       <label for="inve_lab">Product type</label>
                    
                    </div>
                    <span class="help-block"></span>
                 </div>
              </div>
              <div class="row">   
                 <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcategorie_name">
                    <div class="add_inve_box">
                       <label for="inve_lab">Categorie</label>
                       <?php foreach ($get_product_categorie as $key => $value) { ?>
                       <input type="hidden" name="Categorie_ID" value="<?php if(@$value['Categorie_ID']!=''){echo @$value['Categorie_ID']; } ?>">
                       <input type="text" name="categorie_name[]"  placeholder="Enter product categorie name" value="{{$value['categorie_name']}}">
                      <?php } ?>  
                    </div>
                    <span class="help-block"></span>
                 </div>
                 <div class="col-lg-2 col-sm-2">
                    <label for="inve_lab"></label>
                    <br>
                    <button type="button" class="btn btn-success" id="add_new_cat">Add new</button>
                 </div>
               
              </div>
              <div class="row" id="view_pro">
                
              </div>

            <div class="text-end mt_25">
               <?php if ($data['heading']=='Add Categorie') { ?>
                  <button class="btn btn-warning" type="submit">Save</button>
               <?php }elseif($data['heading']=='Edit Categorie'){ ?>
                  <button class="btn btn-warning" type="submit">Update</button>
               <?php } ?>
               <button class="btn btn-secondary" onclick="goBack()">Back</button>
            </div>
         </form>

       <?php } ?>
      </div>
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
   jQuery(document).ready(function() {
     jQuery("#validate_signup_form").submit(function(){
       var datastatus =jQuery(this).attr('data-status');
       jQuery('#validate_signup_form .form-group').removeClass('has-error'); 
       jQuery('#validate_signup_form .help-block').html('');
   
       jQuery('#signup_form_success').html(''); 
       data= jQuery("#validate_signup_form").serialize()+ "&datastatus="+datastatus; 
       var formData = new FormData(this); 
       jQuery('#wait').show(); 
       jQuery.ajax({
         type:"POST",   
         url:"{{ url('save_categorie') }}",   
         datatype: 'JSON',   
         data:formData,   
         cache: false,   
         contentType: false,   
         processData: false,   
         success: function(response) {   
           jQuery('#wait').hide();  
           if(response.error){
   
             jQuery.each( response.error, function( index, value ) {
                 if(value!=''){
                   jQuery('#Input'+index).addClass('has-error');
                   jQuery('#Input'+index+' .help-block').html(value);
                   if(i==1){ 
                     jQuery('#'+index).focus();
                   }
                   i++;
                 }
             });
           }else{
             window.location.href = "productcategorie";
           }
         }
       });
       return false;
     });
   });
</script>
<script type="text/javascript">
   $('body').on("click",'#add_new_cat', function(){
      // alert('yeyg');
      $("#view_pro").append('<div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcategorie_name"><div class="add_inve_box"><input type="text" name="categorie_name[]"  placeholder="Enter product categorie name"></div></div>');

   });
</script>