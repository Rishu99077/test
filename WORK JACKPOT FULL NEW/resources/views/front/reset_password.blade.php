<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("customer.text_reset_pass")}} - {{__("customer.text_work_jackpot")}}</title>

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

    <header class="site_header">
        <div class="container d-flex align-items-center justify-content-between" id="content">
            <div class="site_logo"><a href="#" class="d-inline-block"><img src="{{ asset('admin/assets/images/logo.png') }}" /></a></div>
        </div>
    </header>
    <div class="main_content">
        <section class="login_sec reset_pass pass_bg sign log_sign_sec py_56 d-flex align-items-center">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-md-6 mb-4 mb-md-0">

                    </div>
                    <div class="col-md-6">
                        <form action="{{Route('update_password')}}" autocomplete="off" class="log_frm" method="post">
                            @csrf
                            <div class="overflow_scroll">
                                <div class="loginfrm_head">
                                    <h3 class="f24 f_black">{{__("customer.text_reset_pass")}}</h3>
                                    <p class="f14">Resetting your password is easy. just type your email, and  we will send you email to reset your password </p>
                                </div>
                                <div class="form_row">
                                    <label for="pass">{{__("customer.text_new_password")}}</label>
                                    <input type="hidden" name="id" value="{{request()->id}}">
                                    <input type="password" name="new_password" placeholder='{{__("customer.text_enter")}} {{__("customer.text_new_password")}}'>
                                    <span class="text-danger text_center"> 
                                      <?php if ($errors->has('new_password')) { ?> {{
                                      $errors->first('new_password') }}
                                      <?php } ?>
                                    </span>
                                </div>
                                <div class="form_row">
                                    <label for="confirm_password">{{__("customer.text_con_password")}}</label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder='{{__("customer.text_enter")}} {{__("customer.text_con_password")}}'>
                                    <span class="text-danger text_center"> 
                                      <?php if ($errors->has('confirm_password')) { ?> {{
                                      $errors->first('confirm_password') }}
                                      <?php } ?>
                                    </span>
                                </div>
                                
                                <div class="submit_btn pt-3 text-center">
                                    <button type="submit" class="site_btn w_auto" >{{__("customer.text_submit")}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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