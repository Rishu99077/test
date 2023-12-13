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

    <div class="row mb-3">

        <form action="" method="post" class="mb-3" id="product_filter">
            @csrf
            <div class="row">
                <div class="col-lg-2">
                    <input type="text" name="All" class="form-control search-input" value="{{ $common['report_all'] }}"
                        placeholder="{{ translate('Product Name') }}">
                </div>

                <div class="col-md-2">
                    <input class="form-control datetimepicker" id="timepicker3" name="Order_date" type="text" placeholder="Y-m-d to Y-m-d" value="{{ $common['report_date'] }}" data-options='{"mode":"range","dateFormat":"Y-m-d","locale":"en"}' style="height: 38px;" />
                </div>

                <div class="col-lg-2">
                    <input type="text" name="OrderID" class="form-control search-input" value="{{ $common['report_id'] }}"
                        placeholder="{{ translate('Order ID') }}">
                </div>

                <div class="col-lg-1">
                    <input type="text" name="Name" class="form-control search-input" value="{{ $common['report_name'] }}"
                        placeholder="{{ translate('Name') }}">
                </div>

                <div class="col-lg-1">
                    <input type="text" name="Email" class="form-control search-input" value="{{ $common['report_email'] }}"
                        placeholder="{{ translate('Email') }}">
                </div>

                <div class="col-lg-2">
                    <button class="btn btn-success" type="submit" name="filter" id="filter" value="filter" >{{ translate('Filter') }}</button>
                    <button class="btn btn-danger" type="submit" id="reset" name="reset" value="reset" >{{ translate('Reset') }}</button></a>
                </div>

                <div class="col-lg-2">
                    <a href="{{ route('admin.sales_report_export') }}"><button class="btn btn-primary float-end"
                            type="button">{{ translate('Export') }}</button></a>
                </div>
            </div>
        </form>

    </div>

    <div class="card mb-3" id="ordersTable"
        data-list='{"valueNames":["order","date","address","status","amount"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Reports</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                    <thead class="bg-200 text-900">
                        <tr>

                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">OrderID</th>
                            <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Date</th>
                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="address"
                                style="min-width: 12.5rem;">Ship To</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-orders-body">
                        @if ($get_orders)
                            @foreach ($get_orders as $key => $value)
                                <tr class="btn-reveal-trigger">

                                    <td class="order py-2 align-middle white-space-nowrap"><a
                                            href="{{ route('admin.orders.view', encrypt($value['id'])) }}">
                                            <strong>#{{ $value['order_id'] }}</strong></a> by
                                        <strong>{{ $value['first_name'] }} {{ $value['last_name'] }}</strong><br /><a
                                            href="{{ route('admin.orders.view', encrypt($value['id'])) }}">{{ $value['email'] }}</a>
                                    </td>

                                    <td class="date py-2 align-middle">{{ $value['created_at']->format('d-m-Y') }}</td>

                                    <td class="address py-2 align-middle white-space-nowrap">
                                        {{ $value['address'] }}
                                    </td>
                                    <td class="amount py-2 align-middle text-end fs-0 fw-medium">AED
                                        {{ $value['total'] }}
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

        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-center">
                {!! $get_orders->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript">
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            }
            $('#reportrange').daterangepicker({
                <?php if (!empty($common['startDate']) AND !empty($common['endDate'])) { ?>
                startDate: '<?php echo $common['startDate']; ?>',
                endDate: '<?php echo $common['endDate']; ?>',
                <?php }else{ ?>
                startDate: start,
                endDate: end,
                <?php } ?>
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                locale: {
                    format: 'YYYY/MM/DD'
                }
            }, cb);
            <?php if (!empty($common['startDate']) AND !empty($common['endDate'])) { ?>
            <?php }else{ ?>
            $('#reportrange').val('');
            <?php } ?>
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            cb(start, end);
        });
    </script>
@endsection
