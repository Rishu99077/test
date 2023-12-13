@extends('admin.layout.master')
@section('content')
    <div class="d-flex">
        <ul class="breadcrumb">
            
            <li>
                <a href="#" style="width: auto;">
                    <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" height="25px" width="25px"></span>
                </a>
            </li>
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
            <a class="btn btn-falcon-primary me-1 mb-1" href="{{ route('admin.coupon_code.add') }}" type="button"><span
                    class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }} </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.coupon_code.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_coupon_code['id'] }}" />

                       
                        <div class="col-md-6">
                            <label class="form-label"
                                for="title">{{ translate('Title') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title"
                                name="title[{{ $lang_id }}]" type="text"
                                value="{{ getLanguageTranslate($get_coupon_code_language, $lang_id, $get_coupon_code['id'], 'title', 'coupon_code_id') }}" />
                            @error('title.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Coupon code') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('coupon_code') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Coupon code') }}" id="coupon_code" name="coupon_code" type="text"
                                value="{{ old('coupon_code', $get_coupon_code['coupon_code']) }}" />
                            @error('coupon_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Coupon Type') }}<span
                                    class="text-danger">*</span> </label>
                            <select class="form-select single-select {{ $errors->has('coupon_type') ? 'is-invalid' : '' }}" name="coupon_type">
                                <option value="">--{{ translate('Select coupon type') }}--</option>
                                <option value="percent" {{ getSelected('percent', $get_coupon_code['coupon_type']) }}>{{ translate('Percent') }}</option>
                                <option value="fixed" {{ getSelected('fixed', $get_coupon_code['coupon_type']) }}>
                                    {{ translate('Fixed') }}
                                </option>
                            </select>
                            @error('coupon_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Coupon value') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('coupon_value') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Amount') }}" id="coupon_value" name="coupon_value" type="text"
                                value="{{ old('coupon_value', $get_coupon_code['coupon_value']) }}" />
                            @error('coupon_value')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Minimum Amount') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Amount') }}" id="amount" name="amount" type="text"
                                value="{{ old('amount', $get_coupon_code['amount']) }}" />
                            @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Number of uses') }}
                            </label>
                            <input class="form-control numberonly" placeholder="{{ translate('Number of uses') }}" id="number_of_uses" name="number_of_uses" type="text" value="{{ old('number_of_uses', $get_coupon_code['number_of_uses']) }}" />
                            
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('How many time customer can use') }}
                            </label>
                            <input class="form-control numberonly" placeholder="{{ translate('How many time customer can use') }}" id="how_many" name="how_many" type="text" value="{{ old('how_many', $get_coupon_code['how_many']) }}" />
                            
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="datepicker">Start Date</label>
                            <input class="form-control datetimepicker" id="datepicker" type="text" name="start_date" value="{{$get_coupon_code['start_date']}}" placeholder="d/m/y" data-options='{"disableMobile":true}' />
                        </div>    

                        <div class="col-md-6">
                            <label class="form-label" for="datepicker">End Date</label>
                            <input class="form-control datetimepicker" id="datepicker" type="text" name="end_date" value="{{$get_coupon_code['end_date']}}" placeholder="d/m/y" data-options='{"disableMobile":true}' />
                        </div>    


                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Customer Selection') }} </label>
                            <select class="form-select single-select" name="customer_selection">
                                <option value="All" {{ getSelected('All', $get_coupon_code['customer_selection']) }}>{{ translate('All') }}</option>
                                <option value="Includes" {{ getSelected('Includes', $get_coupon_code['customer_selection']) }}>{{ translate('Includes') }} </option>
                                <option value="Excludes" {{ getSelected('Excludes', $get_coupon_code['customer_selection']) }}> {{ translate('Excludes') }} </option>
                            </select>
                        </div>
                        <?php 
                            $customerArr = array();
                            if ($get_coupon_code['customers']) {
                                $customerArr = json_decode($get_coupon_code['customers']);
                            }
                        ?>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Customers') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select class="single-select form-control" name="customers[]" id="customers" multiple>
                                <option value="">{{ translate('Select Customers') }}</option>
                                @foreach ($get_customers as $C)
                                    <option value="{{ $C['id'] }}"
                                        @if (in_array($C['id'], $customerArr)) selected @endif>
                                        {{ $C['name'] }}</option>
                                @endforeach
                            </select>
                           
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }}</option>
                                <option value="Deactive" {{ getSelected('Deactive', $get_coupon_code['status']) }}>
                                    {{ translate('Deactive') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
