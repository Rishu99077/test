<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("customer.text_login")}} - {{__("customer.text_work_jackpot")}}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Fevi icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/images/site_icon.png') }}">

    <!-- Fontawesome Link  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Theme Color -->
    <meta name="theme-color" content="#082D40 ">

    <!-- *slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/responsive.css') }}">
    <link href="{{ asset('admin/assets/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
</head>

<body>
    <style type="text/css">
        @media (min-width: 1400px){
            .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
              max-width: 1156px;
            }
        }
    </style>

    <header class="site_header">
        <div class="container d-flex align-items-center justify-content-between" id="content">
            <div class="site_logo"><a href="#" class="d-inline-block"><img src="{{ asset('admin/assets/images/logo.png') }}" /></a></div>
        </div>
    </header>
    <div class="main_content">
        <section class="login_sec login_main_sec log_sign_sec py_56 mb_100">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="login_signup_title text-center text-md-start ms-dm-0 mx-auto">
                            <h2 class="clr_white f32 text_shadow_10">{{__("customer.text_welcome_to")}} {{__("customer.text_work_jackpot")}}</h2>
                            <p class="clr_white text_shadow_10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum, quo est. Architecto recusandae, debitis accusamus, illo nam beatae dolorem optio reprehenderit facere dicta.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{url('login')}}" autocomplete="off" class="log_frm" method="post">
                            @csrf    
                            <div class="overflow_scroll mh_auto">
                                <div class="loginfrm_head">
                                    <h3 class="f32">{{__("customer.text_login")}}</h3>
                                    <p class="clr_lgrey f_medium">Lorem ipsum dolor sit amet consectetur.</p>
                                </div>
                                <div class="form_row">
                                    <label for="email">{{__("customer.text_email_phone")}}</label>
                                    <input type="email" required name="email" id="email" value="{{old('email')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_email_phone")}}'>
                                </div>
                                <div class="form_row mb_12">
                                    <label for="pass">{{__("customer.text_password")}}</label>
                                    <input type="password" required name="password" id="pass" value="{{old('password')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_password")}}'>
                                </div>
                                <div class="form_row text-end forget_password">
                                    <a href="{{Route('forgotpassword')}}" class="f14 f_medium">{{__("customer.text_forgot_password")}}?</a>
                                </div>
                                <div class="submit_btn text-center">
                                    <button type="submit" class="site_btn w_auto" >{{__("customer.text_login")}}</button>
                                </div>
                                <div class="last_btm_row text-center">
                                    <p class="f_bold border_b_200">{{__("customer.text_dont_have_acc")}}? <a href="#login_op" data-bs-toggle="modal" >{{__("customer.text_registration")}}</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="login_op" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="f32 text-center mb_50">{{__("customer.text_select_reg")}} <span class="clr_yellow">{{__("customer.text_your_need")}}</span></h2>
                    <div class="login_btns mw_220 mx-auto text-center">                        
                        <a href="{{Route('seeker_signup')}}" class="site_btn w-100 mb_20">{{__("customer.text_a_seeker")}}</a>
                        <a href="{{Route('providersignup')}}" class="site_btn trans_bg_btn w-100">{{__("customer.text_a_provider")}}</a>
                    </div>
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
    <script src="{{ asset('admin/assets/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>

    <!-- custom js -->
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>

    @if($errors->has('error'))
    <script>
       $.toast({   
               heading: 'Error',  
               text: "{{ $errors->first('error') }}",  
               position: 'top-right',   
               loaderBg: '#fff',   
               icon: 'error',   
               hideAfter: 3500,   
               stack: 6   
           });
       
    </script>
    @endif
    @if($errors->has('success'))
    <script>
       $.toast({
           heading: 'Success',
           text: "{{ $errors->first('success') }}",
           position: 'top-right',
           loaderBg: '#fff',
           icon: 'success',
           hideAfter: 3500,
           stack: 6
       });
    </script>
    @endif 