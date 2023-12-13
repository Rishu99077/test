@include('front.layout.header')
@include('front.layout.sidebar')
<?php
   $JobSearch            = "";
   $LocSearch           = "";
   $jobno             = "";
   $search_for_everthing = "";
   
   if(@$_GET['JobSearch']){
       $JobSearch = @$_GET['JobSearch'];
   }
   if(@$_GET['LocSearch']){
       $LocSearch = @$_GET['LocSearch'];
   }
   if(@$_GET['jobno']){
       $jobno = @$_GET['jobno'];
   }
   
   if(@$_GET['search_everything']){
       $search_for_everthing = @$_GET['search_everything'];
   }
   
?>
<div class="main_right">
   <form action="{{Route('job')}}" method="get">
      <div class="top_announce d-flex align-items-center justify-content-between mb_20">
         <div class="top_ann_left">
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
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
         <h3 class="title col-xl-4">{{$common['heading_title']}}</h3>
         <div class="col-xl-8">
            <div class="dash_filter">
               <div class="dropdown_filter">
                  <label>{{__("customer.text_filter_by")}}</label>
                  <a href="#" class="click_to_down">{{__("customer.text_filter")}} </a>
                  <div class="slide_down_up" style="display: none;">
                     <div class="filter_row">
                        <label for="">{{__("customer.text_job_title")}}</label>
                        <input type="text" name="JobSearch" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_title")}}' value="<?php if (@$JobSearch != ''){ echo $JobSearch ; } ?>">
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("customer.text_job_no")}}</label>
                        <input type="text" name="job_no" value="<?php if (@$jobno != ''){ echo $jobno ; } ?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_no")}}'>
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("customer.text_location")}}</label>
                        <input type="text" name="LocSearch" placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}' value="<?php if (@$LocSearch != ''){ echo $LocSearch ; } ?>">
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
   <form method="post">
   @csrf
   @if(count($jobs)>0)
   <div class="job_card_wrapper">
      <?php 
         foreach ($jobs as $key => $value) { ?>
      <div class="job_card">
         <div class="jcard_top d-flex align-items-center justify-content-between">
            <div class="jc_left d-flex align-items-center justify-content-between">
               <div class="jc_left_l">
                  <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
               </div>
               <div class="jc_left_r">
                  <?php $fulltitle = $value['title']; ?>
                  <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($fulltitle) > 25) ? substr($fulltitle, 0, 25) . '...' : $fulltitle; ?></p>
                  <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} {{$value['id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
                  </p>
               </div>
            </div>
            <div class="jc_right text-end" style="width: 20%;">
               <a href="{{Route('job_add')}}/?id={{$value['id']}}"><i class="fa fa-edit"></i></a>
             <!--   <a href="javascript:void(0)" id="add_wishlist" class="wishlist <?php if($value['wishlist']=='1'){echo 'wishlist_added'; } ?>" data-id="{{$value['id']}}">
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
               </a> -->
            </div>
         </div>
         <div class="jcard_center">
            <div class="jc_inbox" title='{{__("customer.text_experience")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j1.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['experience']}}</span>
            </div>
            <div class="jc_inbox" title='{{__("customer.text_salary")}} {{"$/h"}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j2.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12" >{{$value['salary']}} {{"$/h"}}</span>
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
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['work_location']}}</span>
            </div>
            <div class="jc_inbox" title='{{__("customer.text_start_date")}}'>
               <span class="jc_inbox1">
               <img src="{{ asset('assets/images/j6.png') }}" alt="" >
               </span> 
               <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['start_date']}}</span>
            </div>
         </div>
         @if($value['status']=='Pending')
         <div class="jc_footer">
            <a href="#" class="d-flex align-items-center justify-content-between bg-warning">
               <span> {{$value['status'] }}</span>
            </a>
         </div>
         @elseif($value['status']=='Reject')
         <div class="jc_footer">
            <a href="#" class="d-flex align-items-center justify-content-between bg-danger"><span> {{$value['status']}}</span></a>
         </div>
         @elseif($value['status']=='Published' || $value['status']=='Ongoing')
         <div class="jc_footer">
            <a href="{{url('job/view')}}?id={{$value['id']}}" class="d-flex align-items-center justify-content-between">
               <span> {{__("customer.text_total_applier")}}</span>
               <span class="pjob_count"> {{$value['contract_count']}}</span>
            </a>
         </div>
         @endif
      </div>
      <?php }
         ?>
   </div>
   @else
   <div class="container-fluid bg-white text-center no_record">
      <img src="{{asset('assets/images/no_record_face.png')}}">
      <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
   </div>
   @endif
   <!-- *pagination -->
   <div class="my_pagination">
      {{$get_jobs->appends(request()->query())->links() }}
   </div>
   <!-- *pagination -->
</div>
@include('front.layout.footer')
<script type="text/javascript">
   $('body').on("click",'#add_wishlist', function(){
         var Job_ID = $(this).attr('data-id');
         _token = $("input[name='_token']").val();
         $.ajax({
           url:"{{ url('add_wishlist') }}",
           type: 'post',
           data: {'Job_ID': Job_ID,'_token':_token},
            success: function(response) {  
                window.location.href = "{{url('job')}}";
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