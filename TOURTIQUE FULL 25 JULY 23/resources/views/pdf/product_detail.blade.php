<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/newstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <!-- Font Awesome -->
    <link
        rel="stylesheet"href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap"
        rel="stylesheet">

    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
            font-family: 'Poppins', sans-serif;
            line-height: 16px;
        }
        <style>
        .page-break {
            page-break-after: always;
        }
</style>
    </style>
</head>
@php 
$all_vouchers = [];
@endphp
<body>
    <section class='transfer_head_first trnsfer_order'>
        <div class='transfer_header_table'>
            <div class="container1">
                <main>
                    <div class="orderDetails">
                        <table
                            style="width:100%; background-image: url('{{ asset('assets/img/header-slide.png') }}');background-repeat: no-repeat;background-size:cover;background-position: right;width: 100%;">
                            <tbody class="table_left">
                                <tr>
                                    <td colspan="2" style="padding:25px ;"></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;padding: 0 0px 0 15px;">
                                        <img style="width: 150px;" src="{{ asset('assets/img/tourlogo.png') }}"
                                            alt="" />
                                    </td>
                                    <td style="width:65%; text-align: right;">
                                        <img style="width: 35%;float: right;margin: 0px 20px;"
                                            src="{{ asset('assets/img/tourlogo.png') }}" alt="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:20px ;"></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;font-size: 14px;color:#232a35;padding: 0 0px 0px 15px;">
                                        {{ translate('Order Id') }} :
                                        <strong>{{ $get_details_arr['order_id'] }}</strong>
                                    </td>
                                    <td style="width:65%;font-size: 14px;color:#232a35;padding: 0px 15px 0px 0px;">
                                        {{ translate('Payment options') }} :
                                        <strong>{{ $get_details_arr['payment_method'] }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:35%;font-size: 14px;color:#232a35;padding: 0 0px 0px 15px;">
                                        {{ translate('Name') }} : <strong>{{ $get_details_arr['first_name'] }}
                                            {{ $get_details_arr['last_name'] }}</strong>
                                    </td>
                                    <td style="width:65%;font-size: 14px;color:#232a35;padding: 0px 15px 0px 0px;">
                                        {{ translate('Address') }} : <strong>
                                            {{ $get_details_arr['address'] }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:35%;font-size: 14px;color:#232a35;padding: 0 0px 0px 15px;">
                                        {{ translate('Order Date') }} : <strong>
                                            {{ $get_details_arr['date'] }}</strong>
                                    </td>
                                    <td style="width:65%;font-size: 14px;color:#232a35;padding: 0px 15px 0px 0px;">
                                        {{ translate('Total') }} : <strong>{{ $get_details_arr['currency'] }}
                                            {{ $get_details_arr['total'] }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:5px ;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:10px;"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="padding: 0 15px;">
                            @if (count($get_details_arr['product_detail_arr']) > 0)
                                @foreach ($get_details_arr['product_detail_arr'] as $key => $value)
                                    @php
                                    if(isset($value['vouchers'])){
                                        if(count($value['vouchers'])>0){
                                            foreach ($value['vouchers'] as $vouchers_key => $vouchers_value) {
                                                # code...
                                                $get_voucher                  = [] ;
                                                $get_voucher['title']         = $vouchers_value['title'];
                                                $get_voucher['description']   = $vouchers_value['description'];
                                                $get_voucher['remark']        = $vouchers_value['remark'];
                                                $get_voucher['amount_type']   = $vouchers_value['amount_type'];
                                                $get_voucher['voucher_image'] = $vouchers_value['voucher_image'];
                                                $get_voucher['product_id']    = $vouchers_value['product_id'];
                                                $get_voucher['our_logo']      = $vouchers_value['our_logo'];
                                                $get_voucher['client_logo']      = $vouchers_value['client_logo'];
                                                $get_voucher['voucher_amount']   = $vouchers_value['voucher_amount'];
                                                $all_vouchers[] = $get_voucher;
                                            }
                                        }
                                        // dd($value['vouchers']);
                                    }
                                    @endphp
                                    @if ($value['type'] != 'GiftCard')
                                        <table style="width:100%;vertical-align: top;">
                                            <tbody>
                                                <tr>
                                                    <td style=" width: 25%;">
                                                        <img src="{{ $value['image'] }}"
                                                            style="width:100%;vertical-align: text-top;border-radius: 10px;"
                                                            alt="">
                                                    </td>
                                                    <td style="width: 75%; padding: 0 15px;vertical-align: top;">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    
                                                                    <td colspan="2"
                                                                        style="color: #232a35;font-size: 14px;font-weight: 700;">{{ $value['title'] }}
                                                                        <h4>
                                                                            @if ($value['type'] === 'Limousine' || $value['type'] === 'Yatch')
                                                                                @if (isset($value['option'][0]) && isset($value['option'][0]['date']))
                                                                                    Booking Date : {{ $value['option'][0]['date'] }}
                                                                                @endif
                                                                            @endif
                                                                            
                                                                        </h4>
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td colspan="2"
                                                                        style="color: #232a35;font-size: 14px;font-weight: 400;line-height: 12px;">
                                                                        {!! $value['description'] !!}</td>
                                                                </tr> --}}
            
                                                                <tr>
                                                                    <td
                                                                        style="width:40%;padding-bottom: 0px; color: #232a35;font-size: 14px;font-weight: 500;">
                                                                        <span style="color: #baad85;font-size: 12px;">$
                                                                        </span>{{ number_format($value['price'], 2) }}
                                                                    </td>
                                                                </tr>
            
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
            
                                                <tr>
                                                    <td style=" width: 100%;padding: 10px;" colspan="2"> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif

                                        {{-- OPtins lodger  --}}
                                        @if ($value['type'] == 'lodge' && count($value['option']) > 0)
                                            @foreach ($value['option'] as $key2 => $option_value)
                                                <table style="width:100%;">
                                                    <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;">
                                                        <tr>
                                                            <td colspan="4" style="padding:3px ;"></td>
                                                        </tr>
                                            
                                                        <tr>
                                                            <td colspan="4" style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 700;">
                                                                {{ translate('Booking Details') }}</td>
                                                        </tr>
                                            
                                                        <tr>
                                                            <td
                                                                style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                                                {{ $option_value['title'] }} : {{ $option_value['no_of_rooms'] }}
                                                            </td>
                                                            <td
                                                                style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                                            </td>
                                                            <td
                                                                style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                                            </td>
                                                            <td
                                                                style="padding: 0 15px 5px 0px;width:25%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;text-align:right;">
                                                                <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span> {{ $option_value['option_total'] }}
                                                            </td>
                                                        </tr>
                                            
                                                        <tr>
                                                            <td
                                                                style="padding: 0 0px 0px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                                                {{ $option_value['lodge_arrival_date'] }}</td>
                                                            <td
                                                                style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 10px;">
                                                                {{ translate('Adult') }} : {{ $option_value['adult'] }}</td>
                                                            <td
                                                                style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                                                                {{ translate('Child') }} : {{ $option_value['child'] }}</td>
                                                            <td
                                                                style="text-align:right; padding-right: 15px;width:25%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                                                                {{ translate('Infant') }}  : {{ $option_value['infant'] }}</td>
                                                        </tr>
                                                        

                                                            @if (isset($option_value['lodge_upgrade_option']) && $option_value['lodge_upgrade_option'] != '')
                                                            
                                                                <tr>
                                                                    <td colspan="4"
                                                                        style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 500;line-height: 15px;">
                                                                        {{ translate('Lodge Upgrade') }}</td>
                                                                </tr>
                                                                @foreach ($option_value['lodge_upgrade_option'] as $key3 => $upgrade_option_value)
                                                                    <tr>
                                                                        <td
                                                                            style="padding: 0 0px 0px 15px;width:35%;font-size: 12px;color:#686767; font-weight: 500;line-height: 10px;">
                                                                            {{ $upgrade_option_value['title'] }}</td>
                                                                        <td
                                                                            style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                                                            {{ translate('Adult') }} : {{ $upgrade_option_value['lodge_adult_qty'] }} x {{ $get_details_arr['currency'] }} {{ $upgrade_option_value['adult_price'] }}</td>
                                                                        <td
                                                                            style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                                                            {{ translate('Child') }} : {{ $upgrade_option_value['lodge_child_qty'] }} x {{ $get_details_arr['currency'] }} {{ $upgrade_option_value['child_price'] }}</td>
                                                                        <td
                                                                            style="text-align:right; padding-right: 15px;width:25%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                                                            {{ translate('Infant') }} : {{ $upgrade_option_value['lodge_infant_qty'] }} x {{ $get_details_arr['currency'] }} {{ $upgrade_option_value['infant_price'] }}</td>
                                                                    </tr> @endforeach
                                                            @endif
                                                        <tr>
                                                            <td colspan="4"
        style="padding: 0 15px;">
    <hr style="border-top: 0;height: 0;border-bottom: 1px solid #6867677d;margin-bottom:10px;margin-top:10px;">
    </td>
    </tr>
    </tbody>
    </table>
    @endforeach
    @endif
    {{-- OPtins lodger End --}}

    {{-- OPtins Limousine  --}}
    @if ($value['type'] == 'Limousine' && count($value['option']) > 0)
        @foreach ($value['option'] as $key2 => $option_value)
            <table style="width:100%;background: #f7f7f7;border-radius: 4px;padding: 12px 0; ">
                <tbody class="table_left" style="">
                    <tr>
                        <td colspan="4"
                            style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 700;">
                            {{ translate('Booking Details') }}</td>
                    </tr>

                    <tr>
                        <td colspan="4"
                            style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                            {{ $option_value['title'] }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding: 0 0px 0px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                            {{ $option_value['date'] }}</td>
                        <td
                            style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 10px;">
                            {{ translate('Start Time') }} : {{ $option_value['start_time'] }}</td>
                        <td
                            style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                            {{ translate('End Time') }} : {{ $option_value['end_time'] }}</td>
                        <td
                            style="text-align:right; padding-right: 15px;width:25%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                            <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                            {{ $option_value['total_price'] }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" style="padding: 0 15px;">
                            <hr
                                style="border-top: 0;height: 0;border-bottom: 1px solid #6867677d;margin-bottom:10px;margin-top:10px;">
                        </td>
                    </tr>

                    @if (isset($option_value['transfer_option']) && $option_value['transfer_option'] != '')
                        <tr>
                            <td colspan="4"
                                style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                {{ translate(' Extra Options') }}
                            </td>
                        </tr>

                        @foreach ($option_value['transfer_option'] as $key4 => $value3)

                            <tr>
                                <td
                                    style="padding: 0 0px 0px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    {{ $value3['title'] }}
                                </td>
                                <td
                                    style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 10px;">
                                    {{ $value3['get_hours'] }} x
                                    {{ $get_details_arr['currency'] }}{{ $value3['price'] }} </td>
                                <td colspan="2"
                                    style="padding-right: 15px;width:45%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                                    {{ $get_details_arr['currency'] }} {{ number_format($value3['total_price'], 2) }}
                                </td>

                            </tr>
                        @endforeach

                    @endif
                    <tr>
                        <td colspan="4" style="padding: 0 15px;">
                            <hr
                                style="border-top: 0;height: 0;border-bottom: 1px solid #6867677d;margin-bottom:10px;margin-top:10px;">
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endif
    {{-- Options Limousine End  --}}



    {{-- Options Limousine End  --}}
    @if ($value['type'] == 'Yatch' && count($value['option']) > 0)
        @foreach ($value['option'] as $key2 => $option_value)
            <table style="width:100%;background: #f7f7f7;border-radius: 4px;padding: 12px 0; ">
                <tbody class="table_left" style="">
                    <tr>
                        <td colspan="4"
                            style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 700;">
                            {{ translate('Booking Details') }}</td>
                    </tr>

                    <tr>
                        <td colspan="4"
                            style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                            @if ($option_value['title'] == 'Hour Price')
                                Yacht Charter Price
                            @else
                                {{ $option_value['title'] }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding: 0 0px 0px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                            {{ $option_value['date'] }}</td>
                        <td
                            style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 10px;">
                            Start Time : {{ $option_value['start_time'] }}</td>
                        <td
                            style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                            End Time : {{ $option_value['end_time'] }}</td>
                        <td
                            style="text-align:right; padding-right: 15px;width:25%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                            <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                            {{ $option_value['total_price'] }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" style="padding: 0 15px;">
                            <hr
                                style="border-top: 0;height: 0;border-bottom: 1px solid #6867677d;margin-bottom:10px;margin-top:10px;">
                        </td>
                    </tr>
                    {{-- transportaion option Yatch --}}
                    @if (isset($option_value['transportaion']) && $option_value['transportaion'] != '')
                        <tr>
                            <td colspan="4"
                                style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                Transportation
                            </td>
                        </tr>
                        @if (count($option_value['transportaion']) > 0)
                            @foreach ($option_value['transportaion'] as $transportaion_key => $transportaion_value)
                                <tr>
                                    <td
                                        style="padding: 0 10px 0px 15px;width:35%;font-size: 12px;color:#686767; font-weight: 500;line-height: 10px;">
                                        {{ $transportaion_value['title'] }}</td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $transportaion_value['select_qty'] }} x <span
                                            style="color:#baad85">{{ $get_details_arr['currency'] }}</span>{{ $transportaion_value['price'] }}
                                    </td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $transportaion_value['way'] }}</td>
                                    <td
                                        style="text-align:right; padding-right: 15px;width:25%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                                        {{ $transportaion_value['total_price'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    {{-- transportaion option Yatch --}}


                    {{-- transfer_option option Yatch --}}
                    @if (isset($option_value['transfer_option']) && $option_value['transfer_option'] != '')
                        <tr>
                            <td colspan="4"
                                style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                {{ translate('Extra Options') }}
                            </td>
                        </tr>
                        @if (count($option_value['transfer_option']) > 0)
                            @foreach ($option_value['transfer_option'] as $transfer_option_key => $transfer_option_value)
                                <tr>
                                    <td
                                        style="padding: 0 10px 0px 15px;width:35%;font-size: 12px;color:#686767; font-weight: 500;line-height: 10px;">
                                        {{ $transfer_option_value['title'] }}</td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $transfer_option_value['select_qty'] }} x <span
                                            style="color:#baad85">{{ $get_details_arr['currency'] }}</span>{{ $transfer_option_value['price'] }}
                                    </td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $transfer_option_value['way'] }}</td>
                                    <td
                                        style="text-align:right; padding-right: 15px;width:25%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                                        {{ $transfer_option_value['total_price'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    {{-- transfer_option option Yatch --}}



                    {{-- food_beverage option Yatch --}}
                    @if (isset($option_value['food_beverage']) && $option_value['food_beverage'] != '')
                        <tr>
                            <td colspan="4"
                                style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                {{ translate('Extra Options') }}
                            </td>
                        </tr>
                        @if (count($option_value['food_beverage']) > 0)
                            @foreach ($option_value['food_beverage'] as $food_beverage_key => $food_beverage_value)
                                <tr>
                                    <td
                                        style="padding: 0 10px 0px 15px;width:35%;font-size: 12px;color:#686767; font-weight: 500;line-height: 10px;">
                                        {{ $food_beverage_value['title'] }}</td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $food_beverage_value['adult_qty'] }} x <span
                                            style="color:#baad85">{{ $get_details_arr['currency'] }}</span>{{ $food_beverage_value['adult_price'] }}
                                    </td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $food_beverage_value['child_qty'] }} x <span
                                            style="color:#baad85">{{ $get_details_arr['currency'] }}</span>{{ $food_beverage_value['child_price'] }}
                                    </td>

                                    <td
                                        style="text-align:right; padding-right: 15px;width:25%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                                        {{ $food_beverage_value['total_price'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    {{-- food_beverage_value option Yatch --}}



                    {{-- Water Sports option Yatch --}}
                    @if (isset($option_value['food_beverage']) && $option_value['food_beverage'] != '')
                        <tr>
                            <td colspan="4"
                                style="padding: 0 0px 5px 15px;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                {{ translate('Water Sports') }}
                            </td>
                        </tr>
                        @if (count($option_value['water_sports']) > 0)
                            @foreach ($option_value['water_sports'] as $water_sports_key => $water_sports_value)
                                <tr>
                                    <td
                                        style="padding: 0 10px 0px 15px;width:35%;font-size: 12px;color:#686767; font-weight: 500;line-height: 10px;">
                                        {{ $water_sports_value['title'] }}</td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        {{ $water_sports_value['get_hours'] }} x <span
                                            style="color:#baad85">{{ $get_details_arr['currency'] }}</span>{{ $water_sports_value['price'] }}
                                    </td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">

                                    </td>

                                    <td
                                        style="text-align:right; padding-right: 15px;width:25%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                                        {{ $water_sports_value['total_price'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    {{-- Water Sports option Yatch --}}

                </tbody>
            </table>
        @endforeach
    @endif
    {{-- Options Limousine End  --}}


    {{-- OPtins Excursion  --}}
    @if ($value['type'] == 'excursion' && count($value['option']) > 0)
        @foreach ($value['option'] as $key2 => $option_value)
            <table style="width:100%;">
                <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;">
                    <tr>
                        <td colspan="4" style="padding:3px ;"></td>
                    </tr>

                    <tr>
                        <td colspan="4"
                            style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 700;">
                            {{ translate('Booking Details sd') }}</td>
                    </tr>

                    @if (isset($option_value['private_tour']) && $option_value['private_tour'] != '')
                        <tr>
                            <td colspan="4"
                                style="color: #232a35; padding: 0 0px 0px 15px; font-size: 14px;font-weight: 500;line-height: 12px;">
                                {{ translate('Private Tour') }}</td>
                        </tr>

                        @if (count($option_value['private_tour']) > 0)
                            @foreach ($option_value['private_tour'] as $private_key => $private_value)
                                <tr>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        {{ $private_value['title'] }} : {{ $private_value['total_pasenger'] }}
                                    </td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    </td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    </td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                                        {{ $private_value['total_amount'] }}
                                    </td>

                                </tr>
                                <tr>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        Adult : {{ $private_value['adult'] }}
                                    </td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        Child :{{ $private_value['child'] }}
                                    </td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        Infant :{{ $private_value['infant'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif

                    @if (isset($option_value['tour_transfer']) && $option_value['tour_transfer'] != '')
                        <tr>
                            <td colspan="4"
                                style="color: #232a35; padding: 0 0px 0px 15px; font-size: 14px;font-weight: 500;line-height: 12px;">
                                {{ translate('Tour Transfer') }}</td>
                        </tr>
                        @if (count($option_value['tour_transfer']) > 0)
                            @foreach ($option_value['tour_transfer'] as $tour_transfer_key => $tour_transfer_value)
                                <tr>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        {{ $tour_transfer_value['title'] }} :
                                        {{ $tour_transfer_value['option_name'] }}
                                    </td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        <span style="color:#baad85"></td>
                                    <td
                                        style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    </td>
                                    <td
                                        style="padding: 0 15px 5px 0px;width:25%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;text-align:right;">
                                        {{ $get_details_arr['currency'] }}</span>{{ $tour_transfer_value['total_amount'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 0 0px 0px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                        {{ $tour_transfer_value['date'] }}</td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 10px;">
                                        {{ translate('Adult') }} : {{ $tour_transfer_value['adult'] }}</td>
                                    <td
                                        style="padding-right: 15px;width:20%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                                        {{ translate('Child') }} : {{ $tour_transfer_value['child'] }}</td>
                                    <td
                                        style="text-align:right; padding-right: 15px;width:25%; color: #201e1e;font-size: 14px;font-weight: 500;line-height: 12px;">
                                        {{ translate('Infant') }} : {{ $tour_transfer_value['infant'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endif

                    @if (isset($option_value['tour_upgrade_option']) && $option_value['tour_upgrade_option'] != '')
                        <tr>
                            <td colspan="4"
                                style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 500;line-height: 15px;">
                                {{ translate('Lodge Upgrade') }}</td>
                        </tr>

                        @foreach ($option_value['tour_upgrade_option'] as $tour_upgrade_option_key => $tour_upgrade_option_value)
                            <tr>
                                <td
                                    style="padding: 0 0px 0px 15px;width:35%;font-size: 12px;color:#686767; font-weight: 500;line-height: 10px;">
                                    {{ $tour_upgrade_option_value['title'] }}</td>
                                <td
                                    style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                    {{ translate('Adult') }} : {{ $tour_upgrade_option_value['lodge_adult_qty'] }} X
                                    {{ $get_details_arr['currency'] }}{{ $tour_upgrade_option_value['adult_price'] }}
                                </td>
                                <td
                                    style="padding-right: 15px;width:20%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                    {{ translate('Child') }} : {{ $tour_upgrade_option_value['lodge_child_qty'] }} X
                                    {{ $get_details_arr['currency'] }}{{ $tour_upgrade_option_value['child_price'] }}
                                </td>
                                <td
                                    style="text-align:right; padding-right: 15px;width:25%; color: #686767;font-size: 12px;font-weight: 500;line-height: 10px;">
                                    {{ translate('Child') }} : {{ $tour_upgrade_option_value['lodge_infant_qty'] }}
                                    X
                                    {{ $get_details_arr['currency'] }}{{ $tour_upgrade_option_value['infant_price'] }}
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    @if (isset($option_value['group_percentage']) && $option_value['group_percentage'] != '')
                        <tr>
                            <td colspan="4"
                                style="color: #232a35; padding: 0 0px 5px 15px; font-size: 14px;font-weight: 500;line-height: 15px;">
                                {{ translate('Group Percentage') }}</td>
                        </tr>

                        @foreach ($option_value['group_percentage'] as $group_percentage_key => $group_percentage_value)
                            <tr>
                                <td
                                    style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    {{ $group_percentage_value['title'] }} : {{ $group_percentage_value['qty'] }}
                                </td>
                                <td
                                    style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                </td>
                                <td
                                    style="padding: 0 0px 5px 15px;width:20%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                </td>
                                <td
                                    style="padding: 0 15px 5px 0px;width:25%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;text-align:right;">
                                    <span
                                        style="color:#baad85">{{ $get_details_arr['currency'] }}</span>{{ $group_percentage_value['amount'] }}
                                </td>
                            </tr>

                            <tr>
                                <td
                                    style="padding: 0 0px 10px 15px;width:35%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    {{ $group_percentage_value['date'] }}
                                </td>
                                <td colspan="3"
                                    style="padding: 0 15px 10px 0px;width:65%;font-size: 14px;color:#201e1e; font-weight: 500;line-height: 12px;">
                                    {{ translate('Price Per Person') }} :
                                    {{ $group_percentage_value['group_price'] }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endforeach
    @endif
    {{-- Excursion End  --}}





    {{-- Gift Card  Start --}}
    @if ($value['type'] == 'GiftCard')
        <table style="width:100%;vertical-align: top;">
            <tbody>
                <tr>
                    <td
                        style=" width: 50%;background-image: url('{{ $value['image'] }}');background-repeat: no-repeat;background-size: cover;background-position: center;padding: 8px 12px;border-radius: 10px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 25%;">
                                    <img style="width: 150px;"
                                        src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('assets/img/tourlogo.png') }}"
                                        alt="" />
                                </td>
                                <td style="width: 75%; font-size: 14px;line-height: 15px;font-weight: 700;"> </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="padding: 50px;"> </td>
                            </tr>

                            <tr>
                                <td
                                    style="width: 50%; font-size: 14px;line-height: 15px;font-weight: 700;color: #fff;">
                                    {{ $value['note'] }}</td>
                                <td
                                    style="width: 50%; font-size: 14px;line-height: 15px;font-weight: 700;color: #fff;text-align: right;">
                                    {{ $get_details_arr['currency'] }}{{ $value['total'] }}</td>
                            </tr>

                            <tr>
                                <td style="padding: 5px;width: 100%;" colspan="2"> </td>
                            </tr>

                        </table>
                        <!--  -->
                    </td>
                    <td style="width: 50%; padding: 0 15px;vertical-align: top;">
                        <div style="font-size: 14px;line-height: 15px;font-weight: 500;">{{ translate('Name') }} :
                            {{ $value['name'] }}</div>
                        <div style="font-size: 14px;line-height: 15px;font-weight: 500;">
                            {{ translate('Email Address') }} : {{ $value['email'] }}</div>
                        <div style="font-size: 14px;line-height: 15px;font-weight: 500;">
                            {{ translate('Mobile Number') }} :
                            {{ $value['phone_code'] }}  {{ $value['phone_number'] }}</div>
                        <div style="font-size: 14px;line-height: 15px;font-weight: 500;">
                            {{ translate('Name Of The Recipient') }} : {{ $value['recipient_name'] }}</div>
                        <div style="font-size: 14px;line-height: 15px;font-weight: 500;">
                            {{ translate('Recipient Email') }} : {{ $value['recipient_email'] }}</div>
                        <div style="font-size: 14px;line-height: 15px;font-weight: 500;">
                            {{ translate('Recipient Mobile Number') }} :
                            {{ $value['recipient_phone_code'] }}{{ $value['recipient_phone_number'] }}</div>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 15px;" colspan="2"></td>
                </tr>
            </tbody>
        </table>
    @endif
    {{-- Gift Card End  --}}


    <div style="line-height: 16px;padding: 15px;background: #fff;"></div>

    <table style="width:100%;background: #f7f7f7;border-radius: 4px;padding: 5px 12px;">
        <tbody>
            @if (isset($value['tax_amount']) && $value['tax_amount'] > 0)
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Tax') }} {{ $value['tax'] }} %</td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $value['tax_amount'] }}
                    </td>
                </tr>
            @endif

            @if (isset($value['service_charge']) && $value['service_charge'] > 0)
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Service Charge') }}</td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $value['service_charge'] }}
                    </td>
                </tr>
            @endif

            @if (isset($value['total']) && $value['total'] > 0)
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Product Grand Total') }}
                        @if (isset($value['reward_point_apply']) && $value['reward_point_apply'])
                            <p>
                                {!! $value['reward_point_apply_text'] !!}
                            </p>
                        @endif
                    </td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        @if (isset($value['reward_point_apply']) && $value['reward_point_apply'])
                            {{ number_format($value['sum_tax_service_per_product'], 2) }}
                        @else
                            {{ number_format($value['total'], 2) }}
                        @endif
                    </td>
                </tr>
            @endif

        </tbody>
    </table>


    @endforeach
    @endif



    <table style="width:100%;background: #f7f7f7;border-radius: 4px;padding: 5px 12px;">
        <tbody>
            @if ($get_details_arr['sub_total'] != '')
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Sub Total') }}</td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $get_details_arr['sub_total'] }}
                    </td>
                </tr>
            @endif
            @if ($get_details_arr['coupon_value'] != '')
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Coupon Code') }} ({{ $get_details_arr['coupon_code'] }})</td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $get_details_arr['coupon_value'] }}
                    </td>
                </tr>
            @endif
            @if ($get_details_arr['total_tax'] != '')
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Total Tax') }} </td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $get_details_arr['total_tax'] }}
                    </td>
                </tr>
            @endif
            @if ($get_details_arr['total_service_tax'] != '')
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Total Service Charge') }} </td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $get_details_arr['total_service_tax'] }}
                    </td>
                </tr>
            @endif
            @if ($get_details_arr['giftcard_value'] != '')
                <tr>
                    <td style="padding: 0px 0px; color: #201e1e;font-size: 14px;font-weight: 500;">
                        {{ translate('Gift Card Code') }} ({{ $get_details_arr['giftcard_code'] }} )</td>
                    <td style="padding: 0px 0px;text-align: right; color: #201e1e;font-size: 14px;font-weight: 500;">
                        <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                        {{ $get_details_arr['giftcard_value'] }}
                    </td>
                </tr>
            @endif


            <tr>
                <td style="color: #fff;font-size: 14px;font-weight: 500;padding: 10px;background-color:#232a35">
                    {{ translate('Total Amount') }}</td>
                <td
                    style="color: #fff;font-size: 14px;font-weight: 500;padding: 10px;background-color:#232a35;text-align:right;">
                    <span style="color:#baad85">{{ $get_details_arr['currency'] }}</span>
                    {{ number_format($get_details_arr['total'], 2) }}
                </td>
            </tr>

        </tbody>
    </table>
    <div style="page-break-after: always;"></div>



    @if (count($all_vouchers) > 0)
        <div style="line-height: 16px;padding: 15px;background: #fff;margin-top:15px"></div>
        <div
            style="background-color: #232a35;color: #fff;font-weight: 18px;text-align: center;padding: 5px 0 10px;line-height: 16px;font-weight: 700;">
            {{ translate('Voucher') }}
        </div>
        <div style="line-height: 16px;padding: 10px;background: #fff;"></div>
        {{-- {{dd($all_vouchers)}} --}}
        @foreach ($all_vouchers as $all_vouchers_key => $vouchers_value)
           {{-- {{dd($vouchers_value)}} --}}

            <table
                style="width: 100%;background-image: url('{{ $vouchers_value['voucher_image'] != '' ? $vouchers_value['voucher_image'] : asset('uploads/placeholder/background.png') }}');background-repeat: no-repeat;background-size: cover;background-position: center;padding: 8px 12px;border-radius: 6px;" class="page-break">
                <tbody>

                    <tr>
                        <td style="padding: 8px;" colspan="2"></td>
                    </tr>

                    <tr>
                        @if ($vouchers_value['our_logo'] != '')
                            <td style="width: 70%;">
                                <img style="width: 150px;" src="{{ $vouchers_value['our_logo'] }}"
                                    alt="" />
                            </td>
                        @endif
                        @if ($vouchers_value['client_logo'] != '')
                            <td style="width: 30%;text-align: right;">
                                <img style="width: 150px;" src="{{ $vouchers_value['client_logo'] }}"
                                    alt="" />
                            </td>
                        @endif
                    </tr>

                    <tr>
                        <td style="padding: 10px;" colspan="2">
                            <div
                                style="color: #fff;font-size: 16px;text-align: left;line-height: 16px;font-weight: 700;">
                                {{ $vouchers_value['title'] }}</div>
                            <div
                                style="color: #fff;font-size: 14px;text-align: left;line-height: 14px;font-weight: 400;">
                                {!! $vouchers_value['description'] !!}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 5px;" colspan="2"></td>
                    </tr>

                    <tr>
                        <td style="width: 70%;">
                            @if ($vouchers_value['remark'] != '')
                                <div style="color: #fff;font-size: 14px;line-height: 14px;font-weight: 500;">
                                    {{ translate('Remark') }} : {{ $vouchers_value['remark'] }}</div>
                            @endif
                        </td>
                        <td style="width: 30%;">
                            <div
                                style="color: #baad85;font-size: 16px;text-align: right;line-height: 16px;font-weight: 700;">
                                {{ $get_details_arr['currency'] }}
                                {{-- @php
                                                    $voucher_amount=$get_details_arr['voucher_amount'];
                                                    if($get_details_arr['amount_type'] == 'flat'){
                                                        $voucher_amount
                                                    }

                                                    @endphp --}}
                                {{ $vouchers_value['voucher_amount'] }}
                            </div>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding: 8px;" colspan="2"></td>
                    </tr>

                </tbody>
            </table>
            <div style="line-height: 16px;padding: 15px;background: #fff;margin-top:15px"></div>
        @endforeach

       

    @endif
    </div>
    </div>
    </main>
    </div>
    </div>
    </section>
    </body>

</html>
