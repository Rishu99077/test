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
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>

        </div>
        <!-- Page header end -->
        <!-- Page body start -->
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
                        </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.settings') }}" novalidate
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @foreach ($get_settings as $key => $value)
                                        @if (get_setting_data($key, 'type') == 'file')
                                            <div class="col-md-4">
                                                <div class="form-group mb-3 {{ $errors->has($key) ? 'has-danger' : '' }}">
                                                    <label
                                                        class="col-form-label">{{ get_setting_data($key, 'title') }}</label>
                                                    <input type="file"
                                                        class="form-control {{ $errors->has($key) ? 'form-control-danger' : '' }}"
                                                        onchange="loadFile(event,'{{ $key }}')"
                                                        name="{{ $key }}" type="file">
                                                    @error($key)
                                                        <div class="col-form-alert-label">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- placeholder --}}
                                                <div class="media-left">
                                                    <a href="#" class="profile-image">
                                                        <img class="user-img img-circle img-css" id="{{ $key }}"
                                                            src="{{ $get_settings[$key] != '' ? url('uploads/setting', $get_settings[$key]) : asset('uploads/placeholder/placeholder.png') }}">
                                                    </a>
                                                </div>
                                            </div>
                                        @elseif (get_setting_data($key, 'type') == 'text')
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                                    <label
                                                        class="col-form-label">{{ get_setting_data($key, 'title') }}</label>
                                                    <input type="text"
                                                        class="form-control  {{ $key == 'affilliate_commission' || $key == 'admin_commission' ? 'numberonly' : '' }} {{ $errors->has($key) ? 'form-control-danger' : '' }}"
                                                        name="{{ $key }}" id="name"
                                                        placeholder="{{ get_setting_data($key, 'title') }}"
                                                        name="{{ $key }}"
                                                        value="{{ old($key, $get_settings[$key]) }}">
                                                    @error($key)
                                                        <div class="col-form-alert-label">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif (get_setting_data($key, 'type') == 'textarea')
                                            <div class="col-md-12">
                                                <div
                                                    class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                                    <label class="col-form-label"
                                                        for="description">{{ get_setting_data($key, 'title') }}</label>
                                                    <textarea class="form-control {{ $errors->has($key) ? 'is-invalid' : '' }}" id="footer_text"
                                                        placeholder="{{ get_setting_data($key, 'title') }}" name="{{ $key }}">{{ old($key, $get_settings[$key]) }}</textarea>
                                                    @error($key)
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif (get_setting_data($key, 'type') == 'textarea_editor')
                                            <div class="col-md-12">
                                                <div
                                                    class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                                    <label class="col-form-label"
                                                        for="description">{{ get_setting_data($key, 'title') }}</label>
                                                    <textarea class="form-control summernote {{ $errors->has($key) ? 'is-invalid' : '' }}" id="footer_text"
                                                        placeholder="{{ get_setting_data($key, 'title') }}" name="{{ $key }}">{{ old($key, $get_settings[$key]) }}</textarea>
                                                    @error($key)
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif (get_setting_data($key, 'type') == 'checkbox')
                                            <div class="col-md-4">
                                                <div class="form-check form-switch mt-4">
                                                    <input class="form-check-input" id="{{ $key }}"
                                                        type="checkbox"
                                                        {{ $get_settings[$key] == 'active' ? 'checked' : '' }}>
                                                    <input type="hidden" value="{{ $get_settings[$key] }}"
                                                        name="{{ $key }}" id="inp_social">
                                                    <label class="form-check-label"
                                                        for="{{ $key }}">{{ translate('Social Icon') }}
                                                        Status</label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit"
                                            class="btn btn-primary m-b-0 mr-0">{{ translate('Submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
@endsection
