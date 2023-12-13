<html lang="{{App::getLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("front/home.text_work_jackpot")}}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Fevi icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/site_icon.png') }}">

    <!-- Fontawesome Link  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Theme Color -->
    <meta name="theme-color" content="#082D40 ">

    <!-- *slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">

    <!-- custom css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">   
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link href="{{ asset('admin/dashboard/assets/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
</head>

<body>

    <header class="site_header">
        <div class="container d-flex align-items-center justify-content-between" id="content">
            <div class="site_logo"><a href="#" class="d-inline-block"><img src="{{ asset('assets/images/logo.png') }}" /></a></div>
            <div class="nav_menu main-navigation">
                <ul class="d-md-inline-flex d-none flex-end align-items-center">
                    <li><a href="#HOME" class="active">{{__("front/home.text_home")}}</a></li>
                    <li><a href="#ABOUT">{{__("front/home.text_about_us")}}</a></li>
                    <li><a href="#HOWITWORK">{{__("front/home.text_how_it_work")}}</a></li>
                    <li><a href="#FAQ">{{__("front/home.text_faq")}}</a></li>
                    <li><a href="#CONTACT">{{__("front/home.text_contact_us")}}</a></li>
                    <li>
                        <select name="language_converter" id="" class="language_converter changeLang">
                            <?php 
                             $languages = App\Models\LanguagesModel::get();

                             foreach($languages as $key => $value){
                            ?>

                            <option value="{{$value['id']}}"<?php echo session()->get('language_id') == $value['id'] ? "selected" : ""; ?>>{{$value['name']}}</option>
                            <?php 
                             }
                            ?>
                        </select>
                    </li>
                </ul>

                <div class="mobile_menu">
                    <button class="menu-toggle d-block d-md-none">
                        <div class="humbergur__menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    
                        <ul id="#primary-menu" class="d-flex d-md-none">
                            <li><a href="#HOME" class="active">{{__("front/home.text_home")}}</a></li>
                            <li><a href="#ABOUT">{{__("front/home.text_about_us")}}</a></li>
                            <li><a href="#HOWITWORK">{{__("front/home.text_how_it_work")}}</a></li>
                            <li><a href="#FAQ">{{__("front/home.text_faq")}}</a></li>
                            <li><a href="#CONTACT">{{__("front/home.text_contact_us")}}</a></li>
                            <li>
                                <select name="language_converter" id="" class="language_converter">
                                    <option value="English">en</option>
                                    <option value="German">de</option>
                                    <option value="Polish">pl</option>
                                    <option value="Ukraine">ua</option>
                                    <option value="Belarus">be</option>
                                </select>
                            </li>
                        </ul>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <div class="main_content">

        <section class="main_banner" id="HOME">
            <div class="container">
                <div class="row align-items-center reverse_col flex-md-row flex-column-reverse">
                    <div class="col-md-6 ">
                        <div class="banner_content max_511">
                            <p class="clr_green f_bold">{{__("front/home.text_welcome_to")}},</p>
                            <h1 class="f_black clr_purpule">{{__("front/home.text_find_jobs")}} <span class="clr_yellow">{{__("front/home.text_your_life")}}</span></h1>
                            <p>{{__("front/home.text_lorem_lipsum")}}</p>
                            <div class="banner_btns">
                                <a href="{{url('login')}}" class="site_btn">{{__("front/home.text_login")}}</a>
                                <a href="#login_op" class="site_btn trans_bg_btn" data-bs-toggle="modal">{{__("front/home.text_registeration")}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="{{ asset('assets/images/banner_side.png') }}" alt="" srcset="">
                    </div>
                </div>
            </div>
        </section>

        <section class="pt_100 browse_job" id="ABOUT">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="browse_job_heding max_300">
                            <h2>{{__("front/home.text_browse_job")}}</h2>
                            <p>{{__("front/home.text_lorem_lipsum")}}.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mt-md-0 mt-4">
                        <div class="browse_job_blocks">
                            <img src="{{ asset('assets/images/Newest-Jobs.png') }}" alt="" srcset="">
                            <h4>{{__("front/home.text_newest_jobs")}}</h4>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mt-md-0 mt-4">
                        <div class="browse_job_blocks all_jobs">
                            <img src="{{ asset('assets/images/all-jobs.png') }}" alt="" srcset="">
                            <h4>{{__("front/home.text_all_jobs")}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt_100 trusted">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="{{ asset('assets/images/trusted_pic.png') }}" alt="" srcset="" class="w-100 minus_img">
                    </div>
                    <div class="col-md-6">
                        <div class="tblock_content max_540">
                            <h2 class="mb_20 max_342">{{__("front/home.text_trusted_popular")}}</h2>
                            <p>{{__("front/home.text_lorem_lipsum")}}.</p>
                            <div class="banner_btns">
                                <a href="#login_op" data-bs-toggle="modal"class="site_btn">{{__("front/home.text_get_started")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt_100 pb_60 how_its_work" id="HOWITWORK">
            <div class="container">
                <div class="max_390 mb_38">
                    <h2>{{__("front/home.text_how_it_work")}}</h2>
                    <p>{{__("front/home.text_lorem_lipsum")}}.</p>
                </div>
                <div class="seeker_works pb_80">
                    <div class="row align-items-center seeker mb_50">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h3 class="m-0">{{__("front/home.text_as_a_seeker")}}</h3>
                        </div>
                        <div class="col-md-8">
                            <p class="seeker_line">{{__("front/home.text_registration_searching")}}</p>
                        </div>
                    </div>
                    <div class="works_tab">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php $cnt = 1; ?>
                            <?php foreach ($work_seeker as $key => $value) { 
                            $Logo = $value['logo']; ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  <?php if($cnt=='1'){echo 'active'; } ?>"  data-bs-toggle="tab" data-bs-target="#sign_up_<?php echo $key; ?>" type="button" role="tab"> <span class="tab_icon"><img src="{{ url('/Images/Howitwork')}}/{{$Logo}}" alt=""></span><span class="tab_con"> <?php echo $value['title'] ?></span></button>
                            </li>
                            <?php $cnt++; } ?>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <?php $cnt = 1; ?>
                            <?php foreach ($work_seeker as $key => $value) {
                            $Image = $value['image']; ?>
                            <div class="tab-pane fade show <?php if($cnt=='1'){echo 'active'; } ?>" id="sign_up_<?php echo $key; ?>" role="tabpanel" >
                                <div class="tab_content_img">
                                    <img src="{{ url('/Images/Howitwork')}}/{{$Image}}" alt="" srcset="" class="w-100 slider-img">
                                </div>
                                <p class="text-center"><?php echo $value['description'] ?></p>
                            </div>
                            <?php $cnt++; } ?>
                        </div>
                    </div>
                </div>

                <div class="provider_works">
                    <div class="row align-items-center seeker providers mb_50">
                        <div class="col-md-8">
                            <p class="seeker_line text-center">{{__("front/home.text_job_providers_have")}}</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-md-0 mt-3">
                            <h3 class="m-0">{{__("front/home.text_as_a_provider")}}</h3>
                        </div>
                    </div>
                    <div class="works_tab provider_works_tab">
                        <div class="tab-content" id="myTabContent">
                            <?php $cnt = 1; ?>
                            <?php foreach ($work_provider as $key => $value) {
                            $Image = $value['image']; ?>
                            <div class="tab-pane fade show <?php if($cnt=='1'){echo 'active'; } ?>" id="publish_job_<?php echo $key; ?>" role="tabpanel">
                                <div class="tab_content_img">
                                    <img src="{{ url('/Images/Howitwork')}}/{{$Image}}" alt="" srcset="" class="w-100 slider-img">
                                </div>
                                <p class="text-center"><?php echo $value['description'] ?></p>
                            </div>
                            <?php $cnt++; } ?>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php $cnt = 1; ?>
                            <?php foreach ($work_provider as $key => $value) {
                            $Logo = $value['logo']; ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if($cnt=='1'){echo 'active'; } ?>" data-bs-toggle="tab" data-bs-target="#publish_job_<?php echo $key; ?>" type="button" role="tab" aria-selected="true"><span class="tab_con"><?php echo $value['title'] ?></span><span class="tab_icon tab_icon2"><img src="{{ url('/Images/Howitwork')}}/{{$Logo}}" alt=""></span></button>
                            </li>
                            <?php $cnt++; } ?>
                        </ul>
                    </div>
                </div>

            </div>
        </section>

        <section class="py_40 faq_sec" id="FAQ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <img src="{{ asset('assets/images/faq_img.png') }}" alt="" srcset="" class=" minus_img">
                    </div>
                    <div class="col-md-7">
                        <div class="tblock_content ms-md-auto max_540">
                            <h2 class="">{{__("front/home.text_faq")}}</h2>
                            <p class="max_390 mb_20">{{__("front/home.text_lorem_lipsum")}}.</p>

                            <div class="accordion" id="accordionExample">
                                <?php $cnt = 1; ?>
                                <?php foreach ($faqs as $key => $value) { ?>
                                <div class="accordion-item faqs_a">
                                    <h2 class="accordion-header faqs_a_head" id="faq_a">
                                        <button class="accordion-button <?php if($cnt!='1'){echo 'collapsed';} ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqs_a_<?php echo $cnt; ?>">{{$value['title']}}</button>
                                    </h2>
                                    <div id="faqs_a_<?php echo $cnt; ?>" class="accordion-collapse collapse <?php if($cnt=='1'){echo 'show';} ?>" aria-labelledby="faq_a" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>{{$value['description']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <?php $cnt++; } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt_60 pb_80 what_says">
            <div class="container">
                <div class="max_390 mb_38">
                    <h2 class="">{{__("front/home.text_what_says")}}</h2>
                    <p>{{__("front/home.text_lorem_lipsum")}}.</p>
                </div>
                <div class="row align-items-center position-relative">
                    <div class="col-md-6 position-relative mb-md-0 mb-4">
                        <img src="{{ asset('assets/images/group_pic.png') }}" alt="" srcset="" class="w-100">
                        <img src="{{ asset('assets/images/quote.png') }}" class="qImg" alt="">
                    </div>
                    <div class="col-md-6 position-relative">
                        <div class="testimonial_slider">
                            <?php foreach ($testimonials as $key => $value) {
                            $Image = $value['image']; ?>
                            <div class="testi_slides">
                                <img src="{{ url('/Images/Testimonials')}}/{{$Image}}">
                                <h5 class="f_bold">{{$value['name']}}</h5>
                                <p class="client_job mb_20">{{$value['designation']}}</p>
                                <p class="description">
                                    {{$post_data = substr($value['description'], 0, 100);}}
                                    {{$post_data}}
                                </p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <footer class="site_footer position-relative" id="CONTACT">

        <div class="top_footer">
            <div class="container">
                <div class="tfoot_left">
                    <div class="max_350">
                        <h2 class="">{{__("front/home.text_contact_us")}}</h2>
                        <p>{{__("front/home.text_lorem_lipsum")}}.</p>
                    </div>
                    <div class="contact_details col-md-8 p-0">
                        <p><a href="javascript:void(0);"> <img src="{{ asset('assets/images/location.png') }}" alt="" srcset=""> {{__("front/home.text_work_jackpot")}}</a></p>
                        <p><a href="tel:1234 5678 9101"> <img src="{{ asset('assets/images/call.png') }}" alt="" srcset=""> 1234 5678 9101</a></p>
                        <p><a href="mailto:workjackpot@gmail.com"> <img src="{{ asset('assets/images/mail.png') }}" alt="" srcset=""> workjackpot@gmail.com</a></p>
                    </div>
                    <div class="social_icons">
                        <a href="javascript:void(0);"><img src="{{ asset('assets/images/facebook.png') }}" alt="" srcset=""></a>
                        <a href="javascript:void(0);"><img src="{{ asset('assets/images/insta.png') }}" alt="" srcset=""></a>
                        <a href="javascript:void(0);"><img src="{{ asset('assets/images/twitter.png') }}" alt="" srcset=""></a>
                        <a href="javascript:void(0);"><img src="{{ asset('assets/images/linkdin.png') }}" alt="" srcset=""></a>
                    </div>
                </div>

                <div class="foot_contact_form">
                    <form action="{{url('save_contact')}}" method="post" enctype="multipart/form-data">
                        @csrf 
                        <p class="form_row">
                            <label for="">{{__("front/home.text_first_name")}}</label>
                            <input type="text" name="first_name" required placeholder='Enter {{__("front/home.text_first_name")}}'>
                        </p>
                        <p class="form_row">
                            <label for="">{{__("front/home.text_famliy_name")}}</label>
                            <input type="text" name="family_name"  required placeholder='Enter {{__("front/home.text_famliy_name")}}'>
                        </p>
                        <p class="form_row">
                            <label for="">{{__("front/home.text_email_restered")}}</label>
                            <input type="email" name="email" required placeholder='Enter {{__("front/home.text_email_restered")}}'>
                        </p>
                        <p class="form_row">
                            <label for="">{{__("front/home.text_phone_number")}}</label>
                            <input type="number" name="phone" required placeholder='Enter {{__("front/home.text_phone_number")}}'>
                        </p>
                        <p class="form_row">
                            <label for="">{{__("front/home.text_topic")}}</label>
                            <input type="text" name="topic" required placeholder='Enter {{__("front/home.text_topic")}}'>
                        </p>
                        <p class="form_row">
                            <label for="">{{__("front/home.text_message")}}</label>
                            <textarea placeholder='Enter {{__("front/home.text_message")}}' required name="message" rows="3"></textarea>
                        </p>
                        <p class="form_row file_upload_field">
                            <input type="file" required name="attachment" id="files" class="border-0 visually-hidden">
                            <label for="files"><img src="{{ asset('assets/images/file_up_icon.svg') }}" alt="file icon" class="me-2"><span class="file_name clr_purpule">{{__("front/home.text_add_attach")}}</span></label>
                        </p>
                        <p class="form_row text-center m-0">
                            <input type="submit" class="site_btn" value='{{__("front/home.text_submit")}}'>
                            <!-- <button type="submit" class="site_btn">Submit</button> -->
                        </p>
                    </form>
                </div>
            </div>
        </div>

         <!-- Modal -->
        <div class="modal fade" id="login_op" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="f32 text-center mb_50">{{__("front/home.text_select_reg")}} <span class="clr_yellow">{{__("front/home.text_your_need")}}</span></h2>
                        <div class="login_btns mw_220 mx-auto text-center">                        
                            <a href="{{Route('seeker_signup')}}" class="site_btn w-100 mb_20">{{__("front/home.text_a_job_seeker")}}</a>
                            <a href="{{Route('providersignup')}}" class="site_btn trans_bg_btn w-100">{{__("front/home.text_a_provider")}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="main_footer">
            <div class="container">
                <div class="row">
                    <div class="col-12"><a href="#"><img class="foot_logo mb_20" src="{{ asset('assets/images/footer_logo.png') }}" alt="" srcset=""></a></div> 
                    <div class="col-lg-5 col-md-6 mb-md-0 mb-4">
                        <p class="foot_content">{{__("front/home.text_lorem_lipsum")}}.</p>
                    </div>
                    <div class="col-lg-3 col-md-4 offset-lg-0 offset-md-1 offset-0">
                        <ul class="foot_menu">
                            <li><a href="#HOME" class="active">{{__("front/home.text_home")}}</a></li>
                            <li><a href="#ABOUT">{{__("front/home.text_about_us")}}</a></li>
                            <li><a href="#HOWITWORK">{{__("front/home.text_how_it_work")}}</a></li>
                            <li><a href="#FAQ">{{__("front/home.text_faq")}}</a></li>
                            <li><a href="#CONTACT">{{__("front/home.text_contact_us")}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="copyright_sec">
                    <p>© 2022 {{__("front/home.text_work_jackpot")}} — {{__("front/home.text_all_rights")}}.</p>
                </div>
            </div>
        </div>

    </footer>

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
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('admin/dashboard/assets/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>

</body>

</html>
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
<script type="text/javascript">
    $(".changeLang").change(function(){
        // window.location.href = url + "?lang="+ $(this).val();
        var value = $(this).val();

        $.ajax({
           type:"post",
           url: "{{ route('changeLang') }}",
           data:{"value":value,"_token":"{{csrf_token()}}"},
           success:function(resp){
            location.reload();   
           }
       })



    });
  

    
</script>