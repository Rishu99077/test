@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>{{ $common['title'] }}</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href = "{{ route('admin.dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <style type="text/css">
            .card-details .text-icon-color {
                color: #FC5301;
            }

            .card-details .acti_img {
                height: 100px;
                width: 120px;
                border-radius: 8px;
            }

            .card-details .detail_row {
                width: 100%;
            }

            .card-details .table_detail {
                background-color: white;
            }

            .tag_p_table {
                font-size: 16px;
            }

            .all-prd-info {
                display: flex;
            }

            .prd-info-detail {
                margin-left: 10px;
            }

            .checkout_body tr:last-child {
                background-color: black;
                color: white
            }

            th,
            td {
                white-space: inherit;
            }
        </style>
        <div class="page-body card-details">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row p-3">
                                <div class="col-md-6">
                                    <h2>{{ translate('Order detail') }}</h2>
                                    <div class="row p-3">
                                        <div class="col-md-6">
                                            <span class="icofont icofont-ui-user text-icon-color"></span>
                                            <span>{{ $orders['user_name'] }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="icofont icofont-phone text-icon-color"></span>
                                            <span>{{ $orders['phone'] }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="icofont icofont-envelope text-icon-color"></span>
                                            <span>{{ $orders['email'] }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="icofont icofont-location-pin text-icon-color"></span>
                                            <span>{{ $orders['address'] }} {{ $orders['city'] }} , {{ $orders['state'] }} ,
                                                {{ $orders['country'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row p-3">
                                        <div class="col-md-6">
                                            <span>{{ translate('Status') }}</span>
                                            <span class="status_pending">{!! checkStatus($orders['status']) !!}</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <span>{{ translate('Order Date') }} </span>
                                            <br>
                                            <span>{{ date('d ,M Y', strtotime($orders['created_at'])) }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span>{{ translate('Payment Status') }}</span>
                                            <span class="status_pending d-block">{!! checkStatus($orders['status']) !!}</span>
                                            <input type="hidden" name="order_id" id="order_id"
                                                value="{{ $orders['id'] }}">
                                            {{-- <select id="order_status" name="status" class="form-control">
                                                <option value="Pending" {{ getSelected($orders['status'], 'Pending') }}>
                                                    Pending</option>
                                                <option value="Success" {{ getSelected($orders['status'], 'Success') }}>
                                                    Success
                                                <option value="Failed" {{ getSelected($orders['status'], 'Failed') }}>
                                                    Failed
                                                </option>
                                            </select> --}}
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <span>{{ translate('Order ID') }}</span>
                                            <br>
                                            <span>{{ $orders['order_id'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row booking_details">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                            <h5>{{ translate('Booking Detail') }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table_detail" id="example-2">
                                <thead class="bg-dark">
                                    <tr>
                                        <th width="40%">{{ translate('Tour') }}</th>
                                        <th>{{ translate('Activity Type') }} </th>
                                        <th>{{ translate('Booking date') }} </th>
                                        <th>{{ translate('Price') }}</th>
                                        <th>{{ translate('Total Price') }} </th>
                                    </tr>
                                </thead>
                                </tbody>
                                @if (isset($orders['products']->detail))
                                    @foreach ($orders['products']->detail as $key => $value)
                                        @php
                                            $class = '';
                                            if (isset($value->is_cancel)) {
                                                if ($value->is_cancel == 1) {
                                                    $class = 'transport_danger border-5';
                                                }
                                            }
                                        @endphp
                                        <tr class="{{ $class }}">
                                            <td>
                                                <div class="all-prd-info">
                                                    <div class="order_detail_show_img">
                                                        <img src="{{ $value->image != '' ? $value->image : asset('uploads/placeholder/placeholder.png') }}"
                                                            alt="" class="acti_img">
                                                    </div>
                                                    <div class="prd-info-detail">
                                                        <p class="tag_p_table"> <b>{{ $value->title }}</b> </p>
                                                        <span class="tag_span_table">{{ $value->location }}</span>
                                                    </div>
                                            </td>
                                            <td> {{ $value->activity_type }}</td>
                                            <td> {{ $value->time_slot }} {{ $value->date }}</td>

                                            <td>
                                                @if (isset($value->price_brakdown))
                                                    @foreach ($value->price_brakdown as $key2 => $value_brakdown)
                                                        <p>{{ $value_brakdown->totalParticipants }}
                                                            {{ $value_brakdown->title }} X
                                                            {{ $value_brakdown->title == 'Participants' ? get_price_front('', '', '', '', $value_brakdown->pricePerPerson / $value_brakdown->totalParticipants) : get_price_front('', '', '', '', $value_brakdown->pricePerPerson) }}
                                                            :
                                                            {{ $value_brakdown->totalPrice }}</p>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>
                                                <span class="text-icon-color">$</span> {{ $value->totalAmount }}

                                                @php
                                                    $coupon_amount = 0;
                                                @endphp
                                                @if (isset($value->couponText) && isset($value->coupon_amount))
                                                    @php
                                                        $coupon_amount = $value->coupon_amount;
                                                    @endphp
                                                    <p class="mb-0">{{ $value->couponText }} :
                                                        <span>{{ get_price_front('', '', '', '', $value->coupon_amount) }}</span>
                                                    </p>
                                                @endif

                                                @if (isset($value->tax))
                                                    @foreach ($value->tax as $key3 => $value_tax)
                                                        <p class="mb-0">{{ $value_tax->title }}
                                                            @if ($value_tax->type == 'percentage')
                                                                ({{ $value_tax->basic }} %)
                                                            @endif: <span
                                                                class="text-icon-color">{{ $value_tax->format_amount }}</span>
                                                        </p>
                                                    @endforeach
                                                @endif

                                                @if (isset($value->affilliate_commission))
                                                    <p class="mb-0">{{ translate('Affiliate Commission') }}
                                                        ({{ $value->affilliate_commission->commission }} %)
                                                        : <span class="text-icon-color">
                                                            <?php echo get_price_front('', '', '', '', $value->affilliate_commission->commission_amount); ?></span></p>
                                                @endif
                                                @if (isset($value->hotel_commission))
                                                    <p class="mb-0">{{ translate('Hotel Commission') }}
                                                        ({{ $value->hotel_commission->commission }} %)
                                                        : <span class="text-icon-color">
                                                            <?php echo get_price_front('', '', '', '', $value->hotel_commission->commission_amount); ?></span></p>
                                                @endif

                                                @if (isset($value->partner_commission))
                                                    <span class="mytooltip tooltip-effect-1 order_tooltip">
                                                        <span
                                                            class="tooltip-item">{{ translate('Commission Summary') }}</span>
                                                        <span class="tooltip-content clearfix">

                                                            <span class="tooltip-text">{{ translate('Product Aamount') }} :
                                                                <span class="d-block">
                                                                    {{ get_price_front('', '', '', '', $value->totalAmount) . ' - ' . get_price_front('', '', '', '', $coupon_amount) . ' = ' . get_price_front('', '', '', '', $value->partner_commission->product_amount) }}

                                                                </span>
                                                            </span>
                                                            <span class="tooltip-text">{{ translate('Admin Commission') }}
                                                                ({{ $value->partner_commission->commission }}%) :
                                                                {{ get_price_front('', '', '', '', $value->partner_commission->admin_commission_amount) }}
                                                                @php

                                                                    $admin_commission_amount = $value->partner_commission->admin_commission_amount;
                                                                @endphp
                                                            </span>

                                                            <span class="tooltip-text">{{ translate('Partner Amount') }}:
                                                                {{ get_price_front('', '', '', '', $value->partner_commission->partner_amount) }}</span>

                                                            @php
                                                                $affilliate_commission_amount = 0;
                                                                $hotel_commission_amount = 0;
                                                            @endphp

                                                            @if (isset($value->affilliate_commission))
                                                                <span
                                                                    class="tooltip-text">{{ translate('Affilliate Commission') }}
                                                                    ({{ $value->affilliate_commission->commission }}%) :
                                                                    {{ get_price_front('', '', '', '', $value->affilliate_commission->commission_amount) }}
                                                                    @php
                                                                        $affilliate_commission_amount = $value->affilliate_commission->commission_amount;
                                                                    @endphp
                                                            @endif
                                                            @if (isset($value->hotel_commission))
                                                                <span
                                                                    class="tooltip-text">{{ translate('Hotel Commission') }}
                                                                    ({{ $value->hotel_commission->commission }}%) :
                                                                    {{ get_price_front('', '', '', '', $value->hotel_commission->commission_amount) }}
                                                                    @php
                                                                        $hotel_commission_amount = $value->hotel_commission->commission_amount;
                                                                    @endphp
                                                            @endif

                                                            <span
                                                                class="tooltip-text">{{ translate('Total Admin Amount') }}
                                                                :
                                                                {{ get_price_front('', '', '', '', $admin_commission_amount - $affilliate_commission_amount - $hotel_commission_amount) }}</span>
                                                        </span>
                                                    </span>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <h3>{{ config('adminconfig.record_not_found') }}</h3>
                                        </td>
                                    </tr>
                                @endif

                                </tbody>
                                <tbody>
                                    @if (isset($commissions['total']))
                                        <tr>
                                            <td scope="row" colspan="4">{{ translate('Total Commission') }}</td>
                                            <td><?php echo get_price_front('', '', '', '', $commissions['total']); ?></td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tbody class="checkout_body">
                                    @if (isset($orders['products']->checkout))
                                        @foreach ($orders['products']->checkout as $key => $value_check)
                                            <tr>
                                                <td scope="row" colspan="4">{{ $value_check->title }}</td>
                                                <td>{{ $value_check->amount }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('change', '#order_status', function() {
                var status = $(this).val();
                var id = $('#order_id').val();

                $.ajax({
                    "type": "POST",
                    "data": {
                        status: status,
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    url: "{{ route('admin.orders.change_status') }}",
                    success: function(response) {
                        window.location.reload();

                    }
                });
            });
        });
    </script>
@endsection
@endsection
