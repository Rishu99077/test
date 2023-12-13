@include('front.layout.header')
@include('front.layout.sidebar')
<?php
   $contract_no         = "";
   $month               = "";
   $year                = "";
   $offer_no            = "";
   $profession          = "";
   $location            = "";
   $salary_from         = "";
   $salary_to           = "";
   $job_title           = "";
  
   $search_for_everthing = "";
   if(@$_GET['search_everything']){
       $search_for_everthing = @$_GET['search_everything'];
   }
   
   ?>
<div class="main_right">
   <form action="" method="get">
      <div class="top_announce d-flex align-items-center justify-content-between mb_20">
         <div class="top_ann_left">
            <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
         </div>
         <div class="top_ann_right d-flex align-items-center topan_search  justify-content-xl-end ">
            <input type="text" name="search_everything" id="" value="<?php if(@$_GET['search_everything']){ echo @$_GET['search_everything'];}?>" placeholder='{{__("customer.text_search_for_everything")}}'>
            <input type="submit" value="">
         </div>
      </div>
      <div class="row top_bb mb_20 align-items-center justify-content-between">
         <h3 class="title col-xl-4 recom_title">{{$common['heading_title']}}</h3>
         <div class="col-xl-8">
            <div  class="dash_filter">
               <div class="dropdown_filter">
                  <label>{{__("customer.text_filter_by")}}</label>
                  <a href="#" class="click_to_down">{{__("customer.text_filter_by")}}</a>
                  <div class="slide_down_up" style="display: none;">
                     <div class="filter_row  " >
                        <label for="">{{__("customer.text_job_offer_no")}}</label>
                        <input type="text" name="offer_no" id="offer_no"  value="<?php if(@$_GET['offer_no']){ echo @$_GET['offer_no'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_offer_no")}}'>
                     </div>
                     <div class="filter_row ">
                        <label for="">{{__("customer.text_profession")}}</label>
                        <input type="text" name="profession" id="profession" value="<?php if(@$_GET['profession']){ echo @$_GET['profession'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession")}}'>
                     </div>
                     <div class="filter_row" >
                        <label for="">{{__("customer.text_location")}}</label>
                        <input type="text" name="location" id="location"  value="<?php if(@$_GET['location']){ echo @$_GET['location'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}'>
                     </div>
                     <div class="filter_row salary_fields" >
                        <label for="">{{__("customer.text_salary")}} / h</label>
                        <input type="text" id="salary_from" value="<?php if(@$_GET['salary_from']){ echo @$_GET['salary_from'];}?>"  name="salary_from" placeholder='{{__("customer.text_enter")}} {{__("customer.text_from")}}'>
                        <input type="text" id="salary_to"  value="<?php if(@$_GET['salary_to']){ echo @$_GET['salary_to'];}?>" name="salary_to" placeholder='{{__("customer.text_enter")}} {{__("customer.text_to")}}'>
                     </div>
                  </div>
               </div>
               <div class="dropdown_filter">
                  <label>{{__("customer.text_sort_by")}}</label>
                  <select name="sort"> 
                  <option value="date" {{@$_GET['sort'] =="date"?"selected":""}}>{{__("customer.text_date")}}</option>
                  <option value="name" {{@$_GET['sort'] =="name"?"selected":""}}>{{__("customer.text_name")}}</option>
                  <option value="start" {{@$_GET['sort'] =="start"?"selected":""}}>{{__("customer.text_start")}}</option>
                  </select>
               </div>
               <div class="filter_submit_btn"><input type="submit" value="" class="" /></div>
            </div>
         </div>
      </div>
   </form>
   <div class="contact_tabs">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-form-tab"  href="{{Route('seeker.reports')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/calen_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_reports")}}
            </span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link active" id="advertisement-tab" href="{{Route('seeker.advertisment')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/Ads_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_my_advt")}}</span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="contract-to-sign-tab" href="{{Route('seeker.contract_to_sign')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/consign_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_contract_to_sign")}}</span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="actual-contract-tab"  href="{{Route('seeker.actual_contract')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/con_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_actual_report")}}</span>
            </a>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">

        <!-- My Advertisment -->
        <div class="tab-pane fade active show" id="advertisement" role="tabpanel" aria-labelledby="advertisement-tab">
            <?php if(!empty($advs)){ ?>
            <div class="job_card_wrapper">
               <?php foreach ($advs as $key => $value) { ?>
               <div class="job_card">
                  <div class="jcard_top d-flex align-items-center justify-content-between">
                     <div class="jc_left d-flex align-items-center justify-content-between">
                        <div class="jc_left_l" style="height: 65px!important;">
                           <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
                        </div>
                        <div class="jc_left_r">
                           <?php $fullname = $value['firstname']; ?> 
                           <p class="mb0 f16 clr_prpl f_black" style="height: 45px; word-wrap: break-word;"><?php echo (strlen($fullname) > 50) ? substr($fullname, 0, 50) . '...' : $fullname; ?></p>
                           <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_offer_no")}} {{$value['id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
                           </p>
                        </div>
                     </div>
                     <div class="jc_right text-end">
                        <a href="{{Route('seeker.edit_advertisment',['id'=>$value['id']] ) }}"><i class="fa fa-edit"></i></a>
                     </div>
                  </div>
                  <div class="jcard_center">
                     <div class="jc_inbox">
                        <span class="jc_inbox1">
                        <img src="{{ asset('assets/images/j1.png') }}" alt="">
                        </span> 
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['experience']}}</span>
                     </div>
                     <div class="jc_inbox">
                        <span class="jc_inbox1">
                        <img src="{{ asset('assets/images/j2.png') }}" alt="">
                        </span> 
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['hours_salary']}}</span>
                     </div>
                     <div class="jc_inbox">
                        <span class="jc_inbox1">
                        <img src="{{ asset('assets/images/j3.png') }}" alt="">
                        </span>
                        @if($value['driving_license']=='1') 
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}} </span>
                        @elseif($value['driving_license']=='0')
                        <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                        @endif
                     </div>
                     <div class="jc_inbox">
                        <span class="jc_inbox1">
                        <img src="{{ asset('assets/images/j4.png') }}" alt="">
                        </span> 
                        @if($value['own_car']=='1') 
                           <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
                        @elseif($value['own_car']=='0')
                           <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                        @endif
                     </div>
                     <div class="jc_inbox">
                        <span class="jc_inbox1">
                        <img src="{{ asset('assets/images/j5.png') }}" alt="">
                        </span> 
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['work_location']}}</span>
                     </div>
                     <div class="jc_inbox">
                        <span class="jc_inbox1">
                        <img src="{{ asset('assets/images/j6.png') }}" alt="">
                        </span> 
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['start_date']}}</span>
                     </div>
                  </div>
                  <div class="jc_footer">
                     @if($value['adv_status']=='approve')
                        <a href="{{Route('adv_appliers',$value['id'])}}" class="d-flex align-items-center justify-content-between" target="_blank"><span> {{__("customer.text_post_reply")}}</span>
                        <span class="pjob_count">{{$value['adv_contract_count']}}</span>
                        </a>
                     @elseif($value['adv_status']=='pending')
                        <a href="#" class="d-flex align-items-center justify-content-between bg-warning"><span>{{$value['adv_status']}}</span>
                        </a>
                     @endif
                  </div>
               </div>
               <?php } ?>
            </div>
            <div class="my_pagination">
               {{$get_advertisment->appends(request()->query())->links() }}
            </div>
            <?php }else{ ?>
            <div class="container-fluid bg-white text-center no_record">
               <img src="{{asset('assets/images/no_record_face.png')}}">
               <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
           </div>
            <?php } ?> 
        </div>

        
      </div>
   </div>
</div>

<script type="text/javascript">
   $(document).on('click','#checkall',function(){
       $('.download_all').toggle(); 
       if($(this).is(':checked')){
           $('.check_box').attr('checked', true);
       }else{
           $('.check_box').attr('checked', false);
       }
   });
   
   
</script>
@include('front.layout.footer')