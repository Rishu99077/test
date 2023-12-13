@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="#" class="site_btn f16 f_bold blue__btn">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("admin.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>

    </div>
    <div class="d-flex top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title w-100">{{$common['heading_title']}}</h3>
    </div>
    
    <form method="post" action="{{ url('admin/save_customer') }}" autocomplete="off" enctype="multipart/form-data">
      @csrf 

      <input type="hidden" name="CustID" value="{{$customer['id']}}">
      <input type="hidden" name="role" value="{{$customer['role']}}">
      <div class="edit_profile_row">
          <div class="edit_profile_all w-100">
              <div class="profile_nameimg">
                  <div class="profile_img">
                      <div class="upload_cv_sec">
                          <div class="form_row m-0 img_preview_main position-relative">
                              <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png,image/gif,image/jpeg">
                              <span class="upload_icon m-0 p-0">
                                  <img src="{{ url('profile',$customer['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                              </span>
                              <label for="prof_img" class="upload_lbl clicktoupload m-0">
                                  <img src="{{ asset('assets/images/camera.png') }}" alt="" srcset="">
                              </label>
                          </div>
                      </div>
                  </div>
                  <div class="profile_name">
                      <h3>{{$customer['firstname']}} {{$customer['surname']}}</h3>
                      <p>{{$customer['email']}}</p>
                  </div>
              </div>
              <div class="profile_btns p-0">
                  <div class="form_row mt-3">
                      <input type="file" name="files" id="files" class="border-0 visually-hidden">
                      <label for="files" class="upload_lbl"><span class="upload_lbl_btn">{{__("admin.text_choose_file")}}</span><span class="file_name clr_purpule">{{__("admin.text_add_attachment")}}</span></label>
                      @error('files')
                        <div class="custom-invalid">
                           {{ $message }}
                        </div>
                      @enderror
                  </div>
              </div>
          </div>
          <p class="f18 clr_purpule f_black">{{__("admin.text_personal_details")}}</p>
          <div class="row edit_form">
              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_first_name")}}</label>
                  <input type="text" name="firstname" value="{{old('firstname',$customer['firstname'])}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_first_name")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('firstname')) { ?> {{
                    $errors->first('firstname') }}
                  <?php } ?>
                  </span>
              </div>
              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_last_name")}}</label>
                  <input type="text" name="surname" value="{{old('surname',$customer['surname'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_last_name")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('surname')) { ?> {{
                    $errors->first('surname') }}
                  <?php } ?>
                  </span>
              </div>
              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_email")}}</label>
                  <input type="email" name="email" readonly value="{{old('email',$customer['email'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_email")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('email')) { ?> {{
                    $errors->first('email') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_phone_number")}}</label>
                  <input type="text" name="phone_number"  value="{{old('phone_number',$customer['phone_number'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_phone_number")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('phone_number')) { ?> {{
                    $errors->first('phone_number') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_address")}}</label>
                  <input type="text" name="address" value="{{old('address',$customer['address'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_address")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('address')) { ?> {{
                    $errors->first('address') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_zipcode")}}</label>
                  <input type="text" name="zip_code" value="{{old('zip_code',$customer['zip_code'])}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_zipcode")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('zip_code')) { ?> {{
                    $errors->first('zip_code') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                 <label>{{__("admin.text_country")}}</label>
                 <select id="CountryID" name="country">
                    <option value="">-- {{__("admin.text_select")}} {{__("admin.text_country")}} --</option>
                    <?php foreach ($get_countries as $type_key => $val_con) { ?>
                    <option value="<?php echo $val_con['id']; ?>" <?php echo $customer['country'] == $val_con['id'] ? "selected" : "" ;?>><?php echo $val_con['name']; ?></option>
                    <?php } ?>
                 </select>
                 <span class="text-danger"> 
                 <?php if ($errors->has('country')) { ?> {{
                 $errors->first('country') }}
                 <?php } ?>
                 </span>
              </div>

              <div class="col-lg-4 col-md-6">
                 <label>{{__("admin.text_province")}}</label>
                 <select  id="StateID" name="state">
                    <option value="">-- {{__("admin.text_select")}} {{__("admin.text_province")}} --</option>
                    @if($customer['country'] !="")
                    @foreach($StateModel as $key => $state)
                    <option value="{{$state['id']}}"<?php echo $customer['state'] == $state['id'] ? "selected" : "" ;?>><?php echo $state['name']; ?></option>
                    @endforeach
                    @endif
                 </select>
                 <span class="text-danger"> 
                 <?php if ($errors->has('state')) { ?> {{
                 $errors->first('state') }}
                 <?php } ?>
                 </span>
              </div>

              <div class="col-lg-4 col-md-6">
                 <label>{{__("admin.text_city")}}</label>
                 <select id="CityID" name="city">
                    <option value="">-- {{__("admin.text_select")}} {{__("admin.text_city")}} --</option>
                    @if($customer['country'] !="")
                    @foreach($CityModel as $key => $city)
                    <option value="{{$city['id']}}"<?php echo $customer['city'] == $city['id'] ? "selected" : "" ;?>><?php echo $city['name']; ?></option>
                    @endforeach
                    @endif
                 </select>
                 <span class="text-danger"> 
                 <?php if ($errors->has('city')) { ?> {{
                 $errors->first('city') }}
                 <?php } ?>
                 </span>
              </div>

              @if($customer['role']=='seeker')
              <div class="col-lg-12 col-md-6">
                  <div class="form_row ">
                      <p class="f18 clr_purpule f_black"> {{__("admin.text_education_detail")}}</p>
                      <div class="form_row w-100 three_input_clone">
                          <div class="all_available_input">
                              @if(count($customer['education'])>0)
                                @foreach($customer['education'] as $key => $value) 
                                  <div class="single_input  mb_12 flex-wrap justify-content-between">
                                      <div class="group_input_single wid_32p">
                                          <label for="scl_name">{{__("admin.text_school_name")}}</label>
                                          <input type="text" name="school_name[]" value="{{$value['school_name']}}"  id="scl_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_name")}}' class="mb_12">
                                      </div>
                                      <div class="group_input_single wid_32p">
                                          <label for="scl_address">{{__("admin.text_school_add_zip")}}</label>
                                          <input type="text" name="school_address[]" value="{{$value['school_address']}}"  id="scl_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_add_zip")}}' class="mb_12">
                                      </div>
                                      <div class="group_input_single wid_32p">
                                          <label for="scl_years">{{__("admin.text_school_years")}}</label>
                                          <input type="text" name="school_year[]"  value="{{$value['school_year']}}" id="scl_years"  placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_years")}}' class="mb_12">
                                      </div>
                                      <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                                  </div>                                
                                @endforeach
                              @else
                                  <div class="single_input d-flex mb_12   flex-wrap justify-content-between">
                                      <div class="group_input_single wid_32p">
                                          <label for="scl_name">{{__("admin.text_school_name")}}</label>
                                          <input type="text" name="school_name[]" id="school_name"  placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_name")}}' class="mb_12">
                                      </div>

                                      <div class="group_input_single wid_32p">
                                          <label for="scl_address">{{__("admin.text_school_add_zip")}}</label>
                                          <input type="text" name="school_address[]" id="school_address"  placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_add_zip")}}' class="mb_12">
                                      </div>

                                      <div class="group_input_single wid_32p">
                                          <label for="scl_years">{{__("admin.text_school_years")}}</label>
                                          <input type="text" name="school_year[]" id="school_year" placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_years")}}' class="mb_12">
                                      </div>
                                  </div>
                              @endif
                              

                              <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                                  <div class="group_input_single wid_32p">
                                      <label for="scl_name">{{__("admin.text_school_name")}}</label>
                                      <input type="text" name="school_name[]" id="scl_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_name")}}' class="mb_12">
                                  </div>
                                  <div class="group_input_single wid_32p">
                                      <label for="scl_address">{{__("admin.text_school_add_zip")}}</label>
                                      <input type="text" name="school_address[]" id="scl_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_add_zip")}}' class="mb_12">
                                  </div>
                                  <div class="group_input_single wid_32p">
                                      <label for="scl_years">{{__("admin.text_school_years")}}</label>
                                      <input type="text" name="school_year[]" id="scl_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_school_years")}}' class="mb_12">
                                  </div>
                                  <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                              </div>

                          </div>
                          <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-12 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_hiring_history")}}</p>
                  <div class="form_row w-100 three_input_clone">
                      <div class="all_available_input">
                          @if(count($customer['hiring_history'])>0)
                            @foreach($customer['hiring_history'] as $key => $value4) 
                              <div class="single_input  mb_12 flex-wrap justify-content-between">
                                  <div class="group_input_single wid_32p">
                                      <label for="hr_cmp_name">{{__("admin.text_company_name")}}</label>
                                      <input type="text" name="company_name[]"  value="{{$value4['company_name']}}" id="hr_cmp_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_name")}}' class="mb_12">
                                  </div>
                                  <div class="group_input_single wid_32p">
                                      <label for="cmp_address">{{__("admin.text_company_add_zip")}}</label>
                                      <input type="text" name="company_address[]"  value="{{$value4['company_address']}}" id="cmp_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_add_zip")}}' class="mb_12">
                                  </div>
                                  <div class="group_input_single wid_32p">
                                      <label for="wrking_years">{{__("admin.text_working_years")}}</label>
                                      <input type="text" name="working_years[]" value="{{$value4['working_year']}}"  id="wrking_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_working_years")}}' class="mb_12">
                                  </div>
                                  <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                              </div>
                            @endforeach
                          @else
                            <div class="single_input d-flex flex-wrap justify-content-between">
                                  <div class="group_input_single wid_32p">
                                      <label for="hr_cmp_name">{{__("admin.text_company_name")}}</label>
                                      <input type="text" name="company_name[]" id="company_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_name")}}' class="mb_12">
                                  </div>
                                  <div class="group_input_single wid_32p">
                                      <label for="cmp_address">{{__("admin.text_company_add_zip")}}</label>
                                      <input type="text" name="company_address[]" id="company_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_add_zip")}}' class="mb_12">
                                  </div>
                                  <div class="group_input_single wid_32p">
                                      <label for="wrking_years">{{__("admin.text_working_years")}}</label>
                                      <input type="text" name="working_years[]" id="working_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_working_years")}}' class="mb_12">
                                  </div>
                              </div>
                          @endif                            
                      </div>

                      <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                          <div class="group_input_single wid_32p">
                              <label for="hr_cmp_name">{{__("admin.text_company_name")}}</label>
                              <input type="text" name="company_name[]" id="hr_cmp_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_name")}}' class="mb_12">
                          </div>
                          <div class="group_input_single wid_32p">
                              <label for="cmp_address">{{__("admin.text_company_add_zip")}}</label>
                              <input type="text" name="company_address[]" id="cmp_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_add_zip")}}' class="mb_12">
                          </div>
                          <div class="group_input_single wid_32p">
                              <label for="wrking_years">{{__("admin.text_working_years")}}</label>
                              <input type="text" name="working_years[]" id="wrking_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_working_years")}}' class="mb_12">
                          </div>
                          <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>
              </div>

              <div class="col-lg-12 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_exp_abroad")}}?</p>
                  <div class="form_row w-100 three_input_clone">
                      <div class="all_available_input">
                           @if(count($customer['experiance'])>0)
                              @foreach($customer['experiance'] as $key => $value5) 
                                  <div class="single_input d-flex flex-wrap justify-content-between">
                                      <div class="group_input_single wid_32p">
                                          <label for="hr_cmp_name">{{__("admin.text_company_name")}}</label>
                                          <input type="text" name="hr_cmp_name[]" value="{{$value5['company_name']}}" id="hr_cmp_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_name")}}' class="mb_12">
                                      </div>
                                      <div class="group_input_single wid_32p">
                                          <label for="cmp_address">{{__("admin.text_company_add_zip")}}</label>
                                          <input type="text" name="cmp_address[]" value="{{$value5['company_address']}}" id="cmp_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_add_zip")}}' class="mb_12">
                                      </div>
                                      <div class="group_input_single wid_32p">
                                          <label for="wrking_years">{{__("admin.text_working_years")}}</label>
                                          <input type="text" name="wrking_years[]" value="{{$value5['working_year']}}" id="wrking_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_working_years")}}' class="mb_12">
                                      </div>
                                  </div>
                              @endforeach
                           @else
                            <div class="single_input  mb_12 flex-wrap justify-content-between">
                              <div class="group_input_single wid_32p">
                                  <label for="hr_cmp_name">{{__("admin.text_company_name")}}</label>
                                  <input type="text" name="hr_cmp_name[]" id="hr_cmp_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_name")}}' class="mb_12">
                              </div>
                              <div class="group_input_single wid_32p">
                                  <label for="cmp_address">{{__("admin.text_company_add_zip")}}</label>
                                  <input type="text" name="cmp_address[]" id="cmp_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_add_zip")}}' class="mb_12">
                              </div>
                              <div class="group_input_single wid_32p">
                                  <label for="wrking_years">{{__("admin.text_working_years")}}</label>
                                  <input type="text" name="wrking_years[]" id="wrking_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_working_years")}}' class="mb_12">
                              </div>
                              <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                            </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                          <div class="group_input_single wid_32p">
                              <label for="hr_cmp_name">{{__("admin.text_company_name")}}</label>
                              <input type="text" name="hr_cmp_name[]" id="hr_cmp_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_name")}}' class="mb_12">
                          </div>
                          <div class="group_input_single wid_32p">
                              <label for="cmp_address">{{__("admin.text_company_add_zip")}}</label>
                              <input type="text" name="cmp_address[]" id="cmp_address" placeholder='{{__("admin.text_enter")}} {{__("admin.text_company_add_zip")}}' class="mb_12">
                          </div>
                          <div class="group_input_single wid_32p">
                              <label for="wrking_years">{{__("admin.text_working_years")}}</label>
                              <input type="text" name="wrking_years[]" id="wrking_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_working_years")}}' class="mb_12">
                          </div>
                          <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                     
              </div>



              <div class="col-lg-8 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_profession_detail")}}</p>
                  <div class="form_row w-100 three_input_clone">
                      <div class="all_available_input">
                           @if(count($customer['profession'])>0)
                              @foreach($customer['profession'] as $key => $value6) 
                                  <div class="single_input d-flex flex-wrap justify-content-between">
                                      <div class="group_input_single wid_45pi">
                                          <label for="profs_name">{{__("admin.text_profession_name")}}</label>
                                          <input type="text" name="profs_name[]" value="{{$value6['profession_name']}}" id="profs_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_profession_name")}}' class="mb_12">
                                      </div>
                                      <div class="group_input_single wid_45pi">
                                          <label for="profs_years">{{__("admin.text_profession_years")}}</label>
                                          <input type="text" name="profs_years[]" value="{{$value6['profession_year']}}" id="profs_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_profession_years")}}' class="mb_12">
                                      </div>
                                  </div>
                              @endforeach
                           @else
                            <div class="single_input  mb_12 flex-wrap justify-content-between">
                              <div class="group_input_single wid_45pi">
                                  <label for="profs_name">{{__("admin.text_profession_name")}}</label>
                                  <input type="text" name="profs_name[]" id="profs_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_profession_name")}}' class="mb_12">
                              </div>
                              <div class="group_input_single wid_45pi">
                                  <label for="profs_years">{{__("admin.text_profession_years")}}</label>
                                  <input type="text" name="profs_years[]" id="profs_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_profession_years")}}' class="mb_12">
                              </div>
                              <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                            </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12 flex-wrap justify-content-between">
                          <div class="group_input_single wid_45pi">
                              <label for="profs_name">{{__("admin.text_profession_name")}}</label>
                              <input type="text" name="profs_name[]" id="profs_name" placeholder='{{__("admin.text_enter")}} {{__("admin.text_profession_name")}}' class="mb_12">
                          </div>
                          <div class="group_input_single wid_45pi">
                              <label for="profs_years">{{__("admin.text_profession_years")}}</label>
                              <input type="text" name="profs_years[]" id="profs_years" placeholder='{{__("admin.text_enter")}} {{__("admin.text_profession_years")}}' class="mb_12">
                          </div>
                          <div class="remove_btn text-end w-100"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                     
              </div>

              <div class="col-lg-12 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_skills")}}</p>
                  <div class="col-lg-4 col-md-6">
                    <div class="form_row">
                        <label for="information">{{__("admin.text_skills")}}</label>
                        <div class="all_available_input row">
                            @if(count($customer['skills'])>0)
                             @foreach($customer['skills'] as $key => $value1)
                                <div class="single_input col-lg-4 col-md-6 mb_12 wid_45pi">
                                    <input type="text" name="skills[]" id="skills" value="{{$value1}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_skills")}}' class="mb_12">
                                    <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                                </div>
                             @endforeach
                            @else
                               <div class="single_input col-lg-4 col-md-6 wid_45pi">
                                <input type="text" name="skills[]" id="skills" placeholder='{{__("admin.text_enter")}} {{__("admin.text_skills")}}' class="mb_12">
                               </div>
                            @endif


                        </div>
                        <div class="single_input col-lg-4 col-md-6 wid_45pi for_clone_element mb_12">
                            <input type="text" name="skills[]" id="skills" placeholder='{{__("admin.text_enter")}} {{__("admin.text_skills")}}' class="mb_12">
                            <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                        </div>
                        <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                    </div>
                  </div>
              </div>

              <div class="col-lg-4 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_hobbies")}}</p>
                  <div class="form_row">
                      <label for="information">{{__("admin.text_hobbies")}}</label>
                      <div class="all_available_input">
                          @if(count($customer['hobbies'])>0)
                            @foreach($customer['hobbies'] as $key => $value3)
                              <div class="single_input  mb_12">
                                  <input type="text" name="hobbies[]" id="hobbies" value="{{$value3}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_interest_hobbies")}}' class="mb_12">
                                  <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">Remove(-)</a></div>
                              </div>
                            @endforeach
                          @else
                          <div class="single_input">
                              <input type="text" name="hobbies[]" id="hobbies" placeholder='{{__("admin.text_enter")}} {{__("admin.text_interest_hobbies")}}' class="mb_12">
                          </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12">
                          <input type="text" name="hobbies[]" id="hobbies" placeholder='{{__("admin.text_enter")}} {{__("admin.text_interest_hobbies")}}' class="mb_12">
                          <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                    
              </div>

              <!-- Permission -->
              <div class="col-lg-4 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_permissions")}}</p>
                  <div class="form_row">
                      <label for="information">{{__("admin.text_permissions")}}</label>
                      <div class="all_available_input">
                          @if(count($customer['permission'])>0)
                            @foreach($customer['permission'] as $key => $value_per)
                              <div class="single_input  mb_12">
                                  <input type="text" name="permission[]" id="permission" value="{{$value_per['permission']}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_interest_hobbies")}}' class="mb_12">
                                  <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                              </div>
                            @endforeach
                          @else
                          <div class="single_input">
                              <input type="text" name="permission[]" id="permission" placeholder='{{__("admin.text_enter")}} {{__("admin.text_permissions")}}' class="mb_12">
                          </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12">
                          <input type="text" name="permission[]" id="permission" placeholder='{{__("admin.text_enter")}} {{__("admin.text_permissions")}}' class="mb_12">
                          <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                    
              </div>

              <!-- other knowledge -->
              <div class="col-lg-4 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_other_knowledge")}}</p>
                  <div class="form_row">
                      <label for="information">{{__("admin.text_other_knowledge")}}</label>
                      <div class="all_available_input">
                          @if(count($customer['others'])>0)
                            @foreach($customer['others'] as $key => $value_knowledge)
                              <div class="single_input  mb_12">
                                  <input type="text" name="other_knowledge[]" id="other_knowledge" value="{{$value_knowledge['other_knowledge']}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_other_knowledge")}}' class="mb_12">
                                  <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                              </div>
                            @endforeach
                          @else
                          <div class="single_input">
                              <input type="text" name="other_knowledge[]" id="other_knowledge" placeholder='{{__("admin.text_enter")}} {{__("admin.text_other_knowledge")}}' class="mb_12">
                          </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12">
                          <input type="text" name="other_knowledge[]" id="other_knowledge" placeholder='{{__("admin.text_enter")}} {{__("admin.text_other_knowledge")}}' class="mb_12">
                          <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                    
              </div>


              <!-- Langugaes -->
              <div class="col-lg-4 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_languages")}}</p>
                  <div class="form_row">
                      <label for="information">{{__("admin.text_languages")}}</label>
                      <div class="all_available_input">
                          @if(count($customer['cust_languages'])>0)
                            @foreach($customer['cust_languages'] as $key => $value_lang)
                              <div class="single_input  mb_12">
                                  <input type="text" name="languages[]" id="languages" value="{{$value_lang['language']}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_languages")}}' class="mb_12">
                                  <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                              </div>
                            @endforeach
                          @else
                          <div class="single_input">
                              <input type="text" name="languages[]" id="languages" placeholder='{{__("admin.text_enter")}} {{__("admin.text_languages")}}' class="mb_12">
                          </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12">
                          <input type="text" name="languages[]" id="languages" placeholder='{{__("admin.text_enter")}} {{__("admin.text_languages")}}' class="mb_12">
                          <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                    
              </div>

              <!-- Add info -->
              <div class="col-lg-4 col-md-6">
                  <p class="f18 clr_purpule f_black">{{__("admin.text_add_info")}}</p>
                  <div class="form_row">
                      <label for="information">{{__("admin.text_add_info")}}</label>
                      <div class="all_available_input">
                          @if(count($customer['add_info'])>0)
                            @foreach($customer['add_info'] as $key => $value_info)
                              <div class="single_input  mb_12">
                                  <input type="text" name="information[]" id="information" value="{{$value_info['information']}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_add_info")}}' class="mb_12">
                                  <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                              </div>
                            @endforeach
                          @else
                          <div class="single_input">
                              <input type="text" name="information[]" id="information" placeholder='{{__("admin.text_enter")}} {{__("admin.text_add_info")}}' class="mb_12">
                          </div>
                          @endif
                      </div>
                      <div class="single_input for_clone_element mb_12">
                          <input type="text" name="information[]" id="information" placeholder='{{__("admin.text_enter")}} {{__("admin.text_add_info")}}' class="mb_12">
                          <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("admin.text_remove")}}(-)</a></div>
                      </div>
                      <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("admin.text_add_more")}}(+)</a></div>
                  </div>                    
              </div>


              @endif
              <div class="row edit_text">
              

                <div class="col-xl-12 justify-content-center text-center">
                    <input type="reset" value='{{__("admin.text_back")}}' class="site_btn act_btn" onclick="goBack()" style="width: 10%!important;">
                    <button type="submit" class="site_btn">{{__("admin.text_update")}}</button>
                </div>
              </div>

          </div>
      </div>
    </form>
</div>
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
@include('admin.layout.footer')