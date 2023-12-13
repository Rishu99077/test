@include('front.layout.header')
@include('front.layout.sidebar')
<?php 
    $search_for_everthing   = "";
    $job_title              = "";
    $contract_no            = "";
    $location               = "";
    $worker                 = "";

    if(@$_GET['search_everything']){
        $search_for_everthing = @$_GET['search_everything'];
    }
?>

    <div class="main_right">
        <form action="" method="get">
        
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

            <div class="row top_bb mb_20 align-items-center justify-content-between">
                <h3 class="title col-xl-4 recom_title">{{$common['heading_title']}}</h3>
                <div class="col-xl-8">
                    <div class="dash_filter">
                        <div class="dropdown_filter">
                            <label>{{__("customer.text_filter_by")}}</label>
                            <a href="#" class="click_to_down">{{__("customer.text_filter")}}</a>
                            <div class="slide_down_up" style="display: none;">
                                <div class="filter_row" >
                                    <label for="">{{__("customer.text_job_title")}}</label>
                                    <input type="text" name="job_title"  value="<?php if(@$_GET['job_title']){ echo $_GET['job_title']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_title")}}'>
                                </div>
                                 <div class="filter_row">
                                    <label for="">{{__("customer.text_contract_no")}}</label>
                                    <input type="text" name="contract_no"  value="<?php if(@$_GET['contract_no']){ echo $_GET['contract_no']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_contract_no")}}'>
                                </div>
                                <div class="filter_row">
                                    <label for="">Location</label>
                                    <input type="text" name="location"  value="<?php if(@$_GET['location']){ echo $_GET['location']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_work_location")}}'>
                                </div>
                                <div class="filter_row">
                                    <label for="">Worker</label>
                                    <input type="text" name="worker"  value="<?php if(@$_GET['worker']){ echo $_GET['worker']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_worker")}}'>
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

        <div class="contact_tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="contact-form-tab"  href="{{Route('provider.documents_contracts')}}" aria-controls="contract-form" >
                        <span class="tab_icon_a">
                            <img src="{{ asset('assets/images/page_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_contracts")}}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="bills-tab"  href="{{Route('provider.documents_bills')}}" aria-controls="chat" >
                        <span class="tab_icon_a">
                            <img src="{{ asset('assets/images/bills_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_bills")}}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="payed-bills-tab"  href="{{Route('provider.documents_payed_bills')}}" aria-controls="send-sms" >
                        <span class="tab_icon_a">
                            <img src="{{ asset('assets/images/payed_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_payed_bills")}}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="other-documents-tab"  href="{{Route('provider.documents_other_documents')}}" aria-controls="send-sms" >
                        <span class="tab_icon_a">
                            <img src="{{ asset('assets/images/consign_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_other_doc")}}</span>
                    </a>
                </li>
                
            </ul>

            <div class="tab-content" id="myTabContent">

                <!-- Contracts -->
                <div class="tab-pane fade active show seeker_reports" id="contract-form" role="tabpanel" aria-labelledby="contract-form-tab">
                    @if($get_contracts)
                    <div class="job_card_wrapper_contract">
                     @foreach($get_contracts as $key => $value)
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
                                 <?php $full_title = $value['title']; ?>   
                                 <h5 class="heading_title"><?php echo (strlen($full_title) > 15) ? substr($full_title, 0, 15) . '...' : $full_title; ?> ({{$value['customer_name']}})</h5>
                                 <br>
                                 <p>{{__("customer.text_contract_no")}} {{$value['id']}}</p>
                                 <p class="text-pr"><img src="{{ asset('assets/images/j6.png') }}" alt=""> <?php echo date('d/m/Y',strtotime($value['start_date']))?></p>
                               
                                 <div class="jc_inbox_contract">
                                    <span class="jc_inbox1"></span> 
                                    <a href="{{Route('seeker.contract_details')}}?id={{$value['job_id']}}" class="jc_inbox2 f_bold clr_prpl f12 btn add_btn">
                                    <span>{{__("customer.text_view_details")}}</span>
                                    </a>
                                    <!-- <?php if($value['document'] !=""){
                                              $link = url('/Images/WorkDocuments',$value['document']); ?>
                                        <a href="{{$link}}" download onClick="return doconfirm('{{__('customer.text_sure_to_download')}}')" class="jc_inbox2 f_bold clr_prpl f12 btn add_btn download_button">
                                             <span>{{__("customer.text_download")}} </span>
                                        </a>
                                    <?php } ?> -->
                                    <a href="{{Route('generate_pdf',['id'=>$value['id']])}}"  class="jc_inbox2 f_bold clr_prpl f12 btn add_btn download_button"><span> Download </span>
                                    </a>
                                 </div>
                            </div>


                         </div>
                         @endforeach

                    </div>
                    <div class="my_pagination">
                            {{$get_contracts_details->appends(request()->query())->links() }}
                    </div> 
                        @else
                            <div class="container-fluid bg-white text-center no_record">
                                <img src="{{asset('assets/images/no_record_face.png')}}">
                                <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
                            </div>
                        @endif
                </div>

            </div>
        </div>

    </div>

@include('front.layout.footer')