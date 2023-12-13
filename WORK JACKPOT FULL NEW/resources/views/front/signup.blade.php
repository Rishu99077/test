<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("customer.text_provider_reg")}} - {{__("customer.text_work_jackpot")}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Fevi icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/site_icon.png')}}">

    <!-- google captcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    

    <!-- Fontawesome Link  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Theme Color -->
    <meta name="theme-color" content="#082D40 ">

    <!-- *slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">

    <link href="{{ asset('assets/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
</head>
<style type="text/css">
  select {width: 100%;border: none;border-bottom: 2px solid var(--purpule);padding: 10px 0;font-size: 16px;}
  .is-invalid{border-color: #dc3545;padding-right: calc(1.5em + 0.75rem);   background-repeat: no-repeat;background-position: right calc(0.375em + 0.1875rem) center;background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);}
  .custom-invalid,.error{width: 100%;margin-top: 0.25rem;font-size: .875em;color: #dc3545;}
  .field-icon{position: absolute;margin-top: 15px;margin-left: -30px;}
</style>

<body>

    <header class="site_header">
        <div class="container d-flex align-items-center justify-content-between" id="content">
            <div class="site_logo"><a href="{{url('')}}" class="d-inline-block"><img src="{{ asset('assets/images/logo.png')}}" /></a></div>
        </div>
    </header>
    <div class="main_content">
        <section class="login_sec provider_reg sign log_sign_sec py_56 mb_100">
            <div class="container provider_h100">
                <div class="row align-items-start">
                    <div class="col-md-6  mb-md-0">
                        <div class="login_signup_title mt_40 text-center text-md-start ms-dm-0 mx-auto">
                            <h2 class="clr_purpule f32">{{__("customer.text_welcome_to")}} {{__("customer.text_work_jackpot")}}</h2>
                            <p class="clr_lgrey f_medium">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                        </div>
                        <div class="provider_img">
                            <img src="{{ asset('assets/images/job_provider.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{Route('providersignup')}}" method="post" class="log_frm">
                            @csrf
                            <div class="overflow_scroll">
                                <div class="loginfrm_head">
                                    <h3 class="f24 f_black">{{__("customer.text_reg_by_provider")}}</h3>
                                </div>

                                <div class="form_row">
                                    <label for="f-name">{{__("customer.text_first_name")}}</label>
                                    <input type="text" name="firstname" id="name_comment" value="{{old('firstname')}}" class="{{ $errors->has('firstname') ? 'is-invalid' : ''}}" id="firstname" placeholder='{{__("customer.text_enter")}} {{__("customer.text_first_name")}}' maxlength="25">
                                      @error('firstname')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                </div>

                                <div class="form_row">
                                    <label for="fam-name">{{__("customer.text_family_name")}}</label>
                                    <input type="text" name="familyname" id="family_name_comment" value="{{old('familyname')}}" class="{{ $errors->has('familyname') ? 'is-invalid' : ''}}" id="familyname" placeholder='{{__("customer.text_enter")}} {{__("customer.text_family_name")}}' maxlength="25">
                                    @error('familyname')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror
                                </div>

                                <div class="form_row">
                                    <label for="com-name">{{__("customer.text_company_name")}}</label>
                                    <input type="text"  value="{{old('company_name')}}" name="company_name" class="{{ $errors->has('familyname') ? 'is-invalid' : ''}}" id="company_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}'>
                                      @error('company_name')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                </div>

                                <div class="form_row">
                                    <label for="tax_number">{{__("customer.text_tax_number")}}</label>
                                    <input type="number"  value="{{old('tax_number')}}" name="tax_number" class="{{ $errors->has('tax_number') ? 'is-invalid' : ''}}" id="tax_number" placeholder='{{__("customer.text_enter")}} {{__("customer.text_tax_number")}}'>
                                      @error('tax_number')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                </div>

                                <div class="form_row">
                                    <label for="n-name">{{__("customer.text_company_country")}}</label>
                                    <select name="country" id="country" class="{{ $errors->has('country') ? 'is-invalid' : ''}}">
                                        @foreach($CountryModel as $key => $value)
                                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                                        @endforeach
                                    </select>
                                      @error('country')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                   
                                </div>
                                <div class="form_row">
                                    <label for="n-name">{{__("customer.text_company_state")}}</label>
                                    <select name="state" id="state" class="{{ $errors->has('state') ? 'is-invalid' : ''}}" >
                                        <option value="">{{__("customer.text_select")}} {{__("customer.text_company_state")}}</option>
                                    </select>
                                    @error('state')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                    
                                </div>
                                
                                <div class="form_row">
                                    <label for="city">{{__("customer.text_company_city")}}</label>
                                     <select name="city" id="city" class="{{ $errors->has('city') ? 'is-invalid' : ''}}">
                                        <option value="">{{__("customer.text_select")}} {{__("customer.text_company_city")}}</option>
                                    </select>
                                     @error('city')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                    
                                </div>
                                <div class="form_row">
                                    <label for="n-name">{{__("customer.text_company_street")}}</label>
                                    <input type="text" name="street" value="{{old('street')}}" id="street" class="{{ $errors->has('street') ? 'is-invalid' : ''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_street")}}'>
                                     @error('street')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                </div>

                                <div class="form_row">
                                    <label for="zipcode">{{__("customer.text_company_zipcode")}}</label>
                                    <input type="text" name="zipcode" value="{{old('zipcode')}}" class="{{ $errors->has('zipcode') ? 'is-invalid' : ''}}" id="zipcode" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_zipcode")}}'>
                                    @error('zipcode')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror
                                </div>



                                <div class="form_check_parent" style="display: none;">
                                    <div class="form_row checkbox">
                                        <input type="checkbox"  name="owner_check" id="owner_check" class="show_inner_check">
                                        <label for="owner_check">{{__("customer.text_are_owner_of_company")}}?</label>
                                    </div>
                                    <div class="inner_checked owner_checked ms-4">
                                        
                                        <div class="form_row">
                                            <label for="office_no">{{__("customer.text_office_no")}}</label>
                                            <input type="text" name="office_no" value="{{old('office_no')}}" class="{{ $errors->has('office_no') ? 'is-invalid' : ''}}"id="office_no" placeholder='{{__("customer.text_enter")}} {{__("customer.text_office_no")}}'>
                                            @error('office_no')
                                              <div class="invalid-feedback">
                                                 {{ $message }}
                                              </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form_row">
                                    <label for="phone_no">{{__("customer.text_phone_number")}}</label>
                                    <input type="number" name="phone_no" id="phone_no" class="{{ $errors->has('phone_no') ? 'is-invalid' : ''}}" value="{{old('phone_no')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_phone_number")}}'>
                                    @error('phone_no')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                      @enderror
                                </div>

                                <div class="form_row">
                                    <label for="email">{{__("customer.text_company_email")}}</label>
                                    <input type="email" name="email" id="email" class="{{ $errors->has('email') ? 'is-invalid' : ''}}" value="{{old('email')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_email")}}'>
                                    @error('email')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror
                                </div>

                                <div class="form_row">
                                    <label for="password">{{__("customer.text_password")}}</label>
                                    <input type="password" name="password" id="password-field" value="{{old('password')}}" class="{{ $errors->has('password') ? 'is-invalid' : ''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_password")}}'>

                                    <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                    @error('password')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror
                                </div>


                                <div class="form_row">
                                    <label for="confirm_password">{{__("customer.text_con_password")}}</label>
                                    <input type="password" name="confirm_password" id="password-field-2" value="{{old('confirm_password')}}" class="{{ $errors->has('confirm_password') ? 'is-invalid' : ''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_con_password")}}'>
                                    
                                    <span toggle="#password-field-2" class="fa fa-fw fa-eye-slash field-icon toggle-password-2"></span>
                                    @error('confirm_password')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror
                                </div>


                                <div class="form_row">
                                    <input type="file" name="files" id="files" class="border-0 visually-hidden">
                                    <label for="files"><img src="{{ asset('assets/images/file_up_icon.svg')}}" alt="file icon" class="me-2"> <span class="file_name clr_purpule">{{__("customer.text_add_attachment")}}</span></label>
                                    @error('files')
                                      <div class="custom-invalid">
                                         {{ $message }}
                                      </div>
                                    @enderror

                                </div>

                                <div class="form_row checkbox align-items-start {{ $errors->has('rules') ? 'is-invalid' : ''}}">
                                    <input type="checkbox" name="rules" id="rules">
                                    <label for="rules">{{__("customer.text_i_agree")}} <a href="javascript:void(0)" class="text-decoration-underline">{{__("customer.text_rules")}}</a></label>
                                    
                                </div>
                                @error('rules')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror

                                <div class="form_row checkbox align-items-start {{ $errors->has('gdpr') ? 'is-invalid' : ''}}">
                                    <input type="checkbox" name="gdpr" id="gdpr">
                                    <label for="gdpr">{{__("customer.text_i_read")}} <a href="javascript:void(0)" class="text-decoration-underline">{{__("customer.text_gdpr_terms")}}</a></label>
                                     
                                </div>
                                @error('gdpr')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror

                                <div class="form_row checkbox align-items-start {{ $errors->has('accept_term') ? 'is-invalid' : ''}}">
                                    <input type="checkbox" name="accept_term" id="accept_term">
                                    <label for="accept_term">{{__("customer.text_i_declare")}}</label>
                                    
                                </div>
                                @error('accept_term')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror

                                <div class="captcha_box w-100">
                                    <div class="g-recaptcha" data-sitekey="6Lemk0IgAAAAADVU2_wpUdZoV1w6T3wUPMsLS0i8"></div>
                                </div>

                                 <!-- data-bs-toggle="modal" data-bs-target="#otp_modal" -->
                                <div class="submit_btn pt-3 text-center">
                                    <button type="submit" class="site_btn w_auto">{{__("customer.text_registration")}}</button>
                                </div>

                                <div class="last_btm_row text-center">
                                    <p class="f_bold">{{__("customer.text_already_member")}}? <a href="{{url('login')}}">{{__("customer.text_login")}}</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!--OTP Modal -->
    <div id="otp_modal" class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="javascript:void(0)" id="otp_form" method="post">
                        @csrf
                        <h2 class="f32 text-center">{{__("customer.text_otp_verification")}}</h2>
                        <?php 
                            if(session('temp_session_id')){
                                $get_customer = \App\Models\CustomersModel::where(['id'=>session('temp_session_id')])->first();
                               $email = $get_customer->email;
                            }else{
                                $email = "idname@gmail.com";
                            }
                        ?>
                        <p class="w_236 mx-auto clr_lgrey f14 text-center mb_50">{{__("customer.text_we_sent_verify")}} - {{ $email}}</p>
                        <div class="form_row">
                            <label for="otp">{{__("customer.text_otp")}}</label>
                            <input type="text" name="otp" id="otp" placeholder='{{__("customer.text_enter")}} {{__("customer.text_otp")}}'>
                        </div>
                        <div class="resend_link text-center mb_30">
                            <a href="javascript:void(0);" class="text-decoration-underline clr_green text-center" id="resend_otp_btn">{{__("customer.text_resend")}}</a>
                        </div>
                        <div class="otp_sbmt_btn text-center">
                            <button type="submit" class="site_btn w_auto btn_w180 mx-auto" id="submit">{{__("customer.text_submit")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6a8b7e6905.js" crossorigin="anonymous"></script>

    <!-- slick slider -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>


    <!-- custom js -->
    <script src="{{ asset('assets/js/custom.js')}}"></script>
   
    <script type="text/javascript">
       $('#country').on("change",function(){
           var CountryID = $(this).val();
           if(CountryID==''){
               CountryID = 0;
           }
           $.ajax({
               type:"get",
               url: "{{ url('admin/get_states_by_countryid') }}"+"/"+CountryID,
               success:function(resp){
                   $('#state').html(resp.get_states);
               }
           })
       });
       
       
       $('#state').on("change",function(){
           var StateID = $(this).val();
           if(StateID==''){
               StateID = 0;
           }
           $.ajax({
               type:"get",
               url: "{{ url('admin/get_cities_by_stateid') }}"+"/"+StateID,
               success:function(resp){
                   $('#city').html(resp.get_cities);
               }
           })
       });
    </script>

@if($errors->has('provider_otp_modal'))
<script type="text/javascript">
    $(document).ready(function(){
        $('#otp_modal').modal('show');
    })
</script>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $(".show_inner_check").trigger("click");
        if($('.show_inner_check').is(':checked')){
          $('.show_inner_check').parents('.form_check_parent').find('.inner_checked').show();    
        }
    });
