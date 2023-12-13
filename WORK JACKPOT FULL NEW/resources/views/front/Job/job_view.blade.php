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
@foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
   @if(Session::has($key))
      <p id="success_msg" class="alert alert-{{ $key }} alert-block">{{ Session::get($key) }}</p>
   @endif
@endforeach
<div class="row top_bb mb_20 align-items-center justify-content-between">
   <h3 class="title col-md-4 mb-md-0 mb_20">{{__("customer.text_job_details")}}</h3>
   <div class="job_status col-md-8 text-md-end">
      <span class="f_black clr_purpule">{{__("customer.text_status_job")}}</span>
      <select name="" id="">
         <option value="">{{__("customer.text_job_active")}}</option>
         <option value="">{{__("customer.text_delete_job")}}</option>
         <option value="">{{__("customer.text_disable")}}</option>
         <option value="">{{__("customer.text_edited")}}</option>
      </select>
   </div>
</div>
<div class="job_card_wrapper sjob_det mb_30">
   <div class="job_card job_details_sec mb_20">
      <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
         <div class="jc_left d-flex align-items-center justify-content-between">
            <div class="jc_left_l">
               <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
            </div>
            <div class="jc_left_r">
               <p class="mb0 f16 clr_prpl f_black">{{$job_details['title']}}</p>
               <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} {{$job_details['id']}} <span class="clr_ylw"> {{$job_details['datetime']}}</span></p>
            </div>
         </div>
         <div class="jc_right text-end">
            <div class="total_applier text-center">
               <p class="m-0">{{__("customer.text_total_applier")}}</p>
               <h3 class="m-0">{{$job_details['contract_count']}}</h3>
            </div>
         </div>
      </div>
      <div class="uniq_cent px-0 d-flex align-items-center flex-wrap justify-content-between">
         <div class="jcard_center px-0">
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j1.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$job_details['experience']}}</span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j2.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$job_details['working_hours']}}</span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j3.png') }}" alt="">
               </span>
               @if($job_details['driving_license']=='1') 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}} </span>
               @elseif($job_details['driving_license']=='0')
               <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
               @endif
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j4.png') }}" alt="">
               </span> 
               @if($job_details['own_car']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
               @elseif($job_details['own_car']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
               @endif
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j5.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$job_details['work_location']}}</span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j6.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$job_details['start_date']}}</span>
            </div>
         </div>
         <div class="text-center"><a href="#" class="bk_btn" onclick="goBack()"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div>
      </div>
      <div class="jc_footer px-0">
         <h3 class="">{{__("customer.text_description")}}</h3>
         <p class="clr_grey f_regular f_14 description_p">{{$job_details['description']}} 
            <?php  $Word_Count = str_word_count($job_details['description']);
               if ($Word_Count>50) { ?>
            <a href="#">{{__("customer.text_read_more")}}</a>
            <?php } ?>
         </p>
      </div>
   </div>
</div>
<div class="row top_bb mb_20 align-items-center justify-content-between">
   <h3 class="title col-md-6 mb-md-0 mb_20">{{__("customer.text_job_applicants")}}</h3>
   <div class="col-md-6 text-md-end"><a href="#" class="">{{__("customer.text_view_all")}}</a></div>
</div>
<?php if(!empty($contracts)){ ?>
<div class="job_card_wrapper candidates">
   <?php foreach ($contracts as $key => $value_contract) { ?>
   <div class="job_card">
      <div class="jcard_top d-flex align-items-center justify-content-between">
         <div class="jc_left d-flex align-items-center justify-content-between">
            <div class="jc_left_l">
               <span>
               @if($value_contract['profile_image'] !="")
                  <img src="{{ url('profile',$value_contract['profile_image']) }}" alt="" class="img_preview" id="img_preview">
               @else
                  <img src="{{ asset('assets/images/bo.png') }}" alt="" class="img_preview" id="img_preview">
               @endif
               </span>
            </div>
            <div class="jc_left_r">
               <?php $fulltitle = $value_contract['title']; ?>
               
               <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($value_contract['customer_name']) > 25) ? substr($value_contract['customer_name'], 0, 25) . '...' : $value_contract['customer_name']; ?> , <?php echo (strlen($fulltitle) > 15) ? substr($fulltitle, 0, 15) . '...' : $fulltitle; ?></p>
               <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_offer_no")}} {{$value_contract['job_id']}} <span class="clr_ylw"></span>
               </p>
            </div>
         </div>
         <div class="jc_right text-end">
            
         </div>
      </div>
      <div class="jcard_center">
         <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j1.png') }}" alt=""></span> <span
            class="jc_inbox2 f_bold clr_prpl f12">{{$value_contract['experience']}}</span></div>
         <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j2.png') }}" alt=""></span> <span
            class="jc_inbox2 f_bold clr_prpl f12">{{$value_contract['working_hours']}}</span></div>
         <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j3.png') }}" alt=""></span>
            <?php if ($value_contract['driving_license']!='') { ?>
            <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}}</span>
            <?php }else{ ?>
            <span class="jc_inbox2 f_bold clr_prpl f12"> - </span>
            <?php } ?>
         </div>
         <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j4.png') }}" alt=""></span> 
            <?php if ($value_contract['own_car']!='') { ?>
            <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
            <?php }else{ ?>
            <span class="jc_inbox2 f_bold clr_prpl f12"> - </span>
            <?php } ?>
         </div>
         <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j5.png') }}" alt=""></span> <span
            class="jc_inbox2 f_bold clr_prpl f12">{{$value_contract['work_location']}} </span></div>
         <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j6.png') }}" alt=""></span> <span
            class="jc_inbox2 f_bold clr_prpl f12">{{$value_contract['start_date']}}</span></div>
      </div>
      <div class="jc_footer">
         <a href="{{Route('provider.applicant_view_profile')}}?id={{$value_contract['id']}}&Page=Job" class="">{{__("customer.text_view_profile")}} </a>
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
@include('front.layout.footer')