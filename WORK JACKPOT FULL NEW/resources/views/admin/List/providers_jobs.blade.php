@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('jobs_vacancies')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form class="topan_search w-100 justify-content-xl-end">
                <a href="#" class="btn add_btn" onclick="goBack()"> {{__("admin.text_back")}} </a>
            </form>
        </div>
    </div>

    <?php if (!empty($jobs)) { ?>
      <div class="job_card_wrapper">
        <?php foreach ($jobs as $key => $value) { ?>
          <div class="job_card">

              <div class="jcard_top d-flex align-items-center justify-content-between">
                  <div class="jc_left d-flex align-items-center justify-content-between">
                      <div class="jc_left_l">
                          <span><img src="{{ asset('admin/assets/images/bpro.png') }}" alt=""></span>
                      </div>
                      <div class="jc_left_r">
                          <p class="mb0 f16 clr_prpl f_black">{{$value['title']}}</p>
                          <p class="clr_grey f12 mb0 f_bold">{{__("admin.text_job_no")}} {{$value['id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
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
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_experience")}}'>{{$value['experience']}}</span>
                  </div>

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j2.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_working_hours")}}'>{{$value['working_hours']}}</span>
                  </div>

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j3.png') }}" alt="">
                    </span>
                    @if($value['driving_license']=='1') 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_driving_license")}}'>{{__("admin.text_driving_license")}} </span>
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
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_work_location")}}'>{{$value['work_location']}}</span>
                  </div>

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j6.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_start_date")}}'>{{$value['start_date']}}</span>
                  </div>

              </div>

              <div class="jc_footer">
                  <a href="{{Route('providers_applicants',['id'=>$value['id']])}}"
                      class="d-flex align-items-center justify-content-between"><span> {{__("admin.text_total_applier")}'</span> 
                      <span class="pjob_count"> {{$value['contract_count']}}</span></a>
              </div>

          </div>
        <?php } ?>
      </div>
    <?php }else{ ?>
      <div class="container-fluid bg-white text-center no_record">
          <img src="{{asset('assets/images/no_record_face.png')}}">
          <p>{{__("admin.text_sorry")}} , {{__("admin.text_no_record")}}</p>
      </div>
    <?php } ?>

    <!-- *pagination -->
    <div class="my_pagination">
        {{$get_jobs->appends(request()->query())->links() }}
    </div> 
    <!-- *pagination -->

</div>  
  

@include('admin.layout.footer')