</script>



<script src="{{ asset('assets/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    $("#otp_form").validate({
        rules: {
            otp: {
                required: true,
            },
        },
        messages: {
            otp: {
                required: "Please enter Otp",
            },
        },
        submitHandler: function(form) {
        // $('#submit').html('Please Wait...');
        $("#submit").attr("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('match_otp')}}",
                type: "POST",
                dataType: "json",
                data: $('#otp_form').serialize(),
                success: function(response) {
                    if(response.status == 'success'){
                        $.toast({
                           heading: 'Success',
                           text: response.message,
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'success',
                           hideAfter: 1500,
                           stack: 6
                        });
                        $('#otp_modal').modal().hide();
                        setTimeout(function(){
                           window.location = "{{url('login')}}";
                        }, 2000);
                    }else{
                        $.toast({   
                        heading: 'Error',  
                        text: response.message,  
                        position: 'top-right',   
                        loaderBg: '#fff',   
                        icon: 'error',   
                        hideAfter: 3500,   
                        stack: 6   
                        });
                    }
                    // $("#submit"). attr("disabled", false);
                }
            });
        }
    });

    $('#resend_otp_btn').on("click",function(){
        $("#submit"). attr("disabled", false);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
           url: "{{ url('resend_otp') }}",
           type: "POST",
           dataType: "json",
           success:function(response){
                if(response.status == 'success'){
                    $.toast({
                       heading: 'Success',
                       text: "OTP Sent to Your Registered Email ID",
                       position: 'top-right',
                       loaderBg: '#fff',
                       icon: 'success',
                       hideAfter: 3500,
                       stack: 6
                    });

                }else{
                    $.toast({   
                        heading: 'Error',  
                        text: "Technical Error",  
                        position: 'top-right',   
                        loaderBg: '#fff',   
                        icon: 'error',   
                        hideAfter: 3500,   
                        stack: 6   
                    });
                }
           }
       })
    });
