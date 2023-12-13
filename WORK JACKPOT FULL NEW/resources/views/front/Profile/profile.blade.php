@include('front.layout.header')
@include('front.layout.sidebar')
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
   @if($user['role']=='seeker')
   <div class="main_profile_row justify-content-between align-items-start flex-wrap d-flex">
      <div class="left_profile">
         <div class="profile_nameimg">
            <div class="profile_img">
               <div class="upload_cv_sec">
                  <div class="form_row m-0 img_preview_main position-relative">
                    <span class="upload_icon m-0 p-0">
                     @if($user['profile_image'] !="")
                        <img src="{{ url('profile',$user['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                     @else
                        <img src="{{ asset('assets/images/bo.png') }}" alt="" class="img_preview" id="img_preview">
                     @endif
                    </span>
                  </div>
               </div>
            </div>
            <div class="profile_name">
               <h3>{{$user['firstname']}} {{$user['surname']}}</h3>
               <p>{{$user['email']}}</p>
            </div>
         </div>
         <div class="profile_btns">
            <a href="{{Route('change_password')}}" class="change_pass"><img src="{{ asset('assets/images/change-pass.png') }}" alt="" srcset=""> {{__("customer.text_change_pass")}}</a>
            <a href="{{Route('edit_profile')}}" class="edit_btn"><img src="{{ asset('assets/images/edit_profile.png') }}" alt="" srcset=""> {{__("customer.text_edit_profile")}}</a>
         </div>
         <div class="other_profile_details">
            <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
               <div class="details_block_icon">
                  <img src="{{ asset('assets/images/fullname.png') }}" alt="" srcset="">
               </div>
               <div class="details_block_content">
                  <p>{{__("customer.text_full_name")}}</p>
                  <h3>{{$user['firstname']}} {{$user['familyname']}}</h3>
               </div>
            </div>
            <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
               <div class="details_block_icon">
                  <img src="{{ asset('assets/images/calender.png') }}" alt="" srcset="">
               </div>
               <div class="details_block_content">
                  <p>{{__("customer.text_date_of_birth")}}</p>
                  <h3>{{date('d - m - Y',strtotime($user['dob']))}}</h3>
               </div>
            </div>
            <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
               <div class="details_block_icon">
                  <img src="{{ asset('assets/images/gender.png') }}" alt="" srcset="">
               </div>
               <div class="details_block_content">
                  <p>{{__("customer.text_gender")}}</p>
                  <h3>{{ucfirst($user['gender'])}}</h3>
               </div>
            </div>
            <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
               <div class="details_block_icon">
                  <img src="{{ asset('assets/images/email.png') }}" alt="" srcset="">
               </div>
               <div class="details_block_content">
                  <p>{{__("customer.text_email")}}</p>
                  <h3>{{$user['email']}}</h3>
               </div>
            </div>
            <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
               <div class="details_block_icon">
                  <img src="{{ asset('assets/images/phone.png') }}" alt="" srcset="">
               </div>
               <div class="details_block_content">
                  <p>{{__("customer.text_phone_number")}}</p>
                  <h3>{{$user['phone_number']}}</h3>
               </div>
            </div>
           <!--  <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
               <div class="details_block_icon">
                  <img src="{{ asset('assets/images/home.png') }}" alt="" srcset="">
               </div>
               <div class="details_block_content">
                  <p>{{__("customer.text_address")}}</p>
                  <h3>{{$user['address']}}</h3>
               </div>
            </div> -->

            <div class="text-center">
                <input type="reset" value='{{__("customer.text_back")}}' class="site_btn act_btn" onclick="goBack()">
            </div>
         </div>
      </div>
      <div class="profile_right_details">
         <div class="profile_right_sec">
            <h3>{{__("customer.text_education")}}</h3>
            <div class="load_parent">
               <div class="row">
                  @if(count($user['education_source']) >0)
                  <?php $i=1; ?>
                  @foreach($user['education_source'] as $key =>$value)
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
               @if(count($user['professions'])>0)
               @foreach($user['professions'] as $key => $value6)
               <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                  <div class="col-md-6 mb-md-0 mb_20">
                     <h4 class="mb_10">Name <span>- {{$value6['profession_name']}}</span></h4>
                  </div>
                  <div class="col-md-6 text-md-end text-start">
                     <h4 class="mb_10">{{__("customer.text_profession")}} {{__("customer.text_years")}}</h4>
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
               @if(count($user['hiring_history'])>0)
               @foreach($user['hiring_history'] as $key => $value2)
               <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                  <div class="col-md-6 mb-md-0 mb_20">
                     <h4 class="mb_10">{{__("customer.text_designation")}} <span>- {{$value2['company_name']}}</span></h4>
                     <p class="m-0">{{$value2['company_address']}}</p>
                  </div>
                  <div class="col-md-6 text-md-end text-start">
                     <h4 class="mb_10">{{__("customer.text_working_years")}} </h4>
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
                  <!-- remove condition -->
                  <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
               </div>
            </div>
         </div>
         <div class="profile_right_sec">
            <h3>{{__("customer.text_exp_abroad")}}</h3>
            <div class="load_parent">
               @if(count($user['exp_abroad'])>0)
               <?php  $i=1;?>
               @foreach($user['exp_abroad'] as $key => $value3)
               <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                  <div class="col-md-6 mb-md-0 mb_20">
                     <h4 class="mb_10">{{__("customer.text_designation")}} <span>-{{$value3['company_name']}}</span></h4>
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
                     @if(count($user['skills'])>0)
                     <?php $i=1; ?>
                     @foreach($user['skills'] as $key => $value4)
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
                     @if(count($user['permission'])>0)
                     <?php $i=1; ?>
                     @foreach($user['permission'] as $key => $value_per)
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
                     @if(count($user['cust_language'])>0)
                     <?php $i=1; ?>
                     @foreach($user['cust_language'] as $key => $value_lan)
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
                     @if(count($user['other_knowledges'])>0)
                     <?php $i=1; ?>
                     @foreach($user['other_knowledges'] as $key => $value_other)
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
                     @if(count($user['hobbies'])>0)
                     <?php $i=1; ?>
                     @foreach($user['hobbies'] as $key => $value5)
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
                     @if(count($user['add_info'])>0)
                     <?php $i=1; ?>
                     @foreach($user['add_info'] as $key => $value_other)
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
   @elseif($user['role']=='provider')
   <div class="edit_profile_row">
      <div class="edit_profile_all w-100">
         <div class="profile_nameimg">
            <div class="profile_img">
               <div class="upload_cv_sec">
                  <div class="form_row m-0 img_preview_main position-relative">
                     <!-- <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png,image/gif,image/jpeg"> -->
                     <span class="upload_icon m-0 p-0">
                     <img src="{{ url('profile',$user['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                     </span>
                     <!--   <label for="prof_img" class="upload_lbl clicktoupload m-0">
                        <img src="images/camera.png" alt="" srcset="">
                        </label> -->
                  </div>
               </div>
            </div>
            <div class="profile_name">
               <h3>{{$user['firstname']}} {{$user['surname']}}</h3>
               <p>{{$user['email']}}</p>
            </div>
         </div>
         <div class="profile_btns p-0">
            <a href="{{Route('change_password')}}" class="change_pass"><img src="{{ asset('assets/images/change-pass.png') }}" alt="" srcset=""> {{__("customer.text_change_pass")}}</a>
            <a href="{{Route('edit_profile')}}" class="edit_btn"><img src="{{ asset('assets/images/edit_profile.png') }}" alt="" srcset=""> {{__("customer.text_edit_profile")}}</a>
         </div>
      </div>
      <div class="other_profile_details">
         <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
            <div class="details_block_icon">
               <img src="{{ asset('assets/images/fullname.png') }}" alt="" srcset="">
            </div>
            <div class="details_block_content">
               <p>{{__("customer.text_full_name")}}</p>
               <h3>{{$user['firstname']}} {{$user['surname']}}</h3>
            </div>
         </div>
         <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
            <div class="details_block_icon">
               <img src="{{ asset('assets/images/calender.png') }}" alt="" srcset="">
            </div>
            <div class="details_block_content">
               <p>{{__("customer.text_date_of_birth")}}</p>
               <h3>02 - 02 - 1998</h3>
            </div>
         </div>
         <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
            <div class="details_block_icon">
               <img src="{{ asset('assets/images/gender.png') }}" alt="" srcset="">
            </div>
            <div class="details_block_content">
               <p>{{__("customer.text_gender")}}</p>
               <h3>Male</h3>
            </div>
         </div>
         <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
            <div class="details_block_icon">
               <img src="{{ asset('assets/images/email.png') }}" alt="" srcset="">
            </div>
            <div class="details_block_content">
               <p>{{__("customer.text_email")}}</p>
               <h3>{{$user['email']}}</h3>
            </div>
         </div>
         <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
            <div class="details_block_icon">
               <img src="{{ asset('assets/images/phone.png') }}" alt="" srcset="">
            </div>
            <div class="details_block_content">
               <p>{{__("customer.text_phone_number")}}</p>
               <h3>{{$user['phone_number']}}</h3>
            </div>
         </div>
       <!--   <div class="details_block d-flex justify-content-between align-items-end flex-wrap">
            <div class="details_block_icon">
               <img src="{{ asset('assets/images/home.png') }}" alt="" srcset="">
            </div>
            <div class="details_block_content">
               <p>{{__("customer.text_address")}}</p>
               <h3>{{$user['address']}}</h3>
            </div>
         </div> -->
      </div>
   </div>
   @endif
</div>
@include('front.layout.footer')