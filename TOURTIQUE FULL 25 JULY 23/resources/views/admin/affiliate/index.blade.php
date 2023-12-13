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
            <a class="btn btn-falcon-primary me-1 mb-1" href="{{ route('admin.affiliate.add') }}" type="button"><span
                    class="fas fa-plus-circle text-primary "></span> Add New </a>
        </div>
    </div>

    <div class="row g-3 mb-3 affiliate_list">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                            aria-labelledby="tab-dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc"
                            id="dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc">
                            <div class="table-responsive scrollbar mt-2 mb-2">

                                <table class="data-table">
                                    <thead class="d-none">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Email') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th width="100px">{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({

                ajax: "{{ route('admin.affiliate') }}",
                // processing: true,
                language: {
                    emptyTable: "<img src='{{ asset('assets/img/no_record.png') }}'>"
                },
                serverSide: true,
                bLengthChange: false,
                info: false,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });
            $("thead").removeClass('d-none');
        });
    </script>
@endsection
