@include('front.layout.header')
@include('front.layout.sidebar')
<?php
   $job_no               = "";
   $profession           = "";
   $location             = "";
   $search_for_everthing = "";
   
   if(@$_GET['job_no']){
       $job_no = @$_GET['job_no'];
   }
   if(@$_GET['profession']){
       $profession = @$_GET['profession'];
   }
   if(@$_GET['location']){
       $location = @$_GET['location'];
   }
   
   if(@$_GET['search_everything']){
       $search_for_everthing = @$_GET['search_everything'];
   }
   
?>
<div class="main_right">
   <form method="get" action="{{Route('frontdashboard')}}">
      <div class="top_announce d-flex align-items-center justify-content-between mb_20">
         <div class="top_ann_left">
            @if($user['role']=='seeker')
            <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
            @elseif($user['role']=='provider')
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
            @endif
         </div>
         <div class="top_ann_right d-flex align-items-center topan_search justify-content-xl-end">
            <input type="text" name="search_everything" id="search_everything" value="{{$search_for_everthing}}" placeholder='{{__("customer.text_search_for_everything")}}'>
            <input type="submit" value="">
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
      @if(Session::has($key))
      <p id="success_msg" class="alert alert-{{ $key }} alert-block">{{ Session::get($key) }}</p>
      @endif
      @endforeach
      <div class="row top_bb mb_20 align-items-center justify-content-between">
         @if($user['role']=='seeker')
         <h3 class="title col-xl-4 recom_title">{{__("customer.text_rec_jobs")}}</h3>
         @elseif($user['role']=='provider')
         <h3 class="title col-xl-4 recom_title">{{__("customer.text_rec_candidates")}}</h3>
         @endif
         <div class="col-xl-8">
            <?php
               @$NameSearch = @$_GET['NameSearch'];
               ?>
            <div class="dash_filter">
               <div class="dropdown_filter">
                  <label>{{__("customer.text_filter_by")}}</label>
                  <a href="#" class="click_to_down">{{__("customer.text_filter")}} </a>
                  <div class="slide_down_up" style="display: none;">
                     @if($user['role']=='provider')
                     <div class="filter_row">
                        <label for="">{{__("customer.text_name")}}</label>
                        <input type="text" name="NameSearch" placeholder='{{__("customer.text_enter")}} {{__("customer.text_name")}}' value="<?php if (@$NameSearch != ''){ echo $NameSearch ; } ?>">
                     </div>
                     @endif
                     <div class="filter_row">
                        <label for="">{{__("customer.text_job_no")}}</label>
                        <input type="text"  name="job_no" value="{{$job_no}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_no")}}'>
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("customer.text_profession")}}</label>
                        <input type="text" name="profession" value="{{$profession}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession")}}'>
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("customer.text_location")}}</label>
                        <input type="text" name="location" value="{{$location}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}'>
                     </div>
                  </div>
               </div>
               <div class="dropdown_filter">
                  <label>{{__("customer.text_sort_by")}}</label>
                  <select name="sort">
                     <option value="date" {{@$_GET['sort'] =="date"?"selected":""}}>{{__("customer.text_date")}}</option>
                     <option value="name" {{@$_GET['sort'] =="name"?"selected":""}}>{{__("customer.text_name")}}</option>
                  </select>
               </div>
               <div class="filter_submit_btn"><input type="submit" value="" class="" /></div>
            </div>
         </div>
      </div>
   </form>
   @csrf

   <!-- Provider View -->
   <?php if(!empty($seekers)){ ?>
   <div class="job_card_wrapper candidates">
      <?php foreach ($seekers as $key => $value) { ?>
      <div class="job_card">
         <div class="jcard_top d-flex align-items-center justify-content-between">
            <div class="jc_left d-flex align-items-center justify-content-between">
               <div class="jc_left_l">
                  <span>
                  @if($value['profile_image'] !="")
                  <img src="{{ url('profile',$value['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                  @else
                  <img src="{{ asset('assets/images/bo.png') }}" alt="" class="img_preview" id="img_preview">
                  @endif
                  </span>
               </div>
               <div class="jc_left_r">
                  <?php 
                     $fullname = $value['firstname']." ".$value['surname'];
                     ?>
                  <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($fullname) > 15) ? substr($fullname, 0, 15) . '...' : $fullname; ?></p>
                  <p class="clr_grey f12 mb0 f_bold">Job No. {{$value['job_id']}} <span class="clr_ylw"></span>
                  </p>
               </div>
            </div>
            <div class="jc_right text-end">
               <a href="javascript:void(0)" id="favourite_candidates" class="wishlist <?php if($value['fav_candidates']=='1'){echo 'wishlist_added'; } ?>" data-id="{{$value['id']}}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                     <g id="Group_7672" data-name="Group 7672" transform="translate(-9663 -2424)">
                        <g id="Rectangle_4600" data-name="Rectangle 4600"
                           transform="translate(9663 2424)" fill="none" stroke="#707070"
                           stroke-width="1" opacity="0">
                           <rect width="32" height="32" stroke="none" />
                           <rect x="0.5" y="0.5" width="31" height="31" fill="none" />
                        </g>
                        <path id="fi-sr-heart"
                           d="M17.493,1.917A6.387,6.387,0,0,0,12,5.254,6.387,6.387,0,0,0,6.5,1.917,6.845,6.845,0,0,0,0,9.046c0,4.6,4.784,9.62,8.8,13.025a4.928,4.928,0,0,0,6.4,0c4.012-3.4,8.8-8.427,8.8-13.025a6.845,6.845,0,0,0-6.5-7.129Z"
                           transform="translate(9667.005 2427.417)" fill="#aeaeae" />
                     </g>
                  </svg>
               </a>
            </div>
         </div>
         <div class="jcard_center">
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j1.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("customer.text_work_exp")}}'>
               {{@$value['working_year']}}
               </span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j2.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("customer.text_working_hours")}}'>{{@$value['working_hour']}} </span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j3.png') }}" alt="">
               </span> 
               @if($value['driving_license']!='') 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("customer.text_driving_license")}}'>{{__("customer.text_driving_license")}}</span>
               @else
                  <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("customer.text_driving_license")}}'>-</span>
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
               <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("customer.text_location")}}'>{{$value['work_location']}} </span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j6.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("customer.text_start_date")}}'>{{@$value['date']}} </span>
            </div>
         </div>
         <div class="jc_footer">
            <a href="{{Route('seeker_profile')}}?ID={{$value['id']}}&Page=Dashboard" class="">{{__("customer.text_view_profile")}}</a>
         </div>
      </div>
      <?php }  ?>
   </div>
   <?php } ?>

   <!-- Seeker View -->
   <?php if(!empty($jobs)){ ?>
   <div class="job_card_wrapper">
      <?php foreach ($jobs as $key => $value) { ?>
      <div class="job_card">
         <div class="jcard_top d-flex align-items-center justify-content-between">
            <div class="jc_left d-flex align-items-center justify-content-between">
               <div class="jc_left_l">
                  <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
               </div>
               <div class="jc_left_r">
                  <?php $fulltitle =  $value['title'];?>
                  <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($fulltitle) > 25) ? substr($fulltitle, 0, 25) . '...' : $fulltitle; ?></p>
                  <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} {{$value['id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
                  </p>
               </div>
            </div>
            <div class="jc_right text-end">
               <a href="javascript:void(0)" id="add_wishlist" class="wishlist <?php if($value['wishlist']=='1'){echo 'wishlist_added'; } ?>" data-id="{{$value['id']}}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                     <g id="Group_7672" data-name="Group 7672" transform="translate(-9663 -2424)">
                        <g id="Rectangle_4600" data-name="Rectangle 4600"
                           transform="translate(9663 2424)" fill="none" stroke="#707070"
                           stroke-width="1" opacity="0">
                           <rect width="32" height="32" stroke="none" />
                           <rect x="0.5" y="0.5" width="31" height="31" fill="none" />
                        </g>
                        <path id="fi-sr-heart"
                           d="M17.493,1.917A6.387,6.387,0,0,0,12,5.254,6.387,6.387,0,0,0,6.5,1.917,6.845,6.845,0,0,0,0,9.046c0,4.6,4.784,9.62,8.8,13.025a4.928,4.928,0,0,0,6.4,0c4.012-3.4,8.8-8.427,8.8-13.025a6.845,6.845,0,0,0-6.5-7.129Z"
                           transform="translate(9667.005 2427.417)" fill="#aeaeae" />
                     </g>
                  </svg>
               </a>
            </div>
         </div>
         <div class="jcard_center">
            <div class="jc_inbox" title='{{__("customer.text_experience")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j1.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['experience']}}</span>
            </div>
            <div class="jc_inbox" title='{{__("customer.text_working_hours")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j2.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['working_hours']}}</span>
            </div>
            <div class="jc_inbox" title='{{__("customer.text_driving_license")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j3.png') }}" alt="" >
               </span>
               @if($value['driving_license']=='1') 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}} </span>
               @elseif($value['driving_license']=='0')
               <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
               @endif
            </div>
            <div class="jc_inbox" title='{{__("customer.text_own_car")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j4.png') }}" alt="" >
               </span> 
               @if($value['own_car']=='1') 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
               @elseif($value['own_car']=='0')
               <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
               @endif
            </div>
            <div class="jc_inbox" title='{{__("customer.text_work_location")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j5.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12"><?php echo (strlen($value['work_location']) > 15) ? substr($value['work_location'], 0, 15) . '...' : $value['work_location']; ?></span>
            </div>
            <div class="jc_inbox" title='{{__("customer.text_start_date")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j6.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['start_date']}}</span>
            </div>
         </div>
         <?php if ($value['contract']=='') { ?>
         <div class="jc_footer">
            <a href="{{Route('seeker.job_detail')}}?id={{$value['id']}}" class="">{{__("customer.text_contract_now")}} <span> <img src="{{asset('assets/images/bot_ar.png') }}"
               alt=""></span></a>
         </div>
         <?php }else{ ?>
         <div class="jc_footer">
            <a href="{{Route('seeker.job_detail')}}?id={{$value['id']}}" class="">{{$value['contract_status']}} </a>
         </div>
         <?php } ?>
      </div>
      <?php } ?>    
   </div>
   <?php } ?>

   <!-- No Records -->
   <?php if(empty($seekers) && empty($jobs) ){ ?>
   <div class="container-fluid bg-white text-center no_record">
       <img src="{{asset('assets/images/no_record_face.png')}}">
       <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
   </div>
   <?php } ?>
   <!-- No Records -->
   <!-- *pagination --> 
   <?php if(!empty($seekers)){ ?>
   <div class="my_pagination">
      {{$get_seekers->appends(request()->query())->links() }}
   </div>
   <?php } ?>
   <?php if(!empty($jobs)){ ?>
   <div class="my_pagination">
      {{$get_jobs->appends(request()->query())->links() }}
   </div>
   <?php } ?>
   <!-- *pagination -->
