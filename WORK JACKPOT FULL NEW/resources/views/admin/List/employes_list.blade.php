@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('jobs_vacancies')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>


    <?php if (!empty($contracts)) { ?>
      <div class="job_card_wrapper">

      	<?php foreach ($contracts as $key => $value) { ?>
          <div class="job_card">

              <div class="jcard_top d-flex align-items-center justify-content-between">
                  <div class="jc_left d-flex align-items-center justify-content-between">
                      <div class="jc_left_l">
                          <span><img src="{{ asset('admin/assets/images/bpro.png') }}" alt=""></span>
                      </div>
                      <div class="jc_left_r">
                          <?php $fulltitle = $value['title']; ?>
                          <p class="mb0 f16 clr_prpl f_black" title="Employee name">{{$value['employee_name']}}</p>
                          <p title="Job title"> (<?php echo (strlen($fulltitle) > 25) ? substr($fulltitle, 0, 25) . '...' : $fulltitle; ?>)</p>
                          <p class="clr_grey f12 mb0 f_bold">{{__("admin.text_job_no")}} {{$value['job_id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
                          </p>
                      </div>
                  </div>
                  <div class="jc_right text-end">
                     
                  </div>
              </div>

              <div class="jcard_center">

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j1.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title="Employed">{{$value['provider_name']}}</span>
                  </div>

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j2.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title="Contract number">{{$value['contract_id']}}</span>
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
                      <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_own_car")}}'>{{__("admin.text_own_car")}}</span>
                    @elseif($value['own_car']=='0')
                      <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_own_car")}}'>-</span>
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

             <!--  <div class="jc_footer">
                  <a href="#"
                      class="d-flex align-items-center justify-content-between"><span> Total Appliers</span> <span
                          class="pjob_count"> 1</span></a>
              </div> -->

          </div>
      	<?php } ?>

      </div>
    <?php }else{ ?>
      <div class="container-fluid bg-white text-center">
        <img src="{{asset('assets/images/No Record.png')}}">
     </div>
    <?php } ?>

    <!-- *pagination -->
    <div class="my_pagination">
        {{$get_contract->appends(request()->query())->links() }}
    </div> 
    <!-- *pagination -->

</div>	
	

@include('admin.layout.footer')