@include('front.layout.header')
@include('front.layout.sidebar')

<style type="text/css">
 .jc_left_l{
    background: #19286B 0% 0% no-repeat padding-box;
 }    
</style>
<?php
$search_for_everthing = "";
if(@$_GET['search_everything']){
    $search_for_everthing = @$_GET['search_everything'];
}
?>

        <div class="main_right">

            <form method="get" action="">
            <div class="top_announce d-flex align-items-center justify-content-between mb_20">

                <div class="top_ann_left">
                    @if($user['role']=='seeker')
                    <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
                    @elseif($user['role']=='provider')
                    <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
                    @endif
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
                @if($user['role']=='seeker')
                    <h3 class="title col-xl-4 recom_title">{{__("customer.text_post_details")}}</h3>
                @elseif($user['role']=='provider')
                    <h3 class="title col-xl-4 recom_title">{{__("customer.text_rec_candidates")}}</h3>
                 @endif
                <div class="col-xl-8">

                    <?php
                       @$NameSearch = @$_GET['NameSearch'];
                    ?>
                    <div class="dash_filter">
                        <div class="dropdown_filter">
                            <label>{{__("customer.text_filter_by")}}</label>
                            <a href="#" class="click_to_down">{{__("customer.text_filter")}} 
                            </a>
                            <div class="slide_down_up" style="display: none;">
                                <div class="filter_row">
                                    <label for="">{{__("customer.text_company_no")}}</label>
                                    <input type="text" name="company_no" placeholder='{{__("customer.text_enter")}} {{__("customer.text_company_no")}}' value="{{ @$_GET['company_no'] ? $_GET['company_no']:''}}">
                                </div>

                                <div class="filter_row">
                                    <label for="">{{__("customer.text_offer_no")}}</label>
                                    <input type="text"  name="offer_no" value="{{ @$_GET['offer_no'] ? $_GET['company_no']:''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_offer_no")}}'>
                                </div>
                                
                                <div class="filter_row">
                                    <label for="">{{__("customer.text_location")}}</label>
                                    <input type="text" name="location" value="{{ @$_GET['company_no'] ? @$_GET['company_no']:''}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}'>
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
            @csrf

            <div class="job_card_wrapper sjob_det mb_10">
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
                          <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_driving_license")}} </span>
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
                          <span class="jc_inbox2 f_bold clr_prpl f12">{{$get_advertisment['day']}}/{{$get_advertisment['month']}}/{{$get_advertisment['year']}}</span>
                        </div>
                  </div>          
                  
                  <div class="text-center"><a href="#" class="bk_btn" onclick="goBack()"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div>
                  </div>

                  <div class="jc_footer px-0">
                      <h3 class="">{{__("customer.text_description")}}</h3>
                      <p class="clr_grey f_regular f_14 description_p">{{$get_advertisment['description']}} 
                        <?php  $Word_Count = str_word_count($get_advertisment['description']);
                        if ($Word_Count>50) { ?>
                        <a href="#"> {{__("customer.text_read_more")}}</a>
                        <?php } ?>
                      </p>
                  </div>

              </div>
            </div>


            <!-- Seeker View -->
            <!-- According to seeker least Pdf -->
           <!--  <div class="job_card_wrapper">
                
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
                                    <p class="clr_grey f12 mb0 f_bold">Offer No. {{$value['id']}} <span class="clr_ylw">{{$value['date']}}</span>
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
                            <a href="{{Route('advertisment.detail',$value['advertisment_id'])}}" class="">Contract Offer <span> <img src="{{asset('assets/images/bot_ar.png') }}" alt=""></span></a>
                        </div>                      
                    </div>
                    @endforeach 
                @endif              
            </div> -->


            <!-- No Records -->
            <!-- ?php if(empty($seekers) && empty($jobs) ){ ?>
                <div class="container-fluid bg-white text-center">
                    <img src="{{asset('assets/images/No Record.png')}}">
                </div>
            <?php //} ?> -->
            <!-- No Records -->

            <!-- *pagination --> 
            <!-- ?php if(!empty($seekers)){ ?>
            <div class="my_pagination">
                {{--- $get_seekers->appends(request()->query())->links() ----}}
            </div> 
            <?php // } ?>
 -->
            
            <!-- *pagination -->

        </div>

@include('front.layout.footer')
