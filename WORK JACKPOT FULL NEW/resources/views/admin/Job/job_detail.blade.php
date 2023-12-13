@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">

        <div class="top_ann_left">

        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder="Enter job title, skill, location etc">
                <input type="submit" value="">
            </form>
        </div>

    </div>

    @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
	    @if(Session::has($key))
	      <p id="success_msg" class="alert alert-{{ $key }} alert-block">{{ Session::get($key) }}</p>
	    @endif
	@endforeach


    <div class="mb_20">
        <h3 class="title">{{__("admin.text_details")}}</h3>
    </div>
    @csrf
    <div class="job_card_wrapper sjob_det">

        <div class="job_card job_details_sec mb_20">

            <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
                <div class="jc_left d-flex align-items-center justify-content-between">
                    <div class="jc_left_l">
                        <span><img src="{{ asset('admin/assets/images/bpro.png') }}" alt=""></span>
                    </div>
                    <div class="jc_left_r">
                        <p class="mb0 f16 clr_prpl f_black">{{$jobs['title']}}</p>
                        <p class="clr_grey f12 mb0 f_bold">{{__("admin.text_job_no")}} 5415169 <span class="clr_ylw"> {{$jobs['datetime']}}</span></p>
                    </div>
                </div>
            </div>

            <div class="uniq_cent flex-wrap  px-0 d-flex align-items-center justify-content-between">
	            <div class="jcard_center px-0">
	                
	                <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('admin/assets/images/j1.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$jobs['experience']}}</span></div>

	                <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('admin/assets/images/j2.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$jobs['working_hours']}}</span></div>

	                <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('admin/assets/images/j3.png') }}" alt=""></span> 
	                	<?php if ($jobs['driving_license']!='') { ?>
	                	<span class="jc_inbox2 f_bold clr_prpl f12">{{__("admin.text_driving_license")}}</span>
	                	<?php }else{ ?>
	                	<span class="jc_inbox2 f_bold clr_prpl f12">-</span>
	                    <?php } ?>
	                </div>

	                <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('admin/assets/images/j4.png') }}" alt=""></span> 
	                	<?php if ($jobs['own_car']!='') { ?>
	                	<span class="jc_inbox2 f_bold clr_prpl f12">{{__("admin.text_own_car")}}</span>
	                	<?php }else{ ?>
	                	<span class="jc_inbox2 f_bold clr_prpl f12">-</span>
	                    <?php } ?>
	                </div>

	                <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('admin/assets/images/j5.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$jobs['work_location']}} </span></div>

	                <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('admin/assets/images/j6.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">12/03/2022 </span></div>

	            </div>          
            
	            <div class="text-center">
	            	<a href="#" class="bk_btn" onclick="goBack()"><img src="{{ asset('admin/assets/images/back.png') }}" alt="">{{__("admin.text_back")}}</a>
	            </div>
            </div>

            <div class="jc_footer px-0">
                <h3 class="">{{__("admin.text_description")}}</h3>
                <p class="clr_grey f_regular f_14 description_p">{{$jobs['description']}}<a href="#"> {{__("admin.text_read_more")}}</a></p>
                </div>

        </div>

        <div class="box_s d-flex align-items-center justify-content-between mb_20">
        	@if($jobs['status']=='Published' || $jobs['status'] == 'Ongoing')
                <button class="send_btn bg-light text-dark" disabled>{{$jobs['status']}}</button>
                <button class="reject_btn" id="send_pending" data-id="{{$jobs['id']}}" data-status="Reject">{{__("admin.text_reject")}}</button>
            @elseif($jobs['status']=='Pending')
                <button class="send_btn" id="send_pending" data-id="{{$jobs['id']}}" data-status="Published">{{__("admin.text_publish")}}</button>
                <button class="reject_btn" id="send_pending" data-id="{{$jobs['id']}}" data-status="Reject">{{__("admin.text_reject")}}</button>
            @endif
        </div>
        

    </div>

</div>

@include('admin.layout.footer')
<script type="text/javascript">
 	$('body').on("click",'#send_pending', function(){
     
		job=confirm('Are u sure to change job status?');
		if(job!=true){
		  return false;
		}

		var Jobid = $(this).attr('data-id');
		var Datastatus = $(this).attr('data-status');
		_token = $("input[name='_token']").val();


		$.ajax({
			url:"{{ url('admin/change_jobs_status') }}",
			type: 'post',
			data: {'Jobid': Jobid,'_token':_token,'Datastatus':Datastatus},
			success: function(response) {  
			 window.location.href = "{{url('admin/All-jobs')}}";
			}
		});
  
    });
</script>