@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
.dash_admin {margin: 13px;padding: 10px;border-bottom: 1px solid;}
.dash_img {text-align: center;}
.dash_img img {background: #228EE3;width: 40px;height: 40px;object-fit: cover;border: 2px solid var(--sky_blue);border-radius: 50%;}
.f18 {font-size: 18px;}.das_name_time{margin-left: 73%;display: inherit;margin: 0px 0px 0px 85%;}
.new_section .das_name{width: 40%!important;}

</style>
	
	<div class="main_right">

            <div class="top_announce d-flex align-items-center justify-content-between mb_20">

                <div class="top_ann_left">
                     @if($user['role']=='seeker')
                    <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
                    @elseif($user['role']=='provider')
                    <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_a_job")}}</a>
                    @endif
                </div>
                <div class="top_ann_right d-flex align-items-center ">
                    <form action="" class="topan_search w-100 justify-content-xl-end">
                        <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                        <input type="submit" value="">
                    </form>
                </div>

            </div>

            <div class="row top_bb mb_20 align-items-center justify-content-between">
                <h3 class="title col-md-6 mb-md-0 mb_20">{{$common['heading_title']}}</h3>
            </div>
            <div class="main-section bg-white">
                <ul>
                    <?php foreach ($get_notification as $key => $value) {  
                        $newdate = $value['created_at'];
                          $transactionDate = date("d.m.Y",strtotime($newdate)); ?>
                    <li>
                        <div class="dash_admin d-flex align-items-center justify-content-between">
                            <div class="dash_img"><img src="{{ asset('assets/images/bpro.png') }}"></div>
                            <div class="das_name">
                                <p class="f18">{{$value['message']}} <span class="das_name_time">{{$transactionDate}}</span> </p>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <!-- <div class="bg-white main-section">
                <div class="row">
                    <?php foreach ($get_notification as $key => $value) {  
                        $newdate = $value['created_at'];
                          $transactionDate = date("d.m.Y",strtotime($newdate)); ?>
                    <div class="col-md-12 new_section">
                        <div class="row">
                            <div class="col-md-2 dash_img">
                                <img src="{{ asset('assets/images/bpro.png') }}">
                            </div>
                            <div class="col-md-8 das_name" >
                                <p class="f18">{{$value['message']}}</p>
                            </div>
                            <div class="col-md-2 das_name">
                                <p class="f18">{{$transactionDate}}</p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div> -->

        </div>

@include('front.layout.footer')
