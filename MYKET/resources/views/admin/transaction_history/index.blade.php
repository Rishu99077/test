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
                    <li class="breadcrumb-item"><a href="{{ route('admin.affiliates') }}">{{ $common['title'] }}</a>
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

                                <div class="col-sm-3 form-group">
                                    <label class="col-form-label">{{ translate('User Name') }} </label>
                                    <div>
                                        <input type="text" class="form-control" placeholder="User Name" name="user_name"
                                            value="{{ $common['user_name'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-3 form-group">
                                    <label class="col-form-label">{{ translate('User Type') }} </label>
                                    <div>
                                        <select name="user_type" class="form-control">
                                            <option value=""></option>
                                            <option value="Affiliate" {{ getSelected($common['user_type'], 'Affiliate') }}>
                                                {{ translate('Affiliate') }}</option>
                                            <option value="Partner" {{ getSelected($common['user_type'], 'Partner') }}>
                                                {{ translate('Partner') }}
                                            </option>
                                            <option value="Hotel" {{ getSelected($common['user_type'], 'Hotel') }}>
                                                {{ translate('Hotel') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Status') }}</label>
                                    <div>
                                        <select name="user_status" class="form-control">
                                            <option value=""></option>
                                            <option value="Active" {{ getSelected($common['user_status'], 'Active') }}>
                                                {{ translate('Active') }}</option>
                                            <option value="Deactive" {{ getSelected($common['user_status'], 'Deactive') }}>
                                                {{ translate('Deactive') }}
                                            </option>
                                        </select>
                                    </div>
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
                            <h5>{{ translate('All Users') }}</h5>
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
                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Email') }}</th>
                                            <th>{{ translate('Amount paid') }}</th>
                                            <th>{{ translate('Type') }}</th>
                                            <th>{{ translate('Total Amount') }} </th>
                                            <th>{{ translate('Due Amount') }} </th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($get_user) > 0)
                                        @foreach ($get_user as $key => $value)
                                            <tr>
                                                <th scope="row">{{ $key + $get_user->firstItem() }}</th>

                                                <td>{{ $value['first_name'] }} {{ $value['last_name'] }}</td>
                                                <td>{{ $value['email'] }}</td>
                                                <td>
                                                    @php
                                                        $PaidAmount = '15th of month';
                                                        $PaidAmountClass = 'badge badge-warning';
                                                        if ($value['paid_amount_days_type'] == 1) {
                                                            $PaidAmount = 'End of month';
                                                            $PaidAmountClass = 'badge badge-info';
                                                        }
                                                    @endphp
                                                    <span class="{{ $PaidAmountClass }}">{{ $PaidAmount }}</span>
                                                </td>
                                                <td>{{ $value['user_type'] }}</td>
                                                <td>{{ get_price_front('', '', '', '', $value['total_commission'] == '' ? 0 : $value['total_commission']) }}
                                                </td>
                                                <td>{{ get_price_front('', '', '', '', $value['total_commission'] - $value['total_paid']) }}
                                                </td>

                                                <td> {!! checkStatus($value['status']) !!} </td>
                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ route('admin.transaction_history.view', encrypt($value['id'])) }}"
                                                            class="btn btn-warning btn-icon text-white" target="_blank"> <i
                                                                class="icofont icofont-eye"></i>
                                                        </a>
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
                                    {{ $get_user->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
