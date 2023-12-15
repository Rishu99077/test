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
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="row">
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputproduct_type_id">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Product type</label>
                     <select class="form-control select2box" id="product_type_id" required name="product_type_id">
                        <option value="">--Select product type--</option>
                        <?php foreach ($get_product_types as $type_key => $val_prod) { ?>
                        <option value="<?php echo $val_prod['id']; ?>" <?php if ($products['product_type_id'] ==  $val_prod['id'] ) echo 'selected' ; ?>><?php echo $val_prod['name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcategorie_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Categorie</label>
                     <input type="hidden" name="Categorie_ID" value="<?php if(@$products['Categorie_ID']!=''){echo @$products['Categorie_ID']; } ?>">
                     <input type="text" name="categorie_name"  placeholder="Enter product categorie name" value="{{$products['categorie_name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <input type="hidden" name="status" value="{{$products['status']}}">
               <input type="hidden" name="User_ID" value="{{$products['User_ID']}}">
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