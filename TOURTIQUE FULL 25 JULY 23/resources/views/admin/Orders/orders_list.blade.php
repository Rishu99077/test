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
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="text-dark"> {{ translate('Filter') }}</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" class="mb-3" id="product_filter">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="product_name" class="form-control search-input"
                            value="{{ $common['product_name'] }}" placeholder="{{ translate('Product Name') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <input class="form-control datetimepicker" id="timepicker3" name="Order_date" type="text"
                            placeholder="Y-m-d to Y-m-d" value="{{ $common['order_date'] }}"
                            data-options='{"mode":"range","dateFormat":"Y-m-d","locale":"en"}' style="height: 38px;" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <input type="text" name="OrderID" class="form-control search-input"
                            value="{{ $common['order_id'] }}" placeholder="{{ translate('Order ID') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <input type="text" name="Name" class="form-control search-input"
                            value="{{ $common['order_name'] }}" placeholder="{{ translate('Name') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <input type="text" name="Email" class="form-control search-input"
                            value="{{ $common['order_email'] }}" placeholder="{{ translate('Email') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <select class="form-select single-select" name="Status">
                            <option value="">-- Search Status --</option>
                            <option value="Success" <?php if ($common['order_status']=='Success') { ?> selected="selected" <?php } ?>> Success
                            </option>
                            <option value="Pending" <?php if ($common['order_status']=='Pending') { ?> selected="selected" <?php } ?>> Pending
                            </option>
                            <option value="Failed" <?php if ($common['order_status']=='Failed') { ?> selected="selected" <?php } ?>> Failed
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-md-12 text-end">
                        <button class="btn btn-success" type="submit" name="filter" id="filter"
                            value="filter">{{ translate('Filter') }}</button>
                        <a href="{{ route('admin.orders') }}"><button class="btn btn-danger" type="submit" id="reset"
                                name="reset" value="reset">{{ translate('Reset') }}</button></a>
                        <a href="{{ route('admin.generate_excel') }}"><button class="btn btn-warning"
                                type="button">{{ translate('Generate Excel') }}</button></a>
                    </div>


                </div>
            </form>
        </div>

    </div>

    <div class="card mb-3" id="ordersTable"
        data-list='{"valueNames":["order","date","address","status","amount"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Orders</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                    <thead class="bg-200 text-900">
                        <tr>

                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">OrderID</th>
                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">Products Name</th>
                            <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Booking Date</th>
                            <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Excursion Date</th>
                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="address"
                                style="min-width: 12.5rem;">Ship To</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Sent to
                                supplier</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status
                            </th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Paid to
                                supplier</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Amount</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-orders-body">
                        @if ($get_details_arr)
                            @foreach ($get_details_arr as $key => $value)
                                <tr class="btn-reveal-trigger">

                                    <td class="order py-2 align-middle white-space-nowrap"><a
                                            href="{{ route('admin.orders.view', encrypt($value['id'])) }}">
                                            <strong>{{ $value['order_id'] }}</strong></a> by
                                        <strong>{{ $value['first_name'] }} {{ $value['last_name'] }}</strong><br /><a
                                            href="{{ route('admin.orders.view', encrypt($value['id'])) }}">{{ $value['email'] }}</a>
                                    </td>

                                    <td class="address py-2 align-middle white-space-nowrap">
                                        <ul>
                                            @if ($value['product_type'] == 'product')
                                                @foreach ($value['products'] as $key => $value_p)
                                                    <li>{{ $value_p['title'] }}</li>
                                                @endforeach
                                            @else
                                                <li>{{ $value['title'] }}</li>
                                            @endif
                                        </ul>



                                    </td>
                                    <td class="date py-2 align-middle">{{ $value['date'] }}</td>

                                    <td class="date py-2 align-middle">{{ $value['date'] }}</td>

                                    <td class="address py-2 align-middle white-space-nowrap" style="min-width: 12.5rem;">
                                        {{ $value['address'] }}
                                    </td>
                                    <form action="{{ route('admin.order_supplier_update') }}" method="post"
                                        id="product_submit">
                                        @csrf
                                        <td class="address py-2 align-middle white-space-nowrap">
                                            @if ($value['product_type'] == 'product')
                                                <input type="hidden" name="checkout_id" class="form-control"
                                                    value="{{ $value['id'] }}">
                                                <input type="checkbox" name="sent_to_supplier"
                                                    {{ $value['sent_to_supplier'] == 1 ? 'checked' : '' }}>
                                                <input type="text" name="supplier_name" class="form-control"
                                                    value="{{ $value['supplier_name'] }}">
                                            @endif
                                        </td>
                                        <td class="status py-2 align-middle text-center fs-0 white-space-nowrap">
                                            @if ($value['status'] == 'Success')
                                                <span
                                                    class="badge badge rounded-pill d-block badge-soft-success">{{ $value['status'] }}
                                                    <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                                                </span>
                                            @elseif($value['status'] == 'Pending')
                                                <span
                                                    class="badge badge rounded-pill d-block badge-soft-warning">{{ $value['status'] }}
                                                    <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>
                                                </span>
                                            @elseif($value['status'] == 'Failed')
                                                <span
                                                    class="badge badge rounded-pill d-block badge-soft-danger">{{ $value['status'] }}
                                                    <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="address py-2 align-middle white-space-nowrap">
                                            @if ($value['product_type'] == 'product')
                                                <input type="checkbox" name="paid_to_supplier"
                                                    {{ $value['paid_to_supplier'] == 1 ? 'checked' : '' }}>
                                                <br>
                                            @endif
                                        </td>
                                        <td class="amount py-2 align-middle text-end fs-0 fw-medium">
                                            {{ $value['currency'] }}
                                            {{ $value['total'] }}
                                        </td>


                                        <td class="py-2 align-middle white-space-nowrap text-end">
                                            @if ($value['product_type'] == 'product')
                                                <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                                <a
                                                    href="{{ url('admin.generate_product_voucher', encrypt($value['id'])) }}"><button
                                                        class="btn btn-sm btn-primary" type="button">Print</button></a>

                                                <a class="btn p-0"
                                                    href="{{ route('admin.orders.view', encrypt($value['id'])) }}"
                                                    type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View"><span class="text-500 fas fa-eye"></span>
                                                </a>
                                            @else
                                                <a
                                                    href="{{ route('admin.generate_airport_voucher', encrypt($value['id'])) }}"><button
                                                        class="btn btn-sm btn-primary" type="button">Print</button></a>
                                                <a class="btn p-0"
                                                    href="{{ route('admin.orders.airport_transfer_order_detail', encrypt($value['id'])) }}"
                                                    type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View"><span class="text-500 fas fa-eye"></span>
                                                </a>
                                            @endif
                                        </td>


                                    </form>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" align="center">
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
