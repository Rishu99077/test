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
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.productsfood.mealtype') }}">{{ $common['title'] }}</a>
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
                            <a href = "{{ route('admin.productsfood.mealtype') }}">
                                <button onClick="back();"
                                    class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                    data-modal="modal-13">
                                    <i class="ti-control-backward m-r-5"></i>{{ translate('Back') }}
                                </button>
                            </a>
                        </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.productsfood.mealtype.add') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $get_products_food['id'] }}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Title') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                                name="title" type="text"
                                                value="{{ old('title', $get_products_food_language['title']) }}"
                                                placeholder="Enter Title" required = "">
                                            @error('title')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('type') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Type') }}</label>
                                            <select id="type" name="type" class="form-control stock">
                                                <option value="">{{ translate('Select Type') }}</option>
                                                <option value="Meal_type"
                                                    {{ getSelected($get_products_food['type'], 'Meal_type') }}>
                                                    {{ translate('Type of Meal') }}
                                                </option>
                                                {{-- <option value="Day_time"
                                            {{ getSelected($get_products_food["type"],"Day_time") }}>Time of Day
                                            </option> --}}
                                            </select>
                                            @error('type')
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
                                                    {{ getSelected($get_products_food['status'], 'Deactive') }}>
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
