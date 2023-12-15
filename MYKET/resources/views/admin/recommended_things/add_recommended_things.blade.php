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
                    <li class="breadcrumb-item"><a href="{{ route('admin.recommended_things') }}">{{ $common['title'] }}</a>
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
                            <form id="main" method="post" action="{{ route('admin.recommended_things.add') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $get_recommended_things['id'] }}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Title') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                                name="title" type="text"
                                                value="{{ old('title', $get_recommended_things_language['title']) }}"
                                                placeholder="Enter Title" required="">
                                            @error('title')
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
                                                    src="{{ $get_recommended_things['image'] != '' ? url('uploads/recommended_things', $get_recommended_things['image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 {{ $errors->has('description') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('description') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <textarea class="form-control summernote  {{ $errors->has('description') ? 'form-control-danger' : '' }}"
                                                name="description" placeholder="Enter Short Description" required="">{{ old('description', $get_recommended_things_language['description']) }} </textarea>
                                            @error('description')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('country') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Country') }}</label>
                                            <select id="country" name="country" onchange="getStateCity('country')"
                                                class="form-control select2">
                                                <option value="" disabled selected>{{ translate('Select') }}</option>
                                                @foreach ($Countries as $C)
                                                    <option value="{{ $C['id'] }}"
                                                        {{ getSelected($C['id'], $get_recommended_things['country']) }}>
                                                        {{ $C['name'] }}</option>
                                                @endforeach

                                            </select>
                                            @error('country')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('state') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('State') }}</label>
                                            <select id="state" name="state" onchange="getStateCity('state')"
                                                class="form-control select2">
                                                <option value="" disabled selected>{{ translate('Select') }}</option>
                                                @foreach ($States as $S)
                                                    <option value="{{ $S['id'] }}"
                                                        {{ getSelected($S['id'], $get_recommended_things['state']) }}>
                                                        {{ $S['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('city') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('City') }}</label>
                                            <select id="city" name="city" class="form-control select2">
                                                <option value="" disabled selected>{{ translate('Select') }}</option>
                                                @foreach ($Cities as $CI)
                                                    <option value="{{ $CI['id'] }}"
                                                        {{ getSelected($CI['id'], $get_recommended_things['city']) }}>
                                                        {{ $CI['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('city')
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
                                                    {{ getSelected($get_recommended_things['status'], 'Deactive') }}>
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
