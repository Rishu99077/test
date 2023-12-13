@include('front.layout.header')
@include('front.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">

        <div class="top_ann_left">
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>

    </div>

    <!-- <h1 class="post_title mb_30">Marketing Clients</h1> -->
    <div class="d-flex top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title w-100">{{__("customer.text_seeker")}} {{__("customer.text_view_profile")}}</h3>
    </div>

    <div class="main_profile_row justify-content-between align-items-start flex-wrap d-flex mb_20">
        <div class="left_profile">           
            <div class="profile_nameimg">
                <div class="profile_img">
                    <div class="upload_cv_sec">
                        <div class="form_row m-0 img_preview_main position-relative">
                            <!-- <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png') }},image/gif,image/jpeg"> -->
                            <span class="upload_icon m-0 p-0">
                              @if($seeker['profile_image'] !="")
                                <img src="{{ url('profile',$seeker['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                              @else
                                <img src="{{ asset('assets/images/bo.png') }}" alt="" class="img_preview" id="img_preview">
                              @endif
                            </span>
                           <!--  <label for="prof_img" class="upload_lbl clicktoupload m-0">
                                <img src="{{ asset('assets/images/camera.png') }}" alt="" srcset="">
                            </label> -->
                        </div>
                    </div>
                </div>
                <div class="profile_name">
                    <h3>{{$seeker['firstname']}}</h3>
                    <!-- <p>{{$seeker['email']}}</p> -->
                </div>
            </div>
            @if($user['role'] == "seeker")
            <div class="profile_btns">
                <a href="{{Route('change_password')}}" class="change_pass"><img src="{{ asset('assets/images/change-pass.png') }}" alt="" srcset=""> {{__("customer.text_change_pass")}}</a>
                <a href="{{Route('edit_profile')}}" class="edit_btn"><img src="{{ asset('assets/images/edit_profile.png') }}" alt="" srcset=""> {{__("customer.text_edit_profile")}}</a>
            </div>
            @endif
            <div class="other_profile_details">
                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/fullname.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_first_name")}}</p>
                        <h3>{{$seeker['firstname']}}</h3>
                    </div>
                </div>
                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/calender.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_date_of_birth")}}</p>
                        <h3>{{date('d - m - Y',strtotime($seeker['dob']))}}</h3>
                    </div>
                </div>
                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/gender.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_gender")}}</p>
                        <h3>{{ucfirst($seeker['gender'])}}</h3>
                    </div>
                </div>

                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/location_n.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_country")}}</p>
                        <h3>{{$seeker['country_name']}}</h3>
                    </div>
                </div>
                @if($user['role'] == "seeker")
                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/email.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_email")}}</p>
                        <h3>{{$seeker['email']}}</h3>
                    </div>
                </div>
                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/phone.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_phone_number")}}</p>
                        <h3>{{$seeker['phone_number']}}</h3>
                    </div>
                </div>
                <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
                    <div class="details_block_icon">
                        <img src="{{ asset('assets/images/location_n.png') }}" alt="" srcset="">
                    </div>
                    <div class="details_block_content">
                        <p>{{__("customer.text_address")}}</p>
                        <h3>{{$seeker['address']}}</h3>
                    </div>
                </div>
                @endif
            </div>

            <div class="text-center mt-3">
                <input type="reset" value='{{__("customer.text_back")}}' class="site_btn act_btn" onclick="goBack()">
            </div>
        </div>
        <div class="profile_right_details">
            <div class="profile_right_sec">
                <h3>{{__("customer.text_education")}}</h3>
                <div class="load_parent">
                    <div class="row">
                    @if(count($seeker['education_source']) >0)
                        <?php $i=1; ?>
                        @foreach($seeker['education_source'] as $key =>$value)
                        <div class="col-xxl-6  mb_20 row align-items-end {{$i > 2 ? 'hidden_content':''}}">
                            <div class="col-lg-3">
                                <p class="m-0">{{$value['school_year']}}</p>
                            </div>
                            <div class="col-lg-9">
                                <p>{{$value['school_name']}}</p>
                                <h4>{{$value['school_address']}}</h4>
                            </div>
                        </div>
                        <?php $i++; ?>
                        @endforeach
                    @else
                        <div class="col-xxl-6  mb_20 row align-items-end">
                            <div class="col-lg-12">
                                <h4>{{__("customer.text_no_info")}}</h4>
                            </div>
                        </div>
                    @endif
                    </div>
                    <div class="more_btn text-center">
                        <a href="javascript:void(0)" class="show_more ">{{__("customer.text_more_detail")}}</a>
                    </div>
                </div>
            </div>
         

            <div class="profile_right_sec">
                <h3>{{__("customer.text_profession")}}</h3>
                    <?php 
                    $i=1;
                    ?>
                    <div class="load_parent">
                     @if(count($seeker['professions'])>0)
                        @foreach($seeker['professions'] as $key => $value6)
                            <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                                <div class="col-md-6 mb-md-0 mb_20">
                                    <h4 class="mb_10">{{__("customer.text_name")}} <span>- {{$value6['profession_name']}}</span></h4>
                                </div>
                                <div class="col-md-6 text-md-end text-start">
                                    <h4 class="mb_10">{{__("customer.text_profession_years")}}</h4>
                                    <p class="m-0">{{$value6['profession_year']}}</p>
                                </div>
                            </div>
                        <?php $i++;?>
                        @endforeach
                    @else
                    <div class="row ">
                        <div class="col-md-12 mb-md-0 mb_20 ">
                            <h4 class="m-0">{{__("customer.text_no_info")}}</h4>
                        </div>
                                
                     </div>
                     @endif
                        <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                        </div>
                    </div>
            </div>
            
            <div class="profile_right_sec">
                <h3>{{__("customer.text_hiring_history")}}</h3>
                    <?php 
                    $i=1;
                    ?>
                    <div class="load_parent">
                     @if(count($seeker['hiring_history'])>0)
                        @foreach($seeker['hiring_history'] as $key => $value2)
                            <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                                <div class="col-md-6 mb-md-0 mb_20">
                                    <h4 class="mb_10">{{__("customer.text_designation")}} <span>- {{$value2['company_name']}}</span></h4>
                                    <p class="m-0">{{$value2['company_address']}}</p>
                                </div>
                                <div class="col-md-6 text-md-end text-start">
                                    <h4 class="mb_10">{{__("customer.text_working_years")}}</h4>
                                    <p class="m-0">{{$value2['working_year']}}</p>
                                </div>
                            </div>
                        <?php $i++;?>
                        @endforeach
                    @else
                    <div class="row ">
                        <div class="col-md-12 mb-md-0 mb_20 ">
                            <h4 class="m-0">{{__("customer.text_no_info")}}</h4>
                        </div>
                                
                     </div>
                     @endif
                        <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                        </div>
                    </div>
            </div>
            <div class="profile_right_sec">
                <h3>{{__("customer.text_exp_abroad")}}</h3>
                    <div class="load_parent">
                        @if(count($seeker['exp_abroad'])>0)
                         <?php  $i=1;?>
                            @foreach($seeker['exp_abroad'] as $key => $value3)
                            <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                                    <div class="col-md-6 mb-md-0 mb_20">
                                        <h4 class="mb_10">{{__("customer.text_designation")}} <span>- {{$value3['company_name']}}</span></h4>
                                        <p class="m-0">{{$value3['company_address']}}</p>
                                    </div>
                                    <div class="col-md-6 text-md-end text-start">
                                        <h4 class="mb_10">{{__("customer.text_working_years")}}</h4>
                                        <p class="m-0">{{$value3['working_year']}}</p>
                                    </div>
                            </div>
                            <?php $i++;?>
                            @endforeach
                        @else
                        <div class="row ">
                            <div class="col-md-12 mb-md-0 mb_20 ">
                                <h4 class="m-0">{{__("customer.text_no_info")}}</h4>
                            </div>
                                    
                         </div>
                         @endif
                            <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                            </div>
                    </div>
            </div>
            
            
            <div class="row mb_30">
                 
                <div class="col-xxl-6 mb_30 mb-xxl-0">
                    <div class="profile_right_sec">
                        <h3>{{__("customer.text_skills")}}</h3>
                        <div class="load_parent ">
                        @if(count($seeker['skills'])>0)
                            <?php $i=1; ?>
                            @foreach($seeker['skills'] as $key => $value4)
                            

                            <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                                <ul>
                                    <li>{{$value4['skill']}}</li>
                                </ul>
                            </div>
                            <?php $i++;?>
                            @endforeach
                        @else
                            <div class="profile_list ">
                                <ul>
                                    <li>{{__("customer.text_no_info")}}</li>
                                </ul>
                            </div>
                        @endif
                            <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-xxl-6">
                       <div class="profile_right_sec">
                          <h3>{{__("customer.text_customer_permission")}}</h3>
                          <div class="load_parent ">
                             @if(count($seeker['permission'])>0)
                             <?php $i=1; ?>
                             @foreach($seeker['permission'] as $key => $value_per)
                             <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                                <ul>
                                   <li>{{$value_per['permission']}}</li>
                                </ul>
                             </div>
                             <?php $i++;?>
                             @endforeach
                             @else
                             <div class="profile_list ">
                                <ul>
                                   <li>{{__("customer.text_no_info")}}</li>
                                </ul>
                             </div>
                             @endif
                             <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                             </div>
                          </div>
                       </div>
                    </div>   
                 </div>


                <div class="row mb_30">
                    <div class="col-xxl-6 mb_30 mb-xxl-0">
                       <div class="profile_right_sec">
                          <h3>{{__("customer.text_languages")}}</h3>
                          <div class="load_parent ">
                             @if(count($seeker['cust_language'])>0)
                             <?php $i=1; ?>
                             @foreach($seeker['cust_language'] as $key => $value_lan)
                             <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                                <ul>
                                   <li>{{$value_lan['language']}}</li>
                                </ul>
                             </div>
                             <?php $i++;?>
                             @endforeach
                             @else
                             <div class="profile_list ">
                                <ul>
                                   <li>{{__("customer.text_no_info")}}</li>
                                </ul>
                             </div>
                             @endif
                             <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                       
                    <div class="col-xxl-6">
                       <div class="profile_right_sec">
                          <h3>{{__("customer.text_other_knowledge")}}</h3>
                          <div class="load_parent ">
                             @if(count($seeker['other_knowledges'])>0)
                             <?php $i=1; ?>
                             @foreach($seeker['other_knowledges'] as $key => $value_other)
                             <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                                <ul>
                                   <li>{{$value_other['other_knowledge']}}</li>
                                </ul>
                             </div>
                             <?php $i++;?>
                             @endforeach
                             @else
                             <div class="profile_list ">
                                <ul>
                                   <li>{{__("customer.text_no_info")}}</li>
                                </ul>
                             </div>
                             @endif
                             <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                             </div>
                          </div>
                       </div>
                    </div>   
                </div>


                <div class="row">   
                    <div class="col-xxl-6  mb-xxl-0">
                       <div class="profile_right_sec">
                          <h3>{{__("customer.text_interest_hobbies")}}</h3>
                          <div class="load_parent">
                             @if(count($seeker['hobbies'])>0)
                             <?php $i=1; ?>
                             @foreach($seeker['hobbies'] as $key => $value5)
                             <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                                <ul>
                                   <li>{{$value5['hobby']}}</li>
                                </ul>
                             </div>
                             <?php $i++;?>
                             @endforeach
                             @else
                             <div class="profile_list ">
                                <ul>
                                   <li>{{__("customer.text_no_info")}}</li>
                                </ul>
                             </div>
                             @endif
                             <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                             </div>
                          </div>
                       </div>
                    </div>

                    <div class="col-xxl-6">
                       <div class="profile_right_sec">
                          <h3>{{__("customer.text_add_info")}}</h3>
                          <div class="load_parent ">
                             @if(count($seeker['add_info'])>0)
                             <?php $i=1; ?>
                             @foreach($seeker['add_info'] as $key => $value_other)
                             <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                                <ul>
                                   <li>{{$value_other['information']}}</li>
                                </ul>
                             </div>
                             <?php $i++;?>
                             @endforeach
                             @else
                             <div class="profile_list ">
                                <ul>
                                   <li>{{__("customer.text_no_info")}}</li>
                                </ul>
                             </div>
                             @endif
                             <div class="more_btn text-center">
                                <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                             </div>
                          </div>
                       </div>
                    </div>  
            
                </div>
            </div>
    </div>

    <div class="row top_bb mb_20 align-items-center justify-content-between">
      <h3 class="title col-md-6 mb-md-0 mb_20">{{__("customer.text_advertisment")}}</h3>
      <div class="col-md-6 text-md-end"><a href="#" class="">{{__("customer.text_view_all")}}</a></div>
     </div>

      <?php if(!$get_advertisment->isEmpty()){ ?>
          <div class="job_card_wrapper ">

              <?php foreach ($get_advertisment as $key => $value7) { ?>
              <div class="job_card">

                  <div class="jcard_top d-flex align-items-center justify-content-between">
                      <div class="jc_left d-flex align-items-center justify-content-between">
                          <div class="jc_left_l">
                              <span>
                                 @if($value7['profile_image'] !="")
                                    <img src="{{ url('profile',$value7['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                                  @else
                                    <img src="{{ asset('assets/images/bo.png') }}" alt="" class="img_preview" id="img_preview">
                                  @endif
                              </span>
                          </div>
                          <div class="jc_left_r">
                              <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($value7['firstname']) > 25) ? substr($value7['firstname'], 0, 25) . '...' : $value7['firstname']; ?></p>
                              <p class="clr_grey f12 mb0 f_bold"> {{__("customer.text_offer_no")}} {{$value7['id']}} <span class="clr_ylw"></span>
                              </p>
                          </div>
                      </div>
                      <div class="jc_right text-end">
                      </div>
                  </div>

                  <div class="jcard_center">

                      <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j1.png') }}" alt=""></span> <span
                              class="jc_inbox2 f_bold clr_prpl f12">{{$value7['experience']}}</span></div>

                      <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j2.png') }}" alt=""></span> <span
                              class="jc_inbox2 f_bold clr_prpl f12">{{$value7['adv_working_hours']}}</span></div>

                      <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j3.png') }}" alt=""></span>
                        <?php if ($value7['driving_license']!='') { ?>
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}}</span>
                        <?php }else{ ?>
                        <span class="jc_inbox2 f_bold clr_prpl f12"> - </span>
                        <?php } ?>

                      </div>

                      <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j4.png') }}" alt=""></span> 
                        <?php if ($value7['own_car']!='') { ?>
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
                        <?php }else{ ?>
                        <span class="jc_inbox2 f_bold clr_prpl f12"> - </span>
                        <?php } ?>
                      </div>

                      <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j5.png') }}" alt=""></span> <span
                              class="jc_inbox2 f_bold clr_prpl f12">{{$value7['work_location']}} </span></div>

                      <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j6.png') }}" alt=""></span> <span
                              class="jc_inbox2 f_bold clr_prpl f12">{{$value7['date']}}</span></div>

                  </div>

                  
                    <div class="jc_footer">
                        <a href="{{Route('advertisment.detail',$value7['id'])}}" class="">{{__("customer.text_post_details")}}<span> <img src="{{asset('assets/images/bot_ar.png') }}" alt=""></span></a>
                    </div>    

              </div>
              <?php } ?>
          </div>
          <?php }else{ ?>
          <div class="container-fluid bg-white text-center no_record">
                <img src="{{asset('assets/images/no_record_face.png')}}">
                <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
            </div>
      <?php } ?> 

</div>
@include('front.layout.footer')