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
                     <!-- //Report -->
                     <div class="filter_row ">
                        <label for="">{{__("customer.text_contract_no")}}</label>
                        <input type="text" name="contract_no" id="contract_no"  value="<?php if(@$_GET['contract_no']){ echo @$_GET['contract_no'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_contract_no")}}'>
                     </div>
                     <div class="filter_row " >
                        <label for="">{{__("customer.text_month")}}</label>
                        <input type="text" name="month" id="month" value="<?php if(@$_GET['month']){ echo @$_GET['month'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_month")}}'>
                     </div>
                     <div class="filter_row ">
                        <label for="">{{__("customer.text_years")}}</label>
                        <input type="text" name="year" id="year" value="<?php if(@$_GET['year']){ echo @$_GET['year'];}?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_years")}}'>
                     </div>
                     <!-- //Report -->
                  </div>
               </div>
               <div class="dropdown_filter">
                  <label>{{__("customer.text_sort_by")}}</label>
                  <select name="sort" class="form-control"> 
                  <option value="date" {{@$_GET['sort'] =="date"?"selected":""}}>{{__("customer.text_date")}}</option>
                  <option value="contract" {{@$_GET['sort'] =="contract"?"selected":""}}>{{__("customer.text_contract_no")}}</option>
                  <!-- Client want this changes 25-09-2022 -->
                  <!-- <option value="name" {{@$_GET['sort'] =="name"?"selected":""}}>{{__("customer.text_name")}}</option> -->
                  <!-- <option value="start" {{@$_GET['sort'] =="start"?"selected":""}}>{{__("customer.text_start")}}</option> -->
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
            <a class="nav-link active" id="contact-form-tab"  href="{{Route('seeker.reports')}}">
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
            <a class="nav-link" id="actual-contract-tab"  href="{{Route('seeker.actual_contract')}}">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/con_bl.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_actual_report")}}</span>
            </a>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">

         <!-- Reports -->
        <div class="tab-pane fade show active seeker_reports" id="report-form" role="tabpanel" aria-labelledby="contact-form-tab">
            <form action="{{Route('send_report')}}" method="post">
               @csrf
               <div class="row menu-header">
                  <div class="col-md-6">
                     <p class="menu-title">{{__("customer.text_reports")}}</p>
                  </div>
                  <div class="col-md-2" >
                      <a href="{{Route('download_report')}}" class="btn download_all" style="display: none;">{{__("customer.text_download_all")}}</a>
                  </div>
                  <div class="col-md-2  text-end">
                     <button type="submit" class="btn upload_btn">Send</button>
                  </div>
                  <div class="col-md-2  text-end">
                     <a href="{{Route('report_add')}}" class="btn upload_btn"> {{__("customer.text_upload")}} </a>
                  </div>
               </div>
               <table class="table table-responsive">
                  <thead class="table-head">
                     <tr>
                        <th>
                           <div class="form-check form-check-inline" style="display: flex;">
                              <input class="form-check-input" type="checkbox" id="checkall">
                              <label class="form-check-label mt-1"  for="checkall">{{__("customer.text_select_all")}}</label>
                           </div>
                        </th>
                        <th>{{__("customer.text_serial_no")}}</th>
                        <th>{{__("customer.text_contract_no")}}</th>
                        <th>{{__("customer.text_start_date")}}</th>
                        <th>{{__("customer.text_end_date")}}</th>
                        <th>{{__("customer.text_working_hours")}}</th>
                        <th class="text-center">{{__("customer.text_action")}}</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $cnt = ($get_reports->perPage() * ($get_reports->currentPage() - 1)) + 1; ?> 
                     <?php if (!empty($reports)) { 
                        foreach ($reports as $key => $value) { ?>
                     <tr>
                        <td>
                           @if($value['send_provider'] != 1 and $value['send_admin'] != 1) 
                           <div class="form-check  form-check-inline" style="display: inline-flex;">
                              <input class="form-check-input check_box select_all" type="checkbox" id="send_{{$cnt}}" name="report_id[]" value="{{$value['id']}}">
                              <label class="form-check-label" for="send_{{$cnt}}" ></label>
                           </div>
                           @endif
                        </td>
                        <td>{{$cnt}}</td>
                        <td>{{$value['contract']}}</td>
                        <td>{{date("d.m.y", strtotime($value['start_date']))}} </td>
                        <td>{{date("d.m.y", strtotime($value['end_date']) );}}</td>
                        <td>{{$value['working_hours']}}</td>
                        
                        <td class="text-end">

                           <a href="{{Route('generate_report_pdf')}}" target="_blank" class="btn look_btn">
                              <i class="fas fa-eye"></i>{{__("customer.text_look")}}</a>

                         <!--   <a href="{{Route('generate_excel')}}" target="_blank" class="btn look_btn">
                              <i class="fas fa-eye"></i>Generate xlsx</a>    -->

                           <!-- <?php if($value['document'] !=""){
                                  $link = url('/Images/WorkDocuments',$value['document']); ?>
                                 <a href="{{$link}}" target="_blank" class="btn look_btn">
                                    <i class="fas fa-eye"></i>{{__("customer.text_look")}}
                                    </a>
                                    <a href="{{$link}}" download class="btn download_btn" onClick="return doconfirm('{{__('customer.text_sure_to_download')}}')">
                                    <i class="fas fa-download"></i>{{__("customer.text_download")}}
                                 </a>
                           <?php   } ?> -->

                        </td>
                     </tr>
                     <?php $cnt++; } }else{ ?>
                     <tr>
                        <td colspan="10 " class="text-center">{{__("customer.text_no_record")}}</td>
                     </tr>
                     <?php } ?> 
                  </tbody>
               </table>
               <div class="my_pagination">
                  {{$get_reports->appends(request()->query())->links() }}
               </div>
            </form>
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