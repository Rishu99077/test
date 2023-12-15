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
                    <li class="breadcrumb-item"><a href="{{ route('admin.hotels') }}">{{ $common['title'] }}</a>
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
                            <form id="main" method="post" action="{{ route('admin.hotels.add') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $get_hotels['id'] }}">

                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('hotel_owner_name') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Owner Name') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('hotel_owner_name') ? 'form-control-danger' : '' }}"
                                                name="hotel_owner_name" type="text"
                                                value="{{ old('hotel_owner_name', $get_hotels['first_name']) }}"
                                                placeholder="Enter Owner Name">
                                            @error('hotel_owner_name')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('hotel_name') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Home Name') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('hotel_name') ? 'form-control-danger' : '' }}"
                                                name="hotel_name" type="text"
                                                value="{{ old('hotel_name', $get_hotels_language['hotel_name']) }}"
                                                placeholder="Enter Home Name">
                                            @error('hotel_name')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Email') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                                name="email" type="text"
                                                value="{{ old('email', $get_hotels['email']) }}"
                                                placeholder="Enter Hotel Email">
                                            @error('email')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if ($get_hotels['id'] == '')
                                        <div class="col-md-4">
                                            <div
                                                class="form-group mb-3 {{ $errors->has('password') ? 'has-danger' : '' }}">
                                                <label class="col-form-label">{{ translate('Password') }}<span
                                                        class="mandatory cls"
                                                        style="color:red; font-size:15px">*</span></label>
                                                <input
                                                    class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}"
                                                    name="password" type="password"
                                                    value="{{ old('password', $get_hotels['password']) }}"
                                                    placeholder="Enter Password">
                                                @error('password')
                                                    <div class="col-form-alert-label">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group mb-3 {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                                                <label class="col-form-label">{{ translate('Confirm password') }}<span
                                                        class="mandatory cls"
                                                        style="color:red; font-size:15px">*</span></label>
                                                <input
                                                    class="form-control {{ $errors->has('confirm_password') ? 'form-control-danger' : '' }}"
                                                    name="confirm_password" type="password"
                                                    value="{{ old('confirm_password', $get_hotels['password']) }}"
                                                    placeholder="Enter Confirm password">
                                                @error('confirm_password')
                                                    <div class="col-form-alert-label">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('Country') }}
                                            </label>
                                            <select id="country" name="country" onchange="getStateCity('country')"
                                                class="form-control select2">
                                                <option value="" disabled selected>{{ translate('Select') }}</option>
                                                @foreach ($Countries as $C)
                                                    <option value="{{ $C['id'] }}"
                                                        {{ getSelected($C['id'], $get_hotels['country']) }}>
                                                        {{ $C['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('State') }}</label>
                                            <select id="state" name="state" onchange="getStateCity('state')"
                                                class="form-control select2">
                                                <option value="" disabled selected>{{ translate('Select') }}</option>
                                                @foreach ($States as $S)
                                                    <option value="{{ $S['id'] }}"
                                                        {{ getSelected($S['id'], $get_hotels['state']) }}>
                                                        {{ $S['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('City') }}</label>
                                            <select id="city" name="city" class="form-control select2">
                                                <option value="" disabled selected>{{ translate('Select') }}
                                                </option>
                                                @foreach ($Cities as $CI)
                                                    <option value="{{ $CI['id'] }}"
                                                        {{ getSelected($CI['id'], $get_hotels['city']) }}>
                                                        {{ $CI['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('comission') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Commission') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control numberonly {{ $errors->has('comission') ? 'form-control-danger' : '' }}"
                                                name="comission" type="text"
                                                value="{{ old('comission', $get_hotels['hotel_commission']) }}"
                                                placeholder="Enter Commission">
                                            @error('comission')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('Status') }}</label>
                                            <select id="status" name="status" class="form-control status">
                                                <option value="Active">{{ translate('Active') }}</option>
                                                <option value="Deactive"
                                                    {{ getSelected($get_hotels['status'], 'Deactive') }}>
                                                    {{ translate('Deactive') }}
                                                </option>
                                            </select>
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
