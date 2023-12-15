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
                    <li class="breadcrumb-item"><a href="{{ route('admin.partner_account') }}">{{ $common['title'] }}</a>
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
                                        <input type="text" class="form-control" placeholder="Order ID" name="order_id"
                                            value="{{ $common['order_id'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Name') }}</label>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Name" name="order_name"
                                            value="{{ $common['order_name'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Email') }}</label>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Email" name="order_email"
                                            value="{{ $common['order_email'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="form-label" for="order_Date">{{ translate('Date') }}</label>
                                    <input class="form-control datetimepicker" id="timepicker3" name="order_Date"
                                        type="text" placeholder="Y-m-d to Y-m-d"
                                        value="{{ $common['order_orderDate'] }}"
                                        data-options='{"mode":"range","dateFormat":"Y-m-d","locale":"en"}' />
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Order status') }}</label>
                                    <div>
                                        <select name="order_status" class="form-control">
                                            <option value=""></option>
                                            <option value="Success" {{ getSelected($common['order_status'], 'Success') }}>
                                                {{ translate('Success') }}</option>
                                            <option value="Pending" {{ getSelected($common['order_status'], 'Pending') }}>
                                                {{ translate('Pending') }}
                                            </option>
                                            <option value="Failed" {{ getSelected($common['order_status'], 'Failed') }}>
                                                {{ translate('Failed') }}
                                            </option>
                                        </select>
                                    </div>
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
                            <h5>{{ $common['title'] }}</h5>
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
                                            <th>{{ translate('Email') }}</th>
                                            <th>{{ translate('Detail') }}</th>
                                            <th>{{ translate('Amount') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($get_orders) > 0)
                                        @foreach ($get_orders as $key => $value)
                                            <tr>
                                                <th scope="row">{{ $key + $get_orders->firstItem() }}</th>
                                                <td>
                                                    {{ $value['order_id'] }}
                                                    <br>
                                                    <?php echo date('Y-m-d', strtotime($value['created_at'])); ?>
                                                </td>

                                                <td>{{ $value['first_name'] . ' ' . $value['last_name'] }}</td>

                                                <td>{{ $value['email'] }}</td>
                                                <td>
                                                    @php
                                                        $get_order_detail = json_decode($value['order_json']);

                                                    @endphp
                                                    @if (isset($get_order_detail->detail))
                                                        @foreach ($get_order_detail->detail as $key => $order_val)
                                                            @php
                                                                $class = '';
                                                                if (isset($order_val->is_cancel)) {
                                                                    if ($order_val->is_cancel == 1) {
                                                                        $class = 'transport_danger border-5';
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="row {{ $class }}">
                                                                <div class="col-sm-8 col-md-8">
                                                                    <b>{{ $order_val->title }}</b>
                                                                </div>
                                                                <div class="col-sm-4 col-md-4 text-right">
                                                                    {{ $order_val->date }}
                                                                </div>
                                                                <div class="col-sm-12 col-md-12">
                                                                    <p>Option : {{ $order_val->option_details->title }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ get_price_front('', '', '', '', $value['total_amount']) }}</td>
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
                                <div class="dataTables_paginate paging_simple_numbers">
                                    {{ $get_orders->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // $(document).ready(function() {
        function ChangeStatus(e, id) {
            var is_approved = 'Deactive';
            if ($(e).prop('checked') == true) {
                is_approved = 'Active';
            }
            $.ajax({
                "type": "POST",
                "data": {
                    is_approved: is_approved,
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.change_status') }}",
                success: function(response) {
                    window.location.reload();

                }
            })
        }
        // })
    </script>
@endsection
