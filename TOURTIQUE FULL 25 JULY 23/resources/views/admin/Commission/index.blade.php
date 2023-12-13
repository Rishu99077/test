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


</div>
<form action="" method="get" class="mb-3">
    <div class="row">
        <label>Search</label>
        <div class="col-lg-3">
            <select class="form-select single-select" name="Order">
                <option value="">{{ translate('Select Order') }}</option>
                @foreach ($product_checkout as $val)
                <option value="{{ $val['id'] }}" {{ getSelected($val['id'], old('Order', @$_GET['Order'])) }}> {{ $val['order_id'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3">
            <input type="text" name="Affilliate_code" class="form-control search-input" value="{{@$_GET['Affilliate_code']}}" placeholder="{{ translate('Search Affilliate Code') }}">
        </div>

        <div class="col-lg-3">
            <select class="form-select single-select" name="Affiliate">
                <option value="">{{ translate('Select Affiliate') }}</option>
                @foreach ($get_affiliates as $val)
                <option value="{{ $val['id'] }}" {{ getSelected($val['id'], old('Affiliate', @$_GET['Affiliate'])) }}> {{ $val['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-1">
            <button class="btn btn-success" type="submit">{{ translate('Filter') }}</button>
        </div>
        <div class="col-lg-1">
            <a href="{{route('admin.commission')}}"><button class="btn btn-danger" type="button">{{ translate('Reset') }}</button></a>
        </div>
    </div>
</form>

<div class="row g-3 mb-3 ">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body pt-0">
                <div class="tab-content">
                    <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc" id="dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc">
                        <div class="table-responsive scrollbar">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ translate('Order ID') }}</th>
                                        <th scope="col">{{ translate('Affiliate') }}</th>
                                        <th scope="col">{{ translate('Affilliate Code') }}</th>
                                        <th scope="col">{{ translate('Total') }}</th>
                                        <th scope="col">{{ translate('Remain') }}</th>
                                        <th scope="col">{{ translate('Paid Amount') }}</th>
                                        <th class="text-end" scope="col">{{ translate('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @if (!$get_affiliate_commission->isEmpty())
                                    @foreach ($affiliate_comission as $key => $value)
                                    <tr>
                                        <td>#{{ $value['product_order_id'] }}</td>
                                        <td>{{ $value['affiliate_name'] }}</td>
                                        <td>{{ $value['affilliate_code'] }}</td>
                                        <td>AED {{ $value['total'] }}</td>
                                        <td>{{ $value['remaining_amount']}}</td>
                                        <td>{{ $value['total_paid_amount'] }}</td>
                                        <td class="text-end">
                                            <div>
                                                <a class="btn p-0" href="{{ route('admin.commission.view', encrypt($value['id'])) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="view"><span class="text-500 fas fa-eye"></span>
                                                </a>
                                            </div>
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
                        <div>
                            {{ $get_affiliate_commission->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection