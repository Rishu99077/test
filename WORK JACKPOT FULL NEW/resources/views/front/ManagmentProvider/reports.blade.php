@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
    .contact_tabs .nav-tabs a.nav-link {min-height: 67px!important;}
</style>
<?php 
    $name                 = "";
    $location             = "";
    $search_for_everthing = "";
    if(@$_GET['search_everything']){
        $search_for_everthing = @$_GET['search_everything'];
    }
?>
<div class="main_right">
    <form action="" method="get">
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
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
                    <a href="#" class="click_to_down">{{__("customer.text_filter")}}
                    </a>
                    <div class="slide_down_up" style="display: none;">
                        <div class="filter_row" >
                            <label for="">{{__("customer.text_name")}}</label>
                            <input type="text" id="name"  name="name" value="<?php if(@$_GET['name']){ echo @$_GET['name']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_name")}}'>
                            
                        </div>
                        <div class="filter_row">
                            <label for="">{{__("customer.text_location")}}</label>
                            <input type="text" id="location" name="location" value="<?php if(@$_GET['location']){ echo @$_GET['location']; }?>"placeholder='{{__("customer.text_enter")}} {{__("customer.text_location")}}'>
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
                <a class="nav-link active" id="report-form-tab"  href="{{Route('provider.reports')}}">
                    <span class="tab_icon_a"><img src="{{ asset('assets/images/calen_bl.png') }}" alt="" srcset=""></span>
                    <span class="tab_title_txt">{{__("customer.text_reports")}}
                     </span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="applicant-tab"  href="{{Route('provider.applicants')}}">
                    <span class="tab_icon_a"><img src="{{ asset('assets/images/applic_bl.png') }}" alt="" srcset=""></span>
                    <span class="tab_title_txt">{{__("customer.text_applicants")}}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="employees-tab"  href="{{Route('provider.employees')}}">
                    <span class="tab_icon_a"><img src="{{ asset('assets/images/emplye_bl.png') }}" alt="" srcset=""></span>
                    <span class="tab_title_txt">{{__("customer.text_employees")}}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="salaries-tab"  href="{{Route('provider.salaries')}}">
                    <span class="tab_icon_a"><img src="{{ asset('assets/images/slary_bl.png') }}" alt="" srcset=""></span>
                    <span class="tab_title_txt">{{__("customer.text_salaries")}}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <!-- Reports -->
            <div class="tab-pane fade active show" id="report-form" role="tabpanel" aria-labelledby="report-form-tab">
                 
                <div class="row menu-header">
                    <div class="col-md-10">
                        <p class="menu-title">{{__("customer.text_reports")}}</p>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{Route('download_report_provider')}}" class="btn download_all" style="display: none;">{{__("customer.text_download_all")}}</a>
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
                        <th>{{__("customer.text_name")}}</th>
                        <th>{{__("customer.text_job_title")}}</th>
                        <th>{{__("customer.text_start_date")}}</th>
                        <th>{{__("customer.text_end_date")}}</th>
                        <th class="text-center">{{__("customer.text_action")}}</th>
                     </tr>
                    </thead>
                    <tbody>
                        @if(count($get_reports)>0)
                          @foreach($get_reports as $key =>$value)
                            <tr>
                                <td>
                                   <div class="form-check  form-check-inline" style="display: inline-flex;">
                                      <input class="form-check-input check_box select_all" type="checkbox" id="send_{{$key+1}}" name="report_id[]" value="{{$value['report_id']}}">
                                      <label class="form-check-label" for="send_{{$key+1}}" ></label>
                                   </div>
                                </td>  
                                <td>{{$key+1}}</td>
                                <td><?php echo (strlen($value['seeker_name']) > 25) ? substr($value['seeker_name'], 0, 25) . '...' : $value['seeker_name']; ?></td>
                                <td><?php echo (strlen($value['job_title']) > 25) ? substr($value['job_title'], 0, 25) . '...' : $value['job_title']; ?></td>
                                <td>{{$value['start_date']}}</td>
                                <td>{{$value['end_date']}}</td>
                                <td class="text-center">
                                    <!-- <a href="{{url('/Images/WorkDocuments',$value['document'])}}" target="_blank">
                                        <button class="btn look_btn"><i class="fas fa-eye"></i> {{__("customer.text_look")}}</button>
                                    </a> -->
                                    <a href="{{Route('provider.generate_report', ['id'=>$value['report_id'] ])}}" >
                                        <button class="btn look_btn"><i class="fas fa-eye"></i> {{__("customer.text_look")}}</button>
                                    </a>
                                    <a href="{{url('/Images/WorkDocuments',$value['document'])}}"  download onClick="return confirm('{{__('customer.text_sure_to_download')}}');">
                                        <button class="btn download_btn"><i class="fas fa-download"></i> {{__("customer.text_download")}}</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="10" class="text-center">
                                {{__("customer.text_no_record")}}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if(count($get_reports)>0)
                <div class="my_pagination">
                    {{$get_reports_det->appends(request()->query())->links() }}
                </div> 
                @endif
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