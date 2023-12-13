@extends('admin.layout.master')
@section('content')
    <style>
        .duration-box {
            overflow: hidden;
        }

        .duration-updown {
            display: none !important;
        }

        .material-icons {
            display: none !important;
        }

        .typography hr {
            height: 4px !important;
            color: #b0a47f;
        }
    </style>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <form method="post" id="add_transfer" enctype="multipart/form-data" action="">
        @csrf
        <ul class="breadcrumb">
            <li>
              <a href="#" style="width: auto;">
                  <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
              </a>
            </li>
            <li>
                <a href="#" style="width: auto;">

                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    {{ Session::get('TopMenu') }}
                </a>

            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>

        </ul>

        <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
            type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
        </a>

        <button class="btn btn-success me-1 mb-1 backButton float-end" href="javascript:void(0)" id="add_product_btn"
            type="submit"><span class="fas fa-save"></span>
            {{ $common['button'] }}
        </button>

        @if ($get_transfer['id'] !== '' && $get_transfer['status'] !== 'Deactive')
            <a class="btn btn-primary me-1 mb-1 backButton float-end" target="_blank" href="{{ env('APP_URL') }}transfer"
                id="add_product_btn" type="submit"><span class="fas fa-globe"></span>

                {{ translate('Product View') }}
            </a>
        @endif

        <div class="add_product add_product-effect-scale add_product-theme-1">

            <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
                    class="icon-general"></i></label>

            <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Airport Bus') }}">
                <i class="icon-bus"></i></label>

            <input type="radio" name="add_product" id="tab10" class="tab-content-10 addProTab">
            <label for="tab10" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Extras Options') }}"><i class="icon-extra"></i></label>

            <input type="radio" name="add_product" id="tab9" class="tab-content-9 addProTab">
            <label for="tab9" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Extras needs') }}"><i class="icon-option"></i></label>

            <input type="radio" name="add_product" id="tab12" class="tab-content-12 addProTab">
            <label for="tab12" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Product Tooltip') }}"><i class="icon-tip"></i></label>

            <input type="radio" name="add_product" id="tab8" class="tab-content-8 addProTab">
            <label for="tab8" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Extras') }}"><i
                    class="icon-extra"></i></label>

            <input type="radio" name="add_product" id="tab11" class="tab-content-11 addProTab">
            <label for="tab11" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Vouchers') }}"><i
                    class="icon-voucher"></i></label>

            <input type="radio" name="add_product" id="tab13" class="tab-content-13 addProTab">
            <label for="tab13" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Cutomer Group Discount') }}"><i class="icon-customer"></i></label>

            {{-- <input type="radio" name="add_product" id="tab15" class="tab-content-15 addProTab">
            <label for="tab15" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Experience Icon') }}"><i class="icon-option"></i></label> --}}

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <input id="" name="id" type="hidden" value="{{ $get_transfer['id'] }}" />
                    <div class="colcss">
                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end excertion_status"
                                    {{ getChecked('Active', old('transfer_status', $get_transfer['status'])) }}
                                    id="transfer_status" type="checkbox" value="Active" name="transfer_status">
                                <label class="form-check-label form-label"
                                    for="transfer_status">{{ translate('Transfer Status') }}
                                </label>
                            </div>

                        </div>

                        @php
                        $data = 0; @endphp
                        @foreach ($get_transfer_car_type as $CRT)
                            @include('admin.product.transfer._car_types')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_transfer_car_type))
                            @include('admin.product.transfer._car_types')
                        @endif

                    </div>
                </li>

                {{-- Airport Bus --}}

                <li class="tab-content tab-content-6 typography" style="display: none">
                    <div class="colcss">
                        {{-- <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end excertion_status"
                                    {{ getChecked('Active', old('transfer_status', $get_transfer['status'])) }}
                                    id="transfer_status" type="checkbox" value="Active" name="transfer_status">
                                <label class="form-check-label form-label"
                                    for="transfer_status">{{ translate('Transfer Bus') }}
                                </label>
                            </div>

                        </div> --}}

                        @php
                        $data = 0; @endphp
                        @foreach ($get_transfer_bus_type as $CBT)
                            @include('admin.product.transfer._bus_types')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_transfer_bus_type))
                            @include('admin.product.transfer._bus_types')
                        @endif

                    </div>
                </li>

                {{-- Extras Needs Tab  --}}
                <li class="tab-content tab-content-9 typography " style="display: none">
                    <div class="colcss">

                        @php
                        $extras_data_count = 0; @endphp
                        @foreach ($get_transfer_extras as $TXX)
                            @include('admin.product.transfer._extras')
                            @php
                                $extras_data_count++;
                            @endphp
                        @endforeach
                        @if (empty($get_transfer_extras))
                            @include('admin.product.transfer._extras')
                        @endif
                        <div class="show_extras">
                        </div>
                        <div class="row">

                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_extras"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> Add more</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- Extras Options Tab  --}}
                <li class="tab-content tab-content-10 typography " style="display: none">
                    <div class="colcss">

                        @php
                        $extra_data = 0; @endphp
                        @foreach ($get_transfer_extras_options as $EXO)
                            @include('admin.product.transfer._extras_options')
                            @php
                                $extra_data++;
                            @endphp
                        @endforeach
                        @if (empty($get_transfer_extras_options))
                            @include('admin.product.transfer._extras_options')
                        @endif
                        <div class="show_extras_options">
                        </div>
                        <div class="row">

                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_extras_option"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> Add more</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- {{ Tooltip }} --}}
                <li class="tab-content tab-content-12 typography " style="display: none">
                    <div class="colcss">

                        <div class="row">
                            @isset($get_product_deafault_title)
                                @foreach ($get_product_deafault_title as $key2 => $VAL)
                                   
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            for="tooltip_description"><b>{{ $VAL['heading'] }}</b></label>

                                        <input type="hidden" name="tooltip_title[{{ $key2 }}]"
                                            value="{{ $VAL['default_title'] }}">
                                        <input type="hidden" name="default_tooltip_id[{{ $key2 }}]"
                                            value="{{ $VAL['id'] }}">
                                        <input type="hidden" name="heading[{{ $key2 }}]"
                                            value="{{ $VAL['heading'] }}">

                                        <input
                                            class="form-control {{ $errors->has('tooltip_description.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Enter Tour Option') }}" id="tooltip_description"
                                            name="tooltip_description[{{ $lang_id }}][]" type="text"
                                            value="{{ getLanguageTranslate($get_product_tooltip_language, $lang_id, $VAL['id'], 'tooltip_description', 'default_tooltip_id') }}" />
                                        @error('tooltip_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                   
                                @endforeach
                            @endisset

                        </div>

                    </div>
                </li>

                {{-- Extras Tab --}}
                <li class="tab-content tab-content-8 typography " style="display: none">
                    <div class="colcss">
                        <div class="row">
                            <div class="col-md-3 col-lg-3  content_title box">
                                <label class="form-label" for="price">{{ translate('Supplier') }} </label>
                                <select class="form-select multi-select" name="suppliers[]" id="suppliers" multiple>

                                    @foreach ($get_supplier as $GS)
                                        <option value="{{ $GS['id'] }}"
                                            {{ getSelectedInArray($GS['id'], $get_transfer['supplier']) }}>
                                            {{ $GS['company_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label"
                                            for="title">{{ translate('Product Rate Valid Until') }}
                                        </label>
                                        <input class="form-control datetimepicker" id="rate_valid_until"
                                            name="rate_valid_until" type="text"
                                            value="{{ old('rate_valid_until', $get_transfer['rate_valid_until']) }}" />
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">{{ translate('Client Reward Points') }}
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Enter Client Reward Points') }}" id="title"
                                            name="client_reward_point" type="text"
                                            value="{{ old('client_reward_point', $get_transfer['client_reward_point']) }}" />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label"
                                            for="title">{{ translate('How Many Point To Purchase This Product') }}
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Enter Point') }}" id="title"
                                            name="point_to_purchase_product" type="text"
                                            value="{{ old('point_to_purchase_product', $get_transfer['point_to_purchase_product']) }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="affilate_commision">{{ translate('Affilate Commision') }}</label>
                                        <input type="text" class="form-control numberonly" name="affilate_commision"
                                            value="{{ $get_transfer['affilate_commision'] }}" placeholder="{{ translate('Affilate Commision') }}">
                                        @error('affilate_commision')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Other Booking Details') }}</h5>
                            <div class="row">
                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="duration_from">{{ translate('Tax') }}</label>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input class="form-check-input mt-2 "
                                                {{ getChecked('1', $get_transfer['tax_allowed']) }} value="1"
                                                id="tax_allowed" type="checkbox" name="tax_allowed" value="1" />

                                        </div>
                                        <div class="col-md-11">
                                            <div class="input-group mb-3">
                                                <input class="form-control numberonly" type="text"
                                                    placeholder="{{ translate('Enter Tax') }}"
                                                    value="{{ old('tax_percentage', $get_transfer['tax_percentage']) }}"
                                                    name="tax_percentage" value="" aria-label="Username"
                                                    aria-describedby="basic-addon1"><span class="input-group-text"
                                                    id="basic-addon1">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label"
                                        for="duration_from">{{ translate('Service Charge') }}</label>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input class="form-check-input mt-2 " id="service_allowed" type="checkbox"
                                                name="service_allowed"
                                                {{ getChecked('1', $get_transfer['service_allowed']) }} value="1" />
                                        </div>
                                        <div class="col-md-11">
                                            <div class="input-group mb-3">
                                                <input class="form-control numberonly" type="text"
                                                    placeholder="{{ translate('Enter Service Charge') }}"
                                                    value="{{ old('service_amount', $get_transfer['service_amount']) }}"
                                                    name="service_amount" value="" aria-label="Username"
                                                    aria-describedby="basic-addon1"><span class="input-group-text"
                                                    id="basic-addon1">Amount</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">{{ translate('Upload PDF') }}
                                    </label>
                                    <input class="form-control numberonly transfer_pdf"
                                        placeholder="{{ translate('Enter Point') }}" id="title" name="transfer_pdf"
                                        type="file" value="{{ $get_transfer['transfer_pdf'] }}" />

                                    <?php $link = url('/uploads/Transfer_PDF', $get_transfer['transfer_pdf']); ?>
                                    <?php
                                    @$img_explode = explode('.', $get_transfer['transfer_pdf']);
                                    @$img_extension = $img_explode[1];
                                    ?>

                                    <div class="pdf_show" style="display: none;">
                                        <input type="type" class="image_pdf" name="image_pdf" value="1">
                                    </div>
                                    <div class="col-lg-3 mt-2 pdf_div">
                                        <div>
                                            <button class="delete_pdf bg-card btn btn-danger btn-sm float-end"
                                                type="button"><span class="fa fa-trash"></span></button>
                                        </div>
                                        <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                            <div class="h-100 w-100  overflow-hidden position-relative">
                                                <?php if (@$img_extension=='pdf') { ?>
                                                <a href="{{ $link }}" download><img
                                                        src="{{ asset('uploads/placeholder/pdf.png') }}" width="50%"
                                                        alt="" style="width: 25%;height: 25%;" /></a>
                                                <?php }else{ ?>
                                                <img src="{{ $get_transfer['transfer_pdf'] != '' ? asset('uploads/Transfer_PDF/' . $get_transfer['transfer_pdf']) : asset('uploads/placeholder/placeholder.png') }}"
                                                    id="image_banner" width="100" alt="" />
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="title">{{ translate('Extra Top Text') }}
                                    </label>
                                    <input class="form-control" placeholder="{{ translate('Extra Top Text') }}"
                                        id="title" name="extra_top_text" type="text"
                                        value="{{ old('extra_top_text', $get_transfer['extra_top_text']) }}" />
                                </div>
                            </div>

                            {{-- <div class="col-md-6 col-lg-6  content_title box" style="width: 49% !important;">
                                <label class="form-label" for="price">{{ translate('Option Note') }} </label>
                                <textarea class="form-control description" placeholder="{{ translate('Enter Option Note') }}" name="option_note"
                                    id="option_note">{{ $get_transfer['option_note'] }}</textarea>
                            </div>
                            <div class="col-md-6 col-lg-6  content_title box" style="width: 49% !important;">
                                <label class="form-label" for="price">{{ translate('Booking Policy') }} </label>
                                <textarea class="form-control description" placeholder="{{ translate('Enter Booking Policy') }}"
                                    name="booking_policy" id="booking_policy">{{ $get_transfer['booking_policy'] }}</textarea>
                            </div> --}}

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="price">{{ translate('Option Note') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control footer_text" rows="8" id="option_note_{{ $lang_id }}"
                                        name="option_note[{{ $lang_id }}]" placeholder="{{ translate('Option Note') }}">{{ getLanguageTranslate($get_transfer_language, $lang_id, $get_transfer['id'], 'option_note', 'transfer_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="price">{{ translate('Booking Policy') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control footer_text" rows="8" id="booking_policy_{{ $lang_id }}"
                                        name="booking_policy[{{ $lang_id }}]"
                                        placeholder="{{ translate('Booking Policy') }}">{{ getLanguageTranslate($get_transfer_language, $lang_id, $get_transfer['id'], 'booking_policy', 'transfer_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                            </div>


                            <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Other Booking Details') }}</h5>
                            <div class="row">
                               
                                <div class="col-md-4">
                                    <p class="form-label">{{ translate('Can be cancelled up to in advanced') }}
                                    <div id="CancelledUpTo"></div>
                                    <input type='hidden' name='can_be_cancelled_up_to_advance'
                                        id="can_be_cancelled_up_to_advance" value=""> </p>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end" id="per_modifi_or_cancellation"
                                            {{ getChecked(1, $get_transfer['per_modifi_or_cancellation']) }} type="checkbox"
                                            value="1" name="per_modifi_or_cancellation">
                                        <label class="fs-0"
                                            for="per_modifi_or_cancellation">{{ translate('Not refundable. This activity does not permit modification or cancellation.') }}</label>
                                    </div>
                                </div>

                              
                            </div>

                        </div>

                    </div>
                </li>

                {{-- Vouchers Tab --}}
                <li class="tab-content tab-content-11 typography">
                    <div class="colcss">

                        @php
                            $data = 0;
                        @endphp
                        @foreach ($get_transfer_voucher as $TVS)
                            @include('admin.product.transfer._voucher')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_transfer_voucher))
                            @include('admin.product.transfer._voucher')
                        @endif
                        <div class="show_voucher">
                        </div>
                        <div class="row">

                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_voucher"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span>{{ translate('Add more') }}</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- Customer Group Discount Tab --}}
                <li class="tab-content tab-content-13    typography" style="display: none">
                    <div class="colcss">

                        @foreach ($customerGroup as $key => $CG)
                            @php
                                $productCustomerGroup = (array) getDataFromDB('product_customer_group_discount', ['product_id' => $get_transfer['id'], 'customer_group_id' => $CG['id'], 'type' => 'transfer'], 'row');
                                if (!$productCustomerGroup) {
                                    $productCustomerGroup = getTableColumn('product_customer_group_discount');
                                }
                                
                            @endphp

                            <div class="row">
                                <input type="hidden" name="product_customer_group_discount_id[]"
                                    value="{{ $productCustomerGroup['id'] }}">
                                <input type="hidden" name="product_customer_group_id[]" value="{{ $CG['id'] }}">
                                <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ $CG['title'] }}</h5>
                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label"
                                        for="price">{{ translate('Tour Price % Discount') }}</label>
                                    <input type="text" class="form-control numberonly" name="tour_price[]"
                                        value="{{ old('tour_price.' . $key, $productCustomerGroup['tour_price']) }}" />
                                </div>
                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label" for="price">{{ translate('Room Details % Discount') }}

                                    </label>
                                    <input type="text" class="form-control numberonly" name="room_details[]"
                                        value="{{ old('room_details.' . $key, $productCustomerGroup['room_details']) }}" />
                                </div>
                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label"
                                        for="price">{{ translate('Transfer Option % Discount') }}

                                    </label>
                                    <input type="text" class="form-control numberonly" name="transfer_option[]"
                                        value="{{ old('transfer_option.' . $key, $productCustomerGroup['transfer_option']) }}" />
                                </div>
                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label" for="price">{{ translate('Weekdays % Discount') }}

                                    </label>
                                    <input type="text" class="form-control numberonly" name="weekdays[]"
                                        value="{{ old('weekdays.' . $key, $productCustomerGroup['weekdays']) }}" />
                                </div>

                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label" for="price">{{ translate('Base price % Discount') }}

                                    </label>
                                    <input type="text" class="form-control numberonly" name="base_price[]"
                                        value="{{ old('base_price.' . $key, $productCustomerGroup['base_price']) }}" />
                                </div>
                            </div>
                        @endforeach

                    </div>
                </li>

                {{-- Experience Icon Tab  --}}
                {{--  <li class="tab-content tab-content-15 typography " style="display: none">
                        <div class="colcss">

                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_product_experience_icon as $PEI)
                                @include('admin.product.transfer._experience_icon')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (empty($get_product_experience_icon))
                                @include('admin.product.transfer._experience_icon')
                            @endif
                            <div class="show_expe">
                            </div>
                            <div class="row">

                                <div class="col-md-12 add_more_button">
                                    <button class="btn btn-success btn-sm float-end" type="button" id="add_expe"
                                        title='Add more'>
                                        <span class="fa fa-plus"></span> Add more</button>
                                </div>
                            </div>

                        </div>
                    </li> -- }}

            </ul>
        </div>

    </form>

    <input type="hidden" name="count" id="count" value="{{ $data }}">

    <script>
        CKEDITOR.replace('description');
    </script>

    {{-- Add Transfer --}}

    <script>
        $(document).on("submit", "#add_transfer", function(e) {
            e.preventDefault();
            var duration = "";
            $("#add_product_btn").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.transfer.add') }}",
                datatype: 'JSON',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        $.each(response.error, function(index, value) {
                            if (value != '') {

                                var index = index.replace(".", "_");
                                // alert(index);
                                if (index == "passengers") {

                                    var focusDiv = $('input[name^=' + index + ']');
                                    $('input[name^=' + index + ']').addClass(
                                        'is-invalid');
                                    // $('#pick_option_invalid').addClass('d-block');
                                    $('input[name^=' + index + ']').focus();
                                    // $('#pick_option_invalid').html(
                                    //     value);

                                    var $cl = $('input[name^=' + index + ']').closest(
                                        '.tab-content');


                                } else if (index == "duration") {

                                    $('#' + index).addClass('is-invalid');
                                    var $cl = $('#demoDurationRow').closest(
                                        '.tab-content');
                                    var focusDiv = $('#demoDurationRow');


                                } else if (index == "address") {

                                    $('#input_store_address_id').addClass('is-invalid');
                                    var $cl = $('#input_store_address_id').closest(
                                        '.tab-content');
                                    var focusDiv = $('#input_store_address_id');

                                } else {

                                    $('#' + index).addClass('is-invalid');
                                    var $cl = $('#' + index).closest(
                                        '.tab-content');
                                    var focusDiv = $('#' + index);
                                }


                                var ClassName = $($cl).removeClass("tab-content typography")
                                    .attr(
                                        "class");

                                $('input[name="add_product"]').each(function() {
                                    if ($(this).hasClass(ClassName)) {
                                        $(this).prop('checked', true);
                                    }
                                    // $(".typography").css("display", "none");
                                })
                                $("li." + ClassName).css("display", "block");
                                $("li." + ClassName).addClass("typography");
                                $("li." + ClassName).addClass("tab-content");

                                $('#' + index).parent().find('.invalid-feedback').html(value);

                                setTimeout(() => {

                                    $(focusDiv).focus();
                                }, 500);


                            }
                        });
                    } else {

                        success_msg("Transfer {{ $common['button'] }} Successfully...")
                    }
                }
            });
            setTimeout(() => {
                $("#add_product_btn").prop("disabled", false);
            }, 500);

        });
    </script>

    <script>
        $(document).ready(function() {
            CKEDITOR.replaceAll('footer_text');
        });
    </script>

    <!-- Car types -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_car_types').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._car_types',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_car_types');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_car_types", function(e) {
                var length = $(".delete_car_types").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.car_type_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- Higlights -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_highlights').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._highlight',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_highlights');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_highlight", function(e) {
                var length = $(".delete_highlight").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.highlights_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- ExPERINCE -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_expe').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._experience_icon',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_expe');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_expe", function(e) {
                var length = $(".delete_expe").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.expe_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- Extras -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $extras_data_count }}";

            $('#add_extras').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._extras',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_extras');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_extras", function(e) {
                // var length = $(".delete_extras").length;
                // if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.extras_div').remove();
                        e.preventDefault();
                    }
                });
                // }
            });
        });
    </script>

    {{-- Allowed or not  --}}
    <script>
        $(document).on("click", ".child_allowed", function() {
            var nextInput = $(this).parent().next('td').find('input');
            var nextHiddenInput = $(this).next('input');
            if ($(this).prop('checked') == true) {
                nextInput.attr("readonly", false);
                nextInput.val(0);
                nextHiddenInput.val(1);
            } else {
                nextInput.attr("readonly", true);
                nextInput.val("N/A");
                nextHiddenInput.val(0);
            }
        });
    </script>

    <!-- WHY BOOK US  -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_why_book').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._why_book_us',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_why_book');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_book", function(e) {
                var length = $(".delete_book").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.why_book_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- VOUCHER -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_voucher').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._voucher',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_voucher');
                e.preventDefault();
                count++;
            });



            $(document).on('click', ".delete_voucher", function(e) {
                var length = $(".delete_voucher").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.voucher_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- PRICING -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_pricing').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._pricing',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_pricing');
                e.preventDefault();
                count++;
            });



            $(document).on('click', ".delete_pricing", function(e) {
                var length = $(".delete_pricing").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.pricing_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- Extras Needs-->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $extra_data }}";

            $('#add_extras_option').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.transfer._extras_options',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_extras_options');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_extras_options", function(e) {
                var length = $(".delete_extras_options").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.extras_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.min_close').click(function(e) {
                if ($(this).is(':checked') == true) {
                    $(this).closest('.week_box').find('.pick_from').attr("disabled", true);
                    $(this).closest('.week_box').find('.pick_from').css("background", "aliceblue");
                    $(this).closest('.week_box').find('.pick_to').attr("disabled", true);
                    $(this).closest('.week_box').find('.pick_to').css("background", "aliceblue");
                } else {
                    $(this).closest('.week_box').find('.pick_from').attr("disabled", false);
                    $(this).closest('.week_box').find('.pick_from').css("background", "white");
                    $(this).closest('.week_box').find('.pick_to').attr("disabled", false);
                    $(this).closest('.week_box').find('.pick_to').css("background", "white");
                }
            });

            $('input[name="add_product"]').each(function() {
                $(".typography").css("display", "none");

            })
            $("#tab1").addClass("addProTab");
            $("li.tab-content-first").css("display", "block")

            $(".addProTab").click(function() {
                var ClassName = $(this).removeClass("addProTab").attr("class");

                if ($(this).is(':checked') == true) {
                    $('input[name="add_product"]').each(function() {
                        $(".typography").css("display", "none");
                        $(this).addClass("addProTab")
                    })
                    $("li." + ClassName).css("display", "block");
                }
            })
        });
    </script>

    {{-- Google Api Code --}}

    <script>
        var x = document.getElementById("store_address_id");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "{{ translate('Get Location Not Supported') }}";
            }
        }

        function showPosition(position) {
            console.log(position);
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
        }
    </script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete&sensor=false"
        type="text/javascript"></script>
    <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('input_store_address_id');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#address_lattitude').val(place.geometry['location'].lat());
                $('#address_longitude').val(place.geometry['location'].lng());
            });
        }
    </script>
    <script>
        function getAirport(type, selectedCat = "") {

            var city = $("#city").val();

            $.ajax({
                "type": "POST",
                "data": {
                    city: city,
                    selectedCat: selectedCat,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.get_airport') }}",
                success: function(response) {
                    $("#airport").html(response);
                }
            })
        }
    </script>

    <!-- Advertsing Banner Images -->
    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            var html =
                                "<div class='col-md-2'><div class='image-item upload_img_list'>" +
                                "<img src=' " +
                                e.target.result + "' alt='' width='20' title='" + file.name +
                                "'>" + "<div class='image-item__btn-wrapper'>" +
                                "<button type='button' class='btn btn-default remove btn-sm'>" +
                                "<i class='fa fa-times' aria-hidden='true'></i>" +
                                "</button>" +
                                "</div>" +
                                "</div>" +
                                "</div>";
                            $(".appenImage").append(html);
                        });
                        fileReader.readAsDataURL(f);
                    }

                });
            } else {
                alert("Your browser doesn't support to File API")
            }
            $(document).on("click", ".remove", function() {
                $(this).closest(".col-md-2").remove();
            });
        });
    </script>

    <!-- Car Scrolling Banner Images -->
    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files_2").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            var html =
                                "<div class='col-md-2'><div class='image-item upload_img_list'>" +
                                "<img src=' " +
                                e.target.result + "' alt='' width='20' title='" + file.name +
                                "'>" + "<div class='image-item__btn-wrapper'>" +
                                "<button type='button' class='btn btn-default remove btn-sm'>" +
                                "<i class='fa fa-times' aria-hidden='true'></i>" +
                                "</button>" +
                                "</div>" +
                                "</div>" +
                                "</div>";
                            $(".appenImage_2").append(html);
                        });
                        fileReader.readAsDataURL(f);
                    }

                });
            } else {
                alert("Your browser doesn't support to File API")
            }
            $(document).on("click", ".remove", function() {
                $(this).closest(".col-md-2").remove();
            });
        });
    </script>

    {{-- Cancelled Up To Advance Box --}}
    <script>
        $(function() {
            CancelledUpToTrans()
        });

        function CancelledUpToTrans() {

            var $demoRow1 = $('<div id="demoDurationRowCancelledUpTo" class="demo-row">');

            var $subsection1 = $('<div class="section-row">').append($demoRow1);


            $("#CancelledUpTo").append($subsection1);
            $demoRow1.durationjs();

        }
        $(document).ready(function() {
            $("#demoDurationRowCancelledUpTo .duration-val").on("keyup", function() {

                var duration = "";
                var len = $("#demoDurationRowCancelledUpTo .duration-val").length - 1;
                $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {

                    if (key == len) {
                        duration += $(this).val();
                    } else {
                        duration += $(this).val() + "-";
                    }
                });
                $("#can_be_cancelled_up_to_advance").val(duration)

            })

            if ("{{ $get_transfer['id'] }}" != "") {

                var durationData = "{{ $get_transfer['can_be_cancelled_up_to_advance'] }}"
                if (durationData == "") {
                    $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                        $(this).val("00");
                        $(this).keyup();
                    })
                } else {
                    var result = durationData.split('-');
                    $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                        $(this).val(result[key]);
                        $(this).keyup();
                    })
                }
            } else {
                $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                    $(this).val("00");
                    $(this).keyup();
                })
            }
        })
    </script>

@endsection
