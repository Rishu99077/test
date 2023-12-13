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

        <form class="col-lg-12" action="{{ route('admin.best_seller_report_export') }}" method="post" class="mb-3">
            @csrf

            <button type="submit" class="btn btn-primary float-end">{{ translate('Export') }}</button>
        </form>
    </div>

    <div class="card mb-3" id="ordersTable"
        data-list='{"valueNames":["order","date","address","status","amount"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Best Sellers Report</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                    <thead class="bg-200 text-900">
                        <tr>

                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">Product name</th>
                            <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Date</th>
                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="address"
                                style="min-width: 12.5rem;">Product type</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Sales Count
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-orders-body">
                        @if ($get_products)
                            @foreach ($get_products as $key => $value)
                                <tr class="btn-reveal-trigger">
                                    @if ($value['product_type'] == 'excursion')
                                        @php $route_val = 'excursion'; @endphp
                                    @elseif($value['product_type'] == 'lodge')
                                        @php $route_val = 'lodge'; @endphp
                                    @elseif($value['product_type'] == 'yacht')
                                        @php $route_val = 'yacht'; @endphp
                                    @elseif($value['product_type'] == 'limousine')
                                        @php $route_val = 'limousine';  @endphp
                                    @endif

                                    <td class="order py-2 align-middle white-space-nowrap">
                                        <a
                                            href="{{ $route_val }}/edit/{{ encrypt($value['id']) }}"><strong>#{{ $value['order_id'] }}</strong></a>
                                        <strong>{{ $value['title'] }}</strong><br />
                                        <a
                                            href="{{ $route_val }}/edit/{{ encrypt($value['id']) }}">{{ $value['slug'] }}</a>
                                    </td>

                                    <td class="date py-2 align-middle">{{ $value['created_at']->format('d-m-Y') }}</td>

                                    <td class="address py-2 align-middle white-space-nowrap">
                                        {{ $value['product_type'] }}
                                    </td>
                                    <td class="amount py-2 align-middle text-end fs-0 fw-medium">
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

        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-center">
                {!! $get_products->links() !!}
            </div>
        </div>
    </div>
@endsection
