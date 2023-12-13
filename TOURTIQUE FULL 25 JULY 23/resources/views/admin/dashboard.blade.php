@extends('admin.layout.master')
@section('content')
    <div class="content mt-4">
        <div class="row g-3 mb-2">
            <div class="col-xxl-8">
                {{-- <div id="chartContainer" style="height: 310px; width: 100%;"></div> --}}

                <div class="card">
                    <div class="card-header ">
                        <div class="row flex-between-center g-0">
                            <div class="col-auto">
                                <h6 class="mb-0">Sales Report</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body  pe-xxl-0 pb-4">

                        <div class="echart-line-total-sales-ecommerce" data-echart-responsive="true"
                            data-options='{"optionOne":"ecommerceLastMonth"}'></div>
                    </div>
                </div>

            </div>
            <div class="col-xxl-4">
                <div class="card h-100">
                    <div class="card-header d-flex flex-between-center border-bottom py-2">
                        <h6 class="mb-0">Top Seller Products</h6>
                    </div>
                    <div class="card-body">

                        <div class="echart-pie-chart-example" id="echart-pie-chart-example" style="min-height: 320px;"
                            data-echart-responsive="true">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-md-4 col-xxl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">{{ translate('Active Users') }}</h6>
                                <h4 class="fs-3 fw-normal text-primary"
                                    data-countup="{&quot;endValue&quot;:{{ $user_count }} }">
                                    {{ $user_count }}
                                </h4>

                            </div>
                            <div class="col-auto h-100">
                                <a href="{{ route('admin.user') }}">
                                    <span class="badge rounded-pill badge-soft-secondary">
                                        {{ translate('View all') }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xxl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">{{ translate('Active Partner') }}</h6>
                                <h4 class="fs-3 fw-normal text-primary"
                                    data-countup="{&quot;endValue&quot;:{{ $partner_count }} }">
                                    {{ $partner_count }}
                                </h4>

                            </div>
                            <div class="col-auto h-100">
                                <a href="{{ route('admin.partners_list') }}">
                                    <span class="badge rounded-pill badge-soft-primary">
                                        {{ translate('View all') }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xxl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">{{ translate('Affiliates') }}</h6>
                                <h4 class="fs-3 fw-normal text-primary"
                                    data-countup="{&quot;endValue&quot;:{{ $staff_count }} }">
                                    {{ $staff_count }}
                                </h4>

                            </div>
                            <div class="col-auto h-100">
                                <a href="{{ route('admin.affiliate') }}">
                                    <span class="badge rounded-pill badge-soft-warning">
                                        {{ translate('View all') }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3 mb-3">
            <div class="col-xxl-12">

                <div class="row g-3 mb-3 mt-1">
                    <div class="col-sm-6 col-md-4">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card"
                                style="background-image:url(assets/img/icons/spot-illustrations/corner-1.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6> {{ translate('Products') }} {{-- <span class="badge badge-soft-warning rounded-pill ms-2">-0.23%</span> --}}</h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                                    data-countup="{&quot;endValue&quot;:{{ $product_count }}}">{{ $product_count }}</div>
                                <a class="fw-semi-bold fs--1 text-nowrap" href="{{ route('admin.excursion') }}">
                                    {{ translate('See all') }}
                                    <svg class="svg-inline--fa fa-angle-right fa-w-8 ms-1" data-fa-transform="down-1"
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right"
                                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                        data-fa-i2svg="" style="transform-origin: 0.25em 0.5625em;">
                                        <g transform="translate(128 256)">
                                            <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                                <path fill="currentColor"
                                                    d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"
                                                    transform="translate(-128 -256)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card"
                                style="background-image:url(assets/img/icons/spot-illustrations/corner-2.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6>{{ translate('Orders') }} {{-- <span class="badge badge-soft-info rounded-pill ms-2">0.0%</span> --}} </h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                                    data-countup="{&quot;endValue&quot;:{{ $total_checkout }},&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                                    {{ $total_checkout }}k
                                </div>
                                <a class="fw-semi-bold fs--1 text-nowrap" href="{{ route('admin.orders') }}">
                                    {{ translate('All orders') }}
                                    <svg class="svg-inline--fa fa-angle-right fa-w-8 ms-1" data-fa-transform="down-1"
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right"
                                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                        data-fa-i2svg="" style="transform-origin: 0.25em 0.5625em;">
                                        <g transform="translate(128 256)">
                                            <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                                <path fill="currentColor"
                                                    d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"
                                                    transform="translate(-128 -256)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card"
                                style="background-image:url(assets/img/icons/spot-illustrations/corner-3.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6>{{ translate('Affiliate Commission') }}</h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif">
                                    AED
                                    {{ number_format($affilliateCommission, 2) }}
                                </div>
                                <a class="fw-semi-bold fs--1 text-nowrap" href="#">
                                    {{ translate('Statistics') }}
                                    <svg class="svg-inline--fa fa-angle-right fa-w-8 ms-1" data-fa-transform="down-1"
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right"
                                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                        data-fa-i2svg="" style="transform-origin: 0.25em 0.5625em;">
                                        <g transform="translate(128 256)">
                                            <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                                <path fill="currentColor"
                                                    d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"
                                                    transform="translate(-128 -256)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-header d-flex flex-between-center bg-light py-2">
                        <h6 class="mb-0">{{ translate('Upcoming Bookings') }}</h6>
                        <div class="dropdown font-sans-serif btn-reveal-trigger">

                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="table-responsive scrollbar">
                            <table class="table table-dashboard mb-0 fs--1">
                                <tbody class="list" id="table-orders-body">
                                    @if ($optionArr)
                                        @foreach ($optionArr as $key => $value)
                                            @if ($value['type'] == 'excursion')
                                                @php
                                                    
                                                    $badge = 'badge badge-soft-primary';
                                                @endphp
                                            @elseif($value['type'] == 'lodge')
                                                @php
                                                    
                                                    $badge = 'badge badge-soft-secondary';
                                                    
                                                @endphp
                                            @elseif($value['type'] == 'Yatch')
                                                @php
                                                    
                                                    $badge = 'badge badge-soft-info';
                                                    
                                                @endphp
                                            @elseif($value['type'] == 'limousine')
                                                @php
                                                    
                                                    $badge = 'badge badge-soft-warning';
                                                    
                                                @endphp
                                            @else
                                                @php
                                                    $badge = '';
                                                @endphp
                                            @endif

                                            <tr class="btn-reveal-trigger">

                                                <td class="order py-2 align-middle white-space-nowrap">
                                                    <a class="text-800"
                                                        href="{{ route('admin.orders.view', ['id' => encrypt($value['id'])]) }}"><strong>#{{ $value['order_id'] }}</strong>
                                                        <br />
                                                    </a>

                                                </td>
                                                <td> <strong>{{ $value['title'] }}</strong></td>
                                                <td> <strong>{{ $value['date'] }}</strong></td>

                                                <td class="address py-2 align-middle white-space-nowrap">
                                                    <span class="{{ $badge }}">
                                                        {{ $value['type'] }}</span>
                                                </td>
                                                <td class=" py-2 align-middle text-end fs-0 fw-medium">
                                                    AED {{ $value['total_amount'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">
                                                <img src="{{ asset('public/assets/img/no_record.png') }}" alt="">
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-2">
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                {{-- <select class="form-select form-select-sm">
                        <option>Last 7 days</option>
                        <option>Last Month</option>
                        <option>Last Year</option>
                     </select> --}}
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-link btn-sm px-0 fw-medium"
                                    href="{{ route('admin.upcoming_booking_report') }}">
                                    View All
                                    <svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="chevron-right" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z">
                                        </path>
                                    </svg>
                                    <!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card overflow-hidden">
                    <div class="card-header d-flex flex-between-center bg-light py-2">
                        <h6 class="mb-0">{{ translate('Last 10 Order Summary') }}</h6>
                        <div class="dropdown font-sans-serif btn-reveal-trigger">

                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="table-responsive scrollbar">
                            <table class="table table-dashboard mb-0 fs--1">
                                <tbody>

                                    @if (count($get_orders) > 0)
                                        @foreach ($get_orders as $key => $value)
                                            <tr>
                                                <td class="align-middle ps-0 text-nowrap">
                                                    <div class="d-flex position-relative align-items-center">
                                                        <div class="flex-1">
                                                            <a class="stretched-link"
                                                                href="{{ route('admin.orders.view', encrypt($value['id'])) }}">
                                                                <h6 class="mb-0">#{{ $value['order_id'] }}</h6>by
                                                                <strong>{{ $value['first_name'] }}
                                                                    {{ $value['last_name'] }}</strong><br /><a
                                                                    href="{{ route('admin.orders.view', encrypt($value['id'])) }}">{{ $value['email'] }}</a>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle px-4" style="width:1%;">
                                                    @if ($value['status'] == 'Success')
                                                        <span
                                                            class="badge fs--1 w-100 badge-soft-success">{{ $value['status'] }}</span>
                                                    @elseif($value['status'] == 'Pending')
                                                        <span
                                                            class="badge fs--1 w-100 badge-soft-warning">{{ $value['status'] }}</span>
                                                    @elseif($value['status'] == 'Failed')
                                                        <span
                                                            class="badge fs--1 w-100 badge-soft-danger">{{ $value['status'] }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle px-4 text-end text-nowrap" style="width:1%;">
                                                    <h6 class="mb-0">AED {{ $value['total'] }}</h6>
                                                    <p class="fs--2 mb-0">{{ $value['created_at']->format('d-m-Y') }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">
                                                <img src="{{ asset('public/assets/img/no_record.png') }}" alt="">
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-2">
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                {{-- <select class="form-select form-select-sm">
                        <option>Last 7 days</option>
                        <option>Last Month</option>
                        <option>Last Year</option>
                     </select> --}}
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-link btn-sm px-0 fw-medium" href="{{ route('admin.orders') }}">
                                    View All
                                    <svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="chevron-right" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z">
                                        </path>
                                    </svg>
                                    <!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card overflow-hidden">
                    <div class="card-header d-flex flex-between-center bg-light py-2">
                        <h6 class="mb-0">{{ translate('Best Selling Product') }}</h6>
                        <div class="dropdown font-sans-serif btn-reveal-trigger">

                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="table-responsive scrollbar">
                            <table class="table table-dashboard mb-0 fs--1">
                                <tbody class="list" id="table-orders-body">
                                    @if ($get_best_seller)
                                        @foreach ($get_best_seller as $key => $value)
                                            <tr class="btn-reveal-trigger">
                                                @if ($value['product_type'] == 'excursion')
                                                    @php
                                                        $route_val = 'excursion';
                                                        $badge = 'badge badge-soft-primary';
                                                    @endphp
                                                @elseif($value['product_type'] == 'lodge')
                                                    @php
                                                        $route_val = 'lodge';
                                                        $badge = 'badge badge-soft-secondary';
                                                        
                                                    @endphp
                                                @elseif($value['product_type'] == 'yacht')
                                                    @php
                                                        $route_val = 'yacht';
                                                        $badge = 'badge badge-soft-info';
                                                        
                                                    @endphp
                                                @elseif($value['product_type'] == 'limousine')
                                                    @php
                                                        $route_val = 'limousine';
                                                        $badge = 'badge badge-soft-warning';
                                                        
                                                    @endphp
                                                @endif

                                                <td class="order py-2 align-middle white-space-nowrap">
                                                    <a class="text-800"
                                                        href="{{ $route_val }}/edit/{{ encrypt($value['id']) }}"><strong>#{{ $value['order_id'] }}</strong>
                                                        <strong>{{ $value['title'] }}</strong><br />
                                                    </a>

                                                </td>

                                                <td class="address py-2 align-middle white-space-nowrap">
                                                    <span class="{{ $badge }}">
                                                        {{ $value['product_type'] }}</span>
                                                </td>
                                                <td class=" py-2 align-middle text-end fs-0 fw-medium">
                                                    {{ $value['sales_count'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">
                                                <img src="{{ asset('public/assets/img/no_record.png') }}" alt="">
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-2">
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                {{-- <select class="form-select form-select-sm">
                        <option>Last 7 days</option>
                        <option>Last Month</option>
                        <option>Last Year</option>
                     </select> --}}
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-link btn-sm px-0 fw-medium"
                                    href="{{ route('admin.best_seller_report') }}">
                                    View All
                                    <svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="chevron-right" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z">
                                        </path>
                                    </svg>
                                    <!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($get_charts_items != '') {
        $dataPoints = [];
        $allDates = [];
        foreach ($get_charts_items as $key => $value) {
            $my_arr = [];
            $my_arr['y'] = number_format($value['totale'], 2);
            $my_arr['label'] = $value['month_name'];
            $dataPoints[] = $my_arr;
            $allDates[] = $value['month_name'];
        }
    }
    ?>

    <script>
        console.log({!! $get_charts_items->toJson() !!});
        var dateArr = [];
        var totalAmount = []
        $.each({!! $get_charts_items->toJson() !!}, function(key, value) {
            dateArr.push(value.month_name)
        });

        $.each({!! $get_charts_items->toJson() !!}, function(key, value) {
            totalAmount.push(value.totale.toFixed(2))
        });
        console.log("$dataPoints", "{{ json_encode($dataPoints) }}");
        var totalSalesEcommerce = function totalSalesEcommerce() {
            var ECHART_LINE_TOTAL_SALES_ECOMM = '.echart-line-total-sales-ecommerce';
            var $echartsLineTotalSalesEcomm = document.querySelector(ECHART_LINE_TOTAL_SALES_ECOMM);
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            function getFormatter(params) {
                return params.map(function(_ref16, index) {
                    console.log("index", _ref16);
                    var value = _ref16.value,
                        borderColor = _ref16.borderColor;
                    return "<span class= \"fas fa-circle\" style=\"color: ".concat(borderColor,
                        "\"></span>\n    <span class='text-600'>").concat(index === 0 ? _ref16
                        .axisValueLabel :
                        'Previous Year', ": ").concat(value, "</span>");
                }).join('<br/>');
            }

            if ($echartsLineTotalSalesEcomm) {
                // Get options from data attribute
                var userOptions = utils.getData($echartsLineTotalSalesEcomm, 'options');
                var TOTAL_SALES_LAST_MONTH = "#".concat(userOptions.optionOne);

                var totalSalesLastMonth = document.querySelector(TOTAL_SALES_LAST_MONTH);
                var chart = window.echarts.init($echartsLineTotalSalesEcomm);

                var getDefaultOptions = function getDefaultOptions() {
                    return {
                        color: utils.getGrays()['100'],
                        tooltip: {
                            trigger: 'axis',
                            padding: [6, 7],
                            backgroundColor: utils.getGrays()['100'],
                            borderColor: utils.getGrays()['300'],
                            textStyle: {
                                color: utils.getColors().dark
                            },
                            borderWidth: 1,
                            formatter: function formatter(params) {
                                return getFormatter(params);
                            },
                            transitionDuration: 0,
                            position: function position(pos, params, dom, rect, size) {
                                return getPosition(pos, params, dom, rect, size);
                            }
                        },
                        legend: {
                            data: ['lastMonth'],
                            show: false
                        },
                        xAxis: {
                            type: 'category',
                            data: dateArr,
                            boundaryGap: false,
                            axisPointer: {
                                lineStyle: {
                                    color: utils.getColor('300'),
                                    type: 'dashed'
                                }
                            },
                            splitLine: {
                                show: false
                            },
                            axisLine: {
                                lineStyle: {
                                    // color: utils.getGrays()['300'],
                                    color: utils.rgbaColor('#000', 0.01),
                                    type: 'dashed'
                                }
                            },
                            axisTick: {
                                show: false
                            },
                            axisLabel: {
                                color: utils.getColor('400'),
                                formatter: function formatter(value) {
                                    var date = new Date(value);
                                    return "".concat(months[date.getMonth()], " ").concat(date.getDate());
                                },
                                margin: 15 // showMaxLabel: false

                            }
                        },
                        yAxis: {
                            type: 'value',

                            axisPointer: {
                                show: false
                            },
                            splitLine: {
                                lineStyle: {
                                    color: utils.getColor('300'),
                                    type: 'dashed',

                                }
                            },
                            boundaryGap: true,
                            axisLabel: {
                                show: true,
                                color: utils.getColor('400'),
                                margin: -15
                            },
                            axisTick: {
                                show: false
                            },
                            axisLine: {
                                show: false
                            }
                        },
                        series: [{
                            name: 'lastMonth',
                            type: 'line',
                            data: totalAmount,
                            scrollbar: true,
                            lineStyle: {
                                color: '#f5803e'
                            },
                            itemStyle: {
                                borderColor: '#f5803e',
                                borderWidth: 2
                            },
                            symbol: 'circle',
                            symbolSize: 10,
                            hoverAnimation: true,
                            areaStyle: {
                                color: {
                                    type: 'linear',
                                    x: 0,
                                    y: 0,
                                    x2: 0,
                                    y2: 1,
                                    colorStops: [{
                                        offset: 0,
                                        color: utils.rgbaColor("#f5803e", 0.2)
                                    }, {
                                        offset: 1,
                                        color: utils.rgbaColor("#f5803e", 0)
                                    }]
                                }
                            }
                        }],
                        grid: {
                            right: '40px',
                            left: '35px',
                            bottom: '15%',
                            top: '5%'
                        }
                    };
                };

                echartSetOption(chart, userOptions, getDefaultOptions);
                totalSalesLastMonth.addEventListener('click', function() {
                    chart.dispatchAction({
                        type: 'legendToggleSelect',
                        name: 'lastMonth'
                    });
                });

            }
        };
    </script>

    <script>
        var echartsPieChartInit = function echartsPieChartInit() {

            var $pieChartEl = document.querySelector('.echart-pie-chart-example');



            if ($pieChartEl) {

                // Get options from data attribute

                var userOptions = utils.getData($pieChartEl, 'options');

                var chart = window.echarts.init($pieChartEl);



                var getDefaultOptions = function getDefaultOptions() {

                    return {



                        series: [{

                            type: 'pie',

                            radius: window.innerWidth < 530 ? '45%' : '60%',

                            label: {

                                color: utils.getGrays()['700']

                            },

                            center: ['50%', '55%'],

                            data: {!! json_encode($bestSellerChart) !!},

                            emphasis: {

                                itemStyle: {

                                    shadowBlur: 10,

                                    shadowOffsetX: 0,

                                    shadowColor: utils.rgbaColor(utils.getGrays()['600'], 0.5)

                                }

                            }

                        }],

                        tooltip: {

                            trigger: 'item',

                            padding: [7, 10],

                            backgroundColor: utils.getGrays()['100'],

                            borderColor: utils.getGrays()['300'],

                            textStyle: {

                                color: utils.getColors().dark

                            },

                            borderWidth: 1,

                            transitionDuration: 0,

                            axisPointer: {

                                type: 'none'

                            }

                        }

                    };

                };



                echartSetOption(chart, userOptions, getDefaultOptions); //- set chart radius on window resize



                utils.resize(function() {

                    if (window.innerWidth < 530) {

                        chart.setOption({

                            series: [{

                                radius: '45%'

                            }]

                        });

                    } else {

                        chart.setOption({

                            series: [{

                                radius: '60%'

                            }]

                        });

                    }

                });

            }

        };
    </script>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Sales Report"
                },
                axisY: {
                    title: "Sales"
                },
                data: [{
                    type: "line",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
@endsection
