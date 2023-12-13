@include('front.layout.header')
@include('front.layout.sidebar')
<?php
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypal_email = 'dev4.infosparkles@gmail.com';
?>
<div class="main_right">
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
        </div>
    </div>


    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-xl-4 recom_title">{{$common['heading_title']}}</h3>
    </div>
    <div class="presonal-wallines radioPanel wali_ka_form payment_page">
        <div class="row">
            <div class="col-md-6 mb_20">
                <h5> {{__("customer.text_ttl_max_install")}}</h5>
                <h3><span class="currency_sign"> $ </span> {{$reports['total_inst']}} Euro</h3>    
            </div>
            <div class="col-md-6">
                <button class="btn payment_btn"><img src="{{ asset('assets/images/PayU_blue_logo.png') }}"></button>
                <button class="btn payment_btn"><img src="{{ asset('assets/images/Paypal_logo.png') }}"></button>
                <button class="btn payment_btn"><img src="{{ asset('assets/images/bank_logo.png') }}"></button>
            </div>
        </div>
        <form action="{{$paypal_url}}" method="post">
            @csrf
            <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">  
            <input type="hidden" name="cmd" value="_xclick">      
            <!-- Details about the item that buyers will purchase. -->
            <input type="hidden" name="item_name" value="<?php echo $reports['seeker_name']; ?>">
            <input type="hidden" name="item_number" value="<?php echo $reports['report_id']; ?>">
            <input type="hidden" name="amount" value="<?php echo $reports['working_amount']; ?>">
            <input type="hidden" name="currency_code" value="USD">      
            <!-- URLs -->
            <input type='hidden' name='cancel_return' value="{{Route('provider.reports')}}">
            <input type='hidden' name='return' value="{{Route('provider.reports')}}"> 


            <input type="hidden" name="report_id" value="{{$reports['report_id']}}">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <h5>{{__("customer.text_app_details")}}</h5>
                    <div class="col-lg-12 col-sm-12">
                       <div class="form-group">
                          <label for="" class="full-name">{{__("customer.text_name")}}</label>
                          <input type="text" class="form-control full-name-control" name="salary"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_name")}}' value="{{$reports['seeker_name']}}">
                       </div>

                    </div>
                    <div class="col-lg-12 col-sm-12">
                       <div class="form-group">
                          <label for="" class="full-name">{{__("customer.text_working_hours")}}</label>
                          <input type="text" class="form-control full-name-control" name="salary"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_hours")}}' value="{{$reports['working_hours']}}">
                       </div>

                    </div>
                    <div class="col-lg-12 col-sm-12">
                       <div class="form-group">
                          <label for="" class="full-name">{{__("customer.text_contract_no")}}</label>
                          <input type="text" class="form-control full-name-control"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_contract_no")}}' value="{{$reports['contract']}}">
                       </div>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                       <div class="form-group">
                          <label for="" class="full-name">Total amount Brutto / Week</label>
                          <input type="text" class="form-control full-name-control"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_amount_bru")}}' value="{{$reports['total_amount']}}">
                       </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="text-left"><a href="javascript:void(0);" class="btn bk_btn" onclick="goBack()"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div>
                </div>
                <div class="col-md-6 pay_box">
                  @if($reports['paid']=='0')
                    <button class="btn pay_now" type="submit">{{__("customer.text_pay")}}</button>
                  @elseif($reports['paid']=='1')
                    <button class="btn btn-secondary" type="button">{{__("customer.text_paid")}}</button>
                  @endif  
                </div>
            </div>
        </form>
    </div>
@include('front.layout.footer')