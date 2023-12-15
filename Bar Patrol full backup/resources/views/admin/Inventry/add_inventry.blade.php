@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')

<body onload="myFunction()">
   
         <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
            <div class="">
               <h3 class="f24 mb-0 text-white">Edit Inventries </h3>
            </div>
            <div class="">
               <a href="#" class="rec_btn">All Inventries</a>
            </div>
         </div>
         <div class="add_inve_main">
            <form method="post" id="validate_signup_form">
               @csrf 
               <div class="row">
                  <input type="hidden" name="InventryID" value="<?php if(@$inventries['InventryID']!=''){echo @$inventries['InventryID']; } ?>">
                  <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputinventrie_type">
                     <div class="add_inve_box">
                        <label for="inve_lab">Location<span class="text-danger">*</span></label>
                        <div class="position-relative sel">
                           <select class="form-control select2box" id="location" name="location">
                              <?php foreach ($get_locations as $type_key => $val_cat) { ?>
                              <option value="<?php echo $val_cat['location_name']; ?>" <?php if ($inventries['location_name'] ==  $val_cat['location_name'] ) echo 'selected' ; ?>><?php echo $val_cat['location_name']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputdescription">
                     <div class="add_inve_box ">
                        <label for="inve_lab">Description</label>
                        <input type="text" name="description"  placeholder="Enter description" value="{{$inventries['description']}}">
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputdate">
                     <div class="add_inve_box ">
                        <label for="inve_lab">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date"  placeholder="Enter date" value="{{$inventries['date']}}">
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="col-lg-8 col-sm-6 mb_30 form-group" id="Inputinventrie_notes">
                     <div class="add_inve_box ">
                        <label for="inve_lab">Inventry Notes</label>
                        <input type="text" name="inventrie_notes"  placeholder="Enter inventrie_notes" value="{{$inventries['inventrie_notes']}}">
                     </div>
                  </div>
                  
                  
               </div>
               <div class="text-end mt_75">
                  <a class="submit_btn sav"><button type="submit">Save</button></a>
               </div>
            </form>
         </div>
      </div>
   </div>
   <!-- Modal -->
   
</body>
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
         url:"{{ url('save_inventrie') }}",   
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
             window.location.href = "inventries";
           }
         }
       });
       return false;
     });
   });
   
</script>

<script type="text/javascript">
   jQuery(document).ready(function() {
     jQuery("#modal_signup_form").submit(function(){
       var datastatus =jQuery(this).attr('data-status');
       jQuery('#modal_signup_form .form-group').removeClass('has-error');
       jQuery('#modal_signup_form .help-block').html('');  
       jQuery('#signup_form_success').html('');   
       data= jQuery("#modal_signup_form").serialize()+ "&datastatus="+datastatus;   
       var formData = new FormData(this);   
       jQuery('#wait').show();   
       jQuery.ajax({   
         type:"POST",   
         url:"{{ url('save_inventrie_products') }}",
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
             window.location.href = "add_inventrie";   
           }  
         }  
       });
       return false;
     });
   });
</script>