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
                    <li class="breadcrumb-item"><a href="{{ route('admin.coupon.add') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            {{-- <div class="row"> --}}
            {{-- <div class="col-sm-12"> --}}
            <div class="card">
                <div class="card-header">
                    <h5>{{ $common['heading_title'] }}</h5>
                    <a href="{{ url(goPreviousUrl()) }}"
                        class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1" data-modal="modal-13">
                        <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                    </a>
                </div>
                <div class="card-block">
                    <form id="taxForm" method="post" action="{{ route('admin.coupon.add') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $get_coupon['id'] }}">
                            <div class="col-sm-12 radio-buttons-container form-radio">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" value="partner" name="copuon_for" <?php if ($get_coupon['coupon_type']=='partner') { ?>
                                            checked="checked" <?php }else{ ?> checked="checked" <?php } ?>>
                                        <i class="helper"></i>{{ translate('Partner') }}
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" value="category" name="copuon_for" <?php if ($get_coupon['coupon_type']=='category') { ?>
                                            checked="checked" <?php } ?>>
                                        <i class="helper"></i>{{ translate('Category') }}
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" value="product" name="copuon_for" <?php if ($get_coupon['coupon_type']=='product') { ?>
                                            checked="checked" <?php } ?>>
                                        <i class="helper"></i>{{ translate('Product') }}
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="partner copuon_for <?php if ($get_coupon['coupon_type'] == 'partner') {
                            echo 'd-block';
                        } elseif ($get_coupon['id'] == '') {
                            echo 'd-block';
                        } else {
                            echo 'd-none';
                        } ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="inputfield title_filed product_code {{ $errors->has('coupon_value_part') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Partner') }}</h6>
                                        <select name="coupon_value_part" id="partner"
                                            class="form-control single-select { $errors->has('coupon_value_part') ? 'form-control-danger' : '' }}">
                                            <option value="">{{ translate('Select Partner') }}</option>
                                            @foreach ($partner as $P)
                                                <option value="{{ $P['id'] }}"
                                                    {{ getSelected($P['id'], old('coupon_value_part', $get_coupon['value'])) }}>
                                                    {{ $P['first_name'] . ' ' . $P['last_name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('coupon_value_part')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="category copuon_for <?php if ($get_coupon['coupon_type'] == 'category') {
                            echo 'd-block';
                        } else {
                            echo 'd-none';
                        } ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="inputfield title_filed product_code {{ $errors->has('coupon_value_cat') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Category') }}</h6>
                                        <select name="coupon_value_cat" id="categories"
                                            class="form-control single-select { $errors->has('coupon_value_cat') ? 'form-control-danger' : '' }}">
                                            <option value="">{{ translate('Select Category') }}</option>
                                            @foreach ($categories as $C)
                                                <option value="{{ $C['id'] }}"
                                                    {{ getSelected($C['id'], old('coupon_value_cat', $get_coupon['value'])) }}>
                                                    {{ $C['title'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('coupon_value_cat')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product  copuon_for <?php if ($get_coupon['coupon_type'] == 'product') {
                            echo 'd-block';
                        } else {
                            echo 'd-none';
                        } ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="inputfield title_filed product_code {{ $errors->has('coupon_value_pro') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Product') }}</h6>
                                        <select name="coupon_value_pro" id="product"
                                            class="form-control single-select { $errors->has('coupon_value_pro') ? 'form-control-danger' : '' }}">
                                            <option value="">{{ translate('Select Product') }}</option>
                                            @foreach ($get_product as $P)
                                                <option value="{{ $P['id'] }}"
                                                    {{ getSelected($P['id'], old('coupon_value_pro', $get_coupon['value'])) }}>
                                                    {{ $P['title'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('coupon_value_pro')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div
                                        class="inputfield title_filed product_code {{ $errors->has('coupon_code') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Coupon Code') }}<span class="mandatory cls"
                                                style="color:red; font-size:15px">*</span></h6>
                                        <input type="text" name="coupon_code"
                                            class="form-control { $errors->has('coupon_code') ? 'form-control-danger' : '' }}"
                                            value="{{ $get_coupon['code'] }}">
                                        @error('coupon_code')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="inputfield title_filed start_date {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Start Date') }}<span class="mandatory cls"
                                                style="color:red; font-size:15px">*</span></h6>
                                        <input type="text" name="start_date"
                                            class="datetimepicker form-control { $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                            value="{{ $get_coupon['start_date'] }}">
                                    </div>
                                    @error('start_date')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="inputfield title_filed end_date {{ $errors->has('end_date') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('End Date') }}<span class="mandatory cls"
                                                style="color:red; font-size:15px">*</span></h6>
                                        <input type="text" name="end_date"
                                            class="datetimepicker form-control { $errors->has('end_date') ? 'form-control-danger' : '' }}"
                                            value="{{ $get_coupon['end_date'] }}">
                                    </div>
                                    @error('end_date')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div
                                        class="inputfield title_filed minimum_amount {{ $errors->has('minimum_amount') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Minimum Amount') }}<span class="mandatory cls"
                                                style="color:red; font-size:15px">*</span></h6>
                                        <input type="text" name="minimum_amount"
                                            class="form-control numberonly { $errors->has('minimum_amount') ? 'form-control-danger' : '' }}"
                                            value="{{ $get_coupon['minimum_amount'] }}">
                                    </div>
                                    @error('minimum_amount')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="inputfield title_filed coupon_amount_type">
                                        <h6>{{ translate('Coupon Amount Type') }}</h6>

                                        <select name="coupon_amount_type" id="coupon_amount_type"
                                            class="form-control single-select">
                                            <option value="percentage" <?php if ($get_coupon['coupon_amount_type']=='percentage') { ?> selected <?php } ?>>
                                                {{ translate('Percentage') }}</option>
                                            <option value="fixed" <?php if ($get_coupon['coupon_amount_type']=='fixed') { ?> selected <?php } ?>>
                                                {{ translate('Fixed') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div
                                        class="inputfield title_filed coupon_amount {{ $errors->has('coupon_amount') ? 'has-danger' : '' }}">
                                        <h6>{{ translate('Coupon Amount') }}<span class="mandatory cls"
                                                style="color:red; font-size:15px">*</span></h6>
                                        <input type="text" name="coupon_amount"
                                            class="form-control numberonly { $errors->has('coupon_amount') ? 'form-control-danger' : '' }}"
                                            value="{{ $get_coupon['coupon_amount'] }}">
                                    </div>
                                    @error('coupon_amount')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="inputfield title_filed product_code">
                                        <h6>{{ translate('Status') }}</h6>

                                        <select name="status" id="status" class="form-control single-select">
                                            <option value="Active" <?php if ($get_coupon['status']=='Active') { ?> selected <?php } ?>>
                                                {{ translate('Active') }}</option>
                                            <option value="Deactive" <?php if ($get_coupon['status']=='Deactive') { ?> selected <?php } ?>>
                                                {{ translate('Deactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                    class="btn btn-primary tax-btn  m-b-0 mr-0">{{ $common['button'] }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {

            $("input[name='copuon_for']").change(function() {
                var val = $(this).val();
                $(".copuon_for").removeClass('d-block');
                $(".copuon_for").addClass('d-none');
                $('.' + val).addClass("d-block")

                if ($(this).val() == "copuon_for") {
                    $(".accommodation_included_price_div").addClass("d-block");
                    $(".accommodation_included_price_div").removeClass("d-none");
                } else {
                    $(".accommodation_included_price_div").addClass("d-none");
                    $(".accommodation_included_price_div").removeClass("d-block");
                }
            });
        })
    </script>
@endsection
@endsection
