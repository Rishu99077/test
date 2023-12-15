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
                        <a href = "{{ route('admin.dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.affiliate_commission') }}">{{ $common['title'] }}</a>
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
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Order ID') }}</label>
                                    <div>
                                        <input type="text" class="form-control" placeholder="{{ translate('Order ID') }}"
                                            name="affilliate_order_id" value="{{ $common['aff_affilliate_order_id'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Affilliate code') }}</label>
                                    <div>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Affilliate code') }}" name="affilliate_code"
                                            value="{{ $common['aff_affilliate_code'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Affilliate Name') }}</label>
                                    <div>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Affilliate Name') }}" name="affilliate_name"
                                            value="{{ $common['aff_affilliate_name'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-2 form-group">
                                    <label class="form-label" for="affilliate_date">{{ translate('Order Date') }}</label>
                                    <input class="form-control datetimepicker" id="timepicker3" name="affilliate_date"
                                        type="text" placeholder="Y-m-d to Y-m-d"
                                        value="{{ $common['aff_affilliate_date'] }}"
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
                        <div class="card-header">
                            <h5>{{ translate('Affiliate Commissions') }}</h5>

                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>

                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Order ID') }} </th>
                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Affilliate code') }} </th>
                                            <th>{{ translate('Amount') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($get_affiliates_commisions) > 0)
                                        @foreach ($get_affiliates_commisions as $key => $value)
                                            <tr>
                                                <th scope="row">{{ $key + $get_affiliates_commisions->firstItem() }}
                                                </th>
                                                <td>
                                                    <a target="_blank"
                                                        href="{{ route('admin.orders.details', ['id' => encrypt($value['order_id'])]) }}">{{ $value['OrderId'] }}</a>
                                                </td>

                                                <td>{{ $value['first_name'] }} {{ $value['last_name'] }}
                                                    <span class=" d-block f-14 text-custom">{{ translate('Order Date :') }}
                                                        <?php echo date('Y, M d', strtotime($value['created_at'])); ?></span>
                                                </td>
                                                <td>{{ $value['affilliate_code'] }}</td>
                                                <td>{{ get_price_front('', '', '', '', $value['total']) }}</td>
                                                <td>{!! checkStatus($value['status']) !!}</td>
                                                <td>
                                                    <div class="action_cls mt-2">

                                                        <a href="{{ route('admin.affiliate_commission.view', encrypt($value['id'])) }}"
                                                            class=" btn btn-success btn-icon ">
                                                            <i class="icofont icofont-eye-alt"></i></a>
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
                                <div class="dataTables_paginate paging_simple_numbers">
                                    {{ $get_affiliates_commisions->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
