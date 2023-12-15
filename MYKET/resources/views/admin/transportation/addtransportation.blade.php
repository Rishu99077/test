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
                    <li class="breadcrumb-item"><a href="{{ route('admin.transportation') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $common['heading_title'] }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                        </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.transportation.add') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $get_transportation['id'] }}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Title') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                                name="title" type="text"
                                                value="{{ old('title', $get_transportation_language['title']) }}"
                                                placeholder="Enter Title" required = "">
                                            @error('title')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Status') }}</label>
                                            <select id="status" name="status" class="form-control stock">
                                                <option value="Active">{{ translate('Active') }}</option>
                                                <option value="Deactive"
                                                    {{ getSelected($get_transportation['status'], 'Deactive') }}>
                                                    {{ translate('Deactive') }}
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-3">
                                        <div class="checkbox-fade fade-in-success">
                                            <label>
                                                <input type="checkbox" name="capacity_tab"
                                                    {{ $get_transportation['capacity'] == 'yes' ? 'checked' : 'no' }}
                                                    class="my_tabs" value="capacity_tab" id="capacity_tab">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-success"></i>
                                                </span> <span>{{ translate('Capacity Tab') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="checkbox-fade fade-in-success">
                                            <label>
                                                <input type="checkbox" name="air_conditioning_tab"
                                                    {{ $get_transportation['air_conditioning'] == 'yes' ? 'checked' : 'no' }}
                                                    class="my_tabs" value="air_conditioning_tab" id="air_conditioning_tab">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-success"></i>
                                                </span> <span>{{ translate('Air Conditioning Tab') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="checkbox-fade fade-in-success">
                                            <label>
                                                <input type="checkbox" name="wifi_tab"
                                                    {{ $get_transportation['wifi'] == 'yes' ? 'checked' : 'no' }}
                                                    class="my_tabs" value="wifi_tab" id="wifi_tab">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-success"></i>
                                                </span> <span>{{ translate('Wifi Tab') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="checkbox-fade fade-in-success">
                                            <label>
                                                <input type="checkbox" name="private_shared_tab"
                                                    {{ $get_transportation['private_shared'] == 'yes' ? 'checked' : 'no' }}
                                                    class="my_tabs" value="private_shared_tab" id="private_shared_tab">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-success"></i>
                                                </span> <span>{{ translate('Private Shared Tab') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit"
                                            class="btn btn-primary  m-b-0 mr-0">{{ $common['button'] }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