</script>

<!-- Password -->
<script type="text/javascript">
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye-slash fa-eye");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>

<script type="text/javascript">
  $(".toggle-password-2").click(function() {
    $(this).toggleClass("fa-eye-slash fa-eye");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>


<!-- <script>
$('#name_comment').keyup(function () {
  var characterCount = $(this).val().length,
  current = $('#current_name_comment'),
  maximum = $('#maximum_name_comment'),
  theCount = $('#the-count_name_comment');
  var maxlength = $(this).attr('maxlength');
  var changeColor = 0.75 * maxlength;
  current.text(characterCount);

  if (characterCount > changeColor && characterCount < maxlength) {
    current.css('color', '#FF4500');
    current.css('fontWeight', 'bold');
  }
  else if (characterCount >= maxlength) {
    current.css('color', '#B22222');
    current.css('fontWeight', 'bold');
  }
  else {
    var col = maximum.css('color');
    var fontW = maximum.css('fontWeight');
    current.css('color', col);
    current.css('fontWeight', fontW);
  }
});

$('#family_name_comment').keyup(function () {
  var characterCount = $(this).val().length,
  current = $('#current_family_name_comment'),
  maximum = $('#maximum_family_name_comment'),
  theCount = $('#the-count_family_name_comment');
  var maxlength = $(this).attr('maxlength');
  var changeColor = 0.75 * maxlength;
  current.text(characterCount);

  if (characterCount > changeColor && characterCount < maxlength) {
    current.css('color', '#FF4500');
    current.css('fontWeight', 'bold');
  }
  else if (characterCount >= maxlength) {
    current.css('color', '#B22222');
    current.css('fontWeight', 'bold');
  }
  else {
    var col = maximum.css('color');
    var fontW = maximum.css('fontWeight');
    current.css('color', col);
    current.css('fontWeight', fontW);
  }
});
</script> -->