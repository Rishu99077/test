@extends('admin.layout.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/newstyle.css') }}">
    <style>
        body {
            margin: 0;
            font-family: Open Sans, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
        }

        
    </style>
    @php
        $return_transfer_check = 1;
        if ($get_details_arr['return_transfer_check']) {
            $return_transfer_check = 2;
        }
        $transfer_zones_adult_price = 0;
        $transfer_zones_child_price = 0;
        $transfer_zones_total_adult_price = 0;
        $transfer_zones_total_child_price = 0;
        
        if ($get_details_arr['product_detail_arr']['transfer_zones']['adult_price'] > 0) {
            $transfer_zones_adult_price = $get_details_arr['product_detail_arr']['transfer_zones']['adult_price'] * $return_transfer_check;
            $transfer_zones_total_adult_price = $transfer_zones_adult_price * $get_details_arr['adult'];
        }
        
        if ($get_details_arr['product_detail_arr']['transfer_zones']['child_price'] > 0) {
            $transfer_zones_child_price = $get_details_arr['product_detail_arr']['transfer_zones']['child_price'] * $return_transfer_check;
            $transfer_zones_total_child_price = $transfer_zones_child_price * $get_details_arr['child'];
        }
        
        $all_vouchers = [];
        if (isset($get_details_arr['product_detail_arr']['vouchers']) && $get_details_arr['product_detail_arr']['vouchers']) {
            if (count($get_details_arr['product_detail_arr']['vouchers']) > 0) {
                foreach ($get_details_arr['product_detail_arr']['vouchers'] as $vouchers_key => $vouchers_value) {
                    # code...
                    $get_voucher = [];
                    $get_voucher['title'] = $vouchers_value['title'];
                    $get_voucher['description'] = $vouchers_value['description'];
                    $get_voucher['remark'] = $vouchers_value['remark'];
                    $get_voucher['amount_type'] = $vouchers_value['amount_type'];
                    $get_voucher['voucher_image'] = $vouchers_value['voucher_image'];
                    $get_voucher['product_id'] = $vouchers_value['product_id'];
                    $get_voucher['our_logo'] = $vouchers_value['our_logo'];
                    $get_voucher['client_logo'] = $vouchers_value['client_logo'];
                    $get_voucher['voucher_amount'] = $vouchers_value['voucher_amount'];
                    $all_vouchers[] = $get_voucher;
                }
            }
            // dd($value['vouchers']);
        }
    @endphp
    <div class="d-flex">
        <ul class="breadcrumb">
            <li>
                <a href="#" style="width: auto;">
                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>
        <div class="col-auto ms-auto">
            <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
                type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
            </a>
        </div>
    </div>
    <div class="content">
        <div class='transfer_head_first trnsfer_order'>
            <div class='transfer_header_table'>
                <div class="order_details_table mt-5">
                    <table>
                        <tbody class="table_left">
                            <tr>
                                <th>{{ translate('Order Id') }} : </th>
                                <td>{{ $get_details_arr['order_id'] }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Name') }} :</th>
                                <td>{{ $get_details_arr['name_title'] . $get_details_arr['first_name'] . ' ' . $get_details_arr['last_name'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ translate('Order Date') }} :</th>
                                <td>{{ $get_details_arr['order_date'] }}</td>
                            </tr>
                        </tbody>
                        <tbody class="table_right">
                            <tr>
                                <th>{{ translate('Payment options') }} :</th>
                                <td>{{ $get_details_arr['payment_method'] }}</td>
                            </tr>
                            @if ($get_details_arr['address'] != '')
                                <tr>
                                    <th>{{ translate('Address') }} :</th>
                                    <td> <span
                                            class="price_main">{{ $get_details_arr['currency'] }}</span>{{ $get_details_arr['address'] }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th>{{ translate('Total') }} :</th>
                                <td>
                                    <span class="price_main">
                                        {{ $get_details_arr['currency'] }}
                                    </span>
                                    {{ $get_details_arr['total_amount'] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="wizard_transfer wizard_transfer4 mt-4">


                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                            <div class="transfer_car">
                                <img src="{{ $get_details_arr['product_detail']->car_image }}" alt="">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="transferTaxi transferTaxi_tab2">
                                <h3>{{ $get_details_arr['order_id'] }}</h3>
                                <h3>{{ $get_details_arr['product_detail']->title }}
                                </h3>
                                <div class="transferTaxi_list">
                                    <ul>
                                        @if ($get_details_arr['product_detail']->passengers != '')
                                            <li>
                                                <img src="{{ asset('assets/img/passenger.096059495b02334231bb.png') }}"
                                                    alt="">
                                                <span>{{ translate('Up to') }}&nbsp;
                                                    {{ $get_details_arr['product_detail']->passengers }}
                                                    {{ translate('passengers') }}</span>
                                            </li>
                                        @endif

                                        @if ($get_details_arr['product_detail']->luggage_allowed != '')
                                            <li>
                                                <img src="{{ asset('assets/img/suitcase.58cac4198078c19f4184.png') }}"
                                                    alt=""><span>{{ $get_details_arr['product_detail']->luggage_allowed }}</span>
                                            </li>
                                        @endif

                                        @if ($get_details_arr['product_detail']->meet_greet != '' && $get_details_arr['product_detail']->meet_greet > 0)
                                            <li>
                                                <img src="{{ asset('assets/img/handshake.png') }}" alt="">
                                                <span>{{ translate('Meet & Greet') }}</span>
                                            </li>
                                        @endif
                                        @if (
                                            $get_details_arr['product_detail']->product_type != 'bus' ??
                                                $get_details_arr['product_detail']->product_bookable != 0)
                                            <li><img src="{{ asset('assets/img/door-to-door.png') }}" alt="">
                                                <span>{{ translate('Door-to-Door') }}</span>
                                            </li>
                                        @endif

                                        @if ($get_details_arr['product_detail']->journey_time != '')
                                            <li><img src="{{ asset('assets/img/clock.png') }}" alt="">
                                                <span>{{ $get_details_arr['product_detail']->journey_time }}</span>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="user_detail side_border">
                                <div class="userProfile_list">
                                    <ul>
                                        @if ($get_details_arr['adult'] > 0)
                                            <li class="">
                                                <img src="{{ asset('assets/img/adult.png') }}" alt="">
                                                {{ translate('Adults') }} ({{ $get_details_arr['adult'] }})
                                            </li>
                                        @endif
                                        @if ($get_details_arr['child'] > 0)
                                            <li class="">
                                                <img src="{{ asset('assets/img/kids.png') }}" alt="">
                                                {{ translate('Children') }} ({{ $get_details_arr['child'] }})
                                            </li>
                                        @endif
                                        @if ($get_details_arr['infant'] > 0)
                                            <li class="">
                                                <img src="{{ asset('assets/img/kids.png') }}" alt="">
                                                {{ translate('Infant') }} ({{ $get_details_arr['infant'] }})
                                            </li>
                                        @endif

                                        @if ($get_details_arr['infant'] != '')
                                            <li class="">
                                                <img src="{{ asset('assets/img/cars.png') }}" alt="">
                                                {{ translate('Vehicle') }}
                                                ({{ $get_details_arr['number_of_vehical'] }})
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- --------------- Transfer Option Start------ --}}
                    <div class="Wizard3 extras_title  mt-2">
                        <h6> {{ translate('Transfer Option') }}</h6>
                    </div>
                    @if ($get_details_arr['product_detail']->product_type == 'bus')
                        <div class="Wizard3gray_box">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="carDetail_txt">
                                        <p class="bold_price"><span>{{ translate('Adult') }} </span></p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt">

                                        <h6 class="price_font">
                                            {{ $get_details_arr['adult'] }} x
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                            {{ $transfer_zones_adult_price }}
                                        </h6>

                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt text-center">
                                        <h6 class="price_font">
                                            {{ $get_details_arr['return_transfer_check'] != '' ? 'Return Transfer' : 'One way' }}
                                        </h6>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12  text-end">
                                    <div class="carDetail_txt">
                                        <p class="bold_price">
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                            {{ $transfer_zones_total_adult_price }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="carDetail_txt">
                                        <p class="bold_price"><span>{{ translate('Child') }} </span></p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt">
                                        <h6 class="price_font">
                                            {{ $get_details_arr['child'] }} x
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                            {{ $transfer_zones_child_price }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt text-center">
                                        <h6 class="price_font">
                                            {{ $get_details_arr['return_transfer_check'] != '' ? 'Return Transfer' : 'One way' }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12  text-end">
                                    <div class="carDetail_txt">
                                        <p class="bold_price"><span>{{ $get_details_arr['currency'] }}</span>
                                            {{ $transfer_zones_total_child_price }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="border_bottom">
                                <hr>
                            </div>
                        </div>
                    @else
                        <div class="Wizard3gray_box">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="carDetail_txt">
                                        <p class="bold_price">
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']))
                                                {{ $get_details_arr['product_detail_arr']['transfer_zones']['price'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt">

                                        <h6 class="price_font">
                                            {{ translate('Number Of Vehicle ') }} :
                                            {{ $get_details_arr['number_of_vehical'] }}
                                        </h6>

                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt text-center">
                                        <h6 class="price_font">
                                            {{ $get_details_arr['return_transfer_check'] != '' ? 'Return Transfer' : 'One way' }}
                                        </h6>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12  text-end">
                                    <div class="carDetail_txt">
                                        <p class="bold_price">
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']) &&
                                                    isset($get_details_arr['product_detail_arr']['transfer_zones']['transfer_total']))
                                                {{ number_format($get_details_arr['product_detail_arr']['transfer_zones']['transfer_total']) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="border_bottom">
                                <hr>
                            </div>
                        </div>
                    @endif
                    {{-- --------------- Transfer Option End------ --}}

                    {{-- --------------- Parking Fees On Arrival Start ------ --}}
                    @if (isset($get_details_arr['product_detail_arr']) &&
                            isset($get_details_arr['product_detail_arr']['transfer_zones']) &&
                            isset($get_details_arr['product_detail_arr']['transfer_zones']['airport_parking_fee']) &&
                            $get_details_arr['product_detail_arr']['transfer_zones']['airport_parking_fee'] > 0)
                        <div class="Wizard3 extras_title  mt-2">
                            <h6> {{ translate('Parking Fees On Arrival') }}</h6>
                        </div>
                        <div class="Wizard3gray_box">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="carDetail_txt">
                                        <p class="bold_price"><span>{{ $get_details_arr['currency'] }}</span>
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']['total_parking_fee']))
                                                {{ $get_details_arr['product_detail_arr']['transfer_zones']['total_parking_fee'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-center">
                                    <div class="carDetail_txt">
                                        <h6 class="price_font">
                                            {{ translate('Number Of Vehicle') }}:
                                            {{ $get_details_arr['number_of_vehical'] }}
                                        </h6>

                                    </div>
                                </div>


                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12  text-end">
                                    <div class="carDetail_txt">
                                        <p class="bold_price">
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']['parking_total']))
                                                {{ $get_details_arr['product_detail_arr']['transfer_zones']['parking_total'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="border_bottom">
                                <hr>
                            </div>
                        </div>
                    @endif
                    {{-- --------------- Parking Fees On Arrival End ------ --}}

                    {{-- --------------- Parking Fees On Arrival End ------ --}}

                    {{-- --------------- Extra options Start ------ --}}
                    @if (isset($get_details_arr['product_detail_arr']) &&
                            isset($get_details_arr['product_detail_arr']['transfer_option']) &&
                            isset($get_details_arr['product_detail_arr']['transfer_option']['options']))
                        <div class="Wizard3 extras_title mt-2">
                            <h6>{{ translate('Extras') }}</h6>
                        </div>
                        @php
                            $extra_options = [];
                            if (isset($get_details_arr['product_detail_arr']['transfer_option']['options'])) {
                                $extra_options = $get_details_arr['product_detail_arr']['transfer_option']['options'];
                            }
                        @endphp
                        <div class="Wizard3gray_box">
                            @if (count($extra_options) > 0)
                                @foreach ($extra_options as $key => $extra_option_value)
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                            <div class="carDetail_txt">
                                                <h6>{{ $extra_option_value['title'] }}</h6>
                                                <p>{!! $extra_option_value['description'] !!}</p>
                                            </div>
                                        </div>

                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 mt-32">
                                            <div class="carDetail_txt">
                                                <h6 class="price_font">
                                                    {{ $extra_option_value['user_arrival'] == '1' ? 'Arrival' : '' }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 mt-32">
                                            <div class="carDetail_txt">
                                                <h6 class="price_font">
                                                    {{ $extra_option_value['user_departure'] == '1' ? 'Departure' : '' }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 mt-32 text-end">
                                            <div class="carDetail_txt">
                                                <p class="bold_price">
                                                    @if ($extra_option_value['total_price'])
                                                        <span>
                                                            {{ $get_details_arr['currency'] }}
                                                        </span>
                                                        {{ $extra_option_value['total_price'] }}
                                                    @else
                                                        Free
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border_bottom">
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                    {{-- --------------- Extra options End ------ --}}


                    {{-- --------------- Extra Needs Start ------ --}}
                    @if (isset($get_details_arr['product_detail_arr']) &&
                            isset($get_details_arr['product_detail_arr']['transfer_needs']) &&
                            isset($get_details_arr['product_detail_arr']['transfer_needs']['option']))
                        <div class="Wizard3 extras_title mt-2">
                            <h6> {{ translate('Extras Needs') }}</h6>
                        </div>
                        @if (isset($get_details_arr['product_detail_arr']['transfer_needs']['option']))
                            @php
                                $transfer_needs_option = [];
                                if (isset($get_details_arr['product_detail_arr']['transfer_needs']['option'])) {
                                    $transfer_needs_option = $get_details_arr['product_detail_arr']['transfer_needs']['option'];
                                }
                            @endphp
                        @endif
                        <div class="Wizard3gray_box">
                            @foreach ($transfer_needs_option as $key => $transfer_needs_option_value)
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="carDetail_txt">
                                            <h6>{{ $transfer_needs_option_value['title'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 alingnCenter_contain">
                                        <div class="carDetail_txt">
                                            <h6 class="price_font">
                                                {{ translate('Adult') }}<br>
                                                {{ $transfer_needs_option_value['adult_price'] }} x
                                                {{ $transfer_needs_option_value['adult_qty'] }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 alingnCenter_contain">
                                        <div class="carDetail_txt">
                                            <h6 class="price_font"> {{ translate('Child') }}<br>
                                                {{ $transfer_needs_option_value['child_price'] }} x
                                                {{ $transfer_needs_option_value['child_qty'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 alingnCenter_contain">
                                        <div class="carDetail_txt">
                                            <h6 class="price_font">
                                                {{ $transfer_needs_option_value['is_outward'] == '1' ? 'Departure' : '' }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 alingnCenter_contain">
                                        <div class="carDetail_txt">
                                            <h6 class="price_font">
                                                {{ $transfer_needs_option_value['is_return'] == '1' ? 'Arrival' : '' }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 mt-3 text-end">
                                        <div class="carDetail_txt">
                                            <p class="bold_price"><span>{{ $get_details_arr['currency'] }} </span>
                                                {{ $transfer_needs_option_value['total'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border_bottom">
                                    <hr>
                                </div>
                            @endforeach
                            <div class="border_bottom">
                                <hr>
                            </div>
                        </div>
                    @endif
                    {{-- --------------- Extra Needs End ------ --}}

                    {{-- --------------- Tax & Service Charge Start------ --}}
                    <div class="Wizard3 extras_title  mt-2">
                        <h6>{{ translate('Tax & Service Charge') }} </h6>
                    </div>
                    <div class="Wizard3gray_box">
                        @if (isset($get_details_arr['product_detail_arr']['tax_allowed']) &&
                                $get_details_arr['product_detail_arr']['tax_allowed'] > 0)
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="carDetail_txt">
                                        <h6>{{ translate('Tax') }}
                                            ({{ $get_details_arr['product_detail_arr']['tax_percentage'] }} %)</h6>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-end">
                                    <div class="carDetail_txt">
                                        <p class="bold_price"><span>{{ $get_details_arr['currency'] }}
                                            </span>{{ $get_details_arr['product_detail_arr']['tax_amount'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (isset($get_details_arr['product_detail_arr']['service_allowed']) &&
                                $get_details_arr['product_detail_arr']['service_allowed'] > 0)
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="carDetail_txt">
                                        <h6>{{ translate('Service Charge') }}
                                            ({{ $get_details_arr['product_detail_arr']['tax_percentage'] }} %)</h6>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-end">
                                    <div class="carDetail_txt">
                                        <p class="bold_price"><span>{{ $get_details_arr['currency'] }}</span>
                                            {{ $get_details_arr['product_detail_arr']['service_amount'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- --------------- Tax & Service Charge End------ --}}

                    <div class="passengercontact_Info">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="passengercontact_list">
                                    <ul>
                                        <li>
                                            <p><span class="userIcon"><svg aria-hidden="true" focusable="false"
                                                        data-prefix="fas" data-icon="user"
                                                        class="svg-inline--fa fa-user " role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <path fill="currentColor"
                                                            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                                                        </path>
                                                    </svg></span>{{ translate('Lead Passenger') }}</p>
                                        </li>
                                        <li>
                                            <h6>{{ $get_details_arr['name_title'] }}
                                                {{ $get_details_arr['first_name'] }}
                                                {{ $get_details_arr['last_name'] }}</h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="passengercontact_list">
                                    <ul>
                                        <li>
                                            <p><span class="userIcon transfer_phn_icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20">
                                                        <g id="Group_3035" data-name="Group 3035"
                                                            transform="translate(-1172 -1554)">
                                                            <g id="Rectangle_1825" data-name="Rectangle 1825"
                                                                transform="translate(1172 1554)" fill="none"
                                                                stroke="#707070" stroke-width="1" opacity="0">
                                                                <rect width="20" height="20" stroke="none">
                                                                </rect>
                                                                <rect x="0.5" y="0.5" width="19"
                                                                    height="19" fill="none">
                                                                </rect>
                                                            </g>
                                                            <path id="phone"
                                                                d="M15.779,13.305l-2.256,2.238a1.632,1.632,0,0,1-1.2.458,10.434,10.434,0,0,1-5.173-1.949A19.954,19.954,0,0,1,1.107,7.465,8.522,8.522,0,0,1,0,3.71,1.643,1.643,0,0,1,.462,2.489L2.718.234a.746.746,0,0,1,1.221.2L5.754,3.879a1,1,0,0,1-.2,1.136l-.831.831a.41.41,0,0,0-.085.237A7.085,7.085,0,0,0,6.771,9.237c.853.783,1.77,1.843,2.96,2.094a.469.469,0,0,0,.432-.042l.967-.983a1.1,1.1,0,0,1,1.17-.169h.017l3.274,1.933a.788.788,0,0,1,.187,1.237Z"
                                                                transform="translate(1174 1556)" fill="#919191">
                                                            </path>
                                                        </g>
                                                    </svg></span>{{ translate('Telephone Number') }}</p>
                                        </li>
                                        <li>
                                            <h6>{{ $get_details_arr['phone_code'] }}
                                                {{ $get_details_arr['phone_number'] }}</h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="passengercontact_list">
                                    <ul>
                                        <li>
                                            <p><span class="userIcon"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20" viewBox="0 0 20 20">
                                                        <g id="Group_3036" data-name="Group 3036"
                                                            transform="translate(-1172 -1554)">
                                                            <g id="Rectangle_1825" data-name="Rectangle 1825"
                                                                transform="translate(1172 1554)" fill="none"
                                                                stroke="#707070" stroke-width="1" opacity="0">
                                                                <rect width="20" height="20" stroke="none">
                                                                </rect>
                                                                <rect x="0.5" y="0.5" width="19"
                                                                    height="19" fill="none">
                                                                </rect>
                                                            </g>
                                                            <path id="email"
                                                                d="M14.389,1.75a1.579,1.579,0,0,1,1.143.455A1.486,1.486,0,0,1,16,3.315V12.63a1.488,1.488,0,0,1-.469,1.11,1.579,1.579,0,0,1-1.143.455H1.611a1.579,1.579,0,0,1-1.143-.455A1.486,1.486,0,0,1,0,12.63V3.315A1.488,1.488,0,0,1,.469,2.2,1.577,1.577,0,0,1,1.611,1.75Zm0,3.129V3.315L7.981,7.208,1.611,3.315V4.879l6.37,3.857Z"
                                                                transform="translate(1174 1556.028)" fill="#919191">
                                                            </path>
                                                        </g>
                                                    </svg></span>{{ translate('Email Address') }}</p>
                                        </li>
                                        <li>
                                            <h6>{{ $get_details_arr['email'] }}</h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- --------------- Arrival Departure Start ------ --}}
                    <div class="passengerTrip_detail mt-4">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="greyBox">
                                    <div class="passengerTrip_contain">
                                        <div class="outwardTitle">
                                            <h6>{{ translate('Arrival') }}</h6>
                                        </div>
                                        <div class="border_bottom">
                                            <hr>
                                        </div>
                                        <div class="outwardList">
                                            <ul>
                                                @if ($get_details_arr['airport_name'] != '')
                                                    <li>
                                                        <span>
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAYlJREFUSEvtlk9KxDAUxqd4CT2AR3AlNm1c6Alcu9KNJxBL+odZ2K0H0Bu4KNLFSDuCLlS6cetKLyEiVL8HU0hDa1IndDM+KKVJXn5838sLdSYjhzMyb/IPJMedMAwFntCG/b9a6vs+K4piTqA5At/+slBtDcuyvPA878QWVAsk0DeiUbasUiMgyncmhEhkaJqm+3mefw612Ai4UHmP97YEeOecH8DyxyFQYyDq6GHzUt2cDhLZ3IxHURS4rruG5WJR9xJLeDNvDKQEAhJYhQISwfJjjK93qXUQvcAkSTaDIHjtSmSMbUHM0xAL1UPWUtgoUBdR00PYBoBHJjDKv0Ngvxu8nuWcFlBt9C77eoAvcPWaQHI9O+1VB5FwCSWHOiVUt7quP+I4Ptet7VXYTMiNLvXeFex5y7JsWlXV1xCIFkg1g0pGdUDMUIuHvwLUvEFtYQO6YkCUjuPG2LNhnXTVzbDvbedNA9gpJqeWgZH8t9CqIQ7mDpp/1yZQvQxW7NDYtLJvr9Et/QFFBb4djeA0jwAAAABJRU5ErkJggg=="
                                                                alt="">
                                                        </span>
                                                        <div class="outwardlist_main">
                                                            <p>{{ translate('Arrival') }}</p>
                                                            <h6>{{ $get_details_arr['airport_name'] }}</h6>
                                                        </div>
                                                    </li>
                                                @endif
                                                @if ($get_details_arr['drop_off_point'] != '')
                                                    <li>
                                                        <span>
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAbBJREFUSEvdlu1NwzAQhusJYAPCBJQJKBNQJiAbFCagnQCYgDIB7QSkG7QbhA1ggvC+ko3C9c6+8KNCnBRZdc73+D7TMDqwhAPzRn8b2HVdhYic4RnHyGyx7kIIrTdSLg8BmsDgPR6umjTYXADMNStFIGDzCCvZ4vs5oIucYhYI2CMOzzykns4ToLfWGRMI2BSHXgfCkvo1oCvtbA7IQjgxgLu4zwLSpAXw1A3MeEfQNFVlrFp6ooEvtSJSPTQK5ROGKxj56N8cusf4zWgcCY9YtSy4H2IBeesrofsCA7UWJkCX2L8R79bQZx24gA20LoSuWX1GNQ8CMhRs9L5sceNzw0NOHJnHQSGdwMCbYvwOUPbmt8A79tyDousvGh6GoRaL1hbMb+ox5mgvT9h7x8UqLRq5PrRurtmRe3uRSAql0WZ5mYOa3vFQCfib8WaOtSIw5rLBKlvE8nCD3LHgTPF8nph8lr2cJNIoJ9G49DEuAqOXNdbnQrVkQ+kqmj4AbaKNu6SiTpVBbSGV45BeYl/O2DX2ajnUrWi4Qio85R+o1OwrgJhftwwGui0biv8f+AVUR5Ud6uxQngAAAABJRU5ErkJggg=="
                                                                alt="">
                                                        </span>
                                                        <div class="outwardlist_main">
                                                            <p>{{ translate('To') }}</p>
                                                            <h6>{{ $get_details_arr['drop_off_point'] }}</h6>
                                                        </div>
                                                    </li>
                                                @endif
                                                @if (isset($get_details_arr['airport_name']) && $get_details_arr['airport_name'] != '')
                                                    <li>
                                                        <span>
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt="">
                                                        </span>
                                                        <div class="outwardlist_main">
                                                            <p>{{ translate('Flight Number') }}</p>
                                                            <h6>{{ $get_details_arr['flight_number'] }}</h6>
                                                        </div>
                                                    </li>
                                                @endif
                                                @if ($get_details_arr['country_name'] != '')
                                                    <li><span><img
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt=""></span>
                                                        <div class="outwardlist_main">
                                                            <p>{{ translate('Flight Originated from') }}</p>
                                                            <h6> {{ $get_details_arr['country_name'] }}</h6>
                                                        </div>
                                                    </li>
                                                @endif
                                                @if ($get_details_arr['flight_arrival_time'] != '')
                                                    <li>
                                                        <span>
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt="">
                                                        </span>
                                                        <div class="outwardlist_main">
                                                            <p>{{ translate('Flight Arrival Date') }} </p>
                                                            <h6>{{ $get_details_arr['flight_arrival_time'] }}</h6>
                                                        </div>
                                                    </li>
                                                @endif
                                                @if (isset($get_details_arr['flight_arrival_time']) && $get_details_arr['flight_arrival_time'] != '')
                                                    <li class="blank_space">
                                                        <span>
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt="">
                                                        </span>
                                                        <div class="outwardlist_main">
                                                            <p> {{ translate('Flight Arrival Date') }}</p>
                                                            <h6>{{ date('h:m', strtotime($get_details_arr['flight_arrival_time'])) }}
                                                                [{{ date('h:m A', strtotime($get_details_arr['flight_arrival_time'])) }}]
                                                            </h6>
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                    <div class="greyBox">
                                        <div class="passengerTrip_contain">
                                            <div class="outwardTitle">
                                                <h6> {{ translate('Departure') }}</h6>
                                            </div>
                                            <div class="border_bottom">
                                                <hr>
                                            </div>
                                            <div class="outwardList">
                                                <ul>
                                                    @if (isset($get_details_arr['drop_off_point']) && $get_details_arr['drop_off_point'] != '')
                                                        <li>
                                                            <span>
                                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAbBJREFUSEvdlu1NwzAQhusJYAPCBJQJKBNQJiAbFCagnQCYgDIB7QSkG7QbhA1ggvC+ko3C9c6+8KNCnBRZdc73+D7TMDqwhAPzRn8b2HVdhYic4RnHyGyx7kIIrTdSLg8BmsDgPR6umjTYXADMNStFIGDzCCvZ4vs5oIucYhYI2CMOzzykns4ToLfWGRMI2BSHXgfCkvo1oCvtbA7IQjgxgLu4zwLSpAXw1A3MeEfQNFVlrFp6ooEvtSJSPTQK5ROGKxj56N8cusf4zWgcCY9YtSy4H2IBeesrofsCA7UWJkCX2L8R79bQZx24gA20LoSuWX1GNQ8CMhRs9L5sceNzw0NOHJnHQSGdwMCbYvwOUPbmt8A79tyDousvGh6GoRaL1hbMb+ox5mgvT9h7x8UqLRq5PrRurtmRe3uRSAql0WZ5mYOa3vFQCfib8WaOtSIw5rLBKlvE8nCD3LHgTPF8nph8lr2cJNIoJ9G49DEuAqOXNdbnQrVkQ+kqmj4AbaKNu6SiTpVBbSGV45BeYl/O2DX2ajnUrWi4Qio85R+o1OwrgJhftwwGui0biv8f+AVUR5Ud6uxQngAAAABJRU5ErkJggg=="
                                                                    alt="">
                                                            </span>
                                                            <div class="outwardlist_main">
                                                                <p>{{ translate('Departure') }}</p>
                                                                <h6>{{ $get_details_arr['drop_off_point'] }}</h6>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (isset($get_details_arr['airport_name']) && $get_details_arr['airport_name'] != '')
                                                        <li>
                                                            <span>
                                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAYlJREFUSEvtlk9KxDAUxqd4CT2AR3AlNm1c6Alcu9KNJxBL+odZ2K0H0Bu4KNLFSDuCLlS6cetKLyEiVL8HU0hDa1IndDM+KKVJXn5838sLdSYjhzMyb/IPJMedMAwFntCG/b9a6vs+K4piTqA5At/+slBtDcuyvPA878QWVAsk0DeiUbasUiMgyncmhEhkaJqm+3mefw612Ai4UHmP97YEeOecH8DyxyFQYyDq6GHzUt2cDhLZ3IxHURS4rruG5WJR9xJLeDNvDKQEAhJYhQISwfJjjK93qXUQvcAkSTaDIHjtSmSMbUHM0xAL1UPWUtgoUBdR00PYBoBHJjDKv0Ngvxu8nuWcFlBt9C77eoAvcPWaQHI9O+1VB5FwCSWHOiVUt7quP+I4Ptet7VXYTMiNLvXeFex5y7JsWlXV1xCIFkg1g0pGdUDMUIuHvwLUvEFtYQO6YkCUjuPG2LNhnXTVzbDvbedNA9gpJqeWgZH8t9CqIQ7mDpp/1yZQvQxW7NDYtLJvr9Et/QFFBb4djeA0jwAAAABJRU5ErkJggg=="
                                                                    alt="">
                                                            </span>
                                                            <div class="outwardlist_main">
                                                                <p>{{ translate('To') }}</p>
                                                                <h6>{{ $get_details_arr['airport_name'] }}
                                                                </h6>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (isset($get_details_arr['departure_flight_number']) && $get_details_arr['departure_flight_number'] != '')
                                                        <li class="blank_space"><span> <img
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt=""></span>
                                                            <div class="outwardlist_main">
                                                                <p>{{ translate('Departure Flight Number') }}</p>
                                                                <h6> {{ $get_details_arr['departure_flight_number'] }}
                                                                </h6>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (isset($get_details_arr['departure_country']) && $get_details_arr['departure_country'] != '')
                                                        <li class="blank_space">
                                                            <span>
                                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt="">
                                                            </span>
                                                            <div class="outwardlist_main">
                                                                <p>{{ translate('Flight Depart to ') }}</p>
                                                                <h6>{{ $get_details_arr['departure_country'] }}</h6>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (isset($get_details_arr['flight_departure_time']) && $get_details_arr['flight_departure_time'] != '')
                                                        <li class="">
                                                            <span>
                                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt="">
                                                            </span>
                                                            <div class="outwardlist_main">
                                                                <p> {{ translate('Flight Departure Date') }}</p>
                                                                <h6> {{ date('Y-d-m', strtotime($get_details_arr['flight_departure_time'])) }}
                                                                    [{{ date('l d,m', strtotime($get_details_arr['flight_departure_time'])) }}]
                                                                </h6>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (isset($get_details_arr['flight_departure_time']) && $get_details_arr['flight_departure_time'] != '')
                                                        <li class="blank_space">
                                                            <span>
                                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt="">
                                                            </span>
                                                            <div class="outwardlist_main">
                                                                <p>{{ translate('Flight Departure Time') }}</p>
                                                                <h6> {{ date('h:m', strtotime($get_details_arr['flight_departure_time'])) }}
                                                                    [{{ date('h:m A', strtotime($get_details_arr['flight_departure_time'])) }}]
                                                                </h6>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- --------------- total Start ------ --}}
                    <div class="passengerDetail_form accommodationDetail">
                        <div class="border_bottom">
                            <hr>
                        </div>
                        <div class="payDetail_table">
                            <div class="black_box">
                                <p> {{ translate(' Total Amount') }}</p>
                                <span class="payableAmount">
                                    <span class="payable_aed">
                                        {{ $get_details_arr['currency'] }}
                                    </span>
                                    {{ $get_details_arr['total_amount'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            @if (count($all_vouchers) > 0)
                <div class="order_details_table mt-5">
                    <div class="voucher_black_box text-center">
                        <p> {{ translate('Voucher') }}</p>
                    </div>
                    @foreach ($all_vouchers as $all_vouchers_key => $vouchers_value)
                        <div class="voucher_box"
                            style="background-image: url('{{ $vouchers_value['voucher_image'] != '' ? $vouchers_value['voucher_image'] : asset('uploads/placeholder/background.png') }}')">


                            <div class="new_dis_log">
                                <div class="logo_image">
                                    @if ($vouchers_value['our_logo'] != '')
                                        <img alt="" class="me-2"
                                            width="150"src="{{ $vouchers_value['our_logo'] }}" alt="" />
                                    @endif

                                </div>
                                <div class="logo_tetx">
                                    @if ($vouchers_value['client_logo'] != '')
                                        <img alt="" class="me-2"
                                            width="150"src="{{ $vouchers_value['client_logo'] }}" alt="" />
                                    @endif

                                </div>
                            </div>

                            <div class="text_main">
                                <h2>{{ $vouchers_value['title'] }}</h2>
                                <p> {!! $vouchers_value['description'] !!}
                                </p>
                            </div>
                            <div class="remarks">
                                <div class="new_remrk">
                                    @if ($vouchers_value['remark'] != '')
                                        <p> <span>{{ translate('Remark') }} : </span>{{ $vouchers_value['remark'] }}</p>
                                    @endif


                                </div>
                                <div class="new_price">
                                    <span class="payable_aed">
                                        {{ $get_details_arr['currency'] }}
                                    </span>
                                    {{ $vouchers_value['voucher_amount'] }}
                                    </span>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endsection
