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
                    <li class="breadcrumb-item"><a href="{{ route('admin.partner_account') }}">{{ $common['title'] }}</a>
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
                                    <label class="col-form-label">{{ translate('Supplier Name') }}</label>
                                    <div>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Supplier Name') }}" name="partner_name"
                                            value="{{ $common['partner_name'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Supplier Email') }}</label>
                                    <div>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Supplier Email') }}" name="partner_email"
                                            value="{{ $common['partner_email'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="col-form-label">{{ translate('Status') }}</label>
                                    <div>
                                        <select name="partner_status" class="form-control">
                                            <option value=""></option>
                                            <option value="Active" {{ getSelected($common['partner_status'], 'Active') }}>
                                                {{ translate('Active') }}</option>
                                            <option value="Deactive"
                                                {{ getSelected($common['partner_status'], 'Deactive') }}>
                                                {{ translate('Deactive') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label class="form-label" for="partner_date">{{ translate('Date') }}</label>
                                    <input class="form-control datetimepicker" id="timepicker3" name="partner_date"
                                        type="text" placeholder="Y-m-d to Y-m-d" value="{{ $common['partner_date'] }}"
                                        data-options='{"mode":"range","dateFormat":"Y-m-d","locale":"en"}' />
                                </div>

                                <div class="col-sm-3 form-group">
                                    <label class="col-form-label"> {{ translate('Action') }}</label>
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
                            <h5>{{ translate('Total') . ' ' . $common['title'] . ' (' . $get_partners_count . ')' }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                            <a href="{{ route('admin.partner_account.add') }}"
                                class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                data-modal="modal-13"> <i
                                    class="icofont icofont-plus m-r-5"></i>{{ translate('Add Supplier') }}
                            </a>

                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> {{ translate('Name') }}</th>
                                            <th> {{ translate('Email') }}</th>

                                            <th> {{ translate('Verified') }}</th>
                                            <th> {{ translate('Status') }}</th>
                                            <th> {{ translate('Approved') }}</th>
                                            <th> {{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($get_partners) > 0)
                                        @foreach ($get_partners as $key => $value)
                                            <tr>
                                                <th scope="row">{{ $key + $get_partners->firstItem() }}</th>

                                                <td>{{ $value['first_name'] . ' ' . $value['last_name'] }}
                                                    <span class=" d-block f-14 text-custom">{{ translate('Created at :') }}
                                                        <?php echo date('Y, M d', strtotime($value['created_at'])); ?></span>
                                                </td>

                                                <td>{{ $value['email'] }}</td>

                                                <td>
                                                    {!! checkStatus($value['is_verified'] == 1 ? 'verified' : 'Not verified') !!}
                                                </td>
                                                <td>
                                                    {!! checkStatus($value['status']) !!}
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="" id="aa{{ $value['id'] }}"
                                                        onchange="ChangeStatus(this,{{ $value['id'] }})"
                                                        class="add-page-check"
                                                        {{ $value['status'] == 'Active' ? 'checked' : '' }}>
                                                    <label for="aa{{ $value['id'] }}"><span></span></label>
                                                </td>
                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ route('admin.partner_account.edit', encrypt($value['id'])) }}"
                                                            class="btn btn-success btn-icon">
                                                            <i class="icofont icofont-ui-edit"></i></a>
                                                        <a data-href="{{ route('admin.partner_account.delete', encrypt($value['id'])) }}"
                                                            class="btn btn-danger btn-icon text-white confirm-delete">
                                                            <i class="icofont icofont-ui-delete"></i></a>
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
                                    {{ $get_partners->appends(request()->query())->links() }}
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
