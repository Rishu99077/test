@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">Add Product type</h3>
         </div>
         <div class="">
            <a href="#" class="rec_btn">All Product type </a>
         </div>
      </div>
      <div class="add_inve_main">
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="row">
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputname">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Name</label>
                     <input type="hidden" name="Product_type_Id" value="<?php if(@$products['Product_type_Id']!=''){echo @$products['Product_type_Id']; } ?>">
                     <input type="text" name="name"  placeholder="Enter product type name" value="{{$products['name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputicon">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Icon</label>
                     <select class="form-control select2box" id="icon" required name="icon">
                        <option value="">--Select Icon--</option>
                        <?php foreach ($get_icons as $type_key => $val_prod) { ?>
                        <option value="<?php echo $val_prod['IconID']; ?>" <?php if ($products['icon'] ==  $val_prod['IconID'] ) echo 'selected' ; ?>><?php echo $val_prod['icon_name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <span class="help-block"></span>
               </div>
               <input type="hidden" name="status" value="{{$products['status']}}">
               <input type="hidden" name="User_ID" value="{{$products['User_ID']}}">
            </div>
            <div class="text-end mt_75">
               <button class="btn btn-warning" type="submit">Save</button>
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
         url:"{{ url('save_product_type') }}",
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
             window.location.href = "Product_type";
           }
   
         }
   
       });
       return false;
     });
   });
   
</script>