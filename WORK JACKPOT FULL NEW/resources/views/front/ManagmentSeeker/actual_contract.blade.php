@include('front.layout.header')
@include('front.layout.sidebar')
<?php
   $contract_no         = "";
   $month               = "";
   $year                = "";
   $offer_no            = "";
   $profession          = "";
   $location            = "";
   $salary_from         = "";
   $job_title           = "";
  
   $search_for_everthing = "";
   if(@$_GET['search_everything']){
       $search_for_everthing = @$_GET['search_everything'];
   }
   
   ?>
<div class="main_right">
   <form action="" method="get">
      <div class="top_announce d-flex align-items-center justify-content-between mb_20">
         <div class="top_ann_left">
            <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
         </div>
         <div class="top_ann_right d-flex align-items-center topan_search  justify-content-xl-end ">
            <input type="text" name="search_everything" id="" value="<?php if(@$_GET['search_everything']){ echo @$_GET['search_everything'];}?>" placeholder='{{__("customer.text_search_for_everything")}}'>
            <input type="submit" value="">
         </div>
      </div>
      <div class="row top_bb mb_20 align-items-center justify-content-between">
         <h3 class="title col-xl-4 recom_title">{{$common['heading_title']}}</h3>
         <div class="col-xl-8">
            <div  class="dash_filter">
               <div class="dropdown_filter">
                  <label>{{__("customer.text_filter_by")}}</label>
                  <a href="#" class="click_to_down">{{__("customer.text_filter_by")}}</a>
                  <div class="slide_down_up" style="display: none;">
                     <div class="filter_row" >
                        <label for="">{{__("customer.text_job_offer_no")}}</label>
                        <input type="text" name="offer_no" id="offer_no"  value="<?php if(@$_GET['offer_no']){ echo @$_GET['offer_no'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_offer_no")}}'>
                     </div>
                     <div class="filter_row ">
                        <label for="">{{__("customer.text_profession")}}</label>
                        <input type="text" name="profession" id="profession" value="<?php if(@$_GET['profession']){ echo @$_GET['profession'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession")}}'>
                     </div>
                     <div class="filter_row" >
                        <label for="">{{__("customer.text_location")}}</label>
                        <input type="text" name="location" id="location"  value="<?php if(@$_GET['location']){ echo @$_GET['location'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}'>
                     </div>
                     <div class="filter_row salary_fields" >
                        <label for="">{{__("customer.text_salary")}} / h</label>
                        <input type="text" id="salary_from" value="<?php if(@$_GET['salary_from']){ echo @$_GET['salary_from'];}?>"  name="salary_from" placeholder='{{__("customer.text_enter")}} {{__("customer.text_from")}}'>
                        <input type="text" id="salary_to"  value="<?php if(@$_GET['salary_to']){ echo @$_GET['salary_to'];}?>" name="salary_to" placeholder='{{__("customer.text_enter")}} {{__("customer.text_to")}}'>
                     </div>
                  </div>
               </div>
               <div class="dropdown_filter">
                  <label>{{__("customer.text_sort_by")}}</label>
                  <select name="sort"> 
                  <option value="date" {{@$_GET['sort'] =="date"?"selected":""}}>{{__("customer.text_date")}}</option>
                  <option value="name" {{@$_GET['sort'] =="name"?"selected":""}}>{{__("customer.text_name")}}</option>
                  <option value="start" {{@$_GET['sort'] =="start"?"selected":""}}>{{__("customer.text_start")}}</option>
                  </select>
               </div>
               <div class="filter_submit_btn"><input type="submit" value="" class="" /></div>
            </div>
         </div>
      </div>
   </form>
   <div class="contact_tabs">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-form-tab"  href="{{Route('seeker.reports')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/calen_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_reports")}}
            </span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="advertisement-tab" href="{{Route('seeker.advertisment')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/Ads_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_my_advt")}}</span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="contract-to-sign-tab" href="{{Route('seeker.contract_to_sign')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/consign_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_contract_to_sign")}}</span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link active" id="actual-contract-tab"  href="{{Route('seeker.actual_contract')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/con_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_actual_report")}}</span>
            </a>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">

        <!-- Actual Contract -->
        <div class="tab-pane fade active show" id="actual-contract" role="tabpanel" aria-labelledby="actual-contract-tab">
            <div class="job_card_wrapper_contract">
               <?php if (!empty($contracts)) { 
                  foreach ($contracts as $key => $value) { ?>
               <div class="job_card_contract">
                  <div class="jcard_top_contract align-items-center justify-content-between">
                     <div class="jc_left_s align-items-center justify-content-between">
                        <div class="jc_left_l_contract">
                           <span><img src="{{ asset('assets/images/Group_page.png') }}" alt=""></span>
                        </div>
                     </div>
                     <div class="jc_right text-end">
                     </div>
                  </div>
                  <div class="jcard_center_self">
                     <?php $fulltitle = $value['title']; ?> 
                     <h5 class="heading_title"><?php echo (strlen($fulltitle) > 25) ? substr($fulltitle, 0, 25) . '...' : $fulltitle; ?></h5>
                     <br>
                     <p>{{__("customer.text_contract_no")}} {{$value['id']}}</p>
                     <p class="text-pr"><img src="{{ asset('assets/images/j6.png') }}" alt=""> <?php echo date('d/m/Y',strtotime($value['start_date']))?></p>
                   
                     <div class="jc_inbox_contract">
                        <span class="jc_inbox1"></span> 
                        <a href="{{Route('seeker.contract_details')}}?id={{$value['job_id']}}" class="jc_inbox2 f_bold clr_prpl f12 btn add_btn">
                        <span>{{__("customer.text_view_details")}} </span>
                        </a>
                        <?php if($value['document'] !=""){
                           $link = url('/Images/WorkDocuments',$value['document']); ?>
                           <a href="{{$link}}" download onClick="return doconfirm('{{__('customer.text_sure_to_download')}}')" class="jc_inbox2 f_bold clr_prpl f12 btn download_button">
                                <span>{{__("customer.text_download")}} </span>
                           </a>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php }  } ?>
            </div>
            <div class="my_pagination">
               {{$get_contracts->appends(request()->query())->links() }}
            </div>
            <?php if (empty($contracts)) { ?>
            <div class="container-fluid bg-white text-center no_record">
               <img src="{{asset('assets/images/no_record_face.png')}}">
               <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
            </div>
            <?php } ?>
        </div>

      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).on('click','#checkall',function(){
       $('.download_all').toggle(); 
       if($(this).is(':checked')){
           $('.check_box').attr('checked', true);
       }else{
           $('.check_box').attr('checked', false);
       }
   });
   
   
</script>
@include('front.layout.footer')