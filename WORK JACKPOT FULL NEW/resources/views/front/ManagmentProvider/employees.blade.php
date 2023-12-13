@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
.contact_tabs .nav-tabs a.nav-link {min-height: 67px!important;}
</style>
<?php 
    $name                 = "";
    $proffesion           = "";
    $job_no               = "";
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
                     <!-- <img src="{{ asset('assets/images/grey_arrow.png') }}" alt="" srcset=""> -->
                    </a>
                    <div class="slide_down_up" style="display: none;">
                        <div class="filter_row" >
                            <label for="">{{__("customer.text_name")}}</label>
                            <input type="text" id="name"  name="name" value="<?php if(@$_GET['name']){ echo @$_GET['name']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_name")}}'>
                        </div>
                        <div class="filter_row">
                            <label for="">{{__("customer.text_job_no")}}</label>
                            <input type="text" id="job_no" name="job_no"  value="<?php if(@$_GET['job_no']){ echo @$_GET['job_no']; }?>" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_no")}}'>
                        </div>

                        <div class="filter_row">
                            <label for="">{{__("customer.text_profession")}}</label>
                            <input type="text" id="profession" name="profession"  value="<?php if(@$_GET['profession']){ echo @$_GET['profession']; }?>"placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession")}}'>
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
                <a class="nav-link active" id="employees-tab"  href="{{Route('provider.employees')}}">
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

            <!-- Employees -->
            <div class="tab-pane fade active show" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                <?php if(!empty($get_employees)){ ?>
                     <div class="job_card_wrapper candidates">
                            <?php foreach ($get_employees as $key => $value2) { ?>
                            
                                <div class="job_card">

                                    <div class="jcard_top d-flex align-items-center justify-content-between">
                                        <div class="jc_left d-flex align-items-center justify-content-between">
                                            <div class="jc_left_l">
                                                <span>
                                                    @if($value2['profile_image'] !="")
                                                        <img src="{{ url('profile',$value2['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                                                    @else
                                                        <img src="{{ asset('assets/images/bo.png') }}" alt="" class="img_preview" id="img_preview">
                                                    @endif
                                                </span>
                                            </div>
                                            <?php 
                                                $fullname2 = $value2['firstname']." ".$value2['surname'];
                                                $fulltitle = $value2['job_title'];
                                            ?>
                                            <div class="jc_left_r">
                                                <p class="mb0 f16 clr_prpl f_black"><?php echo (strlen($fullname2) > 15) ? substr($fullname2, 0, 15) . '...' : $fullname2; ?>(<?php echo (strlen($fulltitle) > 15) ? substr($fulltitle, 0, 15) . '...' : $fulltitle; ?>)</p>
                                                <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_job_no")}} {{$value2['job_id']}}<span class="clr_ylw"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="jc_right text-end">
                                            
                                        </div>
                                    </div>

                                    <div class="jcard_center">

                                        <div class="jc_inbox" title="Experience">
                                            <span class="jc_inbox1">
                                                <img src="{{ asset('assets/images/j1.png') }}" alt="">
                                            </span> 
                                            @if(@$value2['working_year'])
                                                <span class="jc_inbox2 f_bold clr_prpl f12" title="Experience">{{@$value2['working_year']}}</span>
                                            @else
                                                <span class="jc_inbox2 f_bold clr_prpl f12" title="Experience">-</span>
                                            @endif
                                        </div>

                                        <div class="jc_inbox">
                                            <span class="jc_inbox1">
                                                <img src="{{ asset('assets/images/j2.png') }}" alt="">
                                            </span> 
                                            <span class="jc_inbox2 f_bold clr_prpl f12" title="Working hours">{{@$value2['working_hour']}} </span>
                                        </div>

                                        <div class="jc_inbox">
                                            <span class="jc_inbox1">
                                                <img src="{{ asset('assets/images/j3.png') }}" alt="">
                                            </span> 
                                            <span class="jc_inbox2 f_bold clr_prpl f12" title="Driving Licence">{{__("customer.text_driving_license")}}</span>
                                        </div>

                                        <div class="jc_inbox">
                                            <span class="jc_inbox1">
                                                <img src="{{ asset('assets/images/j4.png') }}" alt="">
                                            </span> 
                                            @if($value2['own_car']=='1') 
                                            <span class="jc_inbox2 f_bold clr_prpl f12">{{__("customer.text_own_car")}}</span>
                                            @elseif($value2['own_car']=='0')
                                            <span class="jc_inbox2 f_bold clr_prpl f12">-</span>
                                            @endif
                                        </div>

                                        <div class="jc_inbox">
                                            <span class="jc_inbox1">
                                                <img src="{{ asset('assets/images/j5.png') }}" alt="">
                                            </span> 
                                            <span class="jc_inbox2 f_bold clr_prpl f12" title="Location">{{$value2['work_location']}}</span>
                                        </div>

                                        <div class="jc_inbox">
                                            <span class="jc_inbox1">
                                                <img src="{{ asset('assets/images/j6.png') }}" alt="">
                                            </span> 
                                            <span class="jc_inbox2 f_bold clr_prpl f12" title="Start Date">{{@$value2['date']}}</span>
                                        </div>

                                    </div>

                                    <div class="jc_footer">
                                        <a href="{{Route('seeker_profile')}}?ID={{$value2['id']}}" class="">{{__("customer.text_view_profile")}} </a>
                                    </div>

                                </div>

                            <?php }  ?>
                    </div>
                <?php }else{?>
                    <div class="container-fluid bg-white text-center no_record">
                        <img src="{{asset('assets/images/no_record_face.png')}}">
                        <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
                    </div>
                <?php 
                }
                ?>
            </div>
            
            @if(count($get_employees)>0)
            <div class="my_pagination">
                {{$Employees->appends(request()->query())->links() }}
            </div> 
            @endif
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