@extends('admin.layout.master')
@section('content')
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

        <div class="card mb-3">
            <div class="bg-holder-2 d-none d-lg-block bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);opacity: 0.7;"></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h5 class="text-dark">Order ID: {{ $orders['id'] }}</h5>
                <p class="fs--1">{{ $orders['created_at']->format('M d, Y, H:i:s') }}</p>
                <div>
                    <strong class="me-2">Status: </strong>
                    <div class="badge rounded-pill badge-soft-success fs--2">{{ $orders['status'] }}<span
                            class="fas fa-check ms-1" data-fa-transform="shrink-2"></span></div>

                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <h5 class="text-dark mb-3 fs-0">Billing Address</h5>
                        <h6 class="mb-2">{{ $orders['first_name'] }}</h6>
                        <p class="mb-1 fs--1">{{ $orders['address'] }}<br />{{ $orders['city'] }}, {{ $orders['country'] }}
                            {{ $orders['postcode'] }}</p>
                        <p class="mb-0 fs--1"> <strong>Email: </strong><a
                                href="mailto:{{ $orders['email'] }}">{{ $orders['email'] }}</a></p>
                        <p class="mb-0 fs--1"> <strong>Phone: </strong><a
                                href="tel:{{ $orders['phone_number'] }}">{{ $orders['phone_number'] }}</a></p>
                    </div>
                    <!--   <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <h5 class="text-dark mb-3 fs-0">Shipping Address</h5>
                        <h6 class="mb-2">Antony Hopkins</h6>
                        <p class="mb-0 fs--1">2393 Main Avenue<br />Penasauka, New Jersey 87896</p>
                        <div class="text-500 fs--1">(Free Shipping)</div>
                     </div> -->
                    <div class="col-md-6 col-lg-4">
                        <h5 class="text-dark mb-3 fs-0">Payment Method</h5>
                        <div class="d-flex">
                            {{ $orders['payment_method'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php $total_tax_amount = 0; @endphp
        @isset($orders['products_detail'])
            @foreach ($orders['products_detail'] as $key => $val_pro)
                @isset($val_pro->tax_amount)
                    @php $total_tax_amount+= $val_pro->tax_amount; @endphp
                @endisset
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="product_list_details">
                            <div class="product_list_top">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-10 col-md-10 col-sm-12 col-12">
                                        <div class="product_title">
                                            <h4 class="text-dark">@isset($val_pro->title){{ $val_pro->title }}({{ $val_pro->type }})@endisset</h4>
                                            </p><span> <span class="price_main"> AED </span> @isset($val_pro->total){{ $val_pro->total }}@endisset</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product_list_detailss mt-3">
                                <div class="prd_options">

                                    <!-- OPTION -->
                                    @isset($val_pro->option)
                                        <div class="prd_main_details">
                                            <div class="prd_otpions_info">
                                                @foreach ($val_pro->option as $key => $val_option)
                                                    @if ($val_pro->type == 'Limousine' || $val_pro->type == 'Yatch')
                                                        <h5 class="text-dark">{{ $val_option->title }}</h5>

                                                        <div class="row">
                                                            <div class="col-md-1"><span> <b>{{ $val_option->date }}</b></span>
                                                            </div>
                                                            <div class="col-md-1"><span> Start Time
                                                                    <b>{{ $val_option->start_time }}</b> </span></div>
                                                            <div class="col-md-1"><span> End Time
                                                                    <b>{{ $val_option->end_time }}</b> </span></div>
                                                            <div class="col-md-1"><span> Price <b><span class="price_option"> AED
                                                                        </span> {{ $val_option->price }}</b> </span></div>
                                                            <div class="col-md-1"><span> Total Hours
                                                                    <b>{{ $val_option->get_hours }}</b> </span></div>
                                                            <div class="col-md-1"><span> Total Price
                                                                    <b>{{ $val_option->total_price }}</b> </span></div>
                                                            <div class="col-md-1"><span> Guest <b>{{ $val_option->guest }}</b>
                                                                </span></div>
                                                            <div class="col-md-1"><span> Hour price
                                                                    <b>{{ $val_option->hour_price }}</b> </span></div>
                                                            <div class="col-md-1"><span> Way <b>{{ $val_option->way }}</b> </span>
                                                            </div>
                                                            <div class="col-md-1"><span> Sub total
                                                                    <b>{{ $val_option->sub_total }}</b> </span></div>
                                                            <div class="col-md-1"><span> Total amount
                                                                    <b>{{ $val_option->total_amount }}</b> </span></div>
                                                        </div>
                                                    @elseif($val_pro->type == 'lodge')
                                                        <h5 class="text-dark">{{ $val_option->title }}</h5>

                                                        <div class="row">
                                                            <div class="col-md-1"><span> Adult <b>{{ $val_option->adult }}</b>
                                                                </span></div>
                                                            <div class="col-md-1"><span> Child <b>{{ $val_option->child }}</b>
                                                                </span></div>
                                                            <div class="col-md-1"><span> Infant <b>{{ $val_option->infant }}</b>
                                                                </span></div>
                                                            <div class="col-md-2"><span> Lodge arrival date
                                                                    <b>{{ $val_option->lodge_arrival_date }}</b> </span></div>
                                                            <div class="col-md-2"><span> Lodge departure date
                                                                    <b>{{ $val_option->lodge_departure_date }}</b> </span></div>
                                                            <div class="col-md-2"><span> No of rooms
                                                                    <b>{{ $val_option->no_of_rooms }}</b> </span></div>
                                                            <div class="col-md-2"><span> Option Total <b><span class="price_option">
                                                                            AED </span> {{ $val_option->option_total }}</b> </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endisset

                                    <!-- TRANSPORTATION -->
                                    @isset($val_option->transportaion)
                                        <hr>
                                        <div class="prd_main_details">
                                            <div class="prd_option_inner">
                                                <h4 class="text-dark"><span>Transportation</span></h4>
                                            </div>
                                            <div class="prd_otpions_info new_option_span">
                                                @foreach ($val_option->transportaion as $key => $val_transport)
                                                    <div class="row">
                                                        <div class="col-md-3"><span>{{ $val_transport->title }} </span></div>
                                                        <div class="col-md-3"><span> {{ $val_transport->way }}</span></div>
                                                        <div class="col-md-3"><span>
                                                                @isset($val_transport->select_qty)
                                                                    {{ $val_transport->select_qty }} x
                                                                @endisset
                                                                <span class="price_option"> AED</span> {{ $val_transport->price }}
                                                            </span></div>
                                                        <div class="col-md-3"><span> <span class="price_option"> AED</span>
                                                                <b>{{ $val_transport->total_price }}</b> </span></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endisset

                                    <!-- TRANFER OPTION  -->
                                    @isset($val_option->transfer_option)
                                        <hr>
                                        <div class="prd_main_details">
                                            <div class="prd_option_inner">
                                                <h4 class="text-dark"><span>Transfer Option</span></h4>
                                            </div>
                                            <div class="prd_otpions_info new_option_span">
                                                @foreach ($val_option->transfer_option as $key => $val_transfer)
                                                    <div class="row">
                                                        <div class="col-md-3"><span>{{ $val_transfer->title }} </span></div>

                                                        @if ($val_transfer->way == 1)
                                                            <div class="col-md-3"><span>One Way</span></div>
                                                        @elseif($val_transfer->way == 2)
                                                            <div class="col-md-3"><span>Two Way</span></div>
                                                        @endif

                                                        @isset($val_transfer->select_qty)
                                                            <div class="col-md-3"><span> {{ $val_transfer->select_qty }} x <span
                                                                        class="price_option"> AED</span> {{ $val_transfer->price }}
                                                                </span></div>
                                                        @endisset

                                                        @isset($val_transfer->get_hours)
                                                            <div class="col-md-3"><span> {{ $val_transfer->get_hours }} x <span
                                                                        class="price_option"> AED</span> {{ $val_transfer->price }}
                                                                </span></div>
                                                        @endisset
                                                        <div class="col-md-3"><span> <span class="price_option"> AED</span>
                                                                <b>{{ $val_transfer->total_price }}</b> </span></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endisset

                                    <!-- FOOD BERVRAGE  -->
                                    @isset($val_option->food_beverage)
                                        @if (!empty($val_option->food_beverage))
                                            <hr>
                                            <div class="prd_main_details">
                                                <div class="prd_option_inner">
                                                    <h4 class="text-dark"><span>FOOD BERVRAGE</span></h4>
                                                </div>
                                                <div class="prd_otpions_info new_option_span">
                                                    @foreach ($val_option->food_beverage as $key => $val_food)
                                                        <div class="row">
                                                            <div class="col-md-3"><span>{{ $val_food->title }} </span></div>
                                                            <div class="col-md-3"><span> {{ $val_food->adult_qty }} x <span
                                                                        class="price_option"> AED</span>
                                                                    <b>{{ $val_food->adult_price }}</b> </span></div>
                                                            <div class="col-md-3"><span> {{ $val_food->child_qty }} x <span
                                                                        class="price_option"> AED</span>
                                                                    <b>{{ $val_food->child_price }}</b> </span></div>
                                                            <div class="col-md-3"><span> <span class="price_option"> AED</span>
                                                                    <b>{{ $val_food->total_price }}</b> </span></div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endisset

                                    <!-- Water Sport  -->
                                    @isset($val_option->water_sports)
                                        @if (!empty($val_option->water_sports))
                                            <hr>
                                            <div class="prd_main_details">
                                                <div class="prd_option_inner">
                                                    <h4 class="text-dark"><span>Water Sport</span></h4>
                                                </div>
                                                <div class="prd_otpions_info new_option_span">
                                                    @foreach ($val_option->water_sports as $key => $val_water)
                                                        <div class="row">
                                                            <div class="col-md-3"><span>{{ $val_water->title }} </span></div>

                                                            @if ($val_water->way == 1)
                                                                <div class="col-md-3"><span>One Way</span></div>
                                                            @elseif($val_water->way == 2)
                                                                <div class="col-md-3"><span>Two Way</span></div>
                                                            @endif

                                                            <div class="col-md-3"><span> {{ $val_water->get_hours }} x <span
                                                                        class="price_option"> AED</span>
                                                                    <b>{{ $val_water->price }}</b> </span></div>

                                                            <div class="col-md-3"><span> <span class="price_option"> AED</span>
                                                                    <b>{{ $val_water->total_price }}</b> </span></div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endisset

                                    <!-- Private Tour  -->
                                    @isset($val_option->private_tour)
                                        @if (!empty($val_option->private_tour))
                                            <hr>
                                            <div class="prd_main_details">
                                                <div class="prd_option_inner">
                                                    <h4 class="text-dark"><span>Private Tour</span></h4>
                                                </div>
                                                <div class="prd_otpions_info new_option_span">
                                                    @foreach ($val_option->private_tour as $key => $val_pri_tour)
                                                        <div class="row">
                                                            <div class="col-md-1"><span><b>{{ $val_pri_tour->title }}</b> </span>
                                                            </div>

                                                            <div class="col-md-1">Date <span>{{ $val_pri_tour->date }} </span>
                                                            </div>
                                                            <div class="col-md-1">Adult <span>{{ $val_pri_tour->adult }} </span>
                                                            </div>
                                                            <div class="col-md-1">Child <span>{{ $val_pri_tour->child }} </span>
                                                            </div>
                                                            <div class="col-md-1">Infant <span>{{ $val_pri_tour->infant }} </span>
                                                            </div>
                                                            <div class="col-md-1">Car Seats <span>{{ $val_pri_tour->car_seats }}
                                                                </span></div>
                                                            <div class="col-md-1">Total Cars <span>{{ $val_pri_tour->total_cars }}
                                                                </span></div>
                                                            <div class="col-md-1">Total Passenger
                                                                <span>{{ $val_pri_tour->total_pasenger }} </span>
                                                            </div>

                                                            <div class="col-md-1"><span>Price <span class="price_option">
                                                                        AED</span> {{ $val_pri_tour->price }} </span></div>
                                                            <div class="col-md-1"><span>Service Charge <span class="price_option">
                                                                        AED</span> {{ $val_pri_tour->service_charge }} </span>
                                                            </div>
                                                            <div class="col-md-1"><span>Tax <span class="price_option"> AED</span>
                                                                    {{ $val_pri_tour->tax }} </span></div>

                                                            <div class="col-md-1"><span>Total amount <span class="price_option">
                                                                        AED</span> {{ $val_pri_tour->total_amount }} </span></div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endisset

                                    <!-- Tour Transfer  -->
                                    @isset($val_option->tour_transfer)
                                        @if (!empty($val_option->tour_transfer))
                                            <hr>
                                            <div class="prd_main_details">
                                                <div class="prd_option_inner">
                                                    <h4 class="text-dark"><span>Tour Transfer</span></h4>
                                                </div>
                                                <div class="prd_otpions_info new_option_span">
                                                    @foreach ($val_option->tour_transfer as $key => $val_trans)
                                                        <div class="row">
                                                            <div class="col-md-2"><span><b>{{ $val_trans->title }}</b> </span>
                                                            </div>

                                                            <div class="col-md-1"><span>{{ $val_trans->date }} </span></div>
                                                            <div class="col-md-1">Adult <span><b>{{ $val_trans->adult }}</b>
                                                                </span></div>
                                                            <div class="col-md-1">Child <span><b>{{ $val_trans->child }}</b>
                                                                </span></div>
                                                            <div class="col-md-1">Infant <span><b>{{ $val_trans->infant }}</b>
                                                                </span></div>

                                                            <div class="col-md-2">Option <span>{{ $val_trans->option_name }}
                                                                </span></div>
                                                            <div class="col-md-1">Private car
                                                                <span>{{ $val_trans->is_private_car }} </span>
                                                            </div>

                                                            <div class="col-md-2"><span>Adult price <span class="price_option">
                                                                        AED</span> <b>{{ $val_trans->adult_price }}</b> </span>
                                                            </div>
                                                            <div class="col-md-1"><span>Child price <span class="price_option">
                                                                        AED</span> <b>{{ $val_trans->child_price }}</b> </span>
                                                            </div>
                                                            <div class="col-md-1"><span>Infant price <span class="price_option">
                                                                        AED</span> <b>{{ $val_trans->infant_price }}</b> </span>
                                                            </div>

                                                            <div class="col-md-2"><span>Total adult price <span
                                                                        class="price_option"> AED</span>
                                                                    <b>{{ $val_trans->total_adult_price }}</b> </span></div>

                                                            <div class="col-md-2"><span>Total child price <span
                                                                        class="price_option"> AED</span>
                                                                    <b>{{ $val_trans->total_child_price }}</b> </span></div>

                                                            <div class="col-md-2"><span>Total infant price <span
                                                                        class="price_option"> AED</span>
                                                                    <b>{{ $val_trans->total_infant_price }}</b> </span></div>

                                                            <div class="col-md-1"><span>Total <span class="price_option">
                                                                        AED</span> <b>{{ $val_trans->total }}</b> </span></div>

                                                            <div class="col-md-2"><span>Service Charge <span class="price_option">
                                                                        AED</span> <b>{{ $val_trans->service_charge }}</b> </span>
                                                            </div>

                                                            <div class="col-md-1"><span>Tax <span class="price_option"> AED</span>
                                                                    <b>{{ $val_trans->tax }}</b> </span></div>
                                                            <div class="col-md-1"><span>Total amount <span class="price_option">
                                                                        AED</span> <b>{{ $val_trans->total_amount }}</b> </span>
                                                            </div>
                                                        </div>

                                                        <!-- Upgrade Option  -->
                                                        @isset($val_trans->tour_upgrade_option)
                                                            @if (!empty($val_trans->tour_upgrade_option))
                                                                <hr>
                                                                <div class="prd_main_details">
                                                                    <div class="prd_option_inner">
                                                                        <h4 class="text-dark"><span>Tour upgrade option</span></h4>
                                                                    </div>
                                                                    <div class="prd_otpions_info new_option_span">
                                                                        @foreach ($val_trans->tour_upgrade_option as $key => $val_upgrade)
                                                                            <div class="row">
                                                                                <div class="col-md-3"><span>{{ $val_upgrade->title }}
                                                                                    </span></div>
                                                                                <div class="col-md-3"><span>
                                                                                        {{ $val_upgrade->lodge_adult_qty }} x <span
                                                                                            class="price_option"> AED</span>
                                                                                        <b>{{ $val_upgrade->adult_price }}</b> </span>
                                                                                </div>
                                                                                <div class="col-md-3"><span>
                                                                                        {{ $val_upgrade->lodge_child_qty }} x <span
                                                                                            class="price_option"> AED</span>
                                                                                        <b>{{ $val_upgrade->child_price }}</b> </span>
                                                                                </div>
                                                                                <div class="col-md-3"><span>
                                                                                        {{ $val_upgrade->lodge_infant_qty }} x <span
                                                                                            class="price_option"> AED</span>
                                                                                        <b>{{ $val_upgrade->infant_price }}</b> </span>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endisset
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endisset

                                    <hr>
                                </div>
                            </div>
                            <div class="prd_main_details produt_btm_main">
                                <div class="prd_option_inner"><span>Tax @isset($val_pro->tax)
                                            {{ $val_pro->tax }}%
                                        @endisset
                                    </span>
                                    <span> <span class="price_main"> AED </span>
                                        @isset($val_pro->tax_amount)
                                            <b>{{ $val_pro->tax_amount }}</b>
                                        @endisset
                                    </span>
                                </div>
                                <div class="prd_option_inner"><span>Service Charge</span><span> <span class="price_main"> AED
                                        </span>
                                        @isset($val_pro->service_charge)
                                            <b>{{ $val_pro->tax_amount }}</b>
                                        @endisset
                                    </span></div>
                                <div class="prd_option_inner"><span>Product Grand Total</span><span> 
                                    @isset($val_pro->total)
                                        <span class="price_main"> AED </span><b>{{ $val_pro->total }}</b></span>
                                    @endisset

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
@endsection
