<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('admin/images/favicon2_logo.png') }}" >
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
        <script src="{{ asset('admin/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <link href="{{ asset('admin/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" id="bootstrap-css">
        <link href="{{ asset('admin/css/parsley.css') }}" rel="stylesheet" id="bootstrap-css">
        <script src="{{ asset('admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- toast CSS -->
        <link href="{{ asset('admin/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
        <script src="{{ asset('admin/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
        <script src="{{ asset('admin/js/parsley.js') }}"></script>
        <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" id="bootstrap-css">
    </head>
    <body>     
      <div id="fullscreen_bg" class="fullscreen_bg"/>
         <div class="container text-center main-text">
            <h2 class="text-light">BAR PATROL</h2>
         </div>
         @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
         @if(Session::has($key))
         <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
         @endif
         @endforeach
         <div id="regContainer" class="container">
            <form method="POST"  id="validate_signup_form" autocomplete="on" class="kt-form well form-horizontal" enctype="multipart/form-data" >
               @csrf
               <fieldset>
                  <legend>
                     <center>
                        <h2><b>Registration Form</b></h2>
                     </center>
                  </legend>
                  <br>
                  <div class="form-group" id="Inputrestaurant_name">
                     <label class="col-md-4 control-label">Restaurant name</label>  
                     <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-stats"></i></span>
                           <input name="restaurant_name" placeholder="Enter Restaurant name" class="form-control" type="text">
                        </div>
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputemail">
                     <label class="col-md-4 control-label">E-Mail</label>  
                     <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                           <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
                        </div>
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputpassword">
                     <label class="col-md-4 control-label" >Password</label> 
                     <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                           <input name="password" placeholder="Password" class="form-control"  type="password">
                        </div>
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputconfirm_password">
                     <label class="col-md-4 control-label" >Confirm Password</label> 
                     <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                           <input name="confirm_password" placeholder="Confirm Password" class="form-control"  type="password">
                        </div>
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputcountry">
                    <label class="col-md-4 control-label">Country</label>
                    <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                          <select class="form-control select2box" id="CountryID" name="country">
                              <option value="">-- Select country --</option>
                              <?php foreach ($get_countries as $type_key => $val_con) { ?>
                              <option value="<?php echo $val_con['id']; ?>"><?php echo $val_con['name']; ?></option>
                              <?php } ?>
                           </select>
                      </div>
                    </div>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputstate">
                    <label class="col-md-4 control-label">State</label>
                    <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                          <select class="form-control select2box" id="StateID" name="state">
                              <option value="">-- Select state --</option>
                  
                          </select>
                      </div>
                    </div>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputcity">
                    <label class="col-md-4 control-label">City</label>
                    <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                          <select class="form-control select2box" id="CityID" name="city">
                              <option value="">-- Select city --</option>
                  
                          </select>
                      </div>
                    </div>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="Inputphone_no">
                     <label class="col-md-4 control-label">Contact No.</label>  
                     <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                           <input name="phone_no" placeholder="(+91)" class="form-control" type="text">
                        </div>
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                     <label class="col-md-4 control-label"></label>
                     <div class="col-md-4 text-center"><br>
                        <button type="submit" class="btn btn-warning">SUBMIT<span class="glyphicon glyphicon-send"></span></button>
                     </div>
                  </div>
                  <div class="signup_action text-right">
                    <a href="{{('admin_login')}}">Already have an account ? <span class="text-danger">Login</span></a>
                 </div>
               </fieldset>
            </form>

         </div>
      </div>
    </body>  
<!-- /.container -->
<script type="text/javascript">
   jQuery(document).ready(function() {
     jQuery('#validate_signup_form').on('submit', function() {
   
       jQuery('#validate_signup_form .form-group').removeClass('has-error');
   
       jQuery('#validate_signup_form .help-block').html('');
   
       jQuery('#wait').show();   
       data= jQuery("#validate_signup_form").serialize();   
       var formData = new FormData(this);   
       jQuery.ajax({   
         type:"POST",   
         url:"{{ url('save_signup') }}", 
         data:formData,  
         datatype: 'JSON',   
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
             window.location.href = "{{url('admin_login')}}"; 
           } 
         } 
       }); 
     return false;
     });
   });
  
</script>
<script type="text/javascript">
  $('#CountryID').on("change",function(){
      var CountryID = $(this).val();
      if(CountryID==''){
          CountryID = 0;
      }
      $.ajax({
          type:"get",
          url: "{{ url('get_states_by_countryid') }}"+"/"+CountryID,
          success:function(resp){
              $('#StateID').html(resp.get_states);
          }
      })
  });


  $('#StateID').on("change",function(){
      var StateID = $(this).val();
      if(StateID==''){
          StateID = 0;
      }
      $.ajax({
          type:"get",
          url: "{{ url('get_cities_by_stateid') }}"+"/"+StateID,
          success:function(resp){
              $('#CityID').html(resp.get_cities);
          }
      })
  });
</script>