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
                    <li class="breadcrumb-item"><a href="{{ route('admin.changepassword') }}">{{ $common['title'] }}</a>
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
                        {{---<button onClick="back();"
                        class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                        data-modal="modal-13"> <i class="ti-control-backward m-r-5"></i>
                        </button> --}}
                    </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.changepassword') }}" 
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$admin['id']}}">       
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('old_password') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{translate('Old Password')}}<span class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('old_password') ? 'form-control-danger' : '' }}"
                                                name="old_password" type="password"
                                                value="{{ old('old_password') }}" placeholder="Enter old password">      
                                            @error('old_password')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('new_password') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{translate('New Password')}}<span class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('new_password') ? 'form-control-danger' : '' }}"
                                                name="new_password" type="password"
                                                value="{{ old('new_password') }}" placeholder="Enter new password">      
                                            @error('new_password')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{translate('Confirm Password')}}<span class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('confirm_password') ? 'form-control-danger' : '' }}"
                                                name="confirm_password" type="password"
                                                value="{{ old('confirm_password') }}" placeholder="Enter confirm password">      
                                            @error('confirm_password')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>                
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" class="btn btn-primary  m-b-0 mr-0">{{$common['button']}}</button>
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

