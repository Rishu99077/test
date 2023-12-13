@include('admin.layout.header')
@include('admin.layout.sidebar')
<style type="text/css">
  .user_outer_main_dash {background: #fff;padding: 15px;}
  .user_outer_main_dash .user_dish_box {position: relative;display: block;padding: 15px;background: #19286b;border-radius: 10px;
  box-shadow: 0 6px 10px rgb(16 0 0 / 44%);min-height: 120px;margin-bottom: 35px;transition: var(--trans);}
  .user_outer_main_dash .user_dish_box .total_count_cls {position: absolute;width: 100%;bottom: 0;left: 0;padding: 0 15px 15px;}
  .user_outer_main_dash .user_dish_box:hover {background: #228EE3;}
  .user_outer_main_dash .user_dish_box p{color: #F8F9FA;}
</style>
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('admin_dashboard')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-xl-4">{{$common['heading_title']}}</h3>
        <!-- <div class="col-xl-8">
            <form action="" class="dash_filter">
                <div class="dropdown_filter">
                    <a href="#" class="click_to_down">Filter <img src="{{ asset('admin/assets/images/grey_arrow.png')}}" alt="" srcset=""></a>
                    <div class="slide_down_up" style="display: none;">
                        <div class="filter_row">
                            <label for="">Job title</label>
                            <input type="text" placeholder="Enter your job Title">
                        </div>
                        <div class="filter_row">
                            <label for="">Job no.</label>
                            <input type="text" placeholder="Enter your job no.">
                        </div>
                        <div class="filter_row">
                            <label for="">Location</label>
                            <input type="text" placeholder="Enter your work location">
                        </div>
                        <div class="filter_row">
                            <label for="">Skills</label>
                            <input type="text" placeholder="Enter your skills">
                        </div>
                        <div class="filter_row salary_fields">
                            <label for="">Salary / h</label>
                            <input type="text" placeholder="Enter from">
                            <input type="text" placeholder="Enter to">
                        </div>
                    </div>
                </div>
                <div class="dropdown_filter">
                    <a href="#" class="click_to_down">Sort <img src="{{ asset('admin/assets/images/grey_arrow.png')}}" alt="" srcset=""></a>
                    <div class="slide_down_up" style="display: none;">
                        <ul class="text-center" id="sortable">
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">Job title</a></li>
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">Date of posting</a></li>
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">Salary/h</a></li>
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">Start</a></li>
                        </ul>
                    </div>
                </div>
                <div class="filter_submit_btn"><input type="submit" value="" class="" /></div>
            </form>
        </div> -->
    </div>

    <div class="user_outer_main_dash">
      <div class="row">
        <div class="col-md-4">
            <a class="user_dish_box" href="{{Route('jobs_vacancies')}}">
               <p class="f20 fw_700 mb-0">{{__("admin.text_total_jobs")}}</p>
               <div class="d-flex align-items-center justify-content-between total_count_cls">
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{__("admin.text_total")}}</p>
                  </div>
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{$common['jobs_count']}}</p>
                  </div>
               </div>
            </a>
        </div>

        <div class="col-md-4">
            <a class="user_dish_box" href="{{Route('all_customers')}}">
               <p class="f20 fw_700 mb-0">{{__("admin.text_total_seekers")}}</p>
               <div class="d-flex align-items-center justify-content-between total_count_cls">
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{__("admin.text_total")}}</p>
                  </div>
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{$common['seeker_count']}}</p>
                  </div>
               </div>
            </a>
        </div>

        <div class="col-md-4">
            <a class="user_dish_box" href="{{Route('all_providers')}}">
               <p class="f20 fw_700 mb-0">{{__("admin.text_total_providers")}}</p>
               <div class="d-flex align-items-center justify-content-between total_count_cls">
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{__("admin.text_total")}}</p>
                  </div>
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{$common['provider_count']}}</p>
                  </div>
               </div>
            </a>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
            <a class="user_dish_box" href="{{Route('jobs_vacancies')}}">
               <p class="f20 fw_700 mb-0">{{__("admin.text_total_published_jobs")}}</p>
               <div class="d-flex align-items-center justify-content-between total_count_cls">
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{__("admin.text_total")}}</p>
                  </div>
                  <div class="">
                     <p class="f18 fw_400 mb-0">{{$common['contract_count']}}</p>
                  </div>
               </div>
            </a>
        </div>

      </div>
    </div>  
      
      

      <div class="tutorial_video_area">
         <div class="row">
           <!--  <div class="col-md-6">
               <h2>{{__("admin.text_tutorial_video")}}</h2>
               <iframe width="100%" height="315" src="https://www.youtube-nocookie.com/embed/UWk5vA--ANs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div> -->
         </div>
      </div>

    </div> 

</div>
@include('admin.layout.footer')