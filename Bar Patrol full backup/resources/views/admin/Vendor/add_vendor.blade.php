@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">{{$data['heading']}}</h3>
         </div>
         <div class="">
            <a href="{{url('vendors')}}" class="rec_btn">All Vendors </a>
         </div>
      </div>
      <div class="add_inve_main">
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="row">
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputvendor_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Vendor Name</label>
                     <input type="hidden" name="VendorID" value="<?php if(@$vendors['VendorID']!=''){echo @$vendors['VendorID']; } ?>">
                     <input type="text" name="vendor_name"  placeholder="Enter product categorie name" value="{{$vendors['vendor_name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcontact_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Contact Name</label>
                     <input type="text" name="contact_name"  placeholder="Enter Contact name" value="{{$vendors['contact_name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputemail">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Email</label>
                     <input type="email" name="email"  placeholder="Enter email address" value="{{$vendors['email']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputphone_number">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Phone number</label>
                     <input type="number" name="phone_number"  placeholder="Enter phone_number" value="{{$vendors['phone_number']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <input type="hidden" name="status" value="{{$vendors['status']}}">
               <input type="hidden" name="User_ID" value="{{$vendors['User_ID']}}">
            </div>
            <div class="text-end mt_25">
               <?php if ($data['heading']=='Add Vendor') { ?>
                  <button class="btn btn-warning" type="submit">Save</button>
               <?php }elseif($data['heading']=='Edit Vendor'){ ?>
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
         url:"{{ url('save_vendor') }}",  
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
             window.location.href = "vendors";
           }
         }
       });
       return false;
     });
   });
</script>