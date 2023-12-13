@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
    .jc_footer .description_p {
        max-width: 100%;
        line-height: 1.5;
    }
</style>

	<div class="main_right">

        <div class="top_announce d-flex align-items-center justify-content-between mb_20">

            <div class="top_ann_left">
                <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>

            </div>
            <div class="top_ann_right d-flex align-items-center ">
                <form action="" class="topan_search w-100 justify-content-xl-end">
                    <input type="text" name="" id="" placeholder='{{__("customer.text_enter_job_skill")}}'>
                    <input type="submit" value="">
                </form>
            </div>

        </div>

        <!-- <h1 class="post_title mb_30">Marketing Clients</h1> -->
        <div class="mb_20">
            <h3 class="title">Post Details</h3>
        </div>

        <div class="job_card_wrapper sjob_det">

            <div class="job_card job_details_sec mb_20">

                <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
                    <div class="jc_left d-flex align-items-center justify-content-between">
                        <div class="jc_left_l">
                            <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
                        </div>
                        <div class="jc_left_r">
                            <p class="mb0 f16 clr_prpl f_black">{{$get_advertisment['firstname']}}</p>
                            <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} 5415169 <span class="clr_ylw"> 3d ago</span></p>
                        </div>
                    </div>
                    <div class="jc_right text-end">  
                        
                    </div>
                </div>

                <div class="uniq_cent flex-wrap  px-0 d-flex align-items-center justify-content-between">
                <div class="jcard_center px-0">
                    
                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j1.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['experience']}} </span></div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j2.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['working_hour']}} </span></div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j3.png') }}" alt=""></span> 
                    	@if($get_advertisment['driving_license']!='')
                    	<span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}} </span>
                    	@else
                    	<span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                    	@endif
                    </div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j4.png') }}" alt=""></span> 
                    	@if($get_advertisment['own_car']!='')
                    	<span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}} </span>
                    	@else
                    	<span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                    	@endif
                    </div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j5.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['work_location']}} </span></div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j6.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['day']}}/{{$get_advertisment['month']}}/{{$get_advertisment['year']}} </span></div>

                </div>          
                
                <div class="text-center"><a href="#" class="bk_btn" onclick="goBack()"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div>
                </div>

                <div class="jc_footer px-0">
                    <h3 class="">{{__("customer.text_description")}}</h3>
                    <p class="clr_grey f_regular f_14 description_p">{{$get_advertisment['description']}} <a href="#"> {{__("customer.text_read_more")}}</a></p>
                    </div>

            </div>

          	
        </div>

      <!--   <h4>Company's and Employers</h4>
        <div class="job_card_wrapper">
                <div class="job_card">

                    <div class="jcard_top d-flex align-items-center justify-content-between">
                        <div class="jc_left d-flex align-items-center justify-content-between">
                            <div class="jc_left_l">
                                <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
                            </div>
                            <div class="jc_left_r">
                                <p class="mb0 f16 clr_prpl f_black">Company Number</p>
                                <p class="clr_grey f12 mb0 f_bold">Offer No. 5415169 <span class="clr_ylw"> 3d ago</span>
                                </p>
                            </div>
                        </div>
                        <div class="jc_right text-end">
                            <a href="javascript:void(0)" class="wishlist">
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

                       
                        <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j5.png') }}" alt=""></span> <span
                                class="jc_inbox2 f_bold clr_prpl f12">Work Location </span></div>

                        <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j6.png') }}" alt=""></span> <span
                                class="jc_inbox2 f_bold clr_prpl f12">12/03/2022 </span></div>

                    </div>

                    <div class="jc_footer">
                        <a href="#" class="">Contract Offer <span> <img src="{{ asset('assets/images/bot_ar.png') }}"
                                    alt=""></span></a>
                    </div>

                </div>

        </div> -->


	</div>

@include('front.layout.footer')	