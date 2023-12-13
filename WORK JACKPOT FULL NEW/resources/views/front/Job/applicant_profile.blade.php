@include('front.layout.header')
@include('front.layout.sidebar') 
<style type="text/css">
    .jc_left {width: 50%;}
    .jc_right{width: 50%;}
</style>
 <div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">

        <div class="top_ann_left">
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>

        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>

    </div>

    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-md-4 mb-md-0 mb_20">{{__("customer.text_job_app_pro")}}</h3>
    </div>
    @csrf
    <div class="job_card_wrapper sjob_det mb_30">

        <div class="job_card job_details_sec mb_20">

            <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
                <div class="jc_left_applicant d-flex align-items-center justify-content-between">
                    <div class="jc_left_l">
                        <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
                    </div>
                    <div class="jc_left_r">
                        <p class="mb0 f16 clr_prpl f_black">{{$contract['customer_name']}},{{$contract['title']}}</p>
                        <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} {{$contract['job_id']}} <span class="clr_ylw"> {{$contract['create_time']}}</span></p>
                    </div>
                </div>
                <div class="jc_right_applicant text-end">
                    <a href="#" onclick="goBack()" class="bk_btn"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a>
                    <a download="custom-filename.jpg" href="{{ asset('assets/images/back.png') }}" title="CV" class="contract_btn">
                    {{__("customer.text_download_cv")}}</a>
                    
                    @if($contract['contract_status']=='Published')
                        <a class="contract_btn">Already Contracted</a>
                    @else
                        <a id="send_pending" data-id="{{$contract['id']}}" job-id="{{$contract['job_id']}}" data-status="Published" class="contract_btn">{{__("customer.text_contract_now")}} <span> <img src="{{ asset('assets/images/bot_ar.png') }}" alt=""></span></a>
                    @endif
                </div>
            </div>

            <div class="uniq_cent px-0 d-flex align-items-center flex-wrap justify-content-between">
                <div class="jcard_center px-0">
                    
                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j1.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$contract['experience']}}</span></div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j2.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$contract['working_hours']}}</span></div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j3.png') }}" alt=""></span> 
                        <?php if ($contract['driving_license']!='') { ?>
                            <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}}</span>
                        <?php }else{ ?>
                            <span class="jc_inbox2 f_bold clr_prpl f12"> - </span>
                        <?php } ?>
                    </div>

                    <div class="jc_inbox">
                        <span class="jc_inbox1"><img src="{{ asset('assets/images/j4.png') }}" alt=""></span>

                        <?php if ($contract['own_car']!='') { ?>
                        <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
                        <?php }else{ ?>
                        <span class="jc_inbox2 f_bold clr_prpl f12"> - </span>
                        <?php } ?>

                    </div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j5.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$contract['work_location']}} </span></div>

                    <div class="jc_inbox"><span class="jc_inbox1"><img src="{{ asset('assets/images/j6.png') }}" alt=""></span> <span class="jc_inbox2 f_bold clr_prpl f12">{{$contract['start_date']}} </span></div>

                </div> 
            </div>

        </div>
        
        <div class="profile_right_details" style="width: 100%;">
             <div class="profile_right_sec">
                <h3>{{__("customer.text_education")}}</h3>
                <div class="load_parent">
                   <div class="row">
                      @if(count($users['education_source']) >0)
                      <?php $i=1; ?>
                      @foreach($users['education_source'] as $key =>$value)
                      <div class="col-xxl-6  mb_20 row align-items-end {{$i > 2 ? 'hidden_content':''}}">
                         <div class="col-lg-3">
                            <p class="m-0">{{$value['school_year']}}</p>
                         </div>
                         <div class="col-lg-9">
                            <p>{{$value['school_name']}}</p>
                            <h4>{{$value['school_address']}}</h4>
                         </div>
                      </div>
                      <?php $i++; ?>
                      @endforeach
                      @else
                      <div class="col-xxl-6  mb_20 row align-items-end">
                         <div class="col-lg-12">
                            <h4>{{__("customer.text_no_info")}}</h4>
                         </div>
                      </div>
                      @endif
                   </div>
                   <div class="more_btn text-center">
                      <a href="javascript:void(0)" class="show_more ">{{__("customer.text_more_detail")}}</a>
                   </div>
                </div>
             </div>
             <div class="profile_right_sec">
                <h3>{{__("customer.text_profession")}}</h3>
                <?php 
                   $i=1;
                   ?>
                <div class="load_parent">
                   @if(count($users['professions'])>0)
                   @foreach($users['professions'] as $key => $value6)
                   <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                      <div class="col-md-6 mb-md-0 mb_20">
                         <h4 class="mb_10">Name <span>- {{$value6['profession_name']}}</span></h4>
                      </div>
                      <div class="col-md-6 text-md-end text-start">
                         <h4 class="mb_10">{{__("customer.text_profession")}} {{__("customer.text_years")}}</h4>
                         <p class="m-0">{{$value6['profession_year']}}</p>
                      </div>
                   </div>
                   <?php $i++;?>
                   @endforeach
                   @else
                   <div class="row ">
                      <div class="col-md-12 mb-md-0 mb_20 ">
                         <h4 class="m-0">{{__("customer.text_no_info")}}</h4>
                      </div>
                   </div>
                   @endif
                   <div class="more_btn text-center">
                      <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                   </div>
                </div>
             </div>
             <div class="profile_right_sec">
                <h3>{{__("customer.text_hiring_history")}}</h3>
                <?php 
                   $i=1;
                   ?>
                <div class="load_parent">
                   @if(count($users['hiring_history'])>0)
                   @foreach($users['hiring_history'] as $key => $value2)
                   <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                      <div class="col-md-6 mb-md-0 mb_20">
                         <h4 class="mb_10">{{__("customer.text_designation")}} <span>- {{$value2['company_name']}}</span></h4>
                         <p class="m-0">{{$value2['company_address']}}</p>
                      </div>
                      <div class="col-md-6 text-md-end text-start">
                         <h4 class="mb_10">{{__("customer.text_working_years")}} </h4>
                         <p class="m-0">{{$value2['working_year']}}</p>
                      </div>
                   </div>
                   <?php $i++;?>
                   @endforeach
                   @else
                   <div class="row ">
                      <div class="col-md-12 mb-md-0 mb_20 ">
                         <h4 class="m-0">{{__("customer.text_no_info")}}</h4>
                      </div>
                   </div>
                   @endif
                   <div class="more_btn text-center">
                      <!-- remove condition -->
                      <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                   </div>
                </div>
             </div>
             <div class="profile_right_sec">
                <h3>{{__("customer.text_exp_abroad")}}</h3>
                <div class="load_parent">
                   @if(count($users['exp_abroad'])>0)
                   <?php  $i=1;?>
                   @foreach($users['exp_abroad'] as $key => $value3)
                   <div class="row {{$i > 1 ?'hidden_content':'load_parent'}}">
                      <div class="col-md-6 mb-md-0 mb_20">
                         <h4 class="mb_10">{{__("customer.text_designation")}} <span>-{{$value3['company_name']}}</span></h4>
                         <p class="m-0">{{$value3['company_address']}}</p>
                      </div>
                      <div class="col-md-6 text-md-end text-start">
                         <h4 class="mb_10">{{__("customer.text_working_years")}}</h4>
                         <p class="m-0">{{$value3['working_year']}}</p>
                      </div>
                   </div>
                   <?php $i++;?>
                   @endforeach
                   @else
                   <div class="row ">
                      <div class="col-md-12 mb-md-0 mb_20 ">
                         <h4 class="m-0">{{__("customer.text_no_info")}}</h4>
                      </div>
                   </div>
                   @endif
                   <div class="more_btn text-center">
                      <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                   </div>
                </div>
             </div>
             <div class="row mb_30">
                <div class="col-xxl-6 mb_30 mb-xxl-0">
                   <div class="profile_right_sec">
                      <h3>{{__("customer.text_skills")}}</h3>
                      <div class="load_parent ">
                         @if(count($users['skills'])>0)
                         <?php $i=1; ?>
                         @foreach($users['skills'] as $key => $value4)
                         <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                            <ul>
                               <li>{{$value4['skill']}}</li>
                            </ul>
                         </div>
                         <?php $i++;?>
                         @endforeach
                         @else
                         <div class="profile_list ">
                            <ul>
                               <li>{{__("customer.text_no_info")}}</li>
                            </ul>
                         </div>
                         @endif
                         <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                         </div>
                      </div>
                   </div>
                </div>
                
                   
                <div class="col-xxl-6">
                   <div class="profile_right_sec">
                      <h3>{{__("customer.text_customer_permission")}}</h3>
                      <div class="load_parent ">
                         @if(count($users['permission'])>0)
                         <?php $i=1; ?>
                         @foreach($users['permission'] as $key => $value_per)
                         <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                            <ul>
                               <li>{{$value_per['permission']}}</li>
                            </ul>
                         </div>
                         <?php $i++;?>
                         @endforeach
                         @else
                         <div class="profile_list ">
                            <ul>
                               <li>{{__("customer.text_no_info")}}</li>
                            </ul>
                         </div>
                         @endif
                         <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                         </div>
                      </div>
                   </div>
                </div>   
             </div>


             <div class="row mb_30">
                <div class="col-xxl-6 mb_30 mb-xxl-0">
                   <div class="profile_right_sec">
                      <h3>{{__("customer.text_languages")}}</h3>
                      <div class="load_parent ">
                         @if(count($users['cust_language'])>0)
                         <?php $i=1; ?>
                         @foreach($users['cust_language'] as $key => $value_lan)
                         <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                            <ul>
                               <li>{{$value_lan['language']}}</li>
                            </ul>
                         </div>
                         <?php $i++;?>
                         @endforeach
                         @else
                         <div class="profile_list ">
                            <ul>
                               <li>{{__("customer.text_no_info")}}</li>
                            </ul>
                         </div>
                         @endif
                         <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                         </div>
                      </div>
                   </div>
                </div>
                
                   
                <div class="col-xxl-6">
                   <div class="profile_right_sec">
                      <h3>{{__("customer.text_other_knowledge")}}</h3>
                      <div class="load_parent ">
                         @if(count($users['other_knowledges'])>0)
                         <?php $i=1; ?>
                         @foreach($users['other_knowledges'] as $key => $value_other)
                         <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                            <ul>
                               <li>{{$value_other['other_knowledge']}}</li>
                            </ul>
                         </div>
                         <?php $i++;?>
                         @endforeach
                         @else
                         <div class="profile_list ">
                            <ul>
                               <li>{{__("customer.text_no_info")}}</li>
                            </ul>
                         </div>
                         @endif
                         <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                         </div>
                      </div>
                   </div>
                </div>   
             </div>


             <div class="row">   
                <div class="col-xxl-6  mb-xxl-0">
                   <div class="profile_right_sec">
                      <h3>{{__("customer.text_interest_hobbies")}}</h3>
                      <div class="load_parent">
                         @if(count($users['hobbies'])>0)
                         <?php $i=1; ?>
                         @foreach($users['hobbies'] as $key => $value5)
                         <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                            <ul>
                               <li>{{$value5['hobby']}}</li>
                            </ul>
                         </div>
                         <?php $i++;?>
                         @endforeach
                         @else
                         <div class="profile_list ">
                            <ul>
                               <li>{{__("customer.text_no_info")}}</li>
                            </ul>
                         </div>
                         @endif
                         <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                         </div>
                      </div>
                   </div>
                </div>

                <div class="col-xxl-6">
                   <div class="profile_right_sec">
                      <h3>{{__("customer.text_add_info")}}</h3>
                      <div class="load_parent ">
                         @if(count($users['add_info'])>0)
                         <?php $i=1; ?>
                         @foreach($users['add_info'] as $key => $value_other)
                         <div class="profile_list {{$i > 1 ?'hidden_content  mt-2':'load_parent'}}">
                            <ul>
                               <li>{{$value_other['information']}}</li>
                            </ul>
                         </div>
                         <?php $i++;?>
                         @endforeach
                         @else
                         <div class="profile_list ">
                            <ul>
                               <li>{{__("customer.text_no_info")}}</li>
                            </ul>
                         </div>
                         @endif
                         <div class="more_btn text-center">
                            <a href="javascript:void(0)" class="show_more">{{__("customer.text_more_detail")}}</a>
                         </div>
                      </div>
                   </div>
                </div>  
                
             </div>
        </div>



    </div>

</div>
@include('front.layout.footer')
<script type="text/javascript">
    $(document).ready(function(){
        $("#show_btn").click(function(){
            $('#more_content').slideDown(500);
            $('#less_content').hide();
        });
        $("#more_btn").click(function(){
            $('#more_content').slideUp(200);
            $('#less_content').show(500);
        });
    });
</script>
<script type="text/javascript">
    $('body').on("click",'#send_pending', function(){
     
        job=confirm('{{__("customer.text_sure")}}');
        if(job!=true){
          return false;
        }

        var ContractId = $(this).attr('data-id');
        var JobId = $(this).attr('job-id');
        var Datastatus = $(this).attr('data-status');
        
        _token = $("input[name='_token']").val();
        // alert(_token);
        // return false;

        $.ajax({
            url:"{{ url('change_job_status') }}",
            type: 'post',
            data: {'ContractId': ContractId,'JobId': JobId,'_token':_token,'Datastatus':Datastatus},
            success: function(response) {  
             window.location.href = "{{url('job')}}";
            }
        });
  
    });
</script>
