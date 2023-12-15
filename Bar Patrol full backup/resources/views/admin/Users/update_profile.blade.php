@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white"><?php echo $data['heading_title']; ?></h3>
         </div>

      </div>
      <div class="add_inve_main">
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="row">
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputrestaurant_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Restaurant name</label>
                     <input type="text" name="restaurant_name"  placeholder="Enter Restaurant name" value="{{$users['restaurant_name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>  
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputemail">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Email</label>
                     <input type="email" name="email"  placeholder="Enter email address" value="{{$users['email']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
                <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputpassword">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Password</label>
                     <input type="password" name="password"  placeholder="Enter password address" value="{{$users['password']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputphone_no">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Phone number</label>
                     <input type="number" name="phone_no"  placeholder="Enter phone number" value="{{$users['phone_no']}}">
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
         url:"{{ url('save_user') }}",  
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
             window.location.href = "users";
           }
         }
       });
       return false;
     });
   });
</script>