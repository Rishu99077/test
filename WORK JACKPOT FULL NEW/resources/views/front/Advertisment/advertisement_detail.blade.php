@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
  .disabled{background: #425564!important;}
</style>
<div class="main_right">
  <div class="top_announce d-flex align-items-center justify-content-between mb_20">

      <div class="top_ann_left">
          @if($user['role']=='seeker')
          <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
          @elseif($user['role']=='provider')
          <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
          @endif
      </div>
      <div class="top_ann_right d-flex align-items-center ">
          <form action="" class="topan_search w-100 justify-content-xl-end">
              <input type="text" name="search_everything" id="search_everything" value="{{ @$_GET['search_everything'] ? $_GET['search_everything']:'' }}" placeholder='{{__("customer.text_search_for_everything")}}'>
              <input type="submit" value="">
          </form>
      </div>

  </div>

  @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
      @if(Session::has($key))
        <p id="success_msg" class="alert alert-{{ $key }} alert-block">{{ Session::get($key) }}</p>
      @endif
  @endforeach

  <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-md-4 mb-md-0 mb_20">{{__("customer.text_advertisment")}} {{__("customer.text_detail")}}</h3>
  </div>

  <div class="job_card_wrapper sjob_det mb_30">

      <div class="job_card job_details_sec mb_20">

          <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
              <div class="jc_left d-flex align-items-center justify-content-between">
                  <div class="jc_left_l">
                      <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
                  </div>
                  <div class="jc_left_r">
                      <p class="mb0 f16 clr_prpl f_black">{{$get_advertisment['firstname']}}</p>
                      <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_offer_no")}} {{$get_advertisment['id']}} <span class="clr_ylw"><?php 
                       echo $newtimeago = App\Models\JobsModel::newtimeago($get_advertisment['created_at']);
                     ?></span></p>
                  </div>
              </div>              
          </div>

          <div class="uniq_cent px-0 d-flex align-items-center flex-wrap justify-content-between">
          <div class="jcard_center px-0">              
                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j1.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['experience']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j2.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['working_hour']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j3.png') }}" alt="">
                  </span>
                  @if($get_advertisment['driving_license']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}}</span>
                  @elseif($get_advertisment['driving_license']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                  @endif
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j4.png') }}" alt="">
                  </span> 
                  @if($get_advertisment['own_car']=='1') 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
                  @elseif($get_advertisment['own_car']=='0')
                  <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                  @endif
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j5.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['work_location']}}</span>
                </div>

                <div class="jc_inbox">
                  <span class="jc_inbox1">
                    <img src="{{ asset('assets/images/j6.png') }}" alt="">
                  </span> 
                  <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['date']}}</span>
                </div>
          </div>          
          
          <div class="text-center"><a href="#" class="bk_btn" onclick="goBack()"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div>
          </div>

          <div class="jc_footer px-0">
              <h3 class="">{{__("customer.text_description")}}</h3>
              <p class="clr_grey f_regular f_14 description_p">{{$get_advertisment['description']}} 
                <?php  $Word_Count = str_word_count($get_advertisment['description']);
                if ($Word_Count>50) { ?>
                <a href="#">{{__("customer.text_read_more")}} </a>
                <?php } ?>
              </p>
          </div>

      </div>
      <div class="jo_rec box_s mb_20">
        <p class="f16 clr_prpl f_black">{{__("customer.text_detail")}}</p>
        <ul>
          <li><strong>{{__("customer.text_academic_level")}}</strong> - {{$get_advertisment['academic_level']  }}</li>
          <li><strong>{{__("customer.text_nationality")}}</strong> - {{$get_advertisment['nationality']  }}</li>
          <li><strong>{{__("customer.text_zipcode")}}</strong> - {{$get_advertisment['zipcode']  }}</li>
          <li><strong>{{__("customer.text_profession")}}</strong> {{__("customer.text_name")}} - {{$get_advertisment['profession_name']  }}</li>
          <li><strong>{{__("customer.text_hours_salary")}}</strong> - {{$get_advertisment['hours_salary']  }}</li>
          <li><strong>{{__("customer.text_work_location")}}</strong> - {{$get_advertisment['work_location']  }}</li>
        </ul>         
      </div>
      
      @if($user['role']=='provider')
      <div class="box_s d-flex align-items-center justify-content-between mb_20">
        <p class="f18 clr_prpl f_black m-0">{{__("customer.text_contract_now")}}</p>
        @if($get_adv_check)
        <a href="javascript:void(0);" class="disabled" disabled >{{__("customer.text_already_contract")}}</a>
        @else
        <a href="javascript:void(0);" class="" id="add_adv_contract" data-id="{{$get_advertisment['id']}}">{{__("customer.text_contract_now")}} <span> <img src="https://dev.infosparkles.com/workjackpot/assets/images/bot_ar.png" alt=""></span></a>
        @endif
      </div>
      @endif
      
  
  </div>
  @if($user['role'] == "seeker")
       <div class="job_card_wrapper">
                
                @if($get_company_appliers)
                    @foreach($get_company_appliers as $key =>$value)
                    <div class="job_card">
                        <div class="jcard_top d-flex align-items-center justify-content-between">
                            <div class="jc_left d-flex align-items-center justify-content-between">
                                <div class="jc_left_l">
                                    <span><img src="{{ asset('assets/images/company.png') }}" alt=""></span>
                                </div>
                                <div class="jc_left_r">
                                    <p class="mb0 f16 clr_prpl f_black">{{$value['company_name']}}</p>
                                    <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_offer_no")}} {{$value['id']}} <span class="clr_ylw">{{$value['date']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="jc_right text-end">
                                <a href="javascript:void(0)" id="add_wishlist" class="wishlist" data-id="">
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
                                <img src="{{ asset('assets/images/j5.png') }}" alt="">
                              </span> 
                              <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['country']}}</span>
                            </div>
                            <div class="jc_inbox">
                              <span class="jc_inbox1">
                                <img src="{{ asset('assets/images/j6.png') }}" alt="">
                              </span> 
                              <span class="jc_inbox2 f_bold clr_prpl f12">{{$value['created_at']}}</span>
                            </div>
                        </div>                      
                        <div class="jc_footer">
                            <a href="" class="">{{__("customer.text_contract_offer")}} <span> <img src="{{asset('assets/images/bot_ar.png') }}" alt=""></span></a>
                        </div>                      
                    </div>
                    @endforeach 
                @endif              
            </div>
      @endif

<script type="text/javascript">
  $(document).on('click','#add_adv_contract',function(){
      var id = {{$get_advertisment['id']}};
      $.ajax({
         url: "{{Route('adv_contract')}}",
         method: 'POST',
         dataType:'json',
         data: {"id":id,"_token": "{{ csrf_token() }}",},
         success:function(resp){
           if(resp.status == true){
              success_msg(resp.message);
              $('#add_adv_contract').attr('disabled',true)
              $('#add_adv_contract').text('Already Contracted');
              $('#add_adv_contract').addClass('disabled');
              $('#add_adv_contract').removeAttr('id');
           }else{
              danger_msg(resp.message);
           }
         }
      });
  });
</script>
@include('front.layout.footer')
