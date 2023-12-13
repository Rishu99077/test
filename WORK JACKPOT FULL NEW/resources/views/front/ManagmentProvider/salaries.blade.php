@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
.contact_tabs .nav-tabs a.nav-link {min-height: 67px!important;}
</style>
<?php 
    $name                 = "";
    $month                = "";
    $year                 = "";
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
                     <!-- <img src="{{ asset('assets/images/grey_arrow.png') }}" alt="" srcset=""> -->
                    </a>
                    <div class="slide_down_up" style="display: none;">
                        <div class="filter_row" >
                            <label for="">{{__("customer.text_name")}}</label>
                            <input type="text" id="name"  name="name" value="<?php if(@$_GET['name']){ echo @$_GET['name']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_name")}}'>
                            
                        </div>
                        <div class="filter_row">
                            <label for="">{{__("customer.text_month")}}</label>
                            <input type="text" id="month"  name="month" value="<?php if(@$_GET['month']){ echo @$_GET['month']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_month")}}'>
                        </div>
                         <div class="filter_row">
                            <label for="">{{__("customer.text_years")}}</label>
                            <input type="text" id="year" name="year" placeholder='{{__("customer.text_enter")}} {{__("customer.text_years")}}' value="<?php if(@$_GET['year']){ echo @$_GET['year']; }?>">
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
                <a class="nav-link" id="report-form-tab"  href="{{Route('provider.reports')}}">
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
                <a class="nav-link active" id="salaries-tab"  href="{{Route('provider.salaries')}}">
                    <span class="tab_icon_a"><img src="{{ asset('assets/images/slary_bl.png') }}" alt="" srcset=""></span>
                    <span class="tab_title_txt">{{__("customer.text_salaries")}}</span>
                </a>
            </li>
            
        </ul>

        <div class="tab-content" id="myTabContent">

            <!-- Salaries -->
            <div class="tab-pane fade active show" id="salaries" role="tabpanel" aria-labelledby="salaries-tab">
                
                <div class="row menu-header">
                    <div class="col-md-10">
                        <p class="menu-title">{{__("customer.text_salaries")}}</p>
                    </div>
                </div>
                <table class="table table-responsive">
                    <thead class="table-head">
                     <tr>
                        <th>{{__("customer.text_serial_no")}}</th>
                        <th>{{__("customer.text_name")}}</th>
                        <th>{{__("customer.text_contract_no")}}</th>
                        <th>{{__("customer.text_start_date")}}</th>
                        <th>{{__("customer.text_end_date")}}</th>
                        <th class="text-center">{{__("customer.text_action")}}</th>
                     </tr>
                    </thead>
                    <tbody>
                       @if(count($get_reports)>0)
                          @foreach($get_reports as $key =>$value)
                            <tr>
                              <td>{{$key+1}}</td>
                              <td>{{$value['seeker_name']}}</td>
                              <td>{{$value['contract_id']}}</td>
                              <td>{{$value['start_date']}}</td>
                              <td>{{$value['end_date']}}</td>
                              <td class="text-center">
                                <a href="{{url('/Images/WorkDocuments',$value['document'])}}" target="_blank">
                                    <button class="btn look_btn"><i class="fas fa-eye"></i> {{__("customer.text_look")}}</button>
                                </a>
                                <a href="{{Route('provider.billing_info', ['id'=>$value['report_id'] ])}}">
                                    <button class="btn pay_btn"><span class="text-center">{{__("customer.text_pay_now")}}</span></button>
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

                           
                <div class="my_pagination">
                </div> 

            </div>
           
        </div>
    </div>
</div>

<script type="text/javascript">
    $('body').on("click",'#send_pending', function(){
     
        job=confirm('{{__("customer.text_sure")}}');
        if(job!=true){
          return false;
        }

        var ContractId = $(this).attr('data-id');
        var JobId = $(this).attr('job-id');
        var Datastatus = $(this).attr('data-status');
        
        _token = $("input[name='_token']").val();
        // alert(_token);
        // return false;

        $.ajax({
            url:"{{ url('change_job_status') }}",
            type: 'post',
            data: {'ContractId': ContractId,'JobId': JobId,'_token':_token,'Datastatus':Datastatus},
            success: function(response) {  
             window.location.href = "{{url('job')}}";
            }
        });
  
    });
</script>
@include('front.layout.footer')