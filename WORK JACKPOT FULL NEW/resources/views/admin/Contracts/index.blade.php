@include('admin.layout.header')
@include('admin.layout.sidebar')
<style type="text/css">
    .jcard_center_self .text-pr{margin-top: -60px !important;}
</style>
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('admin_dashboard')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

    <!-- <h1 class="post_title mb_30">Marketing Clients</h1> -->
    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-xl-4 recom_title">{{$common['heading_title']}}</h3>
        <div class="col-xl-8">
            <form action="" class="dash_filter">
                <div class="dropdown_filter">
                    <a href="#" class="click_to_down">{{__("admin.text_filter")}} <img src="{{ asset('admin/assets/images/grey_arrow.png') }}" alt="" srcset=""></a>
                    <div class="slide_down_up" style="display: none;">
                        <div class="filter_row">
                            <label for="">{{__("admin.text_job_title")}}</label>
                            <input type="text" placeholder='{{__("admin.text_job_title")}}'>
                        </div>
                        <div class="filter_row">
                            <label for="">{{__("admin.text_job_no")}}</label>
                            <input type="text" placeholder='{{__("admin.text_job_no")}}'>
                        </div>
                        <div class="filter_row">
                            <label for="">{{__("admin.text_location")}}</label>
                            <input type="text" placeholder='{{__("admin.text_location")}}'>
                        </div>
                        <div class="filter_row">
                            <label for="">{{__("admin.text_skills")}}</label>
                            <input type="text" placeholder='{{__("admin.text_skills")}}'>
                        </div>
                        <div class="filter_row salary_fields">
                            <label for="">{{__("admin.text_salary_h")}}</label>
                            <input type="text" placeholder='{{__("admin.text_from")}}'>
                            <input type="text" placeholder='{{__("admin.text_to")}}'>
                        </div>
                    </div>
                </div>
                <div class="dropdown_filter">
                    <a href="#" class="click_to_down">{{__("admin.text_sort")}} <img src="{{ asset('admin/assets/images/grey_arrow.png') }}" alt="" srcset=""></a>
                    <div class="slide_down_up" style="display: none;">
                        <ul class="text-center" id="sortable">
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">{{__("admin.text_job_title")}}</a></li>
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">{{__("admin.text_date_of_posting")}}</a></li>
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">{{__("admin.text_salary_h")}}</a></li>
                            <li class="ui-state-default"><a href="#" class="clr_purpule f_14 f_bold">{{__("admin.text_start")}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="filter_submit_btn"><input type="submit" value="" class="" /></div>
            </form>
        </div>
    </div>

    <div class="job_card_wrapper_contract">
        <?php foreach ($contracts as $key => $value) { ?>
            <div class="job_card_contract">

                <div class="jcard_top_contract align-items-center justify-content-between">
                    <div class="jc_left_s d-flex align-items-center justify-content-between">
                        <div class="jc_left_l_contract">
                            <span><img src="{{ asset('admin/assets/images/Group_page.png') }}" alt=""></span>
                        </div>
                    </div>
                    <div class="jc_right text-end">
                        
                    </div>
                </div>

                <div class="jcard_center_self">
                    <?php  $fulltitle = $value['title']; ?>
                    <h5 class="heading_title"><?php echo (strlen($fulltitle) > 13) ? substr($fulltitle, 0, 13) . '...' : $fulltitle; ?> ({{$value['customer_name']}})</h5>
                    <br>
                    <p>{{__("admin.text_contract_no")}} {{$value['id']}}</p>
                    <br>
                    <p class="text-pr"><img src="{{ asset('assets/images/j6.png') }}" alt=""> {{$value['start_date']}}</p>

                   

                    <div class="jc_inbox_contract">
                        <span class="jc_inbox1"></span> 
                        <a href="{{Route('contract_view')}}?id={{$value['id']}}" class="jc_inbox2 f_bold clr_prpl f12 btn add_btn">
                        <span>{{__("admin.text_view_details")}}</span>
                        </a>
                        <?php 
                              if($value['id'] !=""){
                                  $link = url('/Images/WorkDocuments',$value['id']);
                              }else{
                                  $link = "javascript:void(0);";
                              }
                        ?>
                        <a href="{{$link}}" download onClick="return doconfirm('{{__('admin.text_sure_to_download')}}')" class="jc_inbox2 f_bold clr_prpl f12 btn add_btn download_button">
                             <span>{{__("admin.text_download")}} </span>
                        </a>
                    </div>

                </div>

            </div>
        <?php } ?>

    </div>

    <!-- *pagination -->
    <div class="my_pagination">
        {{$Contracts->appends(request()->query())->links() }}
    </div> 
    <!-- *pagination -->

</div>
@include('admin.layout.footer')