</div>
@include('front.layout.footer')
<script type="text/javascript">
   $('body').on("click",'#favourite_candidates', function(){
         var Seeker_ID = $(this).attr('data-id');
         _token = $("input[name='_token']").val();
         $.ajax({
           url:"{{ url('add_favourite_candidates') }}",
           type: 'post',
           data: {'Seeker_ID': Seeker_ID,'_token':_token},
            success: function(response) {  
                window.location.href = "{{url('dashboard')}}";
            }
         });
         // return false;
   });
   
    $(document).ready(function(){
       $('#success_msg').show();
       $('#success_msg').fadeOut(3000);
       $('html, body').animate({ scrollTop: $("#success_msg").offset().top-90 }, 2500);
        setTimeout(explode, 2000);
   });
</script>
<script type="text/javascript">
   $('body').on("click",'#add_wishlist', function(){
         var Job_ID = $(this).attr('data-id');
         _token = $("input[name='_token']").val();
         $.ajax({
           url:"{{ url('add_wishlist') }}",
           type: 'post',
           data: {'Job_ID': Job_ID,'_token':_token},
            success: function(response) {  
                window.location.href = "{{url('dashboard')}}";
            }
         });
         // return false;
   });
   
    $(document).ready(function(){
       $('#success_msg').show();
       $('#success_msg').fadeOut(3000);
       $('html, body').animate({ scrollTop: $("#success_msg").offset().top-90 }, 2500);
        setTimeout(explode, 2000);
   });
</script>