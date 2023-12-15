@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">Add Icons </h3>
         </div>
         <div class="">
            <a href="#" class="rec_btn">All Icons</a>
         </div>
      </div>
      <div class="add_inve_main">
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="row">
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputicon_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Icon Name</label>
                     <input type="hidden" name="IconID" value="<?php if(@$icons['IconID']!=''){echo @$icons['IconID']; } ?>">
                     <input type="text" name="icon_name"  placeholder="Enter icon name" value="{{$icons['icon_name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputimage">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Icon Image</label>
                     <input class="form-control" name="image" type="file" id="image">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputstatus">
                  <div class="add_inve_box">
                     <label for="inve_lab">Status</label>
                     <div class="position-relative sel">
                        <select id="status" class="form-control" name="status">
                           <option value="1" <?php if($icons['status'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
                           <option value="0" <?php if($icons['status'] == 0){ echo 'selected="selected"'; } ?>>Inactive</option>
                        </select>
                        <span class="sel_drop" for="sel2">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8">
                              <path id="fi-rr-angle-small-down" d="M20.665,8.241a1.163,1.163,0,0,0-1.616,0l-5.241,5.116a1.188,1.188,0,0,1-1.616,0L6.951,8.241a1.163,1.163,0,0,0-1.616,0,1.1,1.1,0,0,0,0,1.578l5.24,5.115a3.488,3.488,0,0,0,4.849,0l5.241-5.116a1.1,1.1,0,0,0,0-1.577Z" transform="translate(-5 -7.914)" fill="#474747"/>
                           </svg>
                        </span>
                     </div>
                  </div>
                  <span class="help-block"></span>
               </div>
            </div>
            <div class="text-end mt_75">
               <a class="submit_btn sav"><button type="submit">Save</button></a>
            </div>
         </form>
      </div>
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
   jQuery(document).ready(function() {
   
     //jQuery('.my_submit_btn').on('click', function() {
   
     jQuery("#validate_signup_form").submit(function(){
   
   
   
       var datastatus =jQuery(this).attr('data-status');
   
       //console.log(datastatus);
   
   
   
       jQuery('#validate_signup_form .form-group').removeClass('has-error');
   
       jQuery('#validate_signup_form .help-block').html('');
   
       
   
       jQuery('#signup_form_success').html('');
   
       data= jQuery("#validate_signup_form").serialize()+ "&datastatus="+datastatus;
   
       var formData = new FormData(this);
   
       jQuery('#wait').show();
   
       jQuery.ajax({
   
         type:"POST",
   
         url:"{{ url('save_icons') }}",
   
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
   
                   //console.log('#Input'+index+' .help-block ' + value);
   
   
   
                   jQuery('#Input'+index).addClass('has-error');
   
                   jQuery('#Input'+index+' .help-block').html(value);
   
                   if(i==1){ 
   
                     jQuery('#'+index).focus();
   
                   }
   
                   i++;
   
                 }
   
             });
   
           }else{
   
             window.location.href = "icons";
   
           }
   
         }
   
       });
   
       return false;
   
   
   
     });
   
   
   
   });
   
</script>