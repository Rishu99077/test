@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">
    @csrf
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('jobs_vacancies')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>


    <?php if (!empty($advertisments)) { ?>
      <div class="job_card_wrapper">

      	<?php foreach ($advertisments as $key => $value) { ?>
          <div class="job_card">

              <div class="jcard_top d-flex align-items-center justify-content-between">
                  <div class="jc_left d-flex align-items-center justify-content-between">
                      <div class="jc_left_l">
                          <span><img src="{{ asset('admin/assets/images/bpro.png') }}" alt=""></span>
                      </div>
                      <div class="jc_left_r">
                          <?php $fullname = $value['employee_name']; ?>
                          <p class="mb0 f16 clr_prpl f_black" title="Employee name"><?php echo (strlen($fullname) > 25) ? substr($fullname, 0, 25) . '...' : $fullname; ?></p>
                          <p class="clr_grey f12 mb0 f_bold">Adv No. {{$value['adv_id']}} <span class="clr_ylw"> {{$value['datetime']}}</span>
                          </p>
                      </div>
                  </div>
                  <div class="jc_right text-end">
                     <a href="{{Route('edit_advertisment',['id'=>$value['adv_id']] ) }}"><i class="fa fa-edit"></i></a>
                  </div>
              </div>

              <div class="jcard_center">

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j1.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_working_hours")}}'>{{$value['working_hour']}}</span>
                  </div>

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j2.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_experience")}}'>{{$value['experience']}}</span>
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
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_work_location")}}'>{{$value['work_location']}}</span>
                  </div>

                  <div class="jc_inbox">
                    <span class="jc_inbox1">
                      <img src="{{ asset('admin/assets/images/j6.png') }}" alt="">
                    </span> 
                    <span class="jc_inbox2 f_bold clr_prpl f12" title='{{__("admin.text_start_date")}}'>{{$value['date']}}</span>
                  </div>

                  <div class="text-center">
                    @if($value['status']=='pending' || $value['status']=='reject')
                      <button class="btn btn-success" id="send_pending" data-id="{{$value['adv_id']}}" data-status="approve">{{__("admin.text_approve")}}</button>
                    @elseif($value['status']=='approve')
                      <button class="btn btn-light">{{__("admin.text_approved")}}</button>
                    @endif
                  </div>
                  <div class="text-center">
                    @if($value['status']=='pending' || $value['status']=='approve')
                      <button class="btn btn-danger" id="send_pending" data-id="{{$value['adv_id']}}" data-status="reject">{{__("admin.text_remove")}}</button>
                    @else
                      <button class="btn btn-light">{{__("admin.text_removed")}}</button>
                    @endif    
                  </div>  


              </div>

              <div class="jc_footer">
                  <a href="#"
                      class="d-flex align-items-center justify-content-between"><span>{{__("admin.text_total_contract")}} </span> <span
                          class="pjob_count"> {{$value['adv_contract_count']}}</span></a>
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
        {{$get_advertisment->appends(request()->query())->links() }}
    </div> 
    <!-- *pagination -->

</div>	

<script type="text/javascript">
    $('body').on("click",'#send_pending', function(){
     
        job=confirm('{{__("customer.text_sure")}}');
        if(job!=true){
          return false;
        }

        var Adv_ID     = $(this).attr('data-id');
        var Datastatus = $(this).attr('data-status');
        
        _token = $("input[name='_token']").val();
        // alert(Adv_ID);
        // alert(Datastatus);
        // alert(_token);
        // return false;

        $.ajax({
            url:"{{ url('admin/change_advertisment_status') }}",
            type: 'post',
            data: {'Adv_ID': Adv_ID,'_token':_token,'Datastatus':Datastatus},
            success: function(response) {  
             window.location.href = "{{url('admin/SeekerAdvertisment')}}";
            }
        });
  
    });
</script>
	

@include('admin.layout.footer')