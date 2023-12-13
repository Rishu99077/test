@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('jobs_vacancies')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>


    <div class="job_card_wrapper">
    	<?php foreach ($jobs as $key => $value) { ?>
        <div class="job_card">

            <div class="jcard_top d-flex align-items-center justify-content-between">
                <div class="jc_left d-flex align-items-center justify-content-between">
                    <div class="jc_left_l">
                        <span><img src="{{ asset('admin/assets/images/bpro.png') }}" alt=""></span>
                    </div>
                    <div class="jc_left_r">
                        <?php $fulltitle = $value['title']; ?>
                        <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($fulltitle) > 25) ? substr($fulltitle, 0, 25) . '...' : $fulltitle; ?></p>
                        <p class="clr_grey f12 mb0 f_bold">{{__("admin.text_job_no")}} {{$value['id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
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

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('admin/assets/images/j1.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_experience")}}'>{{$value['experience']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('admin/assets/images/j2.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_working_years")}}'>{{$value['working_hours']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('admin/assets/images/j3.png') }}" alt="">
                  </span>
                  @if($value['driving_license']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_driving_license")}}'>{{__("admin.text_driving_license")}}</span>
                  @elseif($value['driving_license']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_driving_license")}}'>-</span>
                  @endif
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('admin/assets/images/j4.png') }}" alt="">
                  </span> 
                  @if($value['own_car']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title="Own Car">{{__("admin.text_own_car")}}</span>
                  @elseif($value['own_car']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12" title="Own Car">-</span>
                  @endif
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('admin/assets/images/j5.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title="Work location">{{$value['work_location']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('admin/assets/images/j6.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12" title="Start date">{{$value['start_date']}}</span>
                </div>

            </div>

            <div class="jc_footer">
                <a href="#" class="d-flex align-items-center justify-content-between" ><span> {{__("admin.text_total_applier")}} </span> 
                  <span class="pjob_count"> {{$value['contract_count']}}</span></a>
            </div>

        </div>
    	<?php } ?>
    </div>

    <!-- *pagination -->
    <div class="my_pagination">
        {{$get_jobs->appends(request()->query())->links() }}
    </div> 
    <!-- *pagination -->

</div>	
	

@include('admin.layout.footer')