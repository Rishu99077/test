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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap" rel="stylesheet">

    <style>
        @page { margin: 0px; }
        body { margin: 0px;font-family: 'Poppins', sans-serif;} 
        table th, table td{vertical-align: middle;}  
    </style>
</head>
<body>
    @php 
        $return_transfer_check = 1;
        if($get_details_arr['return_transfer_check']){
            $return_transfer_check = 2;
        }
        $transfer_zones_adult_price = 0;
        $transfer_zones_child_price = 0;
        $transfer_zones_total_adult_price = 0;
        $transfer_zones_total_child_price = 0;

        if($get_details_arr['product_detail_arr']['transfer_zones']['adult_price'] > 0){
            $transfer_zones_adult_price       = $get_details_arr['product_detail_arr']['transfer_zones']['adult_price'] * $return_transfer_check;
            $transfer_zones_total_adult_price = $transfer_zones_adult_price * $get_details_arr['adult'];
        }

        if($get_details_arr['product_detail_arr']['transfer_zones']['child_price'] > 0){
            $transfer_zones_child_price       = $get_details_arr['product_detail_arr']['transfer_zones']['child_price'] * $return_transfer_check;
            $transfer_zones_total_child_price = $transfer_zones_child_price * $get_details_arr['child'];
        }

        $all_vouchers = [];
        if(isset($get_details_arr['product_detail_arr']['vouchers']) && $get_details_arr['product_detail_arr']['vouchers']){
            if(count($get_details_arr['product_detail_arr']['vouchers'])>0){
                foreach ($get_details_arr['product_detail_arr']['vouchers'] as $vouchers_key => $vouchers_value) {
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
    <section class='transfer_head_first trnsfer_order'>
        <div class='transfer_header_table'>
            <div class="container1">
                <main>
                    <div class="orderDetails">
                        <table style="width:100%; background-image: url('{{ asset('assets/img/header-slide.png') }}');background-repeat: no-repeat;background-size:cover;background-position: right;width: 100%;">
                            <tbody class="table_left">
                                <tr>
                                    <td colspan="2" style="padding:35px ;"></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;padding: 0 0px 0 15px;">
                                        <img style="width: 150px;" src="{{ asset('assets/img/tourlogo.png') }}" alt="" />
                                    </td>
                                    <td style="width:65%; text-align: right;" >
                                       <img style="width: 35%;float: right;margin: 0px 20px;" src="{{ asset('assets/img/tourlogo.png') }}" alt="" /> 
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="2" style="padding:30px ;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 0 0px 0px 15px; width:35%;font-size: 14px;color:#828282; font-weight: 400;">Booking reference : <span style="color: #232a35;font-size: 14px;font-weight: 500;">IGLU-H295d7bFA </span> </td>
                                    <!-- <td style="padding: 0px 15px 0px 0px;width:65%;color: #232a35;font-size: 14px;font-weight: 500;"></td> -->
                                </tr>
                                <tr>
                                    <td colspan="2" style="width:35%;font-size: 14px;color:#828282; font-weight: 400;padding: 0 0px 0 15px;">Supplier reference : <span style="color: #232a35;font-size: 14px;font-weight: 500;">IGLU-16133411 </span> </td>
                                    <!-- <td style="padding: 0px 15px 0px 0px;width:65%; color: #232a35;font-size: 14px;font-weight: 500;"></td> -->
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:5px ;"></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="2" style="padding: 0 0px 0 15px;font-size: 14px;margin-bottom: 0;">
                                       <b>Please Read the</b> <a href="#"> Frequently asked Question</a> and the <a href="#">Terms & Condition</a> before you travel.
                                    </td>
                                </tr> --}}
                                {{-- <tr>
                                  <td colspan="2" style="padding: 0 0px 0px 15px;font-size: 14px;">his voucher is to be presented to your suppliers representative fe EC</td>
                                </tr> --}}
                                <tr>
                                    <td colspan="2" style="padding:10px;"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="width:100%;vertical-align: middle;">
                            <tbody>
                                <tr>
                                    <td style="width: 25%;padding: 0 0px 5px 15px; ">
                                        <img  src="{{ $get_details_arr['product_detail']->car_image }}" style="width:100%;vertical-align: text-top;" alt="Sheep">
                                    </td>

                                    <td style="width: 55%; padding: 0 15px;">
                                        <table>
                                            <tbody>

                                                <tr>
                                                    <td colspan="2" style="color: #232a35;font-size: 14px;font-weight: 500;line-height: 1px;">
                                                        {{ $get_details_arr['order_id'] }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="color: #232a35;font-size: 14px;font-weight: 500;line-height: 15px;padding-bottom: 10px;">
                                                        {{ $get_details_arr['product_detail']->title }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    @if ($get_details_arr['product_detail']->passengers != '')
                                                        <td style="width:50%;padding-bottom: 10px;padding-right: 5px; color: #232a35;font-size: 14px;font-weight: 500;line-height: 12px;">
                                                            <img style="width: 20px; padding-right: 5px;" src="{{ asset('assets/img/passenger.096059495b02334231bb.png') }}" alt="">{{ translate('Up to') }}  {{ $get_details_arr['product_detail']->passengers }} {{ translate('passengers') }}
                                                        </td>
                                                    @endif

                                                    @if ($get_details_arr['product_detail']->luggage_allowed != '')
                                                        <td style="width:50%;padding-bottom: 10px;padding-right: 5px; color: #232a35;font-size: 14px;font-weight: 500;line-height: 12px;" >
                                                            <img style="width: 20px; padding-right: 5px;" src="{{ asset('assets/img/suitcase.58cac4198078c19f4184.png') }}" alt="">
                                                            {{ $get_details_arr['product_detail']->luggage_allowed }}
                                                        </td>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    @if ($get_details_arr['product_detail']->meet_greet != '' && $get_details_arr['product_detail']->meet_greet > 0)
                                                        <td style="width:50%;padding-bottom: 10px;padding-right: 5px; color: #232a35;font-size: 14px;font-weight: 500;line-height: 12px;">
                                                            <img style="width: 20px; padding-right: 5px;" src="{{ asset('assets/img/handshake.png') }}" alt="">
                                                            {{ translate('Meet & Greet') }}
                                                        </td>
                                                    @endif


                                                    @if ( $get_details_arr['product_detail']->product_type != 'bus' ?? $get_details_arr['product_detail']->product_bookable != 0)
                                                        <td style="width:50%;padding-bottom: 10px;padding-right: 5px; color: #232a35;font-size: 14px;font-weight: 500;line-height: 12px;">
                                                            <img style="width:20px;padding-right: 5px;" src="{{ asset('assets/img/door-to-door.png') }}" alt="">
                                                            {{ translate('Door-to-Door') }}
                                                        </td> 
                                                    @endif
                                                </tr>

                                                <tr>
                                                    @if ($get_details_arr['product_detail']->journey_time != '')
                                                        <td style="color: #6b6b6b;font-size: 14px;font-weight: 500;" colspan="2">
                                                            <span style=""></span>{{ $get_details_arr['product_detail']->journey_time }}
                                                        </td> 
                                                    @endif
                                                </tr> 

                                            </tbody>
                                        </table>
                                    </td>

                                    <td style="padding: 0 15px; width: 20%;color: #6b6b6b;font-size: 14px;font-weight: 500;border-left: 1px solid #232a356e;">
                                        <table>
                                            <tbody>

                                                @if ($get_details_arr['adult'] > 0)
                                                    <tr>
                                                        <td style="color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;padding-bottom: 5px;">
                                                            <img style="width: 20px;height: 20px; padding-right: 5px;" src="{{ asset('assets/img/adult.png') }}" alt="">
                                                             {{ translate('Adults') }} ({{ $get_details_arr['adult'] }})
                                                        </td> 
                                                    </tr>
                                                @endif

                                                @if ($get_details_arr['child'] > 0)
                                                    <tr>
                                                        <td style="color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;padding-bottom: 5px;">
                                                            <img style="width: 20px;height: 20px; padding-right: 5px;" src="{{ asset('assets/img/kids.png') }}" alt="">
                                                            {{ translate('Children') }} ({{ $get_details_arr['child'] }})
                                                        </td> 
                                                    </tr> 
                                                @endif

                                                @if ($get_details_arr['infant'] > 0)
                                                    <tr class="">
                                                        <td style="color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;padding-bottom: 5px;">
                                                            <img style="width: 20px;height: 20px; padding-right: 5px;" src="{{ asset('assets/img/kids.png') }}" alt="">
                                                            {{ translate('Infant') }} ({{ $get_details_arr['infant'] }})
                                                        </td> 
                                                    </tr> 
                                                @endif

                                                @if ($get_details_arr['infant'] != '') 
                                                    <tr class="">
                                                        <td style="color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;padding-bottom: 5px;">
                                                            <img style="width: 20px;height: 20px; padding-right: 5px;" src="{{ asset('assets/img/cars.png') }}" alt="" />
                                                            {{ translate('Vehicle') }} ({{ $get_details_arr['number_of_vehical'] }})
                                                        </td> 
                                                    </tr> 
                                                @endif

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="padding: 0 15px;">
                            {{-- --------------- Transfer Option Start------ --}}
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="2"
                                            style="color: #232a35; padding: 10px 10px 10px 0px; font-size: 14px;font-weight: 500;">{{ translate('Transfer Option') }}</th>
                                    </tr>
                                </thead>
                                @if ($get_details_arr['product_detail']->product_type == 'bus')
                                <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;"> 
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0 0px 0px 15px;width:25%;font-size: 14px;color:#baad85; font-weight: 500;">{{ translate('Adult') }}
                                        </td>
                                        <td
                                            style="text-align: center; padding-right: 15px;width:25%; color: #61728d;font-size: 14px;font-weight: 400;">
                                            {{ $get_details_arr['adult'] }} x {{ $get_details_arr['currency'] }} {{ $transfer_zones_adult_price }}</td>
                                        <td
                                            style="text-align: center; padding-right: 15px;width:25%; color: #61728d;font-size: 14px;font-weight: 400;">{{ $get_details_arr['return_transfer_check'] != '' ? 'Return Transfer' : 'One way' }}</td>
                                        <td
                                            style="text-align: right; padding-right: 15px;width:25%; color: #232a35;font-size: 14px;font-weight: 400;">
                                            <span style="color: #baad85;">{{ $get_details_arr['currency'] }}</span> {{ $transfer_zones_total_adult_price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" padding: 0 0px 0px 15px;width:25%;font-size: 14px;color:#baad85; font-weight: 500;">
                                            Child</td>
                                        <td
                                            style="text-align:center; padding-right: 15px;width:25%; color: #61728d;font-size: 14px;font-weight: 400;">
                                            {{ $get_details_arr['child'] }} x  {{ $get_details_arr['currency'] }} {{ $transfer_zones_child_price }}</td>
                                        <td
                                            style="text-align:center;padding-right: 15px;width:25%; color: #61728d;font-size: 14px;font-weight: 400;">
                                            {{ $get_details_arr['return_transfer_check'] != '' ? 'Return Transfer' : 'One way' }}</td>
                                        <td
                                            style="text-align:right; padding-right: 15px;width:25%; color: #232a35;font-size: 14px;font-weight: 400;">
                                            <span style="color: #baad85;">{{ $get_details_arr['currency'] }}</span> {{ $transfer_zones_total_child_price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding: 0 0px 0px 15px">
                                            <hr
                                                style="border-top: 0;height: 0;border-bottom: 1px solid #6b6b6ba1;margin-bottom:10px;margin-top:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                </tbody>
                                @else
                                <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;">
                                    <tr>
                                        <td colspan="4" style="padding:5px ;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  style="padding: 0 0px 0px 15px;width:25%;font-size: 14px; font-weight: 500;">
                                            <span>{{ $get_details_arr['currency'] }}</span>
                                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']))
                                                                {{ $get_details_arr['product_detail_arr']['transfer_zones']['price'] }}
                                                            @endif
                                        </td>
                                        <td style="padding: 0 0px 0px 15px;width:25%;font-size: 14px;color:#baad85; font-weight: 500;">{{ translate('Number Of Vehicle ') }} : {{ $get_details_arr['number_of_vehical'] }}
                                        </td>
                                        
                                        <td
                                            style="text-align: center; padding-right: 15px;width:25%; color: #61728d;font-size: 14px;font-weight: 400;">{{ $get_details_arr['return_transfer_check'] != '' ? 'Return Transfer' : 'One way' }}</td>
                                        <td
                                            style="text-align: right; padding-right: 15px;width:25%; color: #232a35;font-size: 14px;font-weight: 400;">
                                            <span style="color: #baad85;">{{ $get_details_arr['currency'] }}</>
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']) &&
                                                    isset($get_details_arr['product_detail_arr']['transfer_zones']['transfer_total']))
                                            {{ number_format($get_details_arr['product_detail_arr']['transfer_zones']['transfer_total']) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding: 0 0px 0px 15px">
                                            <hr
                                                style="border-top: 0;height: 0;border-bottom: 1px solid #6b6b6ba1;margin-bottom:10px;margin-top:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                </tbody> 
                                @endif
                               
                            </table>
                            {{-- --------------- Transfer Option End------ --}}

                            {{-- --------------- Parking Fees On Arrival Start ------ --}}
                            @if (isset($get_details_arr['product_detail_arr']) &&
                                    isset($get_details_arr['product_detail_arr']['transfer_zones']) &&
                                    isset($get_details_arr['product_detail_arr']['transfer_zones']['airport_parking_fee']) &&
                                    $get_details_arr['product_detail_arr']['transfer_zones']['airport_parking_fee'] > 0)
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="color: #232a35; padding: 10px 10px 10px 0px; font-size: 14px;font-weight: 500;">
                                            {{ translate('Parking Fees On Arrival') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;">
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0 0px 0px 15px;width:25%;font-size: 14px;color:#232a35; font-weight: 500;"><span
                                                style="color: #baad85;">{{ $get_details_arr['currency'] }}</span> 
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']['total_parking_fee']))
                                                {{ $get_details_arr['product_detail_arr']['transfer_zones']['total_parking_fee'] }}
                                            @endif</td>
                                        <td colspan="2"
                                            style="text-align: center; padding-right: 15px;width:50%; color: #61728d;font-size: 14px;font-weight: 400;">
                                            {{ translate('Number Of Vehicle') }} : 1
                                        </td>
                                        <td
                                            style="text-align: right; padding-right: 15px;width:25%; color: #232a35;font-size: 14px;font-weight: 400;">
                                            <span style="color: #baad85;">{{ $get_details_arr['currency'] }}</span>
                                            @if (isset($get_details_arr['product_detail_arr']['transfer_zones']['parking_total']))
                                                {{ $get_details_arr['product_detail_arr']['transfer_zones']['parking_total'] }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding: 0 15px 0px 15px">
                                            <hr
                                                style="border-top: 0;height: 0;border-bottom: 1px solid #6b6b6ba1;margin-bottom:10px;margin-top:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                            {{-- --------------- Parking Fees On Arrival End ------ --}}

                            {{-- --------------- Extra options Start ------ --}}
                            @if (isset($get_details_arr['product_detail_arr']) &&
                                    isset($get_details_arr['product_detail_arr']['transfer_option']) &&
                                    isset($get_details_arr['product_detail_arr']['transfer_option']['options']))
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="2"
                                            style="color: #232a35; padding: 10px 10px 10px 0px; font-size: 14px;font-weight: 500;">{{ translate('Extras') }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;">
                                    @php 
                                    $extra_options = [];
                                    if(isset($get_details_arr['product_detail_arr']['transfer_option']['options'])){
                                        $extra_options = $get_details_arr['product_detail_arr']['transfer_option']['options'];
                                    }                             
                                    @endphp
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                    @if (count($extra_options) > 0)
                                    @foreach ($extra_options as $key => $extra_option_value)
                                            <tr>
                                                <td colspan="4" style="padding: 0 0px 0px 15px;font-size: 14px;font-weight: 500;color: #232a35;">{{ $extra_option_value['title'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0 0px 5px 15px;width:25%;font-size: 14px;color:#828282; font-weight: 400;">{!! $extra_option_value['description'] !!}</td>
                                                <td colspan="1"
                                                    style="text-align: center; padding-right: 15px;width:50%; color: #61728d;font-size: 14px;font-weight: 400;">
                                                    {{ $extra_option_value['user_arrival'] == '1' ? 'Arrival' : '' }}
                                                </td>
                                                <td colspan="1"
                                                style="text-align: center; padding-right: 15px;width:50%; color: #61728d;font-size: 14px;font-weight: 400;">
                                                    {{ $extra_option_value['user_departure'] == '1' ? 'Departure' : '' }}
                                                </td>
                                                <td
                                                    style="text-align: right; padding-right: 15px;width:25%; color: #232a35;font-size: 14px;font-weight: 400;">
                                                    @if ($extra_option_value['total_price'])
                                                        <span>
                                                            {{ $get_details_arr['currency'] }}
                                                        </span>
                                                            {{ $extra_option_value['total_price'] }}
                                                    @else
                                                        Free
                                                    @endif
                                                </td>
                                            </tr> @endforeach
                                    @endif                
                                    <tr>
                                        <td colspan="4" style="padding: 0 15px 0px 15px">
                                            <hr style="border-top: 0;height: 0;border-bottom: 1px solid #6b6b6ba1;margin-bottom:10px;margin-top:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif

                            {{-- --------------- Extra options End ------ --}}


                            {{-- --------------- Extra Needs Start ------ --}}
                            @if (isset($get_details_arr['product_detail_arr']) &&
                                    isset($get_details_arr['product_detail_arr']['transfer_needs']) &&
                                    isset($get_details_arr['product_detail_arr']['transfer_needs']['option']))
                                <table style="width:100%;">
                                    <tbody class="table_left" style="background: #f7f7f7;border-radius: 4px;padding: 12px;">

                                        <tr>
                                            <td colspan="4"
                                                style="background-color: #fff; color: #232a35; padding: 10px 10px 10px 0px; font-size: 14px;font-weight: 500;">
                                                {{ translate('Extras Needs') }}</td>
                                        </tr>

                                        @if (isset($get_details_arr['product_detail_arr']['transfer_needs']['option']))
                                            @php
                                                $transfer_needs_option = [];
                                                if (isset($get_details_arr['product_detail_arr']['transfer_needs']['option'])) {
                                                    $transfer_needs_option = $get_details_arr['product_detail_arr']['transfer_needs']['option'];
                                                }
                                            @endphp
                                        @endif

                                        @foreach ($transfer_needs_option as $key => $transfer_needs_option_value)
                                            <tr>
                                                <td style="padding: 0 0px 0px 15px;width:40%;font-size: 14px;color:#232a35; font-weight: 500;">
                                                    <h6>{{ $transfer_needs_option_value['title'] }}</h6>
                                                </td>
                                                <td
                                                    style="text-align: center; padding-right: 15px;width:10%; color: #61728d;font-size: 14px;font-weight: 500;">
                                                    {{ translate('Child') }}<br>
                                                    {{ $transfer_needs_option_value['adult_price'] }} x
                                                    {{ $transfer_needs_option_value['adult_qty'] }}
                                                </td>
                                                <td
                                                    style="text-align: center; padding-right: 15px;width:10%; color: #61728d;font-size: 14px;font-weight: 500;">
                                                    {{ translate('Child') }}<br>
                                                    {{ $transfer_needs_option_value['child_price'] }} x
                                                    {{ $transfer_needs_option_value['child_qty'] }}
                                                </td>
                                                <td
                                                    style="text-align: center; padding-right: 15px;width:10%; color: #61728d;font-size: 14px;font-weight: 500;">
                                                    {{ $transfer_needs_option_value['is_outward'] == '1' ? 'Departure' : '' }}
                                                </td>
                                                <td
                                                    style="text-align: center; padding-right: 15px;width:10%; color: #61728d;font-size: 14px;font-weight: 500;">
                                                    {{ $transfer_needs_option_value['is_return'] == '1' ? 'Arrival' : '' }}
                                                </td>

                                                <td
                                                    style="text-align: right; padding-right: 15px;width:40%; color: #232a35;font-size: 14px;font-weight: 400;">
                                                    <span style="color: #baad85;">{{ $get_details_arr['currency'] }}
                                                    </span>{{ $transfer_needs_option_value['total'] }}
                                                </td>
                                            </tr>
                                        @endforeach


                                        <tr>
                                            <td colspan="6" style="padding: 0 15px 0px 15px">
                                                <hr
                                                    style="border-top: 0;height: 0;border-bottom: 1px solid #6b6b6ba1;margin-bottom:10px;margin-top:10px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="padding:5px ;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                            {{-- --------------- Extra Needs End ------ --}}


                            {{-- --------------- Tax & Service Charge Start------ --}}
                            <table style="width:100%;">

                                <tbody style="background: #f7f7f7;border-radius: 4px;padding: 12px;">
                                    <tr>
                                        <td colspan="4"
                                            style="background-color: #fff; color: #232a35; padding: 10px 10px 10px 0px; font-size: 14px;font-weight: 500;">
                                            {{ translate('Tax & Service Charge') }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                    @if (isset($get_details_arr['product_detail_arr']['tax_allowed']) &&
                                            $get_details_arr['product_detail_arr']['tax_allowed'] > 0)

                                        <tr>
                                            <td style="padding: 0 0px 0px 15px;width:50%;font-size: 14px;color:#232a35; font-weight: 500;">Tax
                                                ({{ $get_details_arr['product_detail_arr']['tax_percentage'] }} %)</td>
                                            <td
                                                style="text-align: right; padding-right: 15px;width:50%; color: #232a35;font-size: 14px;font-weight: 400;">
                                                <span style="color: #baad85;">{{ $get_details_arr['currency'] }}</span>
                                                {{ $get_details_arr['product_detail_arr']['tax_amount'] }}
                                            </td>
                                        </tr>
                                    @endif


                                    @if (isset($get_details_arr['product_detail_arr']['service_allowed']) &&
                                            $get_details_arr['product_detail_arr']['service_allowed'] > 0)
                                        <tr>
                                            <td style="padding: 0 0px 0px 15px;width:50%;font-size: 14px;color:#232a35; font-weight: 500;">
                                                {{ translate('Service Charge') }}</td>
                                            <td
                                                style="text-align: right; padding-right: 15px;width:50%; color: #232a35;font-size: 14px;font-weight: 400;">
                                                <span style="color: #baad85;">{{ $get_details_arr['currency'] }}</span>
                                                {{ $get_details_arr['product_detail_arr']['service_amount'] }}
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- --------------- Tax & Service Charge End------ --}}


                            {{-- --------------- INformation ------ --}}
                            <table style="width:100%;">
                                <tbody class="table_left" style="background: #fffff;border-radius: 4px;padding: 12px;">
                                    <tr>
                                        <td colspan="4" style="padding:5px ;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0px 0px 0px 15px;width:50%;font-size: 14px;color:#727272; font-weight: 400;">
                                            <span class="userIcon"><svg width="18px" aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="user" class="svg-inline--fa fa-user " role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path fill="currentColor"
                                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                                                    </path>
                                                </svg></span>{{ translate('Lead Passenger') }}
                                        </td>
                                        <td style="text-align: center;width:50%; color: #727272;font-size: 14px;font-weight: 400;">
                                            <span class="userIcon transfer_phn_icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                    <g id="Group_3035" data-name="Group 3035" transform="translate(-1172 -1554)">
                                                        <g id="Rectangle_1825" data-name="Rectangle 1825" transform="translate(1172 1554)"
                                                            fill="none" stroke="#707070" strokeWidth="1" opacity="0">
                                                            <rect width="20" height="20" stroke="none" />
                                                            <rect x="0.5" y="0.5" width="19" height="19" fill="none" />
                                                        </g>
                                                        <path id="phone"
                                                            d="M15.779,13.305l-2.256,2.238a1.632,1.632,0,0,1-1.2.458,10.434,10.434,0,0,1-5.173-1.949A19.954,19.954,0,0,1,1.107,7.465,8.522,8.522,0,0,1,0,3.71,1.643,1.643,0,0,1,.462,2.489L2.718.234a.746.746,0,0,1,1.221.2L5.754,3.879a1,1,0,0,1-.2,1.136l-.831.831a.41.41,0,0,0-.085.237A7.085,7.085,0,0,0,6.771,9.237c.853.783,1.77,1.843,2.96,2.094a.469.469,0,0,0,.432-.042l.967-.983a1.1,1.1,0,0,1,1.17-.169h.017l3.274,1.933a.788.788,0,0,1,.187,1.237Z"
                                                            transform="translate(1174 1556)" fill="#919191" />
                                                    </g>
                                                </svg>
                                            </span> {{ translate('Telephone Number') }}
                                        </td>
                                        <td
                                            style="text-align: right; padding-right: 15px;width:50%;font-size: 14px;color:#727272; font-weight: 400;">
                                            <span class="userIcon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                    <g id="Group_3036" data-name="Group 3036" transform="translate(-1172 -1554)">
                                                        <g id="Rectangle_1825" data-name="Rectangle 1825" transform="translate(1172 1554)"
                                                            fill="none" stroke="#707070" strokeWidth="1" opacity="0">
                                                            <rect width="20" height="20" stroke="none" />
                                                            <rect x="0.5" y="0.5" width="19" height="19"
                                                                fill="none" />
                                                        </g>
                                                        <path id="email"
                                                            d="M14.389,1.75a1.579,1.579,0,0,1,1.143.455A1.486,1.486,0,0,1,16,3.315V12.63a1.488,1.488,0,0,1-.469,1.11,1.579,1.579,0,0,1-1.143.455H1.611a1.579,1.579,0,0,1-1.143-.455A1.486,1.486,0,0,1,0,12.63V3.315A1.488,1.488,0,0,1,.469,2.2,1.577,1.577,0,0,1,1.611,1.75Zm0,3.129V3.315L7.981,7.208,1.611,3.315V4.879l6.37,3.857Z"
                                                            transform="translate(1174 1556.028)" fill="#919191" />
                                                    </g>
                                                </svg>
                                            </span>{{ translate('Email Address') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="padding: 0px 0px 0px 15px;width:50%; color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;">
                                            {{ $get_details_arr['name_title'] }} {{ $get_details_arr['first_name'] }}
                                            {{ $get_details_arr['last_name'] }}
                                        </td>
                                        <td
                                            style="text-align: center; width:50%; color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;">
                                            {{ $get_details_arr['phone_code'] }} {{ $get_details_arr['phone_number'] }}
                                        </td>
                                        <td
                                            style="text-align: right; padding-right: 15px;width:50%; color: #232a35;font-size: 14px;font-weight: 500;line-height: 10px;">
                                            {{ $get_details_arr['email'] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4" style="padding:10px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- --------------- INformation End ------ --}}


                            {{-- --------------- Arrival Departure Start ------ --}}
                            <table style="width:100%;">
                                <tbody>

                                    <tr>
                                        <td
                                            style="width: 49%;background: #f6f7f8;border-radius: 4px;padding: 0 15px; color: #232a35;font-size: 18px;font-weight: 500;">
                                            {{ translate('Arrival') }}
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="padding: 0 5px 10px 5px;border-bottom: 1px solid #232a35; height: 0;border-top: 0;margin-bottom: 10px;">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0px 15px;color: #232a35;font-size: 18px;font-weight: 500;">
                                                {{ translate('Departure') }}
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="padding: 0 5px 10px 5px;border-bottom: 1px solid #232a35; height: 0;border-top: 0;margin-bottom: 10px;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        @endif
                                    </tr>

                                    <tr>
                                        @if ($get_details_arr['airport_name'] != '')
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px; color: #232a35;font-size: 14px;">
                                                <ul style="display: flex;padding:0px;margin: 0px;line-height: 15px;">
                                                    <li>
                                                        <span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                style="filter: brightness(.8);"
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAYlJREFUSEvtlk9KxDAUxqd4CT2AR3AlNm1c6Alcu9KNJxBL+odZ2K0H0Bu4KNLFSDuCLlS6cetKLyEiVL8HU0hDa1IndDM+KKVJXn5838sLdSYjhzMyb/IPJMedMAwFntCG/b9a6vs+K4piTqA5At/+slBtDcuyvPA878QWVAsk0DeiUbasUiMgyncmhEhkaJqm+3mefw612Ai4UHmP97YEeOecH8DyxyFQYyDq6GHzUt2cDhLZ3IxHURS4rruG5WJR9xJLeDNvDKQEAhJYhQISwfJjjK93qXUQvcAkSTaDIHjtSmSMbUHM0xAL1UPWUtgoUBdR00PYBoBHJjDKv0Ngvxu8nuWcFlBt9C77eoAvcPWaQHI9O+1VB5FwCSWHOiVUt7quP+I4Ptet7VXYTMiNLvXeFex5y7JsWlXV1xCIFkg1g0pGdUDMUIuHvwLUvEFtYQO6YkCUjuPG2LNhnXTVzbDvbedNA9gpJqeWgZH8t9CqIQ7mDpp/1yZQvQxW7NDYtLJvr9Et/QFFBb4djeA0jwAAAABJRU5ErkJggg=="
                                                                alt="" /></span>
                                                    </li>
                                                    <li>
                                                        <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                            {{ translate('Arrival') }}
                                                        </p>
                                                        <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                            {{ $get_details_arr['airport_name'] }}</p>
                                                    </li>
                                                </ul>
                                            </td>
                                        @endif
                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            @if (isset($get_details_arr['drop_off_point']) && $get_details_arr['drop_off_point'] != '')
                                                <td
                                                    style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px;color: #232a35;font-size: 14px;line-height: 15px;">
                                                    <ul style="display: flex;padding:0px;margin: 0px;">
                                                        <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                    style="filter: brightness(.8);"
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAbBJREFUSEvdlu1NwzAQhusJYAPCBJQJKBNQJiAbFCagnQCYgDIB7QSkG7QbhA1ggvC+ko3C9c6+8KNCnBRZdc73+D7TMDqwhAPzRn8b2HVdhYic4RnHyGyx7kIIrTdSLg8BmsDgPR6umjTYXADMNStFIGDzCCvZ4vs5oIucYhYI2CMOzzykns4ToLfWGRMI2BSHXgfCkvo1oCvtbA7IQjgxgLu4zwLSpAXw1A3MeEfQNFVlrFp6ooEvtSJSPTQK5ROGKxj56N8cusf4zWgcCY9YtSy4H2IBeesrofsCA7UWJkCX2L8R79bQZx24gA20LoSuWX1GNQ8CMhRs9L5sceNzw0NOHJnHQSGdwMCbYvwOUPbmt8A79tyDousvGh6GoRaL1hbMb+ox5mgvT9h7x8UqLRq5PrRurtmRe3uRSAql0WZ5mYOa3vFQCfib8WaOtSIw5rLBKlvE8nCD3LHgTPF8nph8lr2cJNIoJ9G49DEuAqOXNdbnQrVkQ+kqmj4AbaKNu6SiTpVBbSGV45BeYl/O2DX2ajnUrWi4Qio85R+o1OwrgJhftwwGui0biv8f+AVUR5Ud6uxQngAAAABJRU5ErkJggg=="
                                                                    alt=""></span></li>
                                                        <li>
                                                            <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                                {{ translate('Departure') }}
                                                            </p>
                                                            <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                                {{ $get_details_arr['drop_off_point'] }}</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                    <tr>
                                        @if ($get_details_arr['drop_off_point'] != '')
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px; color: #232a35;font-size: 14px;line-height: 15px;">
                                                <ul style="display: flex;padding:0px;margin: 0px;">
                                                    <li><span style="margin-right: 16px;padding-bottom: 15px !important;"> <img
                                                                style="filter: brightness(.8);"
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAbBJREFUSEvdlu1NwzAQhusJYAPCBJQJKBNQJiAbFCagnQCYgDIB7QSkG7QbhA1ggvC+ko3C9c6+8KNCnBRZdc73+D7TMDqwhAPzRn8b2HVdhYic4RnHyGyx7kIIrTdSLg8BmsDgPR6umjTYXADMNStFIGDzCCvZ4vs5oIucYhYI2CMOzzykns4ToLfWGRMI2BSHXgfCkvo1oCvtbA7IQjgxgLu4zwLSpAXw1A3MeEfQNFVlrFp6ooEvtSJSPTQK5ROGKxj56N8cusf4zWgcCY9YtSy4H2IBeesrofsCA7UWJkCX2L8R79bQZx24gA20LoSuWX1GNQ8CMhRs9L5sceNzw0NOHJnHQSGdwMCbYvwOUPbmt8A79tyDousvGh6GoRaL1hbMb+ox5mgvT9h7x8UqLRq5PrRurtmRe3uRSAql0WZ5mYOa3vFQCfib8WaOtSIw5rLBKlvE8nCD3LHgTPF8nph8lr2cJNIoJ9G49DEuAqOXNdbnQrVkQ+kqmj4AbaKNu6SiTpVBbSGV45BeYl/O2DX2ajnUrWi4Qio85R+o1OwrgJhftwwGui0biv8f+AVUR5Ud6uxQngAAAABJRU5ErkJggg=="
                                                                alt=""></span></li>
                                                    <li>
                                                        <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">To</p>
                                                        <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                            {{ $get_details_arr['drop_off_point'] }}</p>
                                                    </li>
                                                </ul>
                                            </td>
                                        @endif
                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            @if (isset($get_details_arr['airport_name']) && $get_details_arr['airport_name'] != '')
                                                <td
                                                    style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px;color: #232a35;font-size: 14px;line-height: 15px;">
                                                    <ul style="display: flex;padding:0px;margin: 0px;">
                                                        <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                    style="filter: brightness(.8);"
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAABHNCSVQICAgIfAhkiAAAAYlJREFUSEvtlk9KxDAUxqd4CT2AR3AlNm1c6Alcu9KNJxBL+odZ2K0H0Bu4KNLFSDuCLlS6cetKLyEiVL8HU0hDa1IndDM+KKVJXn5838sLdSYjhzMyb/IPJMedMAwFntCG/b9a6vs+K4piTqA5At/+slBtDcuyvPA878QWVAsk0DeiUbasUiMgyncmhEhkaJqm+3mefw612Ai4UHmP97YEeOecH8DyxyFQYyDq6GHzUt2cDhLZ3IxHURS4rruG5WJR9xJLeDNvDKQEAhJYhQISwfJjjK93qXUQvcAkSTaDIHjtSmSMbUHM0xAL1UPWUtgoUBdR00PYBoBHJjDKv0Ngvxu8nuWcFlBt9C77eoAvcPWaQHI9O+1VB5FwCSWHOiVUt7quP+I4Ptet7VXYTMiNLvXeFex5y7JsWlXV1xCIFkg1g0pGdUDMUIuHvwLUvEFtYQO6YkCUjuPG2LNhnXTVzbDvbedNA9gpJqeWgZH8t9CqIQ7mDpp/1yZQvQxW7NDYtLJvr9Et/QFFBb4djeA0jwAAAABJRU5ErkJggg=="
                                                                    alt=""></span></li>
                                                        <li>
                                                            <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">To</p>
                                                            <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                                {{ $get_details_arr['airport_name'] }}</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>

                                    <tr>
                                        @if (isset($get_details_arr['airport_name']) && $get_details_arr['airport_name'] != '')
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px; color: #232a35;font-size: 14px;line-height: 15px;">
                                                <ul style="display: flex;padding:0px;margin: 0px;">
                                                    <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                style="filter: brightness(.8);"
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt=""></span></li>
                                                    <li>
                                                        <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                            {{ translate('Flight Number') }}
                                                        </p>
                                                        <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                            {{ $get_details_arr['flight_number'] }}</p>
                                                    </li>
                                                </ul>
                                            </td>
                                        @endif

                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            @if (isset($get_details_arr['departure_flight_number']) && $get_details_arr['departure_flight_number'] != '')
                                                <td
                                                    style="width: 49%;background: #f6f7f8;border-radius: 4px;padding: 015px;color: #232a35;font-size: 14px;line-height: 15px;">
                                                    <ul style="display: flex;padding:0px;margin: 0px;">
                                                        <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                    style="filter: brightness(.8);"
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt=""></span></li>
                                                        <li>
                                                            <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                                {{ translate('Departure Flight Number') }}
                                                            </p>
                                                            <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                                {{ $get_details_arr['departure_flight_number'] }}</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>

                                    <tr>
                                        @if ($get_details_arr['country_name'] != '')
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px; color: #232a35;font-size: 14px;line-height: 15px;">
                                                <ul style="display: flex;padding:0px;margin: 0px;">
                                                    <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                style="filter: brightness(.8);"
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt=""></span></li>
                                                    <li>
                                                        <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                            {{ translate('Flight Originated from') }}
                                                        </p>
                                                        <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                            {{ $get_details_arr['country_name'] }}</p>
                                                    </li>
                                                </ul>
                                            </td>
                                        @endif


                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            @if (isset($get_details_arr['departure_country']) && $get_details_arr['departure_country'] != '')
                                                <td
                                                    style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px;color: #232a35;font-size: 14px;line-height: 15px;">
                                                    <ul style="display: flex;padding:0px;margin: 0px;">
                                                        <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                    style="filter: brightness(.8);"
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt=""></span></li>
                                                        <li>
                                                            <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                                {{ translate('Flight Depart to ') }}
                                                            </p>
                                                            <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                                {{ $get_details_arr['departure_country'] }}</p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                    <tr>
                                        @if ($get_details_arr['flight_arrival_time'] != '')
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px; color: #232a35;font-size: 14px;line-height: 15px;">
                                                <ul style="display: flex;padding:0px;margin: 0px;">
                                                    <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                style="filter: brightness(.8);"
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt=""></span></li>
                                                    <li>
                                                        <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                            {{ translate('Flight Arrival Date') }} </p>
                                                        <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                            {{ $get_details_arr['flight_arrival_time'] }}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </td>
                                        @endif

                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            @if (isset($get_details_arr['flight_departure_time']) && $get_details_arr['flight_departure_time'] != '')

                                                <td
                                                    style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px;color: #232a35;font-size: 14px;line-height: 15px;">
                                                    <ul style="display: flex;padding:0px;margin: 0px;">
                                                        <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                    style="filter: brightness(.8);"
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt=""></span></li>
                                                        <li>
                                                            <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                                {{ translate('Flight Departure Date') }}</p>
                                                            <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: 0;">
                                                                {{ date('Y-d-m', strtotime($get_details_arr['flight_departure_time'])) }}
                                                                [{{ date('l d,m', strtotime($get_details_arr['flight_departure_time'])) }}]
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                    <tr>
                                        @if (isset($get_details_arr['flight_arrival_time']) && $get_details_arr['flight_arrival_time'] != '')
                                            <td
                                                style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px; color: #232a35;font-size: 14px;line-height: 15px;">
                                                <ul style="display: flex;padding:0px;margin: 0px;">
                                                    <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                style="filter: brightness(.8);"
                                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                alt=""></span></li>
                                                    <li>
                                                        <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                            {{ translate('Flight Arrival Date') }}</p>
                                                        <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: ;">
                                                            {{ date('h:m', strtotime($get_details_arr['flight_arrival_time'])) }}
                                                            [{{ date('h:m A', strtotime($get_details_arr['flight_arrival_time'])) }}]
                                                        </p>
                                                    </li>
                                                </ul>
                                            </td>
                                        @endif
                                        <td style="width: 2%;background: #fff;"></td>
                                        @if (isset($get_details_arr['return_transfer_check']) && $get_details_arr['return_transfer_check'] == 1)
                                            @if (isset($get_details_arr['flight_departure_time']) && $get_details_arr['flight_departure_time'] != '')
                                                <td
                                                    style="width: 49%;background: #f6f7f8;border-radius: 4px;padding:0 15px;color: #232a35;font-size: 14px;line-height: 15px;">
                                                    <ul style="display: flex;padding:0px;margin: 0px;">
                                                        <li><span style="margin-right: 16px;padding-bottom: 15px !important;"><img
                                                                    style="filter: brightness(.8);"
                                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAATtJREFUSEvllcuNwjAURXGymWUWFJAOSAcDJdABFSRQwUwHmaQBoBIoATpgyW4oYBLPMXKQYoxRfmKBJSuS/fzO+1zHYjTwEAP7H70OkOf5UmUXx/GPK0tlJ6UMkyS52pujlkGapqHv+ylGAYfGfP+EEBcXALsAmw9szsxLURQrxqk6UwNkWbZn47NLX4DtyXr2CCC7OK/OUq5b4GYGCrBl3lJsAfxyAsqynFFDVapWgzLLNwdoKa+R45xS3km4lxLhZEODJrpfNUgjANFG+uLdNZwLNmXxYEKaAkLP8xYWOQWsJUrSKKa23whg0ylZBUB37B1N58q+L8AS59+2ADoDnt2+QQG6fL+um6z+QWuUkdk07opeO1eNnwOIKlvzPYho4FXjz0rxYP9IcAuCO1gBLZ06j73uTe4rm38FgvAZqBBsVAAAAABJRU5ErkJggg=="
                                                                    alt=""></span></li>
                                                        <li>
                                                            <p style="color: #727272;font-size: 14px;font-weight: 400;margin-bottom: 0;">
                                                                {{ translate('Flight Departure Date') }}</p>
                                                            <p style="color: #232a35;font-size: 14px;font-weight: 500;margin-bottom: ;">
                                                                {{ date('h:m', strtotime($get_details_arr['flight_departure_time'])) }}
                                                                [{{ date('h:m A', strtotime($get_details_arr['flight_departure_time'])) }}]
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>

                                </tbody>
                            </table>
                            {{-- --------------- Arrival Departure End ------ --}}


                            {{-- --------------- total Start ------ --}}
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="background-color: #fff;padding: 0 15px 0 15px;">
                                            <hr
                                                style="border-top: 0;height: 0;border-bottom: 1px solid #232a35;margin-bottom:10px;margin-top:10px;">
                                    </tr>
                                    <tr>
                                        <td style="background: #f6f7f8;border-radius: 4px;margin-top: 10px;padding: 15px 10px;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="background: #232a35;border-radius: 4px 0px 0px 4px;padding: 8px;color: #fff;font-size: 18px;font-weight: 500;">

                                                            {{ translate(' Total Amount') }}

                                                        </td>
                                                        <td
                                                            style="background: #232a35;border-radius: 0px 4px 4px 0px;padding: 8px;color: #fff;text-align: right;font-size: 18px;font-weight: 500;">
                                                            <span
                                                                style="color: #baad85;font-size: 14px;font-weight: 500;">{{ $get_details_arr['currency'] }}</span>{{ $get_details_arr['total_amount'] }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            

                            @if(count($all_vouchers)>0)
                                <div style="line-height: 16px;padding: 15px;background: #fff;margin-top:15px"></div>
                                <div style="background-color: #232a35;color: #fff;font-weight: 18px;text-align: center;padding: 5px 0 10px;line-height: 16px;font-weight: 700;">
                                    {{translate('Voucher')}}
                                </div>
                                <div style="line-height: 16px;padding: 10px;background: #fff;"></div>
                                
                                @foreach ($all_vouchers as $all_vouchers_key => $vouchers_value)
                                    <table
                                        style="width: 100%;background-image: url('{{ $vouchers_value['voucher_image'] != '' ? $vouchers_value['voucher_image'] : asset('uploads/placeholder/background.png') }}');background-repeat: no-repeat;background-size: cover;background-position: center;padding: 8px 12px;border-radius: 6px;">
                                        <tbody>

                                            <tr>
                                                <td style="padding: 8px;" colspan="2"></td>
                                            </tr>

                                            <tr>
                                                @if($vouchers_value['our_logo'] !='')
                                                    <td style="width: 70%;">
                                                        <img style="width: 150px;" src="{{ $vouchers_value['our_logo'] }}" alt="" />
                                                    </td>
                                                @endif
                                                @if($vouchers_value['client_logo'] !='')
                                                    <td style="width: 30%;text-align: right;">
                                                        <img style="width: 150px;" src="{{ $vouchers_value['client_logo'] }}" alt="" />
                                                    </td>
                                                @endif
                                            </tr>

                                            <tr>
                                                <td style="padding: 10px;" colspan="2">
                                                    <div style="color: #fff;font-size: 16px;text-align: left;line-height: 16px;font-weight: 700;">
                                                        {{$vouchers_value['title']}}</div>
                                                    <div style="color: #fff;font-size: 14px;text-align: left;line-height: 14px;font-weight: 400;">
                                                        {!! $vouchers_value['description'] !!}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 5px;" colspan="2"></td>
                                            </tr>

                                            <tr>
                                                <td style="width: 70%;">
                                                    @if($vouchers_value['remark'] !='')
                                                    <div style="color: #fff;font-size: 14px;line-height: 14px;font-weight: 500;">
                                                        {{translate('Remark')}} : {{$vouchers_value['remark'] }}</div>
                                                        @endif
                                                </td>
                                                <td style="width: 30%;">
                                                    <div style="color: #baad85;font-size: 16px;text-align: right;line-height: 16px;font-weight: 700;">
                                                        {{$get_details_arr['currency']}} 
                                                        {{-- @php
                                                        $voucher_amount=$get_details_arr['voucher_amount'];
                                                        if($get_details_arr['amount_type'] == 'flat'){
                                                            $voucher_amount
                                                        }

                                                        @endphp --}}
                                                        {{$vouchers_value['voucher_amount']}} 
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