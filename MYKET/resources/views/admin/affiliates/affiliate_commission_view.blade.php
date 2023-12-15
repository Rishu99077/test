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
                <div class="col-md-12">
                    <div class="card p-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 ">
                                    <h4 class="text-dark text-left f-18 ">{{ translate('Order ID') }} :
                                        {{ $commissions['order_id'] }}
                                    </h4>
                                </div>
                                <div class="col-md-3 ">
                                    <h4 class="text-dark text-left f-18 ">{{ translate('Order Date') }} :
                                        {{ date('Y-m-d', strtotime($commissions['date'])) }}
                                    </h4>
                                </div>
                                <div class="col-md-2 ">
                                    <h4 class="text-dark f-18 ">{{ translate('Code') }} :
                                        {{ $commissions['affilliate_code'] }}</h4>
                                </div>
                                <div class="col-md-2 ">
                                    <h4 class="text-dark text-right f-18 ">{{ translate('User') }}:
                                        {{ $commissions['user_name'] }}
                                    </h4>
                                </div>
                                <div class="col-md-2 ">
                                    <h4 class="text-dark text-right f-18 ">{{ translate('Total') }}:
                                        {{ get_price_front('', '', '', '', $commissions['total']) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($commissions['products']) > 0)
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ translate('Affiliate Commissions') }}</h5>

                                <a href="{{ url(goPreviousUrl()) }}"
                                    class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                    data-modal="modal-13"> <i
                                        class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                                </a>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="example-2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ translate('Product Name') }}</th>
                                                <th>{{ translate('Commission') }}</th>
                                                <th>{{ translate('Product Amount') }}</th>
                                                <th>{{ translate('Commission Amount') }}</th>

                                            </tr>
                                        </thead>
                                        </tbody>

                                        @foreach ($commissions['products'] as $key => $value)
                                            @php
                                                $class = '';
                                                if (isset($value->is_cancel)) {
                                                    if ($value->is_cancel == 1) {
                                                        $class = 'transport_danger border-5';
                                                    }
                                                }
                                            @endphp
                                            <tr class="{{ $class }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $value->product_name }}
                                                </td>

                                                <td>{{ $value->commission }}%
                                                </td>

                                                <td>{{ get_price_front('', '', '', '', $value->product_amount) }}</td>
                                                <td>{{ get_price_front('', '', '', '', $value->commission_amount) }}</td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
