@include('front.layout.header')
@include('front.layout.sidebar')
<?php 
    $job_title           = "";
    $contract_no         = "";
    $location            = "";
    $tab                 = "";
    $month               = "";
    $year                = "";
    $offer_no            = "";
    $profession          = "";
    $salary_from         = "";

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
                                <div class="filter_row">
                                    <label for="">{{__("customer.text_job_title")}}</label>
                                    <input type="text" name="job_title"  value="<?php if(@$_GET['job_title']){ echo @$_GET['job_title'];}?>"  id="job_title" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_title")}}'>
                                </div>
                                <div class="filter_row">
                                    <label for="">{{__("customer.text_contract_no")}}</label>
                                    <input type="text" name="contract_no" value="<?php if(@$_GET['contract_no']){ echo $_GET['contract_no'];}?>"  id="contract_no" placeholder='{{__("customer.text_enter")}} {{__("customer.text_contract_no")}}'>
                                </div>
                                <div class="filter_row" >
                                    <label for="">{{__("customer.text_location")}}</label>
                                    <input type="text" name="location" value="<?php if(@$_GET['location']){ echo $_GET['location'];}?>"  id="location" placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}'>
                                </div>
                                <div class="filter_row">
                                    <label for="">{{__("customer.text_month")}}</label>
                                    <input type="text" name="month"  value="<?php if(@$_GET['month']){ echo $_GET['month'];}?>" id="month" placeholder='{{__("customer.text_enter")}} {{__("customer.text_month")}}'>
                                </div>
                                <div class="filter_row">
                                    <label for="">{{__("customer.text_years")}}</label>
                                    <input type="text" name="year"  value="<?php if(@$_GET['year']){ echo $_GET['year'];}?>" id="year" placeholder='{{__("customer.text_enter")}} {{__("customer.text_years")}}'>
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
                    <a class="nav-link"  href="{{Route('seeker.documents_contracts')}}">
                        <span class="tab_icon_a"><img src="{{ asset('assets/images/page_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt" >{{__("customer.text_contracts")}}
                         </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link"  href="{{Route('seeker.documents_salaries')}}">
                        <span class="tab_icon_a"><img src="{{ asset('assets/images/slary_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_salaries")}}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="report-tab" href="{{Route('seeker.documents_reports')}}">
                        <span class="tab_icon_a"><img src="{{ asset('assets/images/calen_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_reports")}}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="other-documents-tab" href="{{Route('seeker.documents_other_documents')}}">
                        <span class="tab_icon_a"><img src="{{ asset('assets/images/consign_bl.png') }}" alt="" srcset=""></span>
                        <span class="tab_title_txt">{{__("customer.text_other_doc")}}</span>
                    </a>
                </li>
            </ul>
            
            <div class="tab-content" id="myTabContent">
                    
                <!-- Reports -->
                <div class="tab-pane fade active show" id="salaries" role="tabpanel" aria-labelledby="salaries-tab">
                    
                    <div class="row menu-header">
                        <div class="col-md-10">
                            <p class="menu-title">{{__("customer.text_reports")}}</p>
                        </div>
                    </div>
                    @if(count($reports)>0)
                    <table class="table table-responsive">
                        <thead class="table-head">
                         <tr>
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
                            <?php if(count($reports)>0){ ?>
                            <?php foreach($reports as $key => $value){ ?>
                            <tr>
                              <td>{{$cnt}}</td>
                              <td>{{$value['contract']}}</td>
                              <td>{{$value['start_date']}}</td>
                              <td>{{$value['end_date']}}</td>
                              <td>{{$value['working_hours']}}</td>
                              <td class="text-right">
                                <?php 
                                    if($value['document'] !=""){
                                        $link = url('/Images/WorkDocuments',$value['document']);
                                    }else{
                                        $link = '';
                                    }
                                ?>
                                @if($link!='')
                                <a href="{{$link}}" target="_blank" class="btn look_btn">
                                    <i class="fas fa-eye"></i>{{__("customer.text_look")}}
                                </a>
                                <a href="{{$link}}" download class="btn download_btn" onClick="return doconfirm('{{__('customer.text_sure_to_download')}}')">
                                    <i class="fas fa-download"></i>{{__("customer.text_download")}}
                                </a>
                                @endif
                              </td>
                            </tr>
                            <?php $cnt++;} } ?>
                        </tbody>
                    </table>
                    @else
                        <div class="container-fluid bg-white text-center no_record">
                            <img src="{{asset('assets/images/no_record_face.png')}}">
                            <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
                        </div>  
                    @endif
                    <div class="my_pagination">
                        {{$get_reports->appends(request()->query())->links() }}
                    </div> 

                </div>

            </div>
        </div>

    </div>

@include('front.layout.footer')