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
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $common['heading_title'] }}</h5>
                            <a href = "{{ route('admin.partner_account') }}">
                                <a href="{{ url(goPreviousUrl()) }}"
                                    class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                    data-modal="modal-13"> <i
                                        class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                                </a>

                            </a>
                        </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.partner_account.add') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $get_partners['id'] }}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('First Name') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('first_name') ? 'form-control-danger' : '' }}"
                                                name="first_name" type="text"
                                                value="{{ old('first_name', $get_partners['first_name']) }}"
                                                placeholder="Enter First Name">
                                            @error('first_name')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Last Name') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('last_name') ? 'form-control-danger' : '' }}"
                                                name="last_name" type="text"
                                                value="{{ old('last_name', $get_partners['last_name']) }}"
                                                placeholder="Enter Last Name">
                                            @error('last_name')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('image') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Image') }}</label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('image') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image')" name="image">
                                            @error('image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            <a href="#" class="profile-image">
                                                <img class="user-img img-circle img-css" id="image"
                                                    src="{{ $get_partners['image'] != '' ? url('uploads/user_image', $get_partners['image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Status') }}</label>
                                            <select id="status" name="status" class="form-control stock">
                                                <option value="Active">{{ translate('Active') }}</option>
                                                <option value="Deactive"
                                                    {{ getSelected($get_partners['status'], 'Deactive') }}>
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

                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('phone_number') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Phone Number') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control numberonly {{ $errors->has('phone_number') ? 'form-control-danger' : '' }}"
                                                name="phone_number" type="text"
                                                value="{{ old('phone_number', $get_partners['phone_number']) }}"
                                                placeholder="Enter Phone Number">
                                            @error('phone_number')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Email') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                                name="email" type="text" <?php if ($get_partners['email']!='') { ?> readonly
                                                <?php } ?> value="{{ old('email', $get_partners['email']) }}"
                                                placeholder="Enter Email">
                                            @error('email')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('company_email') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Company Email') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('company_email') ? 'form-control-danger' : '' }}"
                                                name="company_email" type="text"
                                                value="{{ old('company_email', $get_partners['company_email']) }}"
                                                placeholder="Enter Company Email">
                                            @error('company_email')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('company_phone') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Company Phone') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control numberonly {{ $errors->has('company_phone') ? 'form-control-danger' : '' }}"
                                                name="company_phone" type="text"
                                                value="{{ old('company_phone', $get_partners['company_phone']) }}"
                                                placeholder="Enter Company Phone">
                                            @error('company_phone')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('partner_commission') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Admin Commission') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control numberonly {{ $errors->has('partner_commission') ? 'form-control-danger' : '' }}"
                                                name="partner_commission" type="text"
                                                value="{{ old('partner_commission', $get_partners['partner_commission']) }}"
                                                placeholder="Enter Admin Commission">
                                            @error('partner_commission')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if ($get_partners['id'] == '')
                                        <div class="col-md-6">
                                            <div
                                                class="form-group mb-3 {{ $errors->has('password') ? 'has-danger' : '' }}">
                                                <label class="col-form-label">{{ translate('Password') }}<span
                                                        class="mandatory cls"
                                                        style="color:red; font-size:15px">*</span></label>
                                                <input
                                                    class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}"
                                                    name="password" type="password"
                                                    value="{{ old('password', $get_partners['password']) }}"
                                                    placeholder="Enter Password">
                                                @error('password')
                                                    <div class="col-form-alert-label">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                class="form-group mb-3 {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                                                <label class="col-form-label">{{ translate('Confirm password') }}<span
                                                        class="mandatory cls"
                                                        style="color:red; font-size:15px">*</span></label>
                                                <input
                                                    class="form-control {{ $errors->has('confirm_password') ? 'form-control-danger' : '' }}"
                                                    name="confirm_password" type="password"
                                                    value="{{ old('confirm_password', $get_partners['password']) }}"
                                                    placeholder="Enter Confirm password">
                                                @error('confirm_password')
                                                    <div class="col-form-alert-label">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('company_address') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Company Address') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <textarea class="form-control {{ $errors->has('company_address') ? 'form-control-danger' : '' }}"
                                                name="company_address" placeholder="Enter Company Address">{{ old('company_address', $get_partners['company_address']) }}</textarea>

                                            @error('company_address')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
