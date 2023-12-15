@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">{{$data['heading']}}</h3>
         </div>
         <div class="">
            <a href="{{('locations')}}" class="rec_btn">All Locations</a>
         </div>
      </div>
      <div class="add_inve_main">
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="row">
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputlocation_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Location Name</label>
                     <input type="hidden" name="LocationID" value="<?php if(@$locations['LocationID']!=''){echo @$locations['LocationID']; } ?>">
                     <input type="text" name="location_name"  placeholder="Enter icon name" value="{{$locations['location_name']}}">
                     <input type="hidden" name="status" value="{{$locations['status']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
            </div>
            <div class="text-end mt_25">
               <?php if ($data['heading']=='Add location') { ?>
                  <button class="btn btn-warning" type="submit">Save</button>
               <?php }elseif($data['heading']=='Edit location'){ ?>
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
          url:"{{ url('save_locations') }}",
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
             window.location.href = "locations";
           }
         }
       });
       return false;
     });
   
   });
</script>