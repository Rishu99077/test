@extends('admin.layout.master')
@section('content')
    
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="{{ route('admin.staff.add') }}" type="button"><span
                    class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }}</a>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                            aria-labelledby="tab-dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc"
                            id="dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th class="text-end" scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @if (count($get_staff) > 0)
                                            @foreach ($get_staff as $key => $value)
                                                <tr>
                                                    <td>{{ $key + $get_staff->firstItem() }}</td>
                                                    <td>{{ $value['first_name'] . ' ' . $value['last_name'] }}</td>
                                                    <td>{{ $value['email'] }}</td>
                                                    <td>{!! checkStatus($value['status']) !!}</td>
                                                    <td class="text-end">
                                                        <div>
                                                            <a class="btn p-0" href="{{ route('admin.staff.edit', encrypt($value['id'])) }}" type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></a>
                                                            <a class="btn p-0" onclick="return doconfirm();" href="{{ route('admin.staff.delete', encrypt($value['id'])) }}"
                                                                type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <img src="{{ asset('public/assets/img/no_record.png') }}"
                                                        alt="">
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $get_staff->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
