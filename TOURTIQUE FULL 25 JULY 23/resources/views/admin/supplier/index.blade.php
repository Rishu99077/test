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
        <a class="btn btn-falcon-primary me-1 mb-1" href="{{ route('admin.supplier.add') }}" type="button"><span class="fas fa-plus-circle text-primary "></span> Add New </a>
    </div>
</div>

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
                                        <th scope="col">#</th>
                                        <th scope="col">{{ translate('Full Name') }}</th>
                                        <th scope="col">{{ translate('email') }}</th>
                                        <th scope="col">{{ translate('company_name') }}</th>
                                        <th class="" scope="col">{{ translate('Status') }}</th>
                                        <th class="text-end" scope="col">{{ translate('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @if (!$get_supplier->isEmpty())
                                    @foreach ($get_supplier as $key => $value)
                                    <tr>
                                        <td>{{ $key + $get_supplier->firstItem() }}</td>
                                        <td>{{ $value['username'] }}</td>
                                        <td>{{ $value['email'] }}</td>
                                        <td>{{ $value['company_name'] }}</td>
                                        <td>
                                            {!! checkStatus($value['status']) !!}

                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <a class="btn p-0" href="{{ route('admin.supplier.edit', encrypt($value['id'])) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span>
                                                </a>

                                                <a class="btn p-0" onclick="return  doconfirm(this);" href="{{ route('admin.supplier.delete', encrypt($value['id'])) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span>
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
                            {{ $get_supplier->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection