@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">
   <form action="" method="get">
      <div class="top_announce d-flex align-items-center justify-content-between mb_20">
         <div class="top_ann_left">
            <a href="#" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
         </div>
         <div class="top_ann_right d-flex align-items-center topan_search  justify-content-xl-end ">
            
         </div>
      </div>
      <div class="row top_bb mb_20 align-items-center justify-content-between">
         <h3 class="title col-xl-7 recom_title">{{$common['heading_title']}}</h3>
         <div class="col-xl-5">
            <div  class="dash_filter row">
               <div class="dropdown_filter col-md-5">
                  <label>{{__("admin.text_filter_by")}}</label>
                  <a href="#" class="click_to_down">{{__("admin.text_filter_by")}}</a>
                  <div class="slide_down_up" style="display: none;">
                     <div class="filter_row">
                        <label for="">{{__("admin.text_job")}}</label>
                        <input type="text" name="profession" id="profession" value="<?php if(@$_GET['profession']){ echo @$_GET['profession'];}?>" placeholder='{{__("admin.text_enter")}} {{__("admin.text_job")}}'>
                     </div>
                     <div class="filter_row">
                        <label for="">{{__("admin.text_contract_no")}}</label>
                        <input type="text" name="offer_no" id="offer_no"  value="<?php if(@$_GET['offer_no']){ echo @$_GET['offer_no'];}?>" placeholder='{{__("admin.text_enter")}} {{__("admin.text_contract_no")}}'>
                     </div>
                  </div>
               </div>
               <div class="dropdown_filter col-md-5">
                  <label>{{__("admin.text_sort_by")}}</label>
                  <select name="sort" class="form-control"> 
                     <option value="date" {{@$_GET['sort'] =="date"?"selected":""}}>{{__("admin.text_date")}}</option>
                     <option value="name" {{@$_GET['sort'] =="name"?"selected":""}}>{{__("admin.text_name")}}</option>
                  </select>
               </div>
               <div class="filter_submit_btn col-md-2"><input type="submit" value="" class="" /></div>
            </div>
         </div>
      </div>  
   </form>
   <div class="contact_tabs">
      
      <div class="tab-content" id="myTabContent">

        <!-- Actual Contract -->
        <div class="tab-pane fade active show" id="actual-contract" role="tabpanel" aria-labelledby="actual-contract-tab">
            <div class="job_card_wrapper_contract">
               <?php if (!empty($documents)) { 
                  foreach ($documents as $key => $value) { ?>
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
                        <h5 class="heading_title"><?php echo (strlen($fulltitle) > 15) ? substr($fulltitle, 0, 15) . '...' : $fulltitle; ?> ({{$value['seekername']}}) </h5>
                        <br>
                        <p>{{__("admin.text_contract_no")}} {{$value['contract_id']}}</p>
                        <p class="text-pr"><img src="{{ asset('assets/images/j6.png') }}" alt=""> <?php echo date('d/m/Y',strtotime($value['date']))?></p>
                      
                        <div class="jc_inbox_contract">
                           <span class="jc_inbox1"></span> 
                           <a href="{{Route('otherdocument_detail', ['id'=>$value['id'] ])}}" class="jc_inbox2 f_bold clr_prpl f12 btn add_btn">
                              <span>{{__("admin.text_view_details")}} </span>
                           </a>
                           <?php if($value['document'] !=""){
                              $link = url('/Images/otherdocuments',$value['document']); ?>
                              <a href="{{$link}}" download onClick="return doconfirm('{{__('admin.text_sure_to_download')}}')" class="jc_inbox2 f_bold clr_prpl f12 btn download_button">
                                   <span>{{__("admin.text_download")}} </span>
                              </a>
                           <?php } ?>
                        </div>
                     </div>
                  </div>  
               <?php }  } ?>
               
            </div>
            <div class="my_pagination">
               {{$get_other_document->appends(request()->query())->links() }}
            </div>
            <?php if (empty($documents)) { ?>
            <div class="container-fluid bg-white text-center">
               <img src="{{asset('assets/images/No Record.png')}}">
            </div>
            <?php } ?>
        </div>

      </div>
   </div>
</div>
@include('admin.layout.footer')