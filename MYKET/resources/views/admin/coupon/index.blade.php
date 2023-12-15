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
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.coupon') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <form action="" method="post" id="">
                        @csrf
                        <div class="card p-20 pb-0 pt-1">
                            <div class="row">

                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Coupon Code') }}</label>
                                    <div>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Coupon Code') }}" name="coupon_code"
                                            value="{{ $common['coupon_code'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Amount Type') }}</label>
                                    <div>
                                        <select name="coupon_amount_type" class="form-control">
                                            <option value=""></option>
                                            <option value="percentage"
                                                {{ getSelected($common['coupon_amount_type'], 'percentage') }}>
                                                {{ translate('Percentage') }}</option>
                                            <option value="fixed"
                                                {{ getSelected($common['coupon_amount_type'], 'fixed') }}>
                                                {{ translate('Fixed') }}
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Type') }}</label>
                                    <div>
                                        <select name="coupon_type" class="form-control">
                                            <option value=""></option>
                                            <option value="partner" {{ getSelected($common['coupon_type'], 'partner') }}>
                                                {{ translate('Partner') }}</option>
                                            <option value="category" {{ getSelected($common['coupon_type'], 'category') }}>
                                                {{ translate('Category') }}
                                            </option>
                                            <option value="product" {{ getSelected($common['coupon_type'], 'product') }}>
                                                {{ translate('Product') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Status') }}</label>
                                    <div>
                                        <select name="coupon_status" class="form-control">
                                            <option value=""></option>
                                            <option value="Active" {{ getSelected($common['coupon_status'], 'Active') }}>
                                                {{ translate('Active') }}</option>
                                            <option value="Deactive"
                                                {{ getSelected($common['coupon_status'], 'Deactive') }}>
                                                {{ translate('Deactive') }}
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="form-label" for="coupon_date">{{ translate('Date') }}</label>
                                    <input class="form-control datetimepicker" id="timepicker3" name="coupon_date"
                                        type="text" placeholder="Y-m-d to Y-m-d" value="{{ $common['coupon_date'] }}"
                                        data-options='{"mode":"range","dateFormat":"Y-m-d","locale":"en"}' />
                                </div>

                                <div class="col-sm-2 form-group">
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
                        <div class="card-header">
                            <h5>{{ translate('Coupon') }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                            <a href="{{ route('admin.coupon.add') }}"
                                class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i>
                                {{ translate('Add Coupon') }}
                            </a>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Code') }}</th>
                                            <th>{{ translate('Start date') }} </th>
                                            <th>{{ translate('End date') }} </th>
                                            <th>{{ translate('Minimum Amount') }} </th>
                                            <th>{{ translate('Coupon Amount Type') }} </th>
                                            <th>{{ translate('Coupon Amount') }} </th>
                                            <th>{{ translate('Type') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($get_coupon) > 0)
                                        @foreach ($get_coupon as $key => $value)
                                            <tr>
                                                <th scope="row">{{ $key + $get_coupon->firstItem() }}</th>
                                                <td>{{ $value['code'] }}</td>
                                                <td>{{ date('d-m-Y', strtotime($value['start_date'])) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($value['end_date'])) }}</td>
                                                <td>{{ $value['minimum_amount'] }}</td>
                                                <td>{{ ucfirst($value['coupon_amount_type']) }}</td>
                                                <td>{{ $value['coupon_amount'] }}</td>
                                                <td>{{ ucfirst($value['coupon_type']) }}</td>

                                                <td>
                                                    {!! checkStatus($value['status']) !!}
                                                </td>
                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ route('admin.coupon.edit', encrypt($value['id'])) }}"
                                                            class="btn btn-success btn-icon">
                                                            <i class="icofont icofont-ui-edit"></i></a>
                                                        <a data-href="{{ route('admin.coupon.delete', encrypt($value['id'])) }}"
                                                            class="btn btn-danger btn-icon text-white confirm-delete">
                                                            <i class="icofont icofont-ui-delete"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <h3>{{ config('adminconfig.record_not_found') }}</h3>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="dataTables_paginate paging_simple_numbers">
                                    {{ $get_coupon->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
