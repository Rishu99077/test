@include('front.layout.header')
@include('front.layout.sidebar')
<?php
   $search_for_everthing = "";
   
   if(@$_GET['search_everything']){
       $search_for_everthing = @$_GET['search_everything'];
   }
   ?>
<div class="main_right">
   <form action="" method="get">
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
         <h3 class="title col-xl-4 recom_title">{{$common['heading_title']}}</h3>
         <div class="col-xl-8">
            <div class="dash_filter">
               <div class="dropdown_filter">
                  <label>{{__("customer.text_filter_by")}}</label>
                  <a href="#" class="click_to_down">{{__("customer.text_filter")}} </a>
                  <div class="slide_down_up" style="display: none;">
                     <div class="filter_row">
                        <label for="">{{__("customer.text_job_no")}}</label>
                        <input type="text" name="job_no" value="<?php if(@$_GET['job_no']){ echo $_GET['job_no']; } ?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_no")}}'>
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("customer.text_name")}}</label>
                        <input type="text" name="name" value="<?php if(@$_GET['name']){ echo $_GET['name']; } ?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_name")}}'>
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("customer.text_profession")}}</label>
                        <input type="text" name="profession" value="<?php if(@$_GET['profession']){ echo $_GET['profession']; } ?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession")}}'>
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
   </form>
   </div>
   @csrf
   <div class="job_card_wrapper candidates">
      <?php if(!empty($candidates)){
         foreach ($candidates as $key => $value) { ?>
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
               <?php 
                  $fullname = $value['firstname']." ".$value['surname'];
                  ?>
               <div class="jc_left_r">
                  <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($fullname) > 25) ? substr($fullname, 0, 25) . '...' : $fullname; ?></p>
                  <p class="clr_grey f12 mb0 f_bold">Job No. {{$value['job_id']}} <span class="clr_ylw"></span>
                  </p>
               </div>
            </div>
            <div class="jc_right text-end">
               <a href="javascript:void(0)" id="favourite_candidates" class="wishlist <?php if($value['customer_id']!=''){echo 'wishlist_added'; } ?>" data-id="{{$value['customer_id']}}">
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
               <span class="jc_inbox2 f_bold clr_prpl f12" title="Experience">{{@$value['working_year']}}</span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j2.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12" title="Working hours">{{@$value['working_hour']}}  </span>
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
               <span class="jc_inbox2 f_bold clr_prpl f12" title="Location">{{$value['work_location']}} </span>
            </div>
            <div class="jc_inbox">
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j6.png') }}" alt="">
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12" title="Start Date">{{@$value['date']}} </span>
            </div>
         </div>
         <div class="jc_footer">
            <a href="{{Route('seeker_profile')}}?ID={{$value['customer_id']}}" class="">{{__("customer.text_view_details")}}</a>
         </div>
      </div>
      <?php }  ?>
      <?php } ?>
   </div>
   <!-- No Records -->
   <?php if(empty($candidates)){ ?>
   <div class="container-fluid bg-white text-center no_record">
      <img src="{{asset('assets/images/no_record_face.png')}}">
      <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
   </div>
   <?php } ?>
   <!-- No Records -->
   <!-- *pagination --> 
   <div class="my_pagination">
      {{$get_fav_candidsates->appends(request()->query())->links() }}
   </div>
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
                window.location.href = "{{url('favorite-candidates')}}";
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