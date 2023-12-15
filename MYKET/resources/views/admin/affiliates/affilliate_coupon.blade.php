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
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.affiliates.affilliate_coupon', ['id' => encrypt($id)]) }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $common['title'] }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                            <a href="{{ route('admin.add_affilliate_coupon', ['Afid' => encrypt($id)]) }}"
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
                                                <td>{{ $value['coupon_amount_type'] }}</td>
                                                <td>{{ $value['coupon_amount'] }}</td>
                                                <td>{{ $value['coupon_type'] }}</td>

                                                <td>
                                                    {!! checkStatus($value['status']) !!}
                                                </td>
                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ route('admin.edit_affilliate_coupon', ['Afid' => encrypt($value['value']), 'id' => encrypt($value['id'])]) }}"
                                                            class="btn btn-success btn-icon text-white">
                                                            <i class="icofont icofont-ui-edit"></i></a>
                                                        <a data-href="{{ route('admin.coupon.delete', encrypt($value['id'])) }}"
                                                            class="btn btn-danger btn-icon text-white">
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
