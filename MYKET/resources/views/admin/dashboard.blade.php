@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Dashboard</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form action="" method="post" id="product_filter_34">
                        @csrf
                        <div class="card p-20 pb-0 pt-1">
                            <div class="row">

                                <div class="col-sm-3 form-group">
                                    <label class="form-label" for="order_Date">{{ translate('Date') }}</label>
                                    <input class="form-control datetimepicker" id="timepicker3" name="order_Date"
                                        type="text" placeholder="Y-m-d to Y-m-d" value="{{ $common['order_orderDate'] }}"
                                        data-options='{"mode":"range","dateFormat":"Y-m-d","locale":"en"}' />
                                </div>

                                <div class="col-sm-3 form-group">
                                    <label class="col-form-label">{{ translate('Action') }}</label>
                                    <div>
                                        <button class="btn btn-primary p-2" type="submit" name="filter" value="filter">
                                            <span class="fa fa-filter"></span> {{ translate('Filter') }}
                                        </button>
                                        <button type="submit" class="btn bg-dark cursor-pointer p-2" id="reset2"
                                            name="reset" value="reset"><span class="fa fa-refresh"></span>
                                            {{ translate('Reset') }}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-facebook">
                                            <h3>{{ $data['AffiliateCount'] }}</h3>
                                            <a href="{{ route('admin.affiliates') }}">
                                                <span
                                                    class="m-t-10 f-16 text-white">{{ translate('Total Affiliates') }}</span>
                                            </a>
                                            <i class="icon-user-follow"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-twitter">
                                            <h3>{{ $data['PartnerCount'] }}</h3>
                                            <a href="{{ route('admin.partner_account') }}">
                                                <span
                                                    class="m-t-10 f-16 text-white">{{ translate('Total Suppliers') }}</span>
                                            </a>
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-google-plus">
                                            <h3>{{ $data['HotelCount'] }}</h3>
                                            <a href="{{ route('admin.hotels') }}">
                                                <span class="m-t-10 f-16 text-white">{{ translate('Total Hotels') }}</span>
                                            </a>
                                            <i class="fa fa-h-square"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-success">
                                            <h3>{{ $data['ProductCount'] }}</h3>
                                            <a href="{{ route('admin.get_products') }}">
                                                <span
                                                    class="m-t-10 f-16 text-white">{{ translate('Total Products') }}</span>
                                            </a>
                                            <i class="fa fa-product-hunt"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-linkein">
                                            <h3>{{ get_price_front('', '', '', '', $data['total_earning']) }}</h3>
                                            <a href="javacript:void(0)">
                                                <span
                                                    class="m-t-10 f-16 text-white">{{ translate('Total Earning') }}</span>
                                            </a>
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-dark-primary">
                                            <h3>{{ get_price_front('', '', '', '', $data['total_earning_by_affilliate']) }}
                                            </h3>
                                            <a href="javacript:void(0)">
                                                <span
                                                    class="m-t-10 f-16 text-white">{{ translate('Earning By Affilliate') }}</span>
                                            </a>
                                            <i class="icofont icofont-coins"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card social-widget-card">
                                        <div class="card-block-big bg-facebook">
                                            <h3>{{ get_price_front('', '', '', '', $data['total_earning_by_hotel']) }}
                                            </h3>
                                            <a href="javacript:void(0)">
                                                <span
                                                    class="m-t-10 f-16 text-white">{{ translate('Earning By Hotel') }}</span>
                                            </a>
                                            <i class="icofont icofont-bank-alt"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Generated Affilliate Earning') }}</h5>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>

                            </div>

                        </div>
                        <div class="card-block">
                            <div id="donut-example"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Generated Supplier Earning') }}</h5>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>

                            </div>

                        </div>
                        <div class="card-block">
                            <div id="supplier-donut-example"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Generated Hotel Earning') }}</h5>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>

                            </div>

                        </div>
                        <div class="card-block">
                            <div id="hotel-donut-example"></div>
                        </div>
                    </div>
                </div>
                <!-- Donut chart Ends -->

                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Last 10 Orders') }}</h5>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>

                            </div>

                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>

                                            <th>{{ translate('Order ID') }}</th>
                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Email') }}</th>
                                            <th>{{ translate('Amount') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($data['last_orders']) > 0)
                                        @foreach ($data['last_orders'] as $key => $value)
                                            <tr>

                                                <td>{{ $value['order_id'] }}</td>
                                                <td>{{ $value['first_name'] . ' ' . $value['last_name'] }}
                                                    <span
                                                        class=" d-block f-14 text-custom">{{ translate('Created at :') }}
                                                        <?php echo date('Y, M d', strtotime($value['created_at'])); ?></span>
                                                </td>

                                                <td>{{ $value['email'] }}</td>

                                                <td>
                                                    {{ get_price_front('', '', '', '', $value['total_amount']) }}
                                                </td>
                                                <td>
                                                    {!! checkStatus($value['status']) !!}
                                                </td>

                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ route('admin.orders.details', encrypt($value['id'])) }}"
                                                            class="btn btn-warning btn-icon ">
                                                            <i class="icofont icofont-eye"></i></a>
                                                    </div>
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
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Last 10 Products --}}
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Last 10 Unapproved Products') }}</h5>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>

                            </div>

                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>

                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Added By') }}</th>
                                            <th>{{ translate('Status') }}</th>

                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>

                                    @if (count($data['last_product']) > 0)
                                        @foreach ($data['last_product'] as $key => $value)
                                            <tr>

                                                <td>{{ $value['title'] != '' ? $value['title'] : 'No Title' }}
                                                    <span
                                                        class=" d-block f-14 text-custom">{{ translate('Created at :') }}
                                                        <?php echo date('Y, M d', strtotime($value['created_at'])); ?></span>
                                                </td>
                                                <td>{{ ucfirst($value['added_by']) }}

                                                </td>

                                                <td>
                                                    {!! checkStatus($value['is_approved']) !!}
                                                </td>

                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ url('/add-product/title/') }}?tourId={{ $value['id'] }}"
                                                            class="btn btn-success btn-icon ">
                                                            <i class="fa fa-edit"></i></a>
                                                    </div>
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
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@section('script')
    <script>
        $(document).ready(function() {
            donutChart();
            supplierdonutChart();
            hoteldonutChart();

            $(window).on("resize", function() {
                window.donutChart.redraw();
            });
        });

        /*Donut chart*/
        function donutChart() {
            window.areaChart = Morris.Donut({
                element: "donut-example",
                redraw: true,
                data: <?php echo json_encode($data['afffilliate_commission_chart'], JSON_NUMERIC_CHECK); ?>,

                colors: ["#5FBEAA", "#c90d34", "#FF9F55"],
            });
        }

        function supplierdonutChart() {
            window.areaChart = Morris.Donut({
                element: "supplier-donut-example",
                redraw: true,
                data: <?php echo json_encode($data['supplier_commission_chart'], JSON_NUMERIC_CHECK); ?>,

                colors: ["#0e84eb", "#ff0000", "#00ffa8"],
            });
        }

        function hoteldonutChart() {
            window.areaChart = Morris.Donut({
                element: "hotel-donut-example",
                redraw: true,
                data: <?php echo json_encode($data['hotel_commission_chart'], JSON_NUMERIC_CHECK); ?>,

                colors: ["#9d978e", "#6c1515", "#a3b110"],
            });
        }
    </script>
@endsection
@endsection
