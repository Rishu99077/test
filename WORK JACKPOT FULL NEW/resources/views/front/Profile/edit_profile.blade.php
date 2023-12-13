@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
  .sp_frm_group .site_btn {width: 30%!important;}
  label {color: var(--purpule)!important; font-family: var(--bold)!important;}
  .act_btn {background: #19286b;border-color: #19286b;box-shadow: none;color: #fff!important;}
  .act_btn:hover {background: #fff;border-color: #19286b;box-shadow: none;color: #19286b!important;}
  .wid_45pi{width: 49%!important;}
</style>
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">

        <div class="top_ann_left">
            @if($user['role']=='seeker')
            <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
            @elseif($user['role']=='provider')
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
            @endif  
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>

    </div>
    <div class="d-flex top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title w-100">{{$common['heading_title']}}</h3>
    </div>
    
    <form method="post" action="{{ url('update_profile') }}" autocomplete="off" enctype="multipart/form-data">

    <div class="edit_profile_row">
        <div class="edit_profile_all w-100">
            <div class="profile_nameimg">
                <div class="profile_img">
                    <div class="upload_cv_sec">
                        <div class="form_row m-0 img_preview_main position-relative">
                            <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png,image/gif,image/jpeg">
                            <span class="upload_icon m-0 p-0">
                                <img src="{{ url('profile',$user['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                            </span>
                            <label for="prof_img" class="upload_lbl clicktoupload m-0">
                                <img src="{{ asset('assets/images/camera.png') }}" alt="" srcset="">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="profile_name">
                    <h3>{{$user['firstname']}} {{$user['surname']}}</h3>
                    <p>{{$user['email']}}</p>
                </div>
            </div>
            <div class="profile_btns p-0">
                <div class="form_row mt-3">
                    <input type="file" name="files" id="files" class="border-0 visually-hidden">
                    <label for="files" class="upload_lbl"><span class="upload_lbl_btn">{{__("customer.text_choose_file")}}</span><span class="file_name clr_purpule">{{__("customer.text_add_attachment")}}</span></label>
                    @error('files')
                      <div class="custom-invalid">
                         {{ $message }}
                      </div>
                    @enderror
                </div>
               <!--  <a href="{{Route('change_password')}}" class="change_pass"><img src="{{ asset('assets/images/change-pass.png') }}" alt="" srcset=""> {{__("customer.text_change_pass")}}</a> -->
            </div>
        </div>
        
          <form class="other_profile_details w-100">
          @csrf 
            <p class="f18 clr_purpule f_black">{{__("customer.text_personal_details")}}</p>
            <div class="row edit_form">
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_first_name")}}</label>
                    <input type="text" name="firstname" value="{{old('firstname',$user['firstname'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_first_name")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('firstname')) { ?> {{
                      $errors->first('firstname') }}
                    <?php } ?>
                    </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_family_name")}}</label>
                    <input type="text" name="familyname" value="{{old('familyname',$user['familyname'])}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_family_name")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('familyname')) { ?> {{
                      $errors->first('familyname') }}
                    <?php } ?>
                    </span>
                </div>

                @if($user['role']=='provider')
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_company_name")}}</label>
                    <input type="text" name="company_name" value="{{old('company_name',$user['company_name'])}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('company_name')) { ?> {{
                      $errors->first('company_name') }}
                    <?php } ?>
                    </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_tax_number")}}</label>
                    <input type="text" name="tax_number" value="{{old('tax_number',$user['tax_number'])}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_tax_number")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('tax_number')) { ?> {{
                      $errors->first('tax_number') }}
                    <?php } ?>
                    </span>
                </div>
                @endif
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_phone_number")}}</label>
                    <input type="text" name="phone_number" readonly value="{{old('phone_number',$user['phone_number'])}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_phone_number")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('phone_number')) { ?> {{
                      $errors->first('phone_number') }}
                    <?php } ?>
                    </span>
                </div>


                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_email")}}</label>
                    <input type="email" name="email" readonly value="{{old('email',$user['email'])}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_email")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('email')) { ?> {{
                      $errors->first('email') }}
                    <?php } ?>
                    </span>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label for="street">{{__("customer.text_street")}}</label>
                    <input type="text" name="street" readonly value="{{old('street',$user['street'])}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_street")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('street')) { ?> {{
                      $errors->first('street') }}
                    <?php } ?>
                    </span>
                </div>


                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_zipcode")}}</label>
                    <input type="text" name="zip_code" value="{{old('zip_code',$user['zip_code'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_zipcode")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('zip_code')) { ?> {{
                      $errors->first('zip_code') }}
                    <?php } ?>
                    </span>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_city")}}</label>
                    <input type="text"  readonly value="{{$user['city_name']}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_city")}}' />
                </div>


                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_country")}}</label>
                    <input type="text"  readonly value="{{$user['country_name']}}" id="" placeholder='{{__("customer.text_enter")}} {{__("customer.text_country")}}' />
                </div>

                <div class="col-lg-4 col-md-6" style="display: none;">
                   <label>{{__("customer.text_country")}}</label>
                   <select id="CountryID" name="country">
                      <option value="">-- {{__("customer.text_select")}} {{__("customer.text_country")}} --</option>
                      <?php foreach ($get_countries as $type_key => $val_con) { ?>
                      <option value="<?php echo $val_con['id']; ?>" <?php echo $user['country'] == $val_con['id'] ? "selected" : "" ;?>><?php echo $val_con['name']; ?></option>
                      <?php } ?>
                   </select>
                   <span class="text-danger"> 
                   <?php if ($errors->has('country')) { ?> {{
                   $errors->first('country') }}
                   <?php } ?>
                   </span>
                </div>

                <div class="col-lg-4 col-md-6" style="display: none;">
                   <label>{{__("customer.text_province")}}</label>
                   <select  id="StateID" name="state">
                      <option value="">-- {{__("customer.text_select")}} {{__("customer.text_province")}} --</option>
                      @if($user['country'] !="")
                      @foreach($StateModel as $key => $state)
                      <option value="{{$state['id']}}"<?php echo $user['state'] == $state['id'] ? "selected" : "" ;?>><?php echo $state['name']; ?></option>
                      @endforeach
                      @endif
                   </select>
                   <span class="text-danger"> 
                   <?php if ($errors->has('state')) { ?> {{
                   $errors->first('state') }}
                   <?php } ?>
                   </span>
                </div>

                <div class="col-lg-4 col-md-6" style="display: none;">
                   <label>{{__("customer.text_city")}}</label>
                   <select id="CityID" name="city">
                      <option value="">-- {{__("customer.text_select")}} {{__("customer.text_city")}} --</option>
                      @if($user['country'] !="")
                      @foreach($CityModel as $key => $city)
                      <option value="{{$city['id']}}"<?php echo $user['city'] == $city['id'] ? "selected" : "" ;?>><?php echo $city['name']; ?></option>
                      @endforeach
                      @endif
                   </select>
                   <span class="text-danger"> 
                   <?php if ($errors->has('city')) { ?> {{
                   $errors->first('city') }}
                   <?php } ?>
                   </span>
                </div>
               
              

                @if($user['role']=='seeker')
                <!-- Education detaikls -->
                <div class="col-lg-12 col-md-6">
                    <div class="form_row ">
                        <p class="f18 clr_purpule f_black"> {{__("customer.text_education_detail")}}</p>
                        <div class="form_row w-100 three_input_clone">
                            <div class="all_available_input">
                                @if(count($user['education'])>0)
                                  @foreach($user['education'] as $key => $value) 
                                    <div class="single_input  mb_12 flex-wrap justify-content-between">
                                        <div class="group_input_single wid_32p">
                                            <label for="scl_name">{{__("customer.text_school_name")}}</label>
                                            <input type="text" name="school_name[]" value="{{$value['school_name']}}"  id="scl_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_name")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_32p">
                                            <label for="scl_address">{{__("customer.text_school_add_zip")}}</label>
                                            <input type="text" name="school_address[]" value="{{$value['school_address']}}"  id="scl_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_add_zip")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_32p">
                                            <label for="scl_years">{{__("customer.text_school_years")}}</label>
                                            <input type="text" name="school_year[]"  value="{{$value['school_year']}}" id="scl_years"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_years")}}' class="mb_12">
                                        </div>
                                        <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                    </div>                                
                                  @endforeach
                                @else
                                    <div class="single_input d-flex mb_12   flex-wrap justify-content-between">
                                        <div class="group_input_single wid_32p">
                                            <label for="scl_name">{{__("customer.text_school_name")}}</label>
                                            <input type="text" name="school_name[]" id="school_name"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_name")}}' class="mb_12">
                                        </div>

                                        <div class="group_input_single wid_32p">
                                            <label for="scl_address">{{__("customer.text_school_add_zip")}}</label>
                                            <input type="text" name="school_address[]" id="school_address"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_add_zip")}}' class="mb_12">
                                        </div>

                                        <div class="group_input_single wid_32p">
                                            <label for="scl_years">{{__("customer.text_school_years")}}</label>
                                            <input type="text" name="school_year[]" id="school_year" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_years")}}' class="mb_12">
                                        </div>
                                    </div>
                                @endif
                                

                                <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                                    <div class="group_input_single wid_32p">
                                        <label for="scl_name">{{__("customer.text_school_name")}}</label>
                                        <input type="text" name="school_name[]" id="scl_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_name")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_32p">
                                        <label for="scl_address">{{__("customer.text_school_add_zip")}}</label>
                                        <input type="text" name="school_address[]" id="scl_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_add_zip")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_32p">
                                        <label for="scl_years">{{__("customer.text_school_years")}}</label>
                                        <input type="text" name="school_year[]" id="scl_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_school_years")}}' class="mb_12">
                                    </div>
                                    <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>

                            </div>
                            <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                        </div>
                    </div>
                </div>

                <!-- Hiring history -->
                <div class="col-lg-12 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_hiring_history")}}</p>
                    <div class="form_row w-100 three_input_clone">
                        <div class="all_available_input">
                            @if(count($user['hiring_history'])>0)
                              @foreach($user['hiring_history'] as $key => $value4) 
                                <div class="single_input  mb_12 flex-wrap justify-content-between">
                                    <div class="group_input_single wid_32p">
                                        <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                        <input type="text" name="company_name[]"  value="{{$value4['company_name']}}" id="hr_cmp_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_32p">
                                        <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                        <input type="text" name="company_address[]"  value="{{$value4['company_address']}}" id="cmp_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_32p">
                                        <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                        <input type="text" name="working_years[]" value="{{$value4['working_year']}}"  id="wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                    </div>
                                    <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                              @endforeach
                            @else
                              <div class="single_input d-flex flex-wrap justify-content-between">
                                    <div class="group_input_single wid_32p">
                                        <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                        <input type="text" name="company_name[]" id="company_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_32p">
                                        <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                        <input type="text" name="company_address[]" id="company_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                    </div>
                                    <div class="group_input_single wid_32p">
                                        <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                        <input type="text" name="working_years[]" id="working_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                    </div>
                                </div>
                            @endif                            
                        </div>

                        <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                            <div class="group_input_single wid_32p">
                                <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                <input type="text" name="company_name[]" id="hr_cmp_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                            </div>
                            <div class="group_input_single wid_32p">
                                <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                <input type="text" name="company_address[]" id="cmp_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                            </div>
                            <div class="group_input_single wid_32p">
                                <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                <input type="text" name="working_years[]" id="wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                            </div>
                            <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>
                </div>

                <!-- Study in abroad  -->
                <div class="col-lg-12 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_exp_abroad")}}?</p>
                    <div class="form_row w-100 three_input_clone">
                        <div class="all_available_input">
                             @if(count($user['experiance'])>0)
                                @foreach($user['experiance'] as $key => $value5) 
                                    <div class="single_input d-flex flex-wrap justify-content-between">
                                        <div class="group_input_single wid_32p">
                                            <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                            <input type="text" name="hr_cmp_name[]" value="{{$value5['company_name']}}" id="hr_cmp_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_32p">
                                            <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                            <input type="text" name="cmp_address[]" value="{{$value5['company_address']}}" id="cmp_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_32p">
                                            <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                            <input type="text" name="wrking_years[]" value="{{$value5['working_year']}}" id="wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                        </div>
                                    </div>
                                @endforeach
                             @else
                              <div class="single_input  mb_12 flex-wrap justify-content-between">
                                <div class="group_input_single wid_32p">
                                    <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                    <input type="text" name="hr_cmp_name[]" id="hr_cmp_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                                </div>
                                <div class="group_input_single wid_32p">
                                    <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                    <input type="text" name="cmp_address[]" id="cmp_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                                </div>
                                <div class="group_input_single wid_32p">
                                    <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                    <input type="text" name="wrking_years[]" id="wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                                </div>
                                <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                              </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                            <div class="group_input_single wid_32p">
                                <label for="hr_cmp_name">{{__("customer.text_company_name")}}</label>
                                <input type="text" name="hr_cmp_name[]" id="hr_cmp_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_name")}}' class="mb_12">
                            </div>
                            <div class="group_input_single wid_32p">
                                <label for="cmp_address">{{__("customer.text_company_add_zip")}}</label>
                                <input type="text" name="cmp_address[]" id="cmp_address" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_add_zip")}}' class="mb_12">
                            </div>
                            <div class="group_input_single wid_32p">
                                <label for="wrking_years">{{__("customer.text_working_years")}}</label>
                                <input type="text" name="wrking_years[]" id="wrking_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_years")}}' class="mb_12">
                            </div>
                            <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                     
                </div>

                <!-- Profession details -->
                <div class="col-lg-12 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_profession")}}{{__("customer.text_detail")}}</p>
                    <div class="form_row w-100 three_input_clone">
                        <div class="all_available_input">
                             @if(count($user['profession'])>0)
                                @foreach($user['profession'] as $key => $value6) 
                                    <div class="single_input d-flex flex-wrap justify-content-between">
                                        <div class="group_input_single wid_45pi">
                                            <label for="profs_name">{{__("customer.text_profession_name")}}</label>
                                            <input type="text" name="profs_name[]" value="{{$value6['profession_name']}}" id="profs_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}' class="mb_12">
                                        </div>
                                        <div class="group_input_single wid_45pi">
                                            <label for="profs_years">{{__("customer.text_profession_years")}}</label>
                                            <input type="text" name="profs_years[]" value="{{$value6['profession_year']}}" id="profs_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_years")}}' class="mb_12">
                                        </div>
                                    </div>
                                @endforeach
                             @else
                              <div class="single_input  mb_12 flex-wrap justify-content-between">
                                <div class="group_input_single wid_45pi">
                                    <label for="profs_name">{{__("customer.text_profession_name")}}</label>
                                    <input type="text" name="profs_name[]" id="profs_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}' class="mb_12">
                                </div>
                                <div class="group_input_single wid_45pi">
                                    <label for="profs_years">{{__("customer.text_profession_years")}}</label>
                                    <input type="text" name="profs_years[]" id="profs_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_years")}}' class="mb_12">
                                </div>
                                <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                              </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                            <div class="group_input_single wid_45pi">
                                <label for="profs_name">{{__("customer.text_profession_name")}}</label>
                                <input type="text" name="profs_name[]" id="profs_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}' class="mb_12">
                            </div>
                            <div class="group_input_single wid_45pi">
                                <label for="profs_years">{{__("customer.text_profession_years")}}</label>
                                <input type="text" name="profs_years[]" id="profs_years" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_years")}}' class="mb_12">
                            </div>
                            <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                     
                </div>

                <!-- Skills -->
                <div class="col-lg-4 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_skills")}}</p>
                    <div class="col-lg-12 col-md-12">
                      <div class="form_row">
                          <label for="information">{{__("customer.text_skills")}}</label>
                          <div class="all_available_input row">
                              @if(count($user['skills'])>0)
                               @foreach($user['skills'] as $key => $value1)
                                  <div class="single_input col-lg-12 col-md-12 mb_12">
                                      <input type="text" name="skills[]" id="skills" value="{{$value1}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_skills")}}' class="mb_12">
                                      <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                  </div>
                               @endforeach
                              @else
                                 <div class="single_input col-lg-12 col-md-12">
                                  <input type="text" name="skills[]" id="skills" placeholder='{{__("customer.text_enter")}} {{__("customer.text_skills")}}' class="mb_12">
                                 </div>
                              @endif


                          </div>
                          <div class="single_input col-lg-12 col-md-12  for_clone_element mb_12">
                              <input type="text" name="skills[]" id="skills" placeholder='{{__("customer.text_enter")}} {{__("customer.text_skills")}}' class="mb_12">
                              <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                          </div>
                          <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                      </div>
                    </div>
                </div>

                <!-- Add info -->
                <div class="col-lg-4 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_add_info")}}</p>
                    <div class="form_row">
                        <label for="information">{{__("customer.text_add_info")}}</label>
                        <div class="all_available_input">
                            @if(count($user['add_info'])>0)
                              @foreach($user['add_info'] as $key => $value_info)
                                <div class="single_input  mb_12">
                                    <input type="text" name="information[]" id="information" value="{{$value_info['information']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_add_info")}}' class="mb_12">
                                    <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                              @endforeach
                            @else
                            <div class="single_input">
                                <input type="text" name="information[]" id="information" placeholder='{{__("customer.text_enter")}} {{__("customer.text_add_info")}}' class="mb_12">
                            </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12">
                            <input type="text" name="information[]" id="information" placeholder='{{__("customer.text_enter")}} {{__("customer.text_add_info")}}' class="mb_12">
                            <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                    
                </div>

                <!-- Hobbies -->
                <div class="col-lg-4 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_hobbies")}}</p>
                    <div class="form_row">
                        <label for="information">{{__("customer.text_hobbies")}}</label>
                        <div class="all_available_input">
                            @if(count($user['hobbies'])>0)
                              @foreach($user['hobbies'] as $key => $value3)
                                <div class="single_input  mb_12">
                                    <input type="text" name="hobbies[]" id="hobbies" value="{{$value3}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_interest_hobbies")}}' class="mb_12">
                                    <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                              @endforeach
                            @else
                            <div class="single_input">
                                <input type="text" name="hobbies[]" id="hobbies" placeholder='{{__("customer.text_enter")}} {{__("customer.text_hobbies")}}' class="mb_12">
                            </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12">
                            <input type="text" name="hobbies[]" id="hobbies" placeholder='{{__("customer.text_enter")}} {{__("customer.text_hobbies")}}' class="mb_12">
                            <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                    
                </div>

                <!-- Permission -->
                <div class="col-lg-4 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_permissions")}}</p>
                    <div class="form_row">
                        <label for="information">{{__("customer.text_permissions")}}</label>
                        <div class="all_available_input">
                            @if(count($user['permission'])>0)
                              @foreach($user['permission'] as $key => $value_per)
                                <div class="single_input  mb_12">
                                    <input type="text" name="permission[]" id="permission" value="{{$value_per['permission']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_interest_hobbies")}}' class="mb_12">
                                    <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                              @endforeach
                            @else
                            <div class="single_input">
                                <input type="text" name="permission[]" id="permission" placeholder='{{__("customer.text_enter")}} {{__("customer.text_permissions")}}' class="mb_12">
                            </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12">
                            <input type="text" name="permission[]" id="permission" placeholder='{{__("customer.text_enter")}} {{__("customer.text_permissions")}}' class="mb_12">
                            <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                    
                </div>

                <!-- other knowledge -->
                <div class="col-lg-4 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_other_knowledge")}}</p>
                    <div class="form_row">
                        <label for="information">{{__("customer.text_other_knowledge")}}</label>
                        <div class="all_available_input">
                            @if(count($user['others'])>0)
                              @foreach($user['others'] as $key => $value_knowledge)
                                <div class="single_input  mb_12">
                                    <input type="text" name="other_knowledge[]" id="other_knowledge" value="{{$value_knowledge['other_knowledge']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_other_knowledge")}}' class="mb_12">
                                    <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                              @endforeach
                            @else
                            <div class="single_input">
                                <input type="text" name="other_knowledge[]" id="other_knowledge" placeholder='{{__("customer.text_enter")}} {{__("customer.text_other_knowledge")}}' class="mb_12">
                            </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12">
                            <input type="text" name="other_knowledge[]" id="other_knowledge" placeholder='{{__("customer.text_enter")}} {{__("customer.text_other_knowledge")}}' class="mb_12">
                            <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                    
                </div>


                <!-- Langugaes -->
                <div class="col-lg-4 col-md-6">
                    <p class="f18 clr_purpule f_black">{{__("customer.text_languages")}}</p>
                    <div class="form_row">
                        <label for="information">{{__("customer.text_languages")}}</label>
                        <div class="all_available_input">
                            @if(count($user['cust_languages'])>0)
                              @foreach($user['cust_languages'] as $key => $value_lang)
                                <div class="single_input  mb_12">
                                    <input type="text" name="languages[]" id="languages" value="{{$value_lang['language']}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_languages")}}' class="mb_12">
                                    <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                                </div>
                              @endforeach
                            @else
                            <div class="single_input">
                                <input type="text" name="languages[]" id="languages" placeholder='{{__("customer.text_enter")}} {{__("customer.text_languages")}}' class="mb_12">
                            </div>
                            @endif
                        </div>
                        <div class="single_input for_clone_element mb_12">
                            <input type="text" name="languages[]" id="languages" placeholder='{{__("customer.text_enter")}} {{__("customer.text_languages")}}' class="mb_12">
                            <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                    </div>                    
                </div>

                



                @endif
                <div class="row edit_text">
                

                  <div class="col-xl-12 justify-content-center text-center">
                      <input type="reset" value='{{__("customer.text_back")}}' class="site_btn act_btn" onclick="goBack()" style="width: 10%!important;">
                      <button type="submit" class="site_btn">{{__("customer.text_update")}}</button>
                  </div>
                </div>

            </div>
            
        </form>
    </div>
</div>
@include('front.layout.footer')
<script type="text/javascript">
   $('#CountryID').on("change",function(){
       var CountryID = $(this).val();
       if(CountryID==''){
           CountryID = 0;
       }
       $.ajax({
           type:"get",
           url: "{{ url('admin/get_states_by_countryid') }}"+"/"+CountryID,
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
           url: "{{ url('admin/get_cities_by_stateid') }}"+"/"+StateID,
           success:function(resp){
               $('#CityID').html(resp.get_cities);
           }
       })
   });
</script>