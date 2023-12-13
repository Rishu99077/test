<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Work Jackpot</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Fevi icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/site_icon.png')}}">
    <!-- Fontawesome Link  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- google captcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Theme Color -->
    <meta name="theme-color" content="#082D40 ">
    <!-- *slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
</head>

<body>
<style type="text/css">
  select {width: 100%;border: none;border-bottom: 2px solid var(--purpule);padding: 10px 0;font-size: 14px;}
  .is-invalid{border-color: #dc3545;padding-right: calc(1.5em + 0.75rem);   background-repeat: no-repeat;background-position: right calc(0.375em + 0.1875rem) center;background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);}
  .custom-invalid,.error{width: 100%;margin-top: 0.25rem;font-size: .875em;color: #dc3545;}
  .help-block{color: red;}
</style>

    <header class="site_header">
        <div class="container d-flex align-items-center justify-content-between" id="content">
            <div class="site_logo"><a href="/" class="d-inline-block"><img src="{{ asset('assets/images/logo.png')}}" /></a></div>
        </div>
    </header>
    <div class="main_content">
        <section class="fill_detail_sec pt_100 pb-2">
            <div class="container">
                <div class="fill_detail_inner bg-white">
                    <!-- <form action="{{url('verification_account')}}" method="post" enctype="multipart/form-data"> -->
                    <form method="POST"  id="validate_signup_form" autocomplete="off" enctype="multipart/form-data">

                    @csrf
                        <h2 class="clr_purpule f32 mb_38">{{__("customer.text_file_your_detail")}}</h2>
                        <p class="f18 clr_purpule f_black">1. {{__("customer.text_personal_details")}}</p>
                        <div class="pernal_details three_inputs d-flex flex-wrap justify-content-between mb_38">
                           
                            <div class="form_row form-group" id="Inputname">
                                <label for="name">{{__("customer.text_first_name")}}</label>
                                <input type="text" name="name" readonly value="{{$customers['firstname']}}" id="name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_first_name")}}'>
                                <span class="help-block"></span>
                            </div>
                            
                            <div class="form_row form-group" id="Inputfamilyname">
                                <label for="familyname">{{__("customer.text_family_name")}}</label>
                                <input type="text" name="familyname" id="familyname" value="{{$customers['familyname']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_family_name")}}'>
                                <span class="help-block"></span>
                            </div>
                           
                            <div class="form_row form-group" id="Inputdob">
                                <label for="dob">{{__("customer.text_date_of_birth")}}</label>
                                <input type="date" name="dob" id="dob" value="{{$customers['dob']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_date_of_birth")}}'>
                                <span class="help-block"></span>
                            </div>
                            
                            <div class="form_row radio_input form-group" id="Inputgender">
                                <p class="f12 f_bold clr_purpule">{{__("customer.text_gender")}}</p>
                                <input type="radio" name="gender" id="male" value="male" checked>
                                <label for="male" class="me-5">{{__("customer.text_male")}}</label>
                                <input type="radio" name="gender" id="female" value="female">
                                <label for="female">{{__("customer.text_female")}}</label>
                                <span class="help-block"></span>
                            </div>
                            
                            <div class="form_row form-group" id="Inputemail">
                                <label for="email">{{__("customer.text_email")}}</label>
                                <input type="email" name="email" id="email" readonly value="{{$customers['email']}}" class="{{ $errors->has('email') ? 'is-invalid' : ''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_email")}}'>
                                <span class="help-block"></span>
                            </div>

                            <div class="form_row form-group" id="Inputphone_no">
                                <label for="phone_no">{{__("customer.text_phone_number")}}</label>
                                <input type="number" name="phone_no" id="phone_no" value="{{$customers['phone_no']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_phone_number")}}'>
                                <span class="help-block"></span>
                            </div>

                            <div class="form_row form-group" id="Inputstreet">
                                <label for="street">{{__("customer.text_street_no")}}</label>
                                <input type="text" name="street"  id="street" value="{{$customers['street']}}"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_street_no")}}'>
                                <span class="help-block"></span>
                            </div>

                            <div class="form_row form-group" id="Inputzipcode">
                                <label for="zipcode">{{__("customer.text_zipcode")}}</label>
                                <input type="text" name="zipcode" id="zipcode" value="{{$customers['zipcode']}}"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_zipcode")}}'>
                                <span class="help-block"></span>
                            </div>

                            <div class="form_row form-group" id="Input">
                                <label for="city">{{__("customer.text_city")}}</label>
                                <input type="text"  readonly value="{{$customers['city_name']}}" id="city" placeholder='{{__("customer.text_enter")}} {{__("customer.text_city")}}'>
                            </div>


                            <div class="form_row form-group" id="Inputpersonal_country">
                                <label for="dob">{{__("customer.text_country")}}</label>
                                <select name="personal_country" id="personal_country" >
                                    <option value="">{{__("customer.text_select")}} {{__("customer.text_country")}}</option>
                                    @foreach($CountryModel as $key => $value)
                                    <option value="{{$value['id']}}" <?php if ($customers['country']==$value['id']) {echo 'selected=selected';} ?>>{{$value['name']}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>

                            <div class="form_row form-group" id="Inputnationality">
                                <label for="nationality">{{__("customer.text_nationality")}}</label>
                                <input type="text" name="nationality" id="nationality" value="{{old('nationality')}}" class="{{ $errors->has('nationality') ? 'is-invalid' : ''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_nationality")}}'>
                                <span class="help-block"></span>
                            </div>

                            <div class="form_row form-group">
                            </div>
                        </div>
                        
                        <div class="education_details d-flex justify-content-between flex-wrap mb_38">
                            <p class="f18 clr_purpule f_black">2. {{__("customer.text_education_detail")}}</p>
                
                            <div class="form_row w-100 three_input_clone">
                                <div class="all_available_input">
                                    <div class="single_input d-flex mb_12 flex-wrap justify-content-between">
                                        <div class="group_input_single wid_29p">
                                            <label for="scl_name">{{__("customer.text_school_name")}}</label>
                                            <input type="text" name="school_name[]" required id="school_name"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_name")}}' class="mb_12">
                                        </div>

                                        <div class="group_input_single wid_29p">
                                            <label for="scl_address">{{__("customer.text_school_add_zip")}}</label>
                                            <input type="text" name="school_address[]" required id="school_address"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_add_zip")}}' class="mb_12">
                                        </div>

                                        <div class="group_input_single wid_29p">
                                            <label for="scl_years">{{__("customer.text_school_years")}}</label>
                                            <input type="text" name="school_year[]" required id="school_year" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_years")}}' class="mb_12">
                                        </div>

                                    </div>

                                    <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                                        <div class="group_input_single wid_29p">
                                            <label for="school_name">{{__("customer.text_school_name")}}</label>
                                            <input type="text" name="school_name[]"  id="school_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_name")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="school_address">{{__("customer.text_school_add_zip")}}</label>
                                            <input type="text" name="school_address[]"  id="school_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_add_zip")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="school_year">{{__("customer.text_school_years")}}</label>
                                            <input type="text" name="school_year[]"  id="school_year" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_years")}}' class="mb_12">
                                        </div>
                                        <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>

                                </div>
                                <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                            </div>
                        </div>

                        <div class="professional_details mb_38">
                            <p class="f18 clr_purpule f_black">3. {{__("customer.text_profession_detail")}}</p>
                            <div class="form_row w-100 two_input_clone">
                                <div class="all_available_input">
                                    <div class="single_input d-flex flex-wrap">
                                        <div class="group_input_single wid_29p mr_79">
                                            <label for="prof_name">{{__("customer.text_profession_name")}}</label>
                                            <input type="text" name="profession_name[]" required id="profession_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}' class="mb_12 {{ $errors->has('school_address') ? 'is-invalid' : ''}}">
                                           
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="prof_years">{{__("customer.text_profession_years")}}</label>
                                            <input type="text" name="profession_year[]" required id="profession_year" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_years")}}' class="mb_12">
                                            
                                        </div>

                                    </div>
                                </div>
                                <div class="single_input for_clone_element mb_12 flex-wrap ">
                                    <div class="group_input_single wid_29p mr_79">
                                        <label for="prof_name">{{__("customer.text_profession_name")}}</label>
                                        <input type="text" name="profession_name[]"  id="prof_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_29p">
                                        <label for="prof_years">{{__("customer.text_profession_years")}}</label>
                                        <input type="text" name="profession_year[]"  id="prof_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_years")}}' class="mb_12">
                                        <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                </div>
                                <div class="add_more_btn text-end" style="width: 65%;"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                            </div>
                        </div>

                        <div class="hiring_history mb_38">
                            <p class="f18 clr_purpule f_black">4. {{__("customer.text_hiring_history")}}</p>
                            <div class="form_row w-100 three_input_clone">
                                <div class="all_available_input">
                                    <div class="single_input d-flex flex-wrap justify-content-between">
                                        <div class="group_input_single wid_29p">
                                            <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                            <input type="text" name="company_name[]" required id="company_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                            
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                            <input type="text" name="company_address[]" required id="company_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                            
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                            <input type="text" name="working_years[]" required id="working_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                        </div>
                                    </div>
                                </div>

                                <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                                    <div class="group_input_single wid_29p">
                                        <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                        <input type="text" name="company_name[]"  id="hr_cmp_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_29p">
                                        <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                        <input type="text" name="company_address[]"  id="cmp_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_29p">
                                        <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                        <input type="text" name="working_years[]"  id="wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                    </div>
                                    <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                                <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                           
                            </div>
                        </div>

                        <div class="work_experience mb_38">
                            <p class="f18 clr_purpule f_black">5. {{__("customer.text_exp_abroad")}}?</p>
                            <div class="form_row w-100 three_input_clone">
                                <div class="all_available_input">
                                    <div class="single_input d-flex flex-wrap justify-content-between">
                                        <div class="group_input_single wid_29p">
                                            <label for="exp_company_name">{{__("customer.text_company_name")}}</label>
                                            <input type="text" name="exp_company_name[]" required id="exp_company_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="exp_company_address">{{__("customer.text_company_add_zip")}}</label>
                                            <input type="text" name="exp_company_address[]" required id="exp_company_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_29p">
                                            <label for="exp_wrking_years">{{__("customer.text_working_years")}}</label>
                                            <input type="text" name="exp_wrking_years[]" required id="exp_wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                        </div>
                                    </div>
                                </div>
                                <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                                    <div class="group_input_single wid_29p">
                                        <label for="exp_company_name">{{__("customer.text_company_name")}}</label>
                                        <input type="text" name="exp_company_name[]"  id="exp_company_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_29p">
                                        <label for="exp_company_address">{{__("customer.text_company_add_zip")}}</label>
                                        <input type="text" name="exp_company_address[]"  id="exp_company_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_29p">
                                        <label for="exp_wrking_years">{{__("customer.text_working_years")}}</label>
                                        <input type="text" name="exp_wrking_years[]"  id="exp_wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                    </div>
                                    <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                                <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                            </div>
                        </div>
                        
                        <div class="three_block d-flex flex-wrap justify-content-between">
                            <div class="block since_when_sec wid_29p">
                                <p class="f18 clr_purpule f_black">6. {{__("customer.text_languages")}}</p>
                                 <div class="form_row">
                                    <label for="languages">{{__("customer.text_languages")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="languages[]" required id="languages"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_languages")}}' class="mb_12">
                                        </div>
                                    </div>
                                    <div class="single_input for_clone_element mb_12">
                                        <input type="text" name="languages[]"  id="languages" placeholder='{{__("customer.text_enter")}} {{__("customer.text_languages")}}' class="mb_12">
                                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                                </div>
                            </div>
                            <div class="block information_sec wid_29p">
                                <p class="f18 clr_purpule f_black">7. {{__("customer.text_permissions")}}</p>
                                <div class="form_row">
                                    <label for="permission">{{__("customer.text_permissions")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="permission[]" required id="permission" placeholder='{{__("customer.text_enter")}} {{__("customer.text_permissions")}}' class="mb_12">
                                        </div>
                                    </div>
                                    <div class="single_input for_clone_element mb_12">
                                        <input type="text" name="permission[]" id="permission" placeholder='{{__("customer.text_enter")}} {{__("customer.text_permissions")}}' class="mb_12">
                                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                                </div>
                            </div>
                            <div class="block add_info_sec wid_29p">
                                <p class="f18 clr_purpule f_black">8.{{__("customer.text_skills")}}</p>
                                <div class="form_row">
                                    <label for="information">{{__("customer.text_skills")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="skills[]" required id="skills" placeholder='{{__("customer.text_enter")}} {{__("customer.text_skills")}}' class="mb_12">
                                        </div>
                                    </div>
                                    <div class="single_input for_clone_element mb_12">
                                        <input type="text" name="skills[]"  id="skills" placeholder='{{__("customer.text_enter")}} {{__("customer.text_skills")}}' class="mb_12">
                                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="three_block d-flex flex-wrap justify-content-between">    
                            <div class="block add_info_sec wid_29p">
                                <p class="f18 clr_purpule f_black">9. {{__("customer.text_other_knowledge")}}</p>
                                <div class="form_row">
                                    <label for="other_knowledge">{{__("customer.text_other_knowledge")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="other_knowledge[]" required id="other_knowledge"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_other_knowledge")}}' class="mb_12">
                                        </div>
                                    </div>
                                    <div class="single_input for_clone_element mb_12">
                                        <input type="text" name="other_knowledge[]"  id="other_knowledge" placeholder='{{__("customer.text_enter")}} {{__("customer.text_other_knowledge")}}' class="mb_12">
                                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                                </div>
                            </div>
                            <div class="block information_sec wid_29p">
                                <p class="f18 clr_purpule f_black">10. {{__("customer.text_add_info")}}</p>
                                <div class="form_row">
                                    <label for="information">{{__("customer.text_information")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="information[]" required id="information" placeholder='{{__("customer.text_enter")}} {{__("customer.text_information")}}' class="mb_12">
                                        </div>
                                    </div>
                                    <div class="single_input for_clone_element mb_12">
                                        <input type="text" name="information[]"  id="information" placeholder='{{__("customer.text_enter")}} {{__("customer.text_information")}}' class="mb_12">
                                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                                </div>
                            </div>

                            <div class="block add_info_sec wid_29p">
                                <p class="f18 clr_purpule f_black">11.{{__("customer.text_interest_hobbies")}}</p>
                                <div class="form_row">
                                    <label for="information">{{__("customer.text_hobbies")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="hobbies[]" required id="hobbies" placeholder='{{__("customer.text_enter")}} {{__("customer.text_hobbies")}}' class="mb_12">
                                        </div>
                                    </div>
                                    <div class="single_input for_clone_element mb_12">
                                        <input type="text" name="hobbies[]"  id="hobbies" placeholder='{{__("customer.text_enter")}} {{__("customer.text_hobbies")}}' class="mb_12">
                                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>
                                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                                </div>
                            </div> 
                            <div class="block add_info_sec wid_29p"></div>
                        </div>

                        <div class="upload_img_cvsec mb_38">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload_cv_sec">
                                        <p class="f18 clr_purpule f_black">12. {{__("customer.text_upload_your_cv")}}</p>
                                        <p class="f14 f_medium clr_lgrey">{{__("customer.text_upload_your_cv_per")}}</p>
                                        <div class="form_row mt-3 form-group" id="Inputfiles">
                                            <input type="file" name="files" id="files" class="border-0 visually-hidden">
                                            <label for="files" class="upload_lbl"><span class="upload_lbl_btn">{{__("customer.text_choose_file")}}</span><span class="file_name clr_purpule">{{__("customer.text_add_attachment")}}</span></label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="upload_cv_sec">
                                        <p class="f18 clr_purpule f_black">13. {{__("customer.text_upload_profile")}}</p>
                                        <div class="form_row mt-3 img_preview_main form-group" id="Inputprofile_image">
                                            <input type="file" name="profile_image" id="profile_image" class="border-0 visually-hidden image_upload" accept="image/x-png')}},image/gif,image/jpeg">
                                            <label for="profile_image" class="upload_lbl">
                                                <span class="upload_icon">
                                                    <img src="{{ asset('assets/images/plus_icon.svg')}}" alt="" class="img_preview" id="img_preview">
                                                </span>
                                            </label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="three_block d-flex flex-wrap justify-content-between">
                            <div class="block since_when_sec wid_29p">
                                <p class="f18 clr_purpule f_black">14. {{__("customer.text_job_search_info")}}</p>
                                 <div class="form_row">
                                    <label for="languages">{{__("customer.text_salary_exp")}}</label>
                                    <input type="text" name="salary_expectaion" id="salary_expectaion" placeholder='{{__("customer.text_enter")}} {{__("customer.text_salary_exp")}}' class="mb_12">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="block information_sec wid_29p">
                                <p class="f18 clr_purpule f_black">15. {{__("customer.text_available")}}</p>
                                <div class="form_row">
                                    <label for="permission">{{__("customer.text_available")}}</label>
                                    <div class="all_available_input">
                                        <div class="single_input">
                                            <input type="text" name="available" required id="available" placeholder='{{__("customer.text_enter")}} {{__("customer.text_available")}}'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block add_info_sec wid_29p">
                                
                            </div>
                        </div>

                        <div class="job_sinfo_sec mb_50">
                    
                            <div class="three_inputs  d-flex flex-wrap justify-content-between mb_38">
                                <div class="form_row form-group" id="Inputsearch_country">
                                    <label for="country_n">{{__("customer.text_country")}} {{__("customer.text_name")}}</label>
                                    <select name="search_country" id="">
                                        <option value="">{{__("customer.text_select")}} {{__("customer.text_country")}}</option>
                                        @foreach($CountryModel as $key => $value)
                                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form_row">
                                    <label for="city_job">{{__("customer.text_city_with_zip")}}</label>
                                    <input type="text" name="city_job" id="city_job" placeholder='{{__("customer.text_enter")}} {{__("customer.text_city_with_zip")}}'>
                                </div>
                                <div class="form_row">
                                    <label for="radius">{{__("customer.text_radius")}}</label>
                                    <input type="text" name="radius" id="radius" placeholder='{{__("customer.text_enter")}} {{__("customer.text_radius")}}'>
                                </div>
                            </div>
                            <div class="map_location" style="display: none;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d66429.08006983723!2d7.079458906157831!3d51.24909240299415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b8d63a5c61d467%3A0x42760fc4a2a7440!2sWuppertal%2C%20Germany!5e0!3m2!1sen!2sin!4v1653204782108!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>

                        <h3 class="f18 f_black mb_20">Lorem Ipsum Is Simply Dummy Text</h3>
                        <div class="detail_content_fill mb_20">
                            <h4 class="f16 f_bold">Lorem Ipsum Is Simply Dummy Text</h4>
                            <p class="f12 f_regular clr_grey">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <h4 class="f16 f_bold">Lorem Ipsum Is Simply Dummy Text</h4>
                            <p class="f12 f_regular clr_grey">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <h4 class="f16 f_bold">Lorem Ipsum Is Simply Dummy Text</h4>
                            <p class="f12 f_regular clr_grey">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <h4 class="f16 f_bold">Lorem Ipsum Is Simply Dummy Text</h4>
                            <p class="f12 f_regular clr_grey">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <h4 class="f16 f_bold">Lorem Ipsum Is Simply Dummy Text</h4>
                            <p class="f12 f_regular clr_grey">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                        <p class="f14 f_regular clr_grey mb_20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

                        <div class="form_row checkbox form-group" id="Inputrules">
                            <input type="checkbox" name="rules" id="rules">
                            <label for="rules">{{__("customer.text_i_agree")}} <a href="javascript:void(0)" class="text-decoration-underline">{{__("customer.text_rules")}}</a></label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form_row checkbox form-group" id="Inputgdpr">
                            <input type="checkbox" name="gdpr" id="gdpr">
                            <label for="gdpr">{{__("customer.text_i_read")}} <a href="javascript:void(0)" class="text-decoration-underline">{{__("customer.text_gdpr_terms")}}</a></label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form_row checkbox mb_30 form-group" id="Inputaccept_term">
                            <input type="checkbox" name="accept_term" id="accept_term">
                            <label for="accept_term">{{__("customer.text_i_declare")}}</label>
                            <span class="help-block"></span>

                        </div>
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <div class="captcha_box">
                                    <div class="g-recaptcha" data-sitekey="6Lemk0IgAAAAADVU2_wpUdZoV1w6T3wUPMsLS0i8"></div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex flex-wrap justify-content-md-end justify-content-center align-items-end text-md-end text-center back_sbmt_btn"> 
                                <a href="{{Route('user_logout')}}" class="back_btn btn_w160_40 mr_30 f16 site_btn btn_purple shadow-none">
                                    <span class="me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14">
                                          <path id="arrow-backward" d="M2.465,7.524,8.481,2.489a.985.985,0,0,1,1.475-.074v3.4h.26c5.683,0,9.9,3.863,9.9,9.118,0,1.83-.877,1.163-1.243.525a9.774,9.774,0,0,0-8.7-5.071H9.955v3.323a1.1,1.1,0,0,1-1.475.074L2.464,9.135A1.106,1.106,0,0,1,2.465,7.524Z" transform="translate(-2.116 -2.116)" fill="#fff" fill-rule="evenodd"/>
                                        </svg>
                                    </span>{{__("customer.text_back")}}
                                </a>
                                <button type="submit" class="site_btn f16 btn_w160_40">{{__("customer.text_submit")}}</button>
                            </div>
                        </div>
                    </form>
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


    <!-- custom js -->
    <script src="{{ asset('assets/js/custom.js')}}"></script>

    <script type="text/javascript">
      jQuery(document).ready(function() {
       jQuery('#validate_signup_form').on('submit', function() {
          // alert('fyedygyw hff');
          // return false;
         jQuery('#validate_signup_form .form-group').removeClass('has-error');

         jQuery('#validate_signup_form .help-block').html('');

         jQuery('#wait').show();   
         data= jQuery("#validate_signup_form").serialize();   
         var formData = new FormData(this);   
         jQuery.ajax({   
           type:"POST",   
           url:"{{ url('save_verfication_account') }}", 
           data:formData,  
           datatype: 'JSON',   
           cache: false,  
           contentType: false,  
           processData: false,  
           success: function(response) {  
            console.log(response);

             jQuery('#wait').hide();   
             if(response.error){  
               var i = 1;
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
               window.location.href = "{{url('login')}}"; 
             } 
           } 
         }); 
       return false;
       });
      });
    </script>

    <script type="text/javascript">
        $('#img_preview').click(function(){
           $('#profile_image').trigger('click');
        });
    </script>