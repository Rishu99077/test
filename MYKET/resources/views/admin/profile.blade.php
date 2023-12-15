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
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('ABOUT ME') }}</h5>
                        </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.profile') }}" novaliABOUT ME
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center mb-5">
                                            <a href="#" class="profile-image">
                                                <img id="image_1" class="user-img img-circle img-css"
                                                    src="{{ $get_admin['image'] != '' ? url('uploads/admin_image', $get_admin['image']) : asset('assets/images/user.png') }}"
                                                    alt="user-img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group {{ $errors->has('image') ? 'has-danger' : '' }}">
                                            <span class="input-group-addon" for="image"><i
                                                    class="icofont icofont-user"></i></span>
                                            <input type="file" onchange="loadFile(event,'image_1')"
                                                class="form-control {{ $errors->has('image') ? 'form-control-danger' : '' }}"
                                                id="image" name="image" value="{{ $get_admin['image'] }}"
                                                placeholder="First Name">
                                            @error('image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                                            <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                            <input type="text"
                                                class="form-control {{ $errors->has('first_name') ? 'form-control-danger' : '' }}"
                                                name="first_name" value="{{ $get_admin['first_name'] }}"
                                                placeholder="First Name">
                                            @error('first_name')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                                            <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                            <input type="text"
                                                class="form-control {{ $errors->has('last_name') ? 'form-control-danger' : '' }}"
                                                name="last_name" value="{{ $get_admin['last_name'] }}"
                                                placeholder="Last Name">
                                            @error('last_name')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group {{ $errors->has('email') ? 'has-danger' : '' }}">
                                            <span class="input-group-addon"><i class="icofont icofont-envelope"></i></span>
                                            <input type="text" readonly
                                                class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                                name="email" value="{{ $get_admin['email'] }}" placeholder="Email">
                                            @error('email')
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
                                            class="btn btn-primary m-b-0">{{ translate('Submit') }}</button>
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
