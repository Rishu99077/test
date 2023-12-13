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
                <h5 class="text-dark">Order ID: {{ $orders['order_id'] }}</h5>
                <p class="fs--1">{{ $orders['created_at'] }}</p>
                <div>
                    <strong class="me-2">Status: </strong>
                    @if ($orders['status'] == 'Success')
                        <div class="badge rounded-pill badge-soft-success fs--2">{{ $orders['status'] }}<span
                                class="fas fa-check ms-1" data-fa-transform="shrink-2"></span></div>
                    @elseif($orders['status'] == 'Pending')
                        <div class="badge rounded-pill badge-soft-warning fs--2">{{ $orders['status'] }}<span
                                class="fas fa-stream ms-1" data-fa-transform="shrink-2"></span></div>
                    @elseif($orders['status'] == 'Failed')
                        <div class="badge rounded-pill badge-soft-danger fs--2">{{ $orders['status'] }}<span
                                class="fas fa-ban ms-1" data-fa-transform="shrink-2"></span></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <h5 class="text-dark mb-3 fs-0">Billing Address</h5>
                        <h6 class="mb-2">{{ $orders['first_name'] }} {{ $orders['last_name'] }}</h6>
                        <p class="mb-1 fs--1">{{ $orders['address'] }}<br />{{ $orders['city'] }},
                            {{ $orders['country'] }} {{ $orders['postcode'] }}</p>
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

                @php $color = ''; @endphp
                @isset($val_pro->order_cancel)
                    @if ($val_pro->order_cancel == 1)
                        @php $color = 'lightpink'; @endphp
                    @endif
                @endisset

                <div class="card mb-3" style="background-color: {{ $color }};">
                    <div class="card-body">
                        <div class="product_list_details">
                            <div class="product_list_top">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                                        <div class="product_title">
                                            @isset($val_pro->title)
                                                <h4 class="text-dark">{{ $val_pro->title }}({{ $val_pro->type }})</h4>
                                                </p><span> <span class="price_main"> {{ $orders['currency'] }} </span>
                                                    <b>{{ $val_pro->price }}</b></span>
                                            @endisset
                                            @isset($val_pro->name)
                                                <h4 class="text-dark">{{ $val_pro->type }}</h4>
                                                <p><span class="fw-bold">Name : </span>{{ $val_pro->name }}</p>
                                                <p><span class="fw-bold">Email : </span>{{ $val_pro->email }}</p>
                                                <p><span class="fw-bold">Mobile Number : </span>{{ $val_pro->phone_code }} {{ $val_pro->phone_number }}</p>
                                                <p><span class="fw-bold">Name Of The Recipient : </span>{{ $val_pro->recipient_name }}</p>
                                                <p><span class="fw-bold">Recipient Email  : </span>{{ $val_pro->recipient_email }}</p>
                                                <p><span class="fw-bold">Recipient Mobile Number : </span>{{ $val_pro->recipient_phone_code }} {{ $val_pro->recipient_phone_number }}</p>
                                            @endisset
                                        </div>
                                    </div>
                                    
                                    @isset($val_pro->cancellation_up_to_time)
                                        @isset($val_pro->order_cancel)
                                            @if ($val_pro->cancellation_up_to_time && $val_pro->order_cancel == 0)
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 text-end">
                                                    <button class="btn btn-danger" id="cancel_order" type="button"
                                                        data-id="{{ $val_pro->id }}"
                                                        data-order-id="{{ $orders['id'] }}">Cancel</button>
                                                    <p>cancel up to <b><?php echo date('Y-m-d H:i:s', strtotime($val_pro->cancellation_up_to_time)); ?></b></p>
                                                </div>
                                            @endif
                                        @endisset
                                    @endisset

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
                                                            <div class="col-md-2"><span> <b>{{ $val_option->date }}</b></span>
                                                            </div>
                                                            <div class="col-md-2"><span> Start Time
                                                                    <b>{{ $val_option->start_time }}</b> </span></div>
                                                            <div class="col-md-2"><span> End Time
                                                                    <b>{{ $val_option->end_time }}</b> </span></div>
                                                            <div class="col-md-2"><span> Price <b><span class="price_option">
                                                                            {{ $orders['currency'] }}
                                                                        </span> {{ $val_option->price }}</b> </span></div>
                                                            <div class="col-md-2"><span> Total Hours
                                                                    <b>{{ $val_option->get_hours }}</b> </span></div>
                                                            <div class="col-md-2"><span> Total Price
                                                                    <b><span class="price_option">
                                                                            {{ $orders['currency'] }}
                                                                        </span> {{ $val_option->total_price }}</b> </span></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-2"><span> Guest <b>{{ $val_option->guest }}</b>
                                                                </span></div>
                                                            <div class="col-md-2"><span> Hour price
                                                                    <b>{{ $val_option->hour_price }}</b> </span></div>
                                                            <div class="col-md-2"><span> Way <b>{{ $val_option->way }}</b> </span>
                                                            </div>
                                                            <div class="col-md-2"><span> Sub total
                                                                    <b> <span class="price_option">
                                                                            {{ $orders['currency'] }}
                                                                        </span> {{ $val_option->sub_total }}</b> </span></div>
                                                            <div class="col-md-2"><span> Total amount
                                                                    <b> <span class="price_option">
                                                                            {{ $orders['currency'] }}
                                                                        </span> {{ $val_option->total_amount }}</b> </span></div>
                                                        </div>
                                                    @elseif($val_pro->type == 'lodge')
                                                        <h5 class="text-dark">{{ $val_option->title }}</h5>

                                                        <div class="row">
                                                            <div class="col-md-3"><span> Adult <b>{{ $val_option->adult }}</b>
                                                                </span></div>
                                                            <div class="col-md-3"><span> Child <b>{{ $val_option->child }}</b>
                                                                </span></div>
                                                            <div class="col-md-3"><span> Infant <b>{{ $val_option->infant }}</b>
                                                                </span></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"><span> Lodge arrival date
                                                                    <b>{{ $val_option->lodge_arrival_date }}</b> </span></div>
                                                            <div class="col-md-3"><span> Lodge departure date
                                                                    <b>{{ $val_option->lodge_departure_date }}</b> </span></div>
                                                            <div class="col-md-3"><span> No of rooms
                                                                    <b>{{ $val_option->no_of_rooms }}</b> </span></div>
                                                            <div class="col-md-3"><span> Option Total <b><span class="price_option">
                                                                            {{ $orders['currency'] }} </span>
                                                                        {{ $val_option->option_total }}</b> </span>
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
                                                        <div class="col-md-3"><span><b>{{ $val_transport->title }}</b> </span>
                                                        </div>
                                                        <div class="col-md-3"><span> <b>{{ $val_transport->way }}</b></span></div>
                                                        <div class="col-md-3"><span>
                                                                @isset($val_transport->select_qty)
                                                                    <b>{{ $val_transport->select_qty }}</b> x
                                                                @endisset
                                                                <span class="price_option">
                                                                    {{ $orders['currency'] }}</span>
                                                                <b>{{ $val_transport->price }}</b> </span></div>
                                                        <div class="col-md-3"><span> <span class="price_option">
                                                                    {{ $orders['currency'] }}</span>
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
                                                        <div class="col-md-3"><span><b>{{ $val_transfer->title }}</b> </span>
                                                        </div>

                                                        @if ($val_transfer->way == 1)
                                                            <div class="col-md-3"><span><b>One Way</b></span></div>
                                                        @elseif($val_transfer->way == 2)
                                                            <div class="col-md-3"><span><b>Two Way</b></span></div>
                                                        @endif

                                                        @isset($val_transfer->select_qty)
                                                            <div class="col-md-3"><span> {{ $val_transfer->select_qty }} x <span
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_transfer->price }}</b> </span></div>
                                                        @endisset

                                                        @isset($val_transfer->get_hours)
                                                            <div class="col-md-3"><span> {{ $val_transfer->get_hours }} x <span
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_transfer->price }}</b> </span></div>
                                                        @endisset
                                                        <div class="col-md-3"><span> <span class="price_option">
                                                                    {{ $orders['currency'] }}</span>
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
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_food->adult_price }}</b> </span></div>
                                                            <div class="col-md-3"><span> {{ $val_food->child_qty }} x <span
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_food->child_price }}</b> </span></div>
                                                            <div class="col-md-3"><span> <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
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
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_water->price }}</b> </span></div>

                                                            <div class="col-md-3"><span> <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
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
                                                            <div class="col-md-2"><span><b>{{ $val_pri_tour->title }}</b> </span>
                                                            </div>

                                                            <div class="col-md-2">Date <span><b>{{ $val_pri_tour->date }}</b>
                                                                </span></div>
                                                            <div class="col-md-2">Adult <span><b>{{ $val_pri_tour->adult }}</b>
                                                                </span></div>
                                                            <div class="col-md-2">Child <span><b>{{ $val_pri_tour->child }}</b>
                                                                </span></div>
                                                            <div class="col-md-2">Infant <span><b>{{ $val_pri_tour->infant }}</b>
                                                                </span></div>
                                                            <div class="col-md-2">Car Seats
                                                                <span><b>{{ $val_pri_tour->car_seats }}</b> </span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-2">Total Cars
                                                                <span><b>{{ $val_pri_tour->total_cars }}</b> </span>
                                                            </div>
                                                            <div class="col-md-2">Total Passenger
                                                                <span><b>{{ $val_pri_tour->total_pasenger }}</b> </span>
                                                            </div>

                                                            <div class="col-md-2"><span>Price <span class="price_option">
                                                                        {{ $orders['currency'] }}</span><b>
                                                                        {{ $val_pri_tour->price }}</b> </span></div>
                                                            <div class="col-md-2"><span>Service Charge <span class="price_option">
                                                                        {{ $orders['currency'] }}</span><b>
                                                                        {{ $val_pri_tour->service_charge }}</b>
                                                                </span></div>
                                                            <div class="col-md-2"><span>Tax <span class="price_option">
                                                                        {{ $orders['currency'] }}</span><b>
                                                                        {{ $val_pri_tour->tax }}</b> </span></div>

                                                            <div class="col-md-2"><span>Total amount <span class="price_option">
                                                                        {{ $orders['currency'] }}</span><b>
                                                                        {{ $val_pri_tour->total_amount }}</b> </span>
                                                            </div>
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

                                                            <div class="col-md-2"><span>{{ $val_trans->date }} </span></div>
                                                            <div class="col-md-2">Adult <span><b>{{ $val_trans->adult }}</b>
                                                                </span></div>
                                                            <div class="col-md-2">Child <span><b>{{ $val_trans->child }}</b>
                                                                </span></div>
                                                            <div class="col-md-2">Infant <span><b>{{ $val_trans->infant }}</b>
                                                                </span></div>

                                                            <div class="col-md-2">Option <span>{{ $val_trans->option_name }}
                                                                </span></div>
                                                            <div class="col-md-2">Private car
                                                                <span>{{ $val_trans->is_private_car }} </span>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-2"><span>Adult price <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_trans->adult_price }}</b> </span>
                                                            </div>
                                                            <div class="col-md-2"><span>Child price <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_trans->child_price }}</b> </span>
                                                            </div>
                                                            <div class="col-md-2"><span>Infant price <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_trans->infant_price }}</b> </span>
                                                            </div>

                                                            <div class="col-md-2"><span>Total adult price <span
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ @$val_trans->total_adult_price }}</b> </span></div>

                                                            <div class="col-md-2"><span>Total child price <span
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ @$val_trans->total_child_price }}</b> </span></div>

                                                            <div class="col-md-2"><span>Total infant price <span
                                                                        class="price_option"> {{ $orders['currency'] }}</span>
                                                                    <b>{{ @$val_trans->total_infant_price }}</b> </span></div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-md-2"><span>Total <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ @$val_trans->total }}</b> </span></div>

                                                            <div class="col-md-2"><span>Service Charge <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_trans->service_charge }}</b> </span>
                                                            </div>

                                                            <div class="col-md-2"><span>Tax <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_trans->tax }}</b> </span></div>
                                                            <div class="col-md-2"><span>Total amount <span class="price_option">
                                                                        {{ $orders['currency'] }}</span>
                                                                    <b>{{ $val_trans->total_amount }}</b> </span>
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
                                                                                <div class="col-md-2">
                                                                                    <span><b>{{ $val_upgrade->title }}</b> </span>
                                                                                </div>
                                                                                <div class="col-md-2"><span>
                                                                                        {{ $val_upgrade->lodge_adult_qty }} x <span
                                                                                            class="price_option">
                                                                                            {{ $orders['currency'] }}</span>
                                                                                        <b>{{ $val_upgrade->adult_price }}</b> </span>
                                                                                </div>
                                                                                <div class="col-md-2"><span>
                                                                                        {{ $val_upgrade->lodge_child_qty }} x <span
                                                                                            class="price_option">
                                                                                            {{ $orders['currency'] }}</span>
                                                                                        <b>{{ $val_upgrade->child_price }}</b> </span>
                                                                                </div>
                                                                                <div class="col-md-2"><span>
                                                                                        {{ $val_upgrade->lodge_infant_qty }} x <span
                                                                                            class="price_option">
                                                                                            {{ $orders['currency'] }}</span>
                                                                                        <b>{{ $val_upgrade->infant_price }}</b>
                                                                                    </span></div>
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

                                    <div class="product_list_details">
                                        <div class="prd_main_details produt_btm_main">
                                            <div class="prd_option_inner"><span>Tax data @isset($val_pro->tax)
                                                        {{ $val_pro->tax }}%
                                                    @endisset
                                                </span>
                                                <span style="float: right;"> <span class="price_main">
                                                        {{ $orders['currency'] }} </span>
                                                    @php
                                                        $taxAmount = 0;
                                                        if (isset($val_pro->tax_amount)) {
                                                            $taxAmount = $val_pro->tax_amount;
                                                        }
                                                    @endphp

                                                    <b>{{ $taxAmount }}</b>

                                                </span>
                                            </div>

                                            <div class="prd_option_inner"><span>Service Charge</span><span
                                                    style="float: right;"> <span class="price_main">
                                                        {{ $orders['currency'] }} </span>
                                                    @php
                                                        $serviceCharge = 0;
                                                        if (isset($val_pro->service_charge)) {
                                                            $serviceCharge = $val_pro->service_charge;
                                                        }
                                                    @endphp

                                                    <b>{{ $serviceCharge }}</b>

                                                </span></div>

                                            <div class="prd_option_inner"><span>Product Grand Total</span><span
                                                    style="float: right;"> <span class="price_main">
                                                        {{ $orders['currency'] }}
                                                    </span><b>{{ $val_pro->total }}</b></span></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset

        <div class="card">
            <div class="card-body">
                <div class="product_list_details">
                    <div class="prd_main_details produt_btm_main">
                        <div class="prd_option_inner"><span>Sub Total</span><span style="float: right;"> <span
                                    class="price_main"> {{ $orders['currency'] }} </span>
                                <b>{{ $orders['sub_total'] }}</b> </span></div>

                        @isset($orders['coupon_code'])
                            <div class="prd_option_inner"><span>Coupon Code ( {{ $orders['coupon_code'] }} )</span><span
                                    style="float: right;"> <span class="price_main"> {{ $orders['currency'] }} </span> <b
                                        class="text-danger">-{{ $orders['coupon_value'] }}</b></span></div>
                        @endisset

                        <div class="prd_option_inner"><span>Total Tax</span><span style="float: right;"> <span
                                    class="price_main"> {{ $orders['currency'] }}
                                </span>{{ $orders['total_tax'] }}</span></div>

                        <div class="prd_option_inner"><span>Total Service Charge</span><span style="float: right;"> <span
                                    class="price_main"> {{ $orders['currency'] }}
                                </span>{{ $orders['total_service_tax'] }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body bg-dark text-light">
                <div class="product_list_details">

                    <div class="prd_option_inner"><span>Total Amount</span><span style="float: right;"> <span
                                class="price_main"> {{ $orders['currency'] }} </span> <b>{{ $orders['total'] }}</b>
                        </span></div>

                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).on("click", '#cancel_order', function() {
            var product_id = $(this).attr('data-id');
            var order_id = $(this).attr('data-order-id');

            deleteMsg('Are you sure to delete ?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.orders.cancel') }}",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            product_id: product_id,
                            order_id: order_id,
                        },


                        success: function(response) {
                            success_msg("{{ translate('Cancel Successfully...') }}")
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500)
                        }
                    });
                    e.preventDefault();
                }
            });


        });
    </script>
@endsection
