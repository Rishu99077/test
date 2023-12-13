@include('front.layout.header')
@include('front.layout.sidebar')
<div class="main_right">

	<div class="top_announce d-flex align-items-center justify-content-between mb_20">

	    <div class="top_ann_left">
        <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
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

	<div class="job_card_wrapper sjob_det mb_10">

	    <div class="job_card job_details_sec mb_20">
	    	@csrf
	        <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
	            <div class="jc_left d-flex align-items-center justify-content-between">
	                <div class="jc_left_l">
	                    <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
	                </div>
	                <div class="jc_left_r">
	                    <p class="mb0 f16 clr_prpl f_black">{{@$job_details['title']}}</p>
	                    <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} {{@$job_details['id']}} <span class="clr_ylw"> {{@$job_details['datetime']}}</span></p>
	                </div>
	            </div>
	            <div class="jc_right text-end">  
                    <a href="#" id="add_wishlist" class="wishlist <?php if(@$job_details['wishlist']=='1'){echo 'wishlist_added'; } ?>" data-id="{{@$job_details['id']}}">                
	                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
	                        <g id="Group_7672" data-name="Group 7672" transform="translate(-9663 -2424)">
	                        <g id="Rectangle_4600" data-name="Rectangle 4600" transform="translate(9663 2424)" fill="none" stroke="#707070" stroke-width="1" opacity="0">
	                            <rect width="32" height="32" stroke="none"/>
	                            <rect x="0.5" y="0.5" width="31" height="31" fill="none"/>
	                        </g>
	                        <path id="fi-sr-heart" d="M17.493,1.917A6.387,6.387,0,0,0,12,5.254,6.387,6.387,0,0,0,6.5,1.917,6.845,6.845,0,0,0,0,9.046c0,4.6,4.784,9.62,8.8,13.025a4.928,4.928,0,0,0,6.4,0c4.012-3.4,8.8-8.427,8.8-13.025a6.845,6.845,0,0,0-6.5-7.129Z" transform="translate(9667.005 2427.417)" fill="#aeaeae"/>
	                        </g>
	                    </svg>
                	</a>
                </div>
	        </div>

	        <div class="uniq_cent px-0 d-flex align-items-center flex-wrap justify-content-between">
	        <div class="jcard_center px-0">
	            
	              <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j1.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{@$job_details['experience']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j2.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{@$job_details['salary']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j3.png') }}" alt="">
                  </span>
                  @if(@$job_details['driving_license']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}}</span>
                  @elseif(@$job_details['driving_license']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                  @endif
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j4.png') }}" alt="">
                  </span> 
                  @if(@$job_details['own_car']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
                  @elseif(@$job_details['own_car']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                  @endif
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j5.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{@$job_details['work_location']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j6.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{@$job_details['start_date']}}</span>
                </div>

	        </div>          
	        
	        <div class="text-center"><a href="#" onclick="goBack()" class="bk_btn"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div>
	        </div>

	        <div class="jc_footer px-0">
	            <h3 class="">{{__("customer.text_description")}}</h3>
	            <p class="clr_grey f_regular f_14 description_p">{{@$job_details['description']}} 
	            	<?php $word_count = str_word_count(@$job_details['description']);
	            		if ($word_count>50) { ?>
	            			<a href="#">{{__("customer.text_read_more")}}</a>
	            	<?php } ?>
	            </p>
	        </div>

	    </div>

	</div>

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
                 window.location.href = "{{url('dashboard')}}";
             }
          });
          // return false;
    });

    $('body').on("click",'#add_contract', function(){
          var Job_ID = $(this).attr('data-id');
          _token = $("input[name='_token']").val();
          $.ajax({
            url:"{{ url('save_contract') }}",
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