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

        .mybox {
            background: #f1f6f9;
            padding: 10px;
            border-radius: 7px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>

    <form method="post" id="add_product" enctype="multipart/form-data" action="">
        @csrf
        <ul class="breadcrumb">
            <li>
                <a href="#" style="width: auto;">
                    <span class="text">{{ $common['language_title'] }} <img
                            src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
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

        @if ($get_product['id'] !== '' && $get_product['status'] !== 'Deactive')
            <a class="btn btn-primary me-1 mb-1 backButton float-end" target="_blank"
                href="{{ env('APP_URL') }}activities-detail/{{ $get_product['slug'] }}"id="add_product_btn"
                type="submit"><span class="fas fa-globe"></span>

                {{ translate('Product View') }}
            </a>
        @endif
        <div class="add_product add_product-effect-scale add_product-theme-1">

            <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}">
                <i class="icon-general"></i></label>

            <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Highlight') }}"><i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Timing') }}"><i
                    class="icon-time"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Option') }}"><i
                    class="icon-option"></i></label>

            <input type="radio" name="add_product" id="tab13" class="tab-content-13 addProTab">
            <label for="tab13" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Group Percentage') }}"><i class="icon-group"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Images') }}"><i
                    class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Faqs') }}"><i
                    class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab7" class="tab-content-7 addProTab">
            <label for="tab7" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Site Advertisement') }}"><i class="icon-adver"></i></label>

            <input type="radio" name="add_product" id="tab9" class="tab-content-9 addProTab">
            <label for="tab9" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Vouchers') }}"><i class="icon-voucher"></i></label>

            <input type="radio" name="add_product" id="tab10" class="tab-content-10 addProTab">
            <label for="tab10" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Cutomer Group Discount') }}"><i class="icon-customer"></i></label>

            <input type="radio" name="add_product" id="tab11" class="tab-content-11 addProTab">
            <label for="tab11" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Related Products') }}"><i class="icon-boat"></i></label>

            <input type="radio" name="add_product" id="tab8" class="tab-content-8 addProTab">
            <label for="tab8" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Extras') }}"><i class="icon-extra"></i></label>

            <input type="radio" name="add_product" id="tab14" class="tab-content-14 addProTab">
            <label for="tab14" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Request Pop-up') }}"><i class="icon-group"></i></label>

            <input type="radio" name="add_product" id="tab12" class="tab-content-12 addProTab">
            <label for="tab12" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Product Tooltip') }}"><i class="icon-tip"></i></label>

            <input type="radio" name="add_product" id="tab19" class="tab-content-19 addProTab">
            <label for="tab19" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Expirence Icon Header') }}"><i class="icon-option"></i></label>

            <input type="radio" name="add_product" id="tab20" class="tab-content-20 addProTab">
            <label for="tab20" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Experience Icon Middle') }}"><i class="icon-option"></i></label>

            <input type="radio" name="add_product" id="tab16" class="tab-content-16 addProTab">
            <label for="tab16" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Product Pop-up') }}"><i class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab21" class="tab-content-21 addProTab">
            <label for="tab21" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Buggy') }}"><i class="icon-group"></i></label>

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_product['id'] }}" />
                        <div class="col-lg-8  col-md-8 colcss">
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="form-label" for="title">{{ translate('Excursion Title') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                        placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
                                        name="title[{{ $lang_id }}]" type="text"
                                        value="{{ old('title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'description', 'product_id')) }}" />

                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="price">{{ translate('Short Description') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control {{ $errors->has('short_description.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                                        id="short_description_{{ $lang_id }}" name="short_description[{{ $lang_id }}]"
                                        placeholder="{{ translate('Short Description') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'short_description', 'product_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="description_title">{{ translate('Description Title') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control {{ $errors->has('description_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                        placeholder="{{ translate('Title') }}"
                                        id="description_title_{{ $lang_id }}"
                                        name="description_title[{{ $lang_id }}]" type="text"
                                        value="{{ old('description_title.' . $lang_id, getLanguageTranslate($meta_global_language_description, $lang_id, 'excursion_description_title', 'title', 'meta_title')) }}" />

                                    <div class="invalid-feedback">

                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <label class="form-label"
                                        for="price">{{ translate('Excursion Description') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control footer_text {{ $errors->has('main_description.' . $lang_id) ? 'is-invalid' : '' }}"
                                        rows="8" id="main_description_{{ $lang_id }}" name="main_description[{{ $lang_id }}]"
                                        placeholder="{{ translate('Description') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'main_description', 'product_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                                <div class="col-md-4 content_title ">
                                    <label class="form-label" for="price">{{ translate('Country') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-select form-control single-select country  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                        name="country" id="country" onchange="getStateCity('country')">
                                        <option value="">{{ translate('Select Country') }}</option>
                                        @foreach ($country as $C)
                                            <option value="{{ $C['id'] }}"
                                                {{ getSelected($C['id'], old('country', $get_product['country'])) }}>
                                                {{ $C['name'] }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="title">{{ translate('State') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                        name="state" id="state" onchange="getStateCity('state')">
                                        <option value="">{{ translate('Select State') }}</option>

                                    </select>
                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="title">{{ translate('City') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                        name="city" id="city">
                                        <option value="">{{ translate('Select City') }}</option>
                                    </select>

                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                                <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Category') }}
                                </h5>

                                <div class="add_category_div">
                                    @php
                                        $data = 0;
                                        $CategoryData = 0;
                                        
                                    @endphp
                                    {{-- {{ dd(count($get_product_category)) }} --}}
                                    @foreach ($get_product_category as $GPC)
                                        @include('admin.product.excursion._category')
                                        @php
                                            $data++;
                                            $CategoryData++;
                                        @endphp
                                    @endforeach

                                    @if (count($get_product_category) <= 0)
                                        @include('admin.product.excursion._category')
                                    @endif
                                    <div class="show_category">
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12 add_more_button">
                                            <button class="btn btn-success btn-sm float-end" type="button"
                                                id="add_category" title='Add more'>
                                                <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 content_title">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label"
                                                for="duration_from">{{ translate('Duration') }}<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group mb-3">
                                                <div id="demoBox"></div>
                                                <input type='hidden' name='duration' id="duration" value="">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-self-center col-md-4 mt-4">
                                            <input class="form-check-input " id="approx" type="checkbox"
                                                name="approx" {{ getChecked('1', $get_product['approx']) }} />
                                            <label class="form-check-label"
                                                for="approx">{{ translate('Approx') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="duration_from">{{ translate('Upload Logo') }}
                                        <small>(792X450)</small> </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control " type="file" name="logo"
                                            aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo')"
                                            id="logo" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="price">{{ translate('Duration Text') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input
                                            class="form-control  {{ $errors->has('duration_text') ? 'is-invalid' : '' }}"
                                            type="text" name="duration_text"
                                            placeholder="{{ translate('Duration Text') }}"
                                            aria-describedby="basic-addon2" id="duration_text"
                                            value="{{ old('duration_text', $get_product['duration_text']) }}" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                        <div class="h-100 w-100  overflow-hidden position-relative">
                                            <img src="{{ $get_product['logo'] != '' ? asset('uploads/product_images/' . $get_product['logo']) : asset('uploads/placeholder/placeholder.png') }}"
                                                id="upload_logo" width="100" alt="" />
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label"
                                        for="duration_from">{{ translate('Upload Video Thumbnail') }} </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control " type="file" name="video_thumbnail"
                                            aria-describedby="basic-addon2" onchange="loadFile(event,'video_thumbnail')"
                                            id="video_thumbnail_img" />
                                        <input type="hidden" name="video_thumbnail_dlt"
                                            value="{{ $get_product['video_thumbnail'] }}">

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="title">{{ translate('Video') }}
                                    </label>

                                    <input class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}"
                                        id="Video" name="video" type="text"
                                        value="{{ $get_product['video'] }}"
                                        placeholder="{{ translate('Enter video url') }}" />
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <div class="col-md-6 content_title imgs_div img-thumbnail-preview" style="display:none;">

                                    <div>
                                        <button class="delete_thumbnail bg-card btn btn-danger btn-sm float-end"
                                            type="button"><span class="fa fa-trash"></span></button>
                                    </div>

                                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls ">
                                        <div class="h-100 w-100  overflow-hidden position-relative">
                                            <img src="{{ $get_product['video_thumbnail'] != '' ? asset('uploads/product_images/' . $get_product['video_thumbnail']) : '' }}"
                                                id="video_thumbnail" width="100" alt="" />
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="price">{{ translate('Pick Options') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input class="form-control  {{ $errors->has('pick_option') ? 'is-invalid' : '' }}"
                                            type="text" name="pick_option"
                                            placeholder="{{ translate('Pick Option Details') }}"
                                            aria-describedby="basic-addon2" id="pick_option"
                                            value="{{ old('pick_option', $get_product['pick_option']) }}" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label"
                                        for="duration_from">{{ translate('Original Price') }}</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control numberonly" type="text" name="original_price"
                                            placeholder="{{ translate('Original Price') }}"
                                            value="{{ old('original_price', $get_product['original_price']) }}"
                                            aria-describedby="basic-addon2" id="original_price" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="duration_from">{{ translate('Selling Price') }}<span
                                            class="text-danger">*</span></label>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="input-group mb-3">
                                                <input class="form-control numberonly" type="text"
                                                    name="selling_price" placeholder="{{ translate('Website Price') }}"
                                                    value="{{ old('selling_price', $get_product['selling_price']) }}"
                                                    aria-describedby="basic-addon2" id="selling_price" />

                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group mb-3"><span class="input-group-text"
                                                    id="basic-addon1">{{ translate('Per') }}</span><input
                                                    class="form-control" type="text" placeholder="Username"
                                                    name="per_value"
                                                    value="{{ old('per_value', $get_product['per_value']) }}"
                                                    aria-label="Username" aria-describedby="basic-addon1"></div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="title">{{ translate('Blackout Dates') }}

                                    </label>
                                    <input class="form-control datetimepickerdate" id="blackout_date"
                                        name="blackout_date" type="text" placeholder="Y-m-d" value="" />

                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label"
                                        for="duration_from">{{ translate('Affiliate Commission') }}</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control numberonly" type="text" name="affiliate_commission"
                                            placeholder="{{ translate('Affiliate Commission In Percentage') }}"
                                            value="{{ old('affiliate_commission', $get_product['affiliate_commission']) }}"
                                            aria-describedby="basic-addon2" id="affiliate_commission" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label"
                                        for="duration_from">{{ translate('How Many Are Sold') }}</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control numberonly" type="text" name="how_many_are_sold"
                                            placeholder="{{ translate('How Many Are Sold') }}"
                                            value="{{ old('how_many_are_sold', $get_product['how_many_are_sold']) }}"
                                            aria-describedby="basic-addon2" id="how_many_are_sold" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="title">{{ translate('Not On Sale') }}

                                    </label>
                                    <input class="form-control datetimepickerdate note_on_sale_date"
                                        id="note_on_sale_date" name="note_on_sale_date" type="text"
                                        placeholder="Y-m-d" value="{{ $get_product['note_on_sale_date'] }}" />

                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                                <div class="col-md-12 content_title">
                                    <label class="form-label" for="title">{{ translate('Address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="3" cols="50"
                                        placeholder="{{ translate('Enter Location') }}" id="input_store_address_id" name="address">{{ old('address', $get_product['address']) }}</textarea>
                                    <input type="hidden" name="address_lattitude" id="address_lattitude"
                                        class="form-control" value="{{ $get_product['address_lattitude'] }}">
                                    <input type="hidden" name="address_longitude" id="address_longitude"
                                        class="form-control" value="{{ $get_product['address_longitude'] }}">

                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                                <h5 class="text-black mt-2 fw-semi-bold fs-0">
                                    {{ translate('Additional Information') }}
                                </h5>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="additional_heading">{{ translate('Additional information') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('additional_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Title') }}"
                                            id="additional_heading{{ $lang_id }}"
                                            name="additional_heading[{{ $lang_id }}]" type="text"
                                            value="{{ old('additional_heading.' . $lang_id, getLanguageTranslate($additional_heading, $lang_id, 'heading_title', 'title', 'meta_title')) }}" />
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="add_info_row">

                                    @php
                                        $data = 0;
                                        $AddtionalINFO = 0;
                                    @endphp
                                    @foreach ($get_product_additional_info as $GPAI)
                                        @include('admin.product.excursion._info')
                                        @php
                                            $data++;
                                            $AddtionalINFO++;
                                        @endphp
                                    @endforeach
                                    @if (empty($get_product_highlight))
                                        @include('admin.product.excursion._info')
                                    @endif

                                    <div class="row">
                                        <div class="show_info">
                                        </div>
                                        <div class="col-md-12 add_more_button mt-3">
                                            <button class="btn btn-success btn-sm float-end" type="button"
                                                id="add_info" title='Add more'> <span class="fa fa-plus"></span>
                                                {{ translate('Add More') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Divide Row --}}
                        <div class="col-lg-4 col-md-4 colcss content_title">
                            <div class="row">
                                <div class="col-md-12 content_title">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end excertion_status "
                                            {{ getChecked('Active', old('excertion_status', $get_product['status'])) }}
                                            id="excertion_status" type="checkbox" value="Active"
                                            name="excertion_status">
                                        <label class="form-check-label form-label"
                                            for="excertion_status">{{ translate('Excursion Status') }}
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-12 content_title">
                                    <label class="form-label" for="title">{{ translate('Availability') }} </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text" name="availability"
                                            placeholder="{{ translate('Availability') }}"
                                            value="{{ old('availability', $get_product['availability']) }}"
                                            aria-describedby="basic-addon2" id="availability" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>

                                @if (check_table_count('user_review', $get_product['id'], 'product_id') == 0)
                                    <div class="col-md-12 content_title">
                                        <label class="form-label" for="title">{{ translate('Review Rating') }}
                                        </label>
                                        <div class="input-group mb-3">
                                            <select name="rating" class="form-control">
                                                <option value="1"
                                                    {{ $get_product['random_rating'] == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2"
                                                    {{ $get_product['random_rating'] == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3"
                                                    {{ $get_product['random_rating'] == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4"
                                                    {{ $get_product['random_rating'] == 4 ? 'selected' : '' }}>4</option>
                                                <option value="5"
                                                    {{ $get_product['random_rating'] == 5 ? 'selected' : '' }}>5</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12 content_title pro_status">
                                    <label class="form-label" for="price">{{ translate('Excursion Type') }}
                                    </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text" name="excursion_type"
                                            placeholder="{{ translate('Excursion Type') }}"
                                            value="{{ old('excursion_type', $get_product['excursion_type']) }}"
                                            aria-describedby="basic-addon2" id="excursion_type" />
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 content_title pro_status">
                                    <label class="form-label" for="price">{{ translate('Excursion Information') }}
                                    </label>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" type="text" name="product_info[excursion_type]"
                                            placeholder="{{ translate('Excursion Information') }}" aria-describedby="basic-addon2" id="excursion_type">{{ old('product_info.excursion_type', getAllInfo('product_info', ['title' => 'excursion_type', 'product_id' => $get_product['id']], 'value')) }}
                                    </textarea>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[add_to_recom_tours]" id="recom_tours" type="checkbox"
                                            {{ getChecked('on', old('product_setting.add_to_recom_tours', getProductSetting('Excursion', $get_product['id'], 'add_to_recom_tours'))) }}>
                                        <label class="form-check-label form-label"
                                            for="recom_tours">{{ translate('Add to recommended tours') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[recom_tours_main_page_big_picture]"
                                            id="recom_tours_main_page_big_picture" type="checkbox"
                                            {{ getChecked('on', old('product_setting.recom_tours_main_page_big_picture', getProductSetting('Excursion', $get_product['id'], 'recom_tours_main_page_big_picture'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="recom_tours_main_page_big_picture">{{ translate('Add to Recommended main tour in main page the big picture') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 content_title {{ getProductSetting('Excursion', $get_product['id'], 'recom_tours_main_page_big_picture') != 'on' ? 'd-none' : '' }}"
                                    id="recom_big_div">
                                    <label class="form-label"
                                        for="duration_from">{{ translate('Recommended Tours Big Pictures') }}
                                        <small>(600×400)</small> </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control " type="file" name="recom_big_pic"
                                            aria-describedby="basic-addon2" onchange="loadFile(event,'recom_big_pic_pre')"
                                            id="recom_big_pic" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls"
                                        style="width: 200px; height: 100px;">
                                        <div class="h-100 w-100  overflow-hidden position-relative">
                                            <img src="{{ $get_product['recommend_pic'] != '' ? asset('uploads/product_images/recom_big_pic/' . $get_product['recommend_pic']) : asset('uploads/placeholder/placeholder.png') }}"
                                                id="recom_big_pic_pre" width="100" alt="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[recom_tours_main_page_small_picture]"
                                            id="recom_tours_main_page_small_picture" type="checkbox"
                                            {{ getChecked('on', old('product_setting.recom_tours_main_page_small_picture', getProductSetting('Excursion', $get_product['id'], 'recom_tours_main_page_small_picture'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="recom_tours_main_page_small_picture">{{ translate('Add to Recommended main tour in main page the small picture') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[add_to_world_adventure_main_page]"
                                            id="add_to_world_adventure_main_page" type="checkbox"
                                            {{ getChecked('on', old('product_setting.add_to_world_adventure_main_page', getProductSetting('Excursion', $get_product['id'], 'add_to_world_adventure_main_page'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="add_to_world_adventure_main_page">{{ translate('Add to world of adventures awaits you on main page') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[add_to_luxury_main_page]" id="add_to_luxury_main_page"
                                            type="checkbox"
                                            {{ getChecked('on', old('product_setting.add_to_luxury_main_page', getProductSetting('Excursion', $get_product['id'], 'add_to_luxury_main_page'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="add_to_luxury_main_page">{{ translate('Add to luxury treats on main page') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[add_to_top_seller_in_uae]" id="add_to_top_seller_in_uae"
                                            type="checkbox"
                                            {{ getChecked('on', old('product_setting.add_to_top_seller_in_uae', getProductSetting('Excursion', $get_product['id'], 'add_to_top_seller_in_uae'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="add_to_top_seller_in_uae">{{ translate('Add to top sellers in UAE') }}
                                        </label>
                                    </div>
                                </div>

                                <div
                                    class="col-md-12 content_title mt-3 top_seller_sort_div _18xMp
                                @php if (getChecked('on',old('product_setting.add_to_top_seller_in_uae',getProductSetting('Excursion', $get_product['id'], 'add_to_top_seller_in_uae'))) != ' checked')  { echo ' d-none ' ;} @endphp">
                                    <label class="form-label"
                                        for="price">{{ translate('Select Top Seller Sort Number') }}
                                    </label>
                                    <div class="form-check form-switch pl-0">
                                        <select name="product_setting[top_seller_in_uae_sort_no]"
                                            class="top_seller_sort form-select single-select" id="top_seller_sort">
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ getSelected($i, old('product_setting.top_seller_in_uae_sort_no', getProductSetting('Excursion', $get_product['id'], 'top_seller_in_uae_sort_no'))) }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[city_best_selling_tour]" id="city_best_selling_tour"
                                            type="checkbox"
                                            {{ getChecked('on', old('product_setting.city_best_selling_tour', getProductSetting('Excursion', $get_product['id'], 'city_best_selling_tour'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="city_best_selling_tour">{{ translate('City best selling tour') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end "
                                            name="product_setting[related_top_rated_activity]"
                                            id="related_top_rated_activity" type="checkbox"
                                            {{ getChecked('on', old('product_setting.city_best_selling_tour', getProductSetting('Excursion', $get_product['id'], 'related_top_rated_activity'))) }}>
                                        <label class="form-check-label form-label w-90"
                                            for="related_top_rated_activity">{{ translate('Top Rated Activities') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 content_title mt-3">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end " name="is_recently" id="is_recently"
                                            type="checkbox" {{ $get_product['is_recently'] == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label form-label w-90"
                                            for="is_recently">{{ translate('Recently Product') }}
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>

                {{-- Highlight TAb  --}}
                <li class="tab-content tab-content-2 typography " style="display: none">
                    <div class="colcss">

                        @php
                            $data = 0;
                            $Highlights_data = 0;
                        @endphp
                        @foreach ($get_product_highlight as $GPH)
                            @include('admin.product.excursion._highlight')
                            @php
                                $data++;
                                $Highlights_data++;
                            @endphp
                        @endforeach
                        @if (empty($get_product_highlight))
                            @include('admin.product.excursion._highlight')
                        @endif
                        <div class="show_highlights">
                        </div>
                        <div class="row">

                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_highlights"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> Add more</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- Timing TAb --}}
                <li class="tab-content tab-content-3 typography " style="display: none">

                    <div class="row colcss">
                        <div class="col-md-1"></div>

                        <div class="col-md-10 content_title">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="opening_time_heading">{{ translate('Opening Time') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control {{ $errors->has('opening_time_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                        placeholder="{{ translate('Title') }}"
                                        id="opening_time_heading{{ $lang_id }}"
                                        name="opening_time_heading[{{ $lang_id }}]" type="text"
                                        value="{{ old('opening_time_heading.' . $lang_id, getLanguageTranslate($opening_time_heading, $lang_id, 'heading_title', 'title', 'meta_title')) }}" />
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end timing_status"
                                    {{ getChecked(1, $get_product['timing_status']) }} id="timing_status"
                                    type="checkbox" value="Active" name="timing_status">
                                <label class="form-check-label form-label"
                                    for="timing_status">{{ translate('Active/Not Active') }}
                                </label>
                            </div>
                            @php
                                $check_daily = [];
                            @endphp
                            @foreach ($get_timings as $key => $value)
                                @php
                                    $check_daily[] = $value['day'];
                                @endphp
                                <div class="row week_box">
                                    <div class="col-md-3 content_title align-self-end">
                                        <h5 class="text-primary">{{ $value['day'] }}</h5>
                                        <input type="hidden" name="day[]" value="{{ $value['day'] }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="timepicker1">{{ translate('From') }}</label>
                                        <input class="form-control datetimepicker pick_from" id="timepicker1"
                                            name="time_from[]" type="text" placeholder="H:i"
                                            data-options='{"enableTime":true,"dateFormat":"H:i","disableMobile":true}'
                                            value="{{ $value['time_from'] }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="timepicker1">To</label>
                                        <input class="form-control datetimepicker pick_to" id="timepicker1"
                                            name="time_to[]" type="text" placeholder="H:i"
                                            data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
                                            value="{{ $value['time_to'] }}" />
                                    </div>
                                    <div class="col-md-1 align-self-end">
                                        <label class="form-check-label" for="flexCheckChecked">Close</label>
                                        <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                            name="is_close[{{ $value['day'] }}]"
                                            {{ getChecked('1', $value['is_close']) }} />
                                    </div>
                                </div>
                            @endforeach

                            @if (!in_array('Daily', $check_daily))
                                <div class="row week_box">
                                    <div class="col-md-3 content_title align-self-end">
                                        <h5 class="text-primary">Daily</h5>
                                        <input type="hidden" name="day[]" value="Daily">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="timepicker1">{{ translate('From') }}</label>
                                        <input class="form-control datetimepicker pick_from" id="timepicker1"
                                            name="time_from[]" type="text" placeholder="H:i"
                                            data-options='{"enableTime":true,"dateFormat":"H:i","disableMobile":true}'
                                            value="9:00" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="timepicker1">To</label>
                                        <input class="form-control datetimepicker pick_to" id="timepicker1"
                                            name="time_to[]" type="text" placeholder="H:i"
                                            data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
                                            value="11:00" />
                                    </div>
                                    <div class="col-md-1 align-self-end">
                                        <label class="form-check-label" for="flexCheckChecked">Close</label>
                                        <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                            name="is_close['Daily']" {{ getChecked('1', 0) }} />
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-md-1"></div>

                    </div>
                </li>

                {{-- Option TAb  --}}
                <li class="tab-content tab-content-4 typography" style="display: none">
                    @if (!empty($get_product_option_week_tour))
                        @php
                            $tour_id = count($get_product_option_week_tour) + 1;
                        @endphp
                    @else
                        @php
                            $tour_id = 1;
                        @endphp
                    @endif

                    @if (!empty($get_product_option_period_pricing))
                        @php
                            $period_id = count($get_product_option_period_pricing) + 1;
                        @endphp
                    @else
                        @php
                            $period_id = 1;
                        @endphp
                    @endif

                    @if (!empty($get_product_option_group_percentage))
                        @php
                            $group_per_id = count($get_product_option_group_percentage) + 1;
                        @endphp
                    @else
                        @php
                            $group_per_id = 1;
                        @endphp
                    @endif

                    @if (!empty($get_product_option_tour_upgrade))
                        @php
                            $tour_upgrade_id = count($get_product_option_tour_upgrade);
                        @endphp
                    @else
                        @php
                            $tour_upgrade_id = 1;
                        @endphp
                    @endif
                    <div class="col-md-12 content_title colcss">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label"
                                    for="price">{{ translate('Private Tour Option Heading') }}</label>
                                <input
                                    class="form-control {{ $errors->has('tour_option_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                    id="tour_option_heading_{{ $lang_id }}"
                                    name="tour_option_heading[{{ $lang_id }}]"
                                    placeholder="{{ translate('Tour option heading') }}"
                                    value="{{ getLanguageTranslate($tour_option_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>

                        @php
                            $data = $optiondata = 1;
                            
                        @endphp

                        @foreach ($get_product_option as $GPO)
                            @include('admin.product.excursion._option')
                            @php
                                $optiondata++;
                                $data = $optiondata;
                                
                            @endphp
                        @endforeach
                        @if (empty($get_product_option))
                            @include('admin.product.excursion._option')
                        @endif
                        <div class="show_table">
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_table"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span>
                                    {{ translate('Add More') }}</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- Group Percentage --}}
                <li class="tab-content tab-content-13 typography" style="display: none">
                    <div class="colcss">
                        <div class="row">
                            <input type="hidden" name="single_group_percentage_id"
                                value="{{ $get_product_group_percentage['id'] }}">

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="title">{{ translate('Main Title') }}
                                </label>
                                <input
                                    class="form-control {{ $errors->has('main_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Main Title') }}" id="main_title_{{ $lang_id }}"
                                    name="main_title[{{ $lang_id }}]" type="text"
                                    value="{{ getLanguageTranslate($get_product_group_percentage_language, $lang_id, $get_product_group_percentage['id'], 'main_title', 'group_percentage_id') }}" />

                                <div class="invalid-feedback">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="title">{{ translate('Group Percentage') }}
                                </label>
                                <input
                                    class="form-control {{ $errors->has('single_group_percentage.' . $lang_id) ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Group Percentage') }}"
                                    id="group_single_group_percentage_{{ $lang_id }}"
                                    name="group_single_group_percentage[{{ $lang_id }}]" type="text"
                                    value="{{ getLanguageTranslate($get_product_group_percentage_language, $lang_id, $get_product_group_percentage['id'], 'title', 'group_percentage_id') }}" />

                                <div class="invalid-feedback">

                                </div>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label"
                                    for="single_group_addtional_info">{{ translate('Additional Info') }}
                                </label>
                                <textarea class="form-control {{ $errors->has('single_group_addtional_info.' . $lang_id) ? 'is-invalid' : '' }}"
                                    cols="50" row="3" placeholder="{{ translate('Enter Additional Info') }}"
                                    id="group_single_group_addtional_info_{{ $lang_id }}"
                                    name="group_single_group_addtional_info[{{ $lang_id }}]" type="text">{{ getLanguageTranslate($get_product_group_percentage_language, $lang_id, $get_product_group_percentage['id'], 'description', 'group_percentage_id') }}</textarea>

                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 content_title ">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-check-input mt-2 " id="group_per_tax_allowed"
                                                    type="checkbox" name="group_per_tax_allowed" value="1"
                                                    {{ $get_product_group_percentage['tax_allowed'] == 1 ? 'checked' : '' }} />
                                                <label for="group_per_tax_allowed"
                                                    class="fs-0 mt-1">{{ translate('Tax') }}</label>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input class="form-control numberonly" type="text"
                                                        placeholder="{{ translate('Enter Tax ') }}" name="group_per_tax"
                                                        value="{{ $get_product_group_percentage['tax_percentage'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"><span
                                                        class="input-group-text" id="basic-addon1">%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-6 content_title">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <td> <input class="form-check-input mt-2 " id="tax_check" type="checkbox"
                                                    name="group_per_service_charge" value="1"
                                                    {{ $get_product_group_percentage['service_charge_allowed'] == 1 ? 'checked' : '' }} />
                                                <label for="group_per_service_charge"
                                                    class="fs-0 mt-1">{{ translate('Service Charge') }}</label>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3"><input class="form-control numberonly"
                                                        type="text"
                                                        placeholder="{{ translate('Enter Service Charge') }}"
                                                        name="group_per_service_amount"
                                                        value="{{ $get_product_group_percentage['service_charge_amount'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"><span
                                                        class="input-group-text"
                                                        id="basic-addon1">{{ translate('Amount') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="mt-2">
                            <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Tour Availability') }}</h5>
                            <div class="form-check avia_div">
                                <div class="row">
                                    <div class="col-md-1">
                                        <input class="form-check-input group_available_record"
                                            id="group_daily_{{ $data }}" type="radio"
                                            data-id="{{ $data }}" value="daily" name="group_available_type"
                                            checked="">
                                        <label class="form-check-label"
                                            for="group_daily_{{ $data }}">{{ translate('Daily') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-check-input group_available_record"
                                            data-id="{{ $data }}"
                                            id="group_days_available_{{ $data }}"
                                            {{ getChecked('days_available', $get_product_group_percentage['available_type']) }}
                                            type="radio" value="days_available" name="group_available_type">
                                        <label class="form-check-label"
                                            for="group_days_available_{{ $data }}">{{ translate('Select Days Available') }}</label>
                                        <div
                                            class="row div_group_days_available_{{ $data }} @if ($get_product_group_percentage['available_type'] == 'days_available') @else {{ ' d-none' }} @endif group_available_record_div_{{ $data }}">
                                            <div class="col-md-12 content_title show_timings append_weekdays ">
                                                @php
                                                    $product = json_decode($get_product_group_percentage['days_available']);
                                                    if ($product == '') {
                                                        $product = [];
                                                    }
                                                @endphp
                                                <table class="table table-responsive bg-white">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2">
                                                                {{ translate('Same Time For All Weekdays') }}

                                                            </td>

                                                            <td>
                                                                <div class="form-check form-switch pl-0">
                                                                    <input
                                                                        class="form-check-input float-end group_time_for_all_weekdays"
                                                                        id="group_time_for_all_weekdays{{ $data }}"
                                                                        type="checkbox"
                                                                        {{ getChecked(1, $get_product_group_percentage['same_time_for_weekdays']) }}
                                                                        value="{{ $get_product_group_percentage['same_time_for_weekdays'] }}"
                                                                        data-id="{{ $data }}"
                                                                        name="group_time_for_all_weekdays">
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $days_available = json_decode($get_product_group_percentage['days_available']);
                                                            if ($days_available == '') {
                                                                $days_available = [];
                                                            }
                                                            $get_timings = App\Models\Timing::where('is_close', 0)->get();
                                                        @endphp
                                                        @foreach ($days_available as $daysKey => $GPDA)
                                                            @php
                                                                
                                                                $NewWeekArr[$daysKey] = $GPDA;
                                                            @endphp
                                                        @endforeach

                                                        @foreach ($get_timings as $timeKey => $GT)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch pl-0">
                                                                        <input
                                                                            class="form-check-input float-end timing_status"
                                                                            id="timing_status" type="checkbox"
                                                                            value="Active"
                                                                            {{ isset($NewWeekArr[$GT['day']]) ? ' checked' : '' }}
                                                                            name="group_available_tour_week_time_status[{{ $GT['day'] }}]">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{ $GT['day'] }}
                                                                </td>
                                                                <td style="min-width: 103px !important;">

                                                                    <select
                                                                        class="form-select multi-select available_tour_week_time"
                                                                        name="group_available_tour_week_time[{{ $GT['day'] }}][]"
                                                                        data-id="{{ $timeKey }}"
                                                                        data-dataid="{{ $data }}"
                                                                        id="available_tour_week_time{{ $data }}{{ $timeKey }}"
                                                                        multiple>
                                                                        @foreach ($product_option_time as $POT)
                                                                            <option value="{{ $POT->id }}"
                                                                                {{ isset($NewWeekArr[$GT['day']]) ? getSelectedInArray($POT->id, $NewWeekArr[$GT['day']]) : '' }}>
                                                                                {{ $POT->title }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="form-check-input group_available_record"
                                            data-id="{{ $data }}"
                                            id="group_date_available_{{ $data }}"
                                            {{ getChecked('date_available', $get_product_group_percentage['available_type']) }}
                                            type="radio" value="date_available" name="group_available_type">

                                        <label class="form-check-label"
                                            for="group_date_available_{{ $data }}">{{ translate('Select Date Available') }}</label>
                                        <div
                                            class="div_group_date_available_{{ $data }} @if ($get_product_group_percentage['available_type'] == 'date_available') @else{{ ' d-none' }} @endif group_available_record_div_{{ $data }}">

                                            <table class="table table-responsive bg-white">
                                                <thead>
                                                    <tr>
                                                        <td colspan="2">{{ translate('Same Time For All Dates') }}
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch pl-0">
                                                                <input
                                                                    class="form-check-input float-end group_time_for_all_dates"
                                                                    id="group_time_for_all_dates{{ $data }}"
                                                                    type="checkbox"
                                                                    {{ getChecked(1, $get_product_group_percentage['same_time_for_dates']) }}
                                                                    value="{{ $get_product_group_percentage['same_time_for_dates'] }}"
                                                                    data-id="{{ $get_product_group_percentage['id'] }}"
                                                                    name="group_time_for_all_dates">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_tour_group_date_box_{{ $data }}">
                                                    @php
                                                        $tour_date_id = 0;
                                                    @endphp
                                                    @php
                                                        $date_available = json_decode($get_product_group_percentage['date_available']);
                                                        if ($date_available == '') {
                                                            $date_available = [];
                                                        }
                                                    @endphp
                                                    @foreach ($date_available as $dateKey => $DA)
                                                        @include('admin.product.excursion._tour_group_date_time')
                                                        @php
                                                            $tour_date_id++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <button
                                                                class="btn btn-success btn-sm add_group_tour_avail_date"
                                                                data-dataid="{{ $data }}"
                                                                data-id="{{ $tour_date_id }}" type="button">
                                                                <span class="fa fa-plus"></span>
                                                                {{ translate('Add More') }}</button>
                                                        </td>
                                                    </tr>

                                                </tfoot>

                                            </table>

                                        </div>
                                    </div>
                                    @php
                                        $available_type = 1;
                                    @endphp
                                    @if ($get_product_group_percentage['available_type'] == 'days_available')
                                        @php
                                            $available_type = $get_product_group_percentage['same_time_for_weekdays'];
                                        @endphp
                                    @elseif($get_product_group_percentage['available_type'] == 'date_available')
                                        @php
                                            $available_type = $get_product_group_percentage['same_time_for_dates'];
                                        @endphp
                                    @endif
                                    <div
                                        class="col-md-3 group_time_availble_div{{ $data }} @if ($available_type == 0) {{ ' d-none' }} @endif">

                                        <label class="form-check-label"
                                            for="time_available">{{ translate('Select Available Time') }}</label>
                                        <select class="form-select multi-select" name="group_option_available_time[]"
                                            id="option_available_time{{ $data }}" multiple>
                                            @foreach ($product_option_time as $POT)
                                                <option value="{{ $POT->id }}"
                                                    {{ getSelectedInArray($POT->id, $get_product_group_percentage['time_available']) }}>
                                                    {{ $POT->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 content_title ">
                            <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Group Price') }}
                                <small>({{ translate('Enter default price') }})</small>
                            </h5>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Group Price') }}</th>
                                        {{-- <th>{{ translate('Child Allowed') }}</th>
                                        <th>{{ translate('Child Price') }}</th>
                                        <th>{{ translate('Infant Allowed') }}</th>
                                        <th>{{ translate('Infant') }}</th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <input
                                                class="form-control numberonly {{ $errors->has('deafult_group_price') ? 'is-invalid' : '' }}"
                                                style="width: 25%" type="text" name="deafult_group_price"
                                                placeholder="{{ translate('Group Price') }}"
                                                value="{{ $get_product_group_percentage['group_price'] }}" />
                                            @error('deafult_group_price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 content_title ">
                            <table class="private_tour_table table table-responsive ">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Group Price') }}</th>
                                        <th>{{ translate('Number Of Pax') }}</th>
                                        <th>{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="show_single_group_percentage">
                                    @php
                                        $data = 0;
                                        $single_group_percentage_id = 0;
                                        
                                    @endphp
                                    @foreach ($get_product_group_percentage_details as $GPGPD)
                                        @include('admin.product.excursion._single_group_percentage')
                                        @php
                                            
                                            $data++;
                                            $single_group_percentage_id++;
                                        @endphp
                                    @endforeach

                                    @if (count($get_product_group_percentage_details) <= 0)
                                        @include('admin.product.excursion._single_group_percentage')
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button"
                                    id="add_single_group_percentage" title='Add more'>
                                    <span class="fa fa-plus"></span>
                                    {{ translate('Add More') }}</button>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Images Tab --}}
                <li class="tab-content tab-content-5  typography" style="display: none">
                    <div class="row colcss">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="duration_from">{{ translate('Image') }}<span
                                            class="text-danger">*</span> <small>(792X450)</small> </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control " type="file" name="image"
                                            aria-describedby="basic-addon2" onchange="loadFile(event,'preview_image')"
                                            id="image" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                        <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                            <div class="h-100 w-100  overflow-hidden position-relative">
                                                <img src="{{ $get_product['image'] != '' ? asset('uploads/product_images/' . $get_product['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                    id="preview_image" width="100" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 content_title">
                                    <label class="form-label" for="duration_from">{{ translate('Image Text') }}
                                    </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control " type="text" name="image_text"
                                            aria-describedby="basic-addon2" id="image_text"
                                            value="{{ old('image_text', $get_product['image_text']) }}" />

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">

                                <div class="col-md-6 content_title">
                                    <input class="{{ $errors->has('files_count') ? 'is-invalid' : '' }}" type="hidden"
                                        name="files_count" placeholder="{{ translate('Files Count') }}"
                                        id="files_count" />

                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                    for="customFile">{{ translate('Multiple Banner Image') }}
                                    <small>(792X450)</small>
                                    <span class="fas fa-info-circle"></span>
                                </label>
                                <div class="upload_img">

                                    <div class="uploader_file wrapper">
                                        <div class="drop">
                                            <div class="cont">
                                                <span class="image-file">
                                                    <img src="{{ asset('assets/img/add-image.png') }}"
                                                        class="img-fluid">
                                                </span>
                                                <div class="browse">
                                                    <span class="upload-icon">
                                                        <img src="{{ asset('assets/img/pro_upload.png') }}"
                                                            class="img-fluid"></span>
                                                    {{ translate('Drop your image here.or') }}
                                                    <span class="browse_txt">{{ translate('Browse') }}</span>
                                                </div>
                                                <input id="files" id="files" multiple="true" name="files[]"
                                                    type="file" />
                                            </div>
                                            <output id="list"></output>
                                            <div class="row appenImage"></div>
                                        </div>

                                    </div>

                                    @if (count($get_product_images) > 0)
                                        <?php $i = 1; ?>
                                        <div class="row">
                                            @foreach ($get_product_images as $key => $image)
                                                <div class='col-md-2'>
                                                    <div class="image-item upload_img_list">

                                                        <img src="{{ asset('uploads/product_images/' . $image['product_images']) }}"
                                                            alt="" width="20" title="">

                                                        <div class="image_name_sort">
                                                            <input type="number"
                                                                name="sort_order_images[{{ $key }}]"
                                                                class="form-control"
                                                                placeholder="{{ translate('Enter Sort value') }}"
                                                                value="{{ $image['sort_order_images'] }}">
                                                        </div>
                                                        <div class="image_name_size">
                                                            <input type="hidden" name="image_id[]"
                                                                value="{{ $image['id'] }}">
                                                        </div>
                                                        <div class="image-item__btn-wrapper">
                                                            <button type="button" class="btn btn-default remove btn-sm"
                                                                data-count="{{ $i++ }}">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Faq Tab --}}
                <li class="tab-content tab-content-6    typography" style="display: none">
                    <div class="colcss">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label"
                                    for="faq_heading">{{ translate('Frequently asked question Heading') }}<span
                                        class="text-danger">*</span>
                                </label>
                                <input
                                    class="form-control {{ $errors->has('faq_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Title') }}" id="faq_heading{{ $lang_id }}"
                                    name="faq_heading[{{ $lang_id }}]" type="text"
                                    value="{{ old('faq_heading.' . $lang_id, getLanguageTranslate($faq_heading, $lang_id, 'heading_title', 'title', 'meta_title')) }}" />
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        @php
                            $data = 0;
                        @endphp
                        @foreach ($get_product_faq as $GPF)
                            @include('admin.product.excursion._faq')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_product_faq))
                            @include('admin.product.excursion._faq')
                        @endif

                        <div class="show_faqs">
                        </div>
                        <div class="row">
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_faqs"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- Advertisement Tab --}}
                <li class="tab-content tab-content-7    typography" style="display: none">
                    <div class="colcss">
                        @php
                            $data = 0;
                        @endphp
                        @foreach ($get_product_site_adver as $GPSD)
                            @include('admin.product.excursion._site_advertisement')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_product_site_adver))
                            @include('admin.product.excursion._site_advertisement')
                        @endif

                        <div class="show_adver">
                        </div>
                        <div class="row">
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_adver"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Vouchers Tab --}}
                <li class="tab-content tab-content-9 typography " style="display: none">
                    <div class="colcss">

                        @php
                            $data = 0;
                        @endphp
                        @foreach ($get_product_voucher as $GPV)
                            @include('admin.product.excursion._voucher')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_product_voucher))
                            @include('admin.product.excursion._voucher')
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
                <li class="tab-content tab-content-10    typography" style="display: none">
                    <div class="colcss">

                        @foreach ($customerGroup as $key => $CG)
                            @php
                                $productCustomerGroup = (array) getDataFromDB('product_customer_group_discount', ['product_id' => $get_product['id'], 'customer_group_id' => $CG['id'], 'type' => 'excursion'], 'row');
                                if (!$productCustomerGroup) {
                                    $productCustomerGroup = getTableColumn('product_customer_group_discount');
                                }
                                
                            @endphp

                            <div class="row">
                                <input type="hidden" name="product_customer_group_discount_id[]"
                                    value="{{ $productCustomerGroup['id'] }}">
                                <input type="hidden" name="product_customer_group_id[]"
                                    value="{{ $CG['id'] }}">
                                <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ $CG['title'] }}</h5>
                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label"
                                        for="price">{{ translate('Tour Price % Discount') }}</label>
                                    <input type="text" class="form-control numberonly" name="tour_price[]"
                                        value="{{ old('tour_price.' . $key, $productCustomerGroup['tour_price']) }}" />
                                </div>
                                <div class="col-md-2-5 col-lg-2-5  content_title box">
                                    <label class="form-label"
                                        for="price">{{ translate('Tour Upgrade % Discount') }}

                                    </label>
                                    <input type="text" class="form-control numberonly" name="tour_upgrade_option[]"
                                        value="{{ old('tour_upgrade_option.' . $key, $productCustomerGroup['tour_upgrade_option']) }}" />
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

                {{-- Related Products TAb  --}}
                <li class="tab-content tab-content-11 typography " style="display: none">
                    <div class="colcss">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"
                                    for="related_product_title">{{ translate('Related Products Title') }}<span
                                        class="text-danger">*</span>
                                </label>
                                <input
                                    class="form-control {{ $errors->has('related_product_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Related Products Title') }}"
                                    id="title_{{ $lang_id }}" name="related_product_title[{{ $lang_id }}]"
                                    type="text"
                                    value="{{ old('related_product_title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'related_product_title', 'product_id')) }}" />

                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>

                        @php
                            $data = 0;
                        @endphp
                        @foreach ($get_product_related_boats as $GYRB)
                            @include('admin.product.excursion._realated_boats')
                            @php
                                $data++;
                            @endphp
                        @endforeach

                        <div class="show_boats">
                        </div>
                        <div class="row">

                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_boats"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span>{{ translate('Add more') }}</button>
                            </div>
                        </div>

                    </div>
                </li>

                {{-- Extras Tab --}}
                <li class="tab-content tab-content-8 typography " style="display: none">
                    <div class="colcss">
                        <div class="row">
                            <div class="col-md-3 col-lg-3  content_title box">
                                <label class="form-label" for="price">{{ translate('Supplier') }}</label>
                                <select class="form-select multi-select" name="suppliers[]" id="suppliers" multiple>

                                    @foreach ($get_supplier as $GS)
                                        <option value="{{ $GS['id'] }}"
                                            {{ getSelectedInArray($GS['id'], $get_product['supplier']) }}>
                                            {{ $GS['company_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">{{ translate('Child Age Limit') }}
                                        </label>
                                        <input class="form-control"
                                            placeholder="{{ translate('Enter Age Child Limit') }}" id="title"
                                            name="child_age_limit" type="text"
                                            value="{{ old('child_age_limit', $get_product['child_age_limit']) }}" />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="title">{{ translate('Infant Age Limit') }}
                                        </label>
                                        <input class="form-control"
                                            placeholder="{{ translate('Enter Infant Child Limit') }}" id="title"
                                            name="infant_age_limit" type="text"
                                            value="{{ old('infant_age_limit', $get_product['infant_age_limit']) }}" />
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">{{ translate('Minimum People') }}
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Enter Minimum People') }}" id="title"
                                            name="minimum_people" type="text"
                                            value="{{ old('minimum_people', $get_product['minimum_people']) }}" />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="title">{{ translate('Maximum People') }}
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Enter Maximum People') }}" id="title"
                                            name="maximum_people" type="text"
                                            value="{{ old('maximum_people', $get_product['maximum_people']) }}" />
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label"
                                            for="title">{{ translate('Product Rate Valid Until') }}
                                        </label>
                                        <input class="form-control datetimepickerdate" id="rate_valid_until"
                                            name="rate_valid_until" type="text"
                                            value="{{ old('rate_valid_until', $get_product['rate_valid_until']) }}" />
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 col-lg-3 content_title box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Client Reward Points') }}
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Enter Client Reward Points') }}" id="title"
                                            name="client_reward_point" type="text"
                                            value="{{ old('client_reward_point', $get_product['client_reward_point']) }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="price">{{ translate('Reward Points type') }}</label>
                                        <select class="form-select single-select client_reward_point_type"
                                            name="client_reward_point_type" id="client_reward_point_type">
                                            <option value="">{{ translate('Select') }}</option>

                                            <option value="Flat" <?php if ($get_product['client_reward_point_type'] == 'Flat') {
                                                echo 'selected="selected"';
                                            } ?>>Flat</option>
                                            <option value="Percentage" <?php if ($get_product['client_reward_point_type'] == 'Percentage') {
                                                echo 'selected="selected"';
                                            } ?>>Percentage</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label"
                                            for="title">{{ translate('How Many Point To Purchase This Product') }}
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Enter Point') }}" id="title"
                                            name="point_to_purchase_product" type="text"
                                            value="{{ old('point_to_purchase_product', $get_product['point_to_purchase_product']) }}" />
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-6 col-lg-6  content_title box" style="width: 49% !important;">
                                <label class="form-label" for="price">{{ translate('Option Note') }}</label>
                                <textarea class="form-control extra editor" placeholder="{{ translate('Enter Option Note') }}"
                                    name="option_note">{{ $get_product['option_note'] }}</textarea>
                            </div>

                            <div class="col-md-6 col-lg-6  content_title box" style="width: 49% !important;">
                                <label class="form-label" for="price">{{ translate('Booking Policy') }}</label>
                                <textarea class="form-control extra editor" id="booking_policy"
                                    placeholder="{{ translate('Enter Booking Policy') }}" name="booking_policy">{{ $get_product['booking_policy'] }}</textarea>
                            </div> --}}

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="price">{{ translate('Option Note') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control footer_text" rows="8" id="option_note_{{ $lang_id }}"
                                        name="option_note[{{ $lang_id }}]" placeholder="{{ translate('Option Note') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'option_note', 'product_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="price">{{ translate('Booking Policy') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control footer_text" rows="8" id="booking_policy_{{ $lang_id }}"
                                        name="booking_policy[{{ $lang_id }}]" placeholder="{{ translate('Booking Policy') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'booking_policy', 'product_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="price">{{ translate('Group Option Note') }}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <textarea class="form-control footer_text" rows="8" id="extra_option_note_{{ $lang_id }}"
                                        name="extra_option_note[{{ $lang_id }}]" placeholder="{{ translate('Group Option Note') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'extra_option_note', 'product_id') }}</textarea>

                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Other Booking Details') }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="form-label">{{ translate('Can be booked up to in advanced') }}
                                <div id="BookedUpTo"></div>
                                <input type='hidden' name='can_be_booked_up_to_advance'
                                    id="can_be_booked_up_to_advance" value=""> </p>
                            </div>
                            <div class="col-md-4">
                                <p class="form-label">{{ translate('Can be cancelled up to in advanced') }}
                                <div id="CancelledUpTo"></div>
                                <input type='hidden' name='can_be_cancelled_up_to_advance'
                                    id="can_be_cancelled_up_to_advance" value=""> </p>
                            </div>
                            <div class="col-md-8 mt-2">
                                <div class="form-check form-switch pl-0">
                                    <input class="form-check-input float-end" id="per_modifi_or_cancellation"
                                        {{ getChecked(1, $get_product['per_modifi_or_cancellation']) }} type="checkbox"
                                        value="1" name="per_modifi_or_cancellation">
                                    <label class="fs-0"
                                        for="per_modifi_or_cancellation">{{ translate('Not refundable. This activity does not permit modification or cancellation.') }}</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end" id="product_bookable"
                                            {{ getChecked('bookable', $get_product['product_bookable_type']) }}
                                            type="radio" value="bookable" name="product_bookable_type" checked>
                                        <label class="fs-0"
                                            for="product_bookable">{{ translate('Bookable') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end" id="product_on_request"
                                            {{ getChecked('on_request', $get_product['product_bookable_type']) }}
                                            type="radio" value="on_request" name="product_bookable_type">
                                        <label class="fs-0"
                                            for="product_on_request">{{ translate('On Request') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- ToolTip TAb  --}}
                <li class="tab-content tab-content-12 typography " style="display: none">
                    <div class="colcss">

                        <div class="row">

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

                        </div>

                    </div>
                </li>

                {{-- REQUEST POPUP Tab --}}
                <li class="tab-content tab-content-14 typography" style="display: none">
                    <div class="colcss">

                        <div class="col-md-6 content_title img_pop_div img-pop-up-preview" style="display:none;">

                            <div>
                                <button class="delete_pop_img bg-card btn btn-danger btn-sm float-end"
                                    type="button"><span class="fa fa-trash"></span></button>
                            </div>

                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                <div class="h-100 w-100  overflow-hidden position-relative">
                                    <img src="{{ $get_product['popup_image'] != '' ? asset('uploads/product_images/' . $get_product['popup_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                        id="upload_logo_23" width="100" alt="" />
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Pop Up Image') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="file" name="popup_image"
                                    aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo_23')"
                                    id="popup_image" />

                                <input type="hidden" name="popup_image_dlt"
                                    value="{{ $get_product['popup_image'] }}">

                                <div class="invalid-feedback">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="popup_heading">{{ translate('Pop Up Heading') }}<span
                                        class="text-danger">*</span>
                                </label>
                                <input class="form-control" placeholder="{{ translate('Heading') }}"
                                    id="popup_heading_{{ $lang_id }}" name="popup_heading[{{ $lang_id }}]"
                                    type="text"
                                    value="{{ old('popup_heading.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'popup_heading', 'product_id')) }}" />

                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="price">{{ translate('Pop Up Title') }}<span
                                        class="text-danger">*</span>
                                </label>

                                <input class="form-control" placeholder="{{ translate('Pop Up Title') }}"
                                    id="popup_title_{{ $lang_id }}" name="popup_title[{{ $lang_id }}]"
                                    type="text"
                                    value="{{ old('popup_title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'popup_title', 'product_id')) }}" />

                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>

                        @php
                            $data = 0;
                            $Pop_data = 0;
                        @endphp
                        @foreach ($get_product_request_popup as $POPUP)
                            @include('admin.product.excursion._request_popup')
                            @php
                                $data++;
                                $Pop_data++;
                            @endphp
                        @endforeach
                        @if (empty($get_product_request_popup))
                            @include('admin.product.excursion._request_popup')
                        @endif

                        <div class="show_popup">
                        </div>
                        <div class="row">
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_popup"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Experience Icon Tab  --}}
                <li class="tab-content tab-content-19 typography " style="display: none">
                    <div class="colcss">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label"
                                    for="price">{{ translate('Experience Icon heading') }}</label>
                                <input
                                    class="form-control {{ $errors->has('experience_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                    id="experience_heading_{{ $lang_id }}"
                                    name="experience_heading[{{ $lang_id }}]"
                                    placeholder="{{ translate('Experience Icon heading') }}"
                                    value="{{ getLanguageTranslate($experience_icon_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}">

                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>

                        @php
                            $data = 0;
                            $experience_data = 0;
                        @endphp
                        @foreach ($get_product_experience_icon as $PEI)
                            @include('admin.product.excursion._experience_icon')
                            @php
                                $data++;
                                $experience_data++;
                            @endphp
                        @endforeach
                        @if (empty($get_product_experience_icon))
                            @include('admin.product.excursion._experience_icon')
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
                </li>

                {{-- Product Pop-up Tab  --}}
                <li class="tab-content tab-content-16 typography " style="display: none">
                    <div class="colcss">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group form-check form-switch pl-0">
                                    <input class="form-check-input float-end status switch_button" id="popup_status"
                                        {{ $get_product['popup_status'] === 'Active' ? 'checked' : '' }} type="checkbox"
                                        value="Active" name="popup_status">
                                    {{-- <label class="form-check-label form-label" for="status">Status
                                </label> --}}
                                </div>
                            </div>

                            <div class="col-md-6 content_title">
                                <label class="form-label" for="duration_from">{{ translate('Product Pop Up Image') }}
                                </label>
                                <div class="input-group mb-3">
                                    <input class="form-control " type="file" name="pro_popup_image"
                                        aria-describedby="basic-addon2" onchange="loadFile(event,'Pro_pop')"
                                        id="pro_popup_image" />
                                    <input type="hidden" name="pro_popup_image_dlt"
                                        value="{{ $get_product['pro_popup_image'] }}">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls popup_imgs img-pro-preview"
                                    style="display:none;">

                                    <div>
                                        <button class="delete_pro_pop bg-card btn btn-danger btn-sm float-end"
                                            type="button"><span class="fa fa-trash"></span></button>
                                    </div>
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img style="width: 100px;height: 100px;"
                                            src="{{ $get_product['pro_popup_image'] != '' ? asset('uploads/product_images/' . $get_product['pro_popup_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="Pro_pop" width="100" alt="" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 content_title">
                                <label class="form-label" for="price">{{ translate('Product Pop Up Video Link') }}
                                </label>

                                <input class="form-control" placeholder="{{ translate('Product Pop Up Video Link') }}"
                                    id="title" name="pro_popup_link" type="text"
                                    value="{{ $get_product['pro_popup_link'] }}" />
                            </div>

                            <div class="col-md-6 content_title">
                                <label class="form-label"
                                    for="duration_from">{{ translate('Product Pop Up Thumnail Image') }}
                                </label>
                                <div class="input-group mb-3">
                                    <input class="form-control " type="file" name="pro_popup_thumnail_image"
                                        aria-describedby="basic-addon2"
                                        onchange="loadFile(event,'pro_popup_thumnail_image_')"
                                        id="pro_popup_thumnail_image" />
                                    <input type="hidden" name="pro_popup_thumnail_image_dlt"
                                        value="{{ $get_product['pro_popup_thumnail_image'] }}">

                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls popup_thumnail_imgs"
                                    style="display:none;">

                                    <div>
                                        <button
                                            class="delete_popup_thumnail_image bg-card btn btn-danger btn-sm float-end"
                                            type="button"><span class="fa fa-trash"></span></button>
                                    </div>

                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img style="width: 100px;height: 100px;"
                                            src="{{ $get_product['pro_popup_thumnail_image'] != '' ? asset('uploads/product_images/popup_image/' . $get_product['pro_popup_thumnail_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="pro_popup_thumnail_image_" width="100" alt="" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 content_title">
                                <label class="form-label" for="price">{{ translate('Redirection Link') }}
                                </label>

                                <input class="form-control" placeholder="{{ translate('Redirection Link') }}"
                                    id="title" name="redirection_link" type="text"
                                    value="{{ $get_product['redirection_link'] }}" />
                            </div>

                            <div class="col-md-6 content_title">
                                <label class="form-label"
                                    for="duration_from">{{ translate('Product Pop Up Video') }}</label>
                                <div class="input-group mb-3">
                                    <input class="form-control " type="file" name="pro_popup_video"
                                        aria-describedby="basic-addon2" id="pro_popup_video" />
                                    <input type="hidden" name="pro_popup_video_dlt"
                                        value="{{ $get_product['pro_popup_video'] }}">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                @if ($get_product['pro_popup_video'] != '')
                                    <div
                                        class="avatar popup_video shadow-sm img-thumbnail position-relative blog-image-cls">
                                        <div class="h-100 w-100  overflow-hidden position-relative">
                                            @if ($get_product['pro_popup_video'] != '')
                                                <button class="delete_popup_video bg-card btn btn-danger btn-sm float-end"
                                                    type="button"><span class="fa fa-trash"></span></button>
                                                <video width="150" height="150"
                                                    src="{{ asset('uploads/product_images/popup_image/' . $get_product['pro_popup_video']) }}"
                                                    controls>
                                                </video>
                                            @endif

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="price">{{ translate('Product Pop Up Title') }}
                                </label>

                                <input class="form-control" placeholder="{{ translate('Product Pop Up Title') }}"
                                    id="pro_popup_title_{{ $lang_id }}"
                                    name="pro_popup_title[{{ $lang_id }}]" type="text"
                                    value="{{ old('pro_popup_title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'pro_popup_title', 'product_id')) }}" />
                                <div class="invalid-feedback">

                                </div>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label"
                                    for="pro_popup_desc">{{ translate('Product Pop Up Description') }}<span
                                        class="text-danger">*</span>
                                </label>
                                <textarea class="form-control editor {{ $errors->has('pro_popup_desc.' . $lang_id) ? 'is-invalid' : '' }}"
                                    rows="8" id="pro_popup_desc_{{ $lang_id }}" name="pro_popup_desc[{{ $lang_id }}]"
                                    placeholder="{{ translate('Product Pop Up Description') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'pro_popup_desc', 'product_id') }}</textarea>

                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Experience Icon Header Tab  --}}
                <li class="tab-content tab-content-20 typography " style="display: none">
                    <div class="colcss">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label"
                                    for="price">{{ translate('Header Experience Icon heading') }}</label>
                                <input
                                    class="form-control {{ $errors->has('header_experience_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                    id="header_experience_heading_{{ $lang_id }}"
                                    name="header_experience_heading[{{ $lang_id }}]"
                                    placeholder="{{ translate('Experience Icon heading') }}"
                                    value="{{ getLanguageTranslate($experience_icon_upper_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>

                        @php
                            $data = 0;
                            $icon_data = 0;
                        @endphp
                        @foreach ($get_product_experience_icon_upper as $PEIH)
                            @include('admin.product.excursion._experience_icon_header')
                            @php
                                $data++;
                                $icon_data++;
                            @endphp
                        @endforeach
                        @if (count($get_product_experience_icon_upper) == 0)
                            @include('admin.product.excursion._experience_icon_header')
                        @endif
                        <div class="show_expe_header">
                        </div>
                        <div class="row">

                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_expe_header"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> Add more</button>
                            </div>
                        </div>

                    </div>
                </li>





                {{-- Buggy --}}
                <li class="tab-content tab-content-21 typography" style="display: none">
                    <div class="colcss">
                        <div class="row">
                            @include('admin.product.excursion._buggy_tab')
                        </div>
                    </div>
                </li>
                {{-- Buggy --}}

            </ul>
        </div>
        
        
        
        {{-- private transfer modal --}}
            <div class="modal fade carModal" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button
                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                data-bs-dismiss="modal" aria-label="Close"></button></div>
                        <div class="modal-body p-0">
                            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                                <h4 class="mb-1" id="staticBackdropLabel">{{ translate('Car List ') }}</h4>
                            </div>
                            <div class="carAppendData"></div>

                        </div>
                    </div>
                </div>
            </div>
        {{-- private transfer modal --}}
    </form>

    <input type="hidden" name="count" id="count" value="{{ $data }}">
    @php
        $blackouDate = '';
        if ($get_product['id'] != '') {
            $blackouDate = "'" . implode("', '", json_decode($get_product['blackout_date'])) . "'";
        
            $duration = explode('-', $get_product['duration']);
        }
        
    @endphp
    @if ($get_product['id'] != '' && count($get_product_category) == 0)
        <script>
            $(document).ready(function() {
                var loadCountry = "{{ old('country', $get_product['country']) }}";
                var loadCategory = "{{ old('category', $get_product['category']) }}";

                getCountry(loadCountry, loadCategory, count = "")
            });
        </script>
    @endif

    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            var loadCountry = "{{ old('country', $get_product['country']) }}";
            var loadCategory = "{{ old('category', $get_product['category']) }}";
            var state = "{{ old('state', $get_product['state']) }}";
            var city = "{{ old('city', $get_product['city']) }}";
            if (state != "") {
                setTimeout(() => {
                    getStateCity("country", state);
                    setTimeout(() => {
                        getStateCity("state", city);
                    }, 1000);
                }, 500);
            }
            // if (loadCountry != "") {
            //     getCountry(loadCountry, loadCategory)
            // }
            $('.avl_item').change(function(e) {
                var avl_type = $(this).val();
                $('.show_timings').addClass("d-none");
                if (avl_type == 'week_days') {
                    $('.show_timings').removeClass("d-none");
                }
            });


            $('#excursion_type').change(function(e) {
                var ex_type = $(this).val();
                $('.cncl_duration').addClass("d-none");
                if (ex_type == 'can_be_cancled') {
                    $('.cncl_duration').removeClass("d-none");
                }
                // alert(ex_type);
            });


            // Get Category By Country
            $(".country").change(function() {
                var country = $(this).val();
                var selectedCat = ""
                getCountry(country, selectedCat)
            })

            // Get Category By Country
            $(document).on("change", ".category", function() {

                var country = $(".country").val();
                var category = $(this).val();
                var count = $(this).data("id");
                var selectedCat = ""
                $("#sub_category" + count).val(null).trigger("change");
                getSubCategory(country, category, selectedCat, count)
            })


        })
        // Get Country FUnction
        function getCountry(country, selectedCat, count = "") {
            var categoryArr = [];
            if (count != "") {
                $(".category").each(function(k, v) {
                    console.log($(v).val());
                    if ($(v).val() != "") {
                        categoryArr.push($(v).val());
                    }
                });
            } else {
                $(".show_category").html("");
            }


            $.ajax({
                "type": "POST",
                "url": "{{ route('admin.get_category_by_country') }}",
                "data": {
                    _token: "{{ csrf_token() }}",
                    country: country,
                    selectedCat: selectedCat,
                    data: categoryArr,
                    array: ""
                },
                "success": function(response) {
                    if (count == "") {
                        $(".category").each(function(kk, vv) {
                            $(vv).html(response);
                        })
                    } else {
                        setTimeout(() => {
                            $("#category_" + count).html(response);
                        }, 1000);

                    }
                }

            })

        }

        function checkValue(value, arr) {
            var status = false;
            for (var i = 0; i < arr.length; i++) {
                var name = arr[i];
                if (name == value) {
                    status = true;
                    break;
                }
            }

            return status;
        }


        // Get Sub Category
        function getSubCategory(country, category, selectedSubCategory, count) {
            $.ajax({
                "type": "POST",
                "url": "{{ route('admin.get_subcategory_by_category') }}",
                "data": {
                    _token: "{{ csrf_token() }}",
                    country: country,
                    category: category,
                    selectedSubCategory: selectedSubCategory,
                    array: "array"
                },
                "success": function(response) {
                    $("#sub_category" + count).html(response.view);

                }
            })
        }
    </script>

    <script>
        $(".datetimepickerdate").flatpickr({
            minDate: "today",
            enableTime: false,
            dateFormat: "Y-m-d",
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
        src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete"
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

    <!-- Request Popup -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $Pop_data }}";
            $('#add_popup').click(function(e) {

                var ParamArr = {
                    'view': 'admin.product.excursion._request_popup',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_popup');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_popup", function(e) {
                var length = $(".delete_popup").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.popup_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- HIGHLIGHTS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $Highlights_data }}";

            $('#add_highlights').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._highlight',
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
                            $(this).parent().closest('.highlight_div').remove();
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
            var count = "{{ $experience_data }}";

            $('#add_expe').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._experience_icon',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_expe');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_expe", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.expe_div').remove();
                        e.preventDefault();
                    }
                });

            });
        });
    </script>

    {{-- Expireance Heafer --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $icon_data }}";

            $('#add_expe_header').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._experience_icon_header',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_expe_header');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_expe_header", function(e) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.header_expe_div').remove();
                        e.preventDefault();
                    }
                });

            });
        });
    </script>

    <!-- BOATS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_boats').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._realated_boats',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_boats');
                e.preventDefault();
                count++;
            });



            $(document).on('click', ".delete_boats", function(e) {
                var length = $(".delete_boats").length;

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.boats_div').remove();
                        e.preventDefault();
                    }
                });

            });
        });
    </script>

    {{-- Lodge Script --}}

    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_lodge').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._lodge',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_lodge');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_lodge", function(e) {
                var length = $(".delete_lodge").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.lodge_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    {{-- Category Box --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $CategoryData }}";
            // count = parseInt(count) + parseInt(1);



            $('#add_category').click(function(e) {
                var country = $(".country").val();
                var Newcount = count - 1;
                var checkCategory = $("#category_" + Newcount).val();
                // console.log(checkCategory);
                if (country != "") {
                    if (checkCategory != "") {
                        var ParamArr = {
                            'view': 'admin.product.excursion._category',
                            'data': count
                        }
                        getAppendPage(ParamArr, '.show_category');
                        var selectedCat = "";
                        getCountry(country, "", count);
                        e.preventDefault();
                        count++;
                    } else {
                        danger_msg("Select Prevoius Category");
                    }
                } else {
                    danger_msg("Select Country");
                }

            });



            $(document).on("click", ".delete_category_row", function() {
                var length = $(".delete_category_row").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().parent().remove();



                        }

                    });
                }
            })



        });
    </script>

    <!-- VOUCHER -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_voucher').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._voucher',
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

    {{-- Option --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var count = '{{ $optiondata }}';
            $('#add_table').click(function(e) {

                // var count = $("#count").val();
                count = parseInt(count) + parseInt(1);
                // $("#count").val(count)
                var ParamArr = {
                    'view': 'admin.product.excursion._option',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_table');
                e.preventDefault();
                count++;
            });


            $(document).on("click", ".delete_option", function(e) {
                var length = $(".delete_option").length;
                var count = $(this).data('rowid');
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.row').remove();
                            $("#option_div" + count).remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- ADDITIONAL INFO -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = '{{ $AddtionalINFO }}';
            $('body').on('click', "#add_info", function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._info',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_info');

                e.preventDefault();
                count++;
            });

            $(document).on("click", ".delete_info", function(e) {
                var length = $(".delete_info").length;
                // if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.info_div').remove();
                        e.preventDefault();
                    }
                });
                // }
            });
        });
    </script>

    <!-- FAQS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_faqs').click(function(e) {

                var ParamArr = {
                    'view': 'admin.product.excursion._faq',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_faqs');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_faq", function(e) {
                var length = $(".delete_faq").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.faq_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Sinlge Group Percentage -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $single_group_percentage_id }}";
            $('#add_single_group_percentage').click(function(e) {

                var ParamArr = {
                    'view': 'admin.product.excursion._single_group_percentage',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_single_group_percentage');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_single_group_percentage", function(e) {
                var length = $(".delete_single_group_percentage").length;
                var rowid = $(this).data("rowid");
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.group_percentage_tr_' + rowid).remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Site Advertisement -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_adver').click(function(e) {

                var ParamArr = {
                    'view': 'admin.product.excursion._site_advertisement',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_adver');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_adver", function(e) {
                var length = $(".delete_adver").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.adver_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    if (filesLength <= 10) {
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
                                    "<input type='number' name='sort_order_images[]' class='form-control' placeholder='{{ translate('Enter Sort value') }}'>" +
                                    "</div>";

                                // $(html).insertAfter(".appenImage");
                                $(".appenImage").append(html);
                            });
                            fileReader.readAsDataURL(f);
                        }
                    } else {
                        $("#files").val('');

                        alert('Minimum 10 images');
                    }


                });
            } else {
                alert("Your browser doesn't support to File API")
            }
            $(document).on("click", ".remove", function() {
                $(this).closest(".col-md-2").remove();
            });


            $(".pick_from").each(function() {
                var time = $(this).val();
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: time

                })
            });

            $(".pick_to").each(function() {
                var time = $(this).val();
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: time

                })
            });
        });
    </script>

    {{-- Add Product --}}
    <script>
        $(document).on("submit", "#add_product", function(e) {
            e.preventDefault();
            var duration = "";
            $("#add_product_btn").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.excursion.add') }}",
                datatype: 'JSON',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.error) {
                        $.each(response.error, function(index, value) {
                            if (value != '') {
                                $('.tab-content').each(function() {
                                    $(this).css("display", "none");
                                })
                                // var index = index.replace(".", "_");
                                var index = index.replace(/\./g, '_');
                                console.log(index);

                                if (index == "pick_option") {

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

                                $('#' + index).parent().find('.invalid-feedback')
                                    .html(value[0]);

                                setTimeout(() => {

                                    $(focusDiv).focus();
                                }, 500);


                            }
                        });
                    } else {

                        success_msg("Product {{ $common['button'] }} Successfully...")


                    }
                }
            });
            setTimeout(() => {
                $("#add_product_btn").prop("disabled", false);
            }, 500);

        });
    </script>

    {{-- Allowed or not  --}}
    <script>
        $(document).on("click", ".tour_child_allowed", function() {
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

        $(document).on("click", ".tour_infant_allowed", function() {
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
        })


        $(document).on("click", ".tour_group_percentage_allowed", function() {
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
        })


        $(document).on("click", ".tour_infant_limit", function() {
            var nextInput = $(this).parent().prev('td').find('input');

            if ($(this).prop('checked') == true) {
                nextInput.attr("readonly", true);
                nextInput.val("No Limit");

            } else {
                nextInput.attr("readonly", false);
                nextInput.val(0);

            }
        })
    </script>

    {{-- Add To TOp Seller Slect --}}
    <script>
        $(document).on("click", "#add_to_top_seller_in_uae", function() {

            if ($(this).prop('checked') == true) {
                $(".top_seller_sort_div").removeClass('d-none');
                $(".top_seller_sort_div").addClass('d-block');
            } else {

                $(".top_seller_sort_div").removeClass('d-block');
                $(".top_seller_sort_div").addClass('d-none');
            }
        })
    </script>

    {{-- Duration Box --}}
    <script>
        $(function() {
            demoDuration()
        });

        function demoDuration() {

            var $demoRow1 = $('<div id="demoDurationRow" class="demo-row">');

            var $subsection1 = $('<div class="section-row">').append($demoRow1);


            $("#demoBox").append($subsection1);
            $demoRow1.durationjs();

        }


        $(document).ready(function() {
            $(".duration-val").on("keyup", function() {
                var duration = "";
                var len = $(".duration-val").length - 1;
                $(".duration-val").each(function(key, value) {

                    if (key == len) {
                        duration += $(this).val();
                    } else {
                        duration += $(this).val() + "-";
                    }
                });
                $("#duration").val(duration)

            })

            if ("{{ $get_product['id'] }}" != "") {

                var durationData = "{{ $get_product['duration'] }}"

                var result = durationData.split('-');

                $(".duration-val").each(function(key, value) {

                    $(this).val(result[key]);

                    $(this).keyup();
                })
            }
        })
    </script>

    {{-- Booked Up To Advance Box --}}
    <script>
        $(function() {
            BookedUpTo()
        });

        function BookedUpTo() {

            var $demoRow1 = $('<div id="demoDurationRowBookedUpTo" class="demo-row">');

            var $subsection1 = $('<div class="section-row">').append($demoRow1);


            $("#BookedUpTo").append($subsection1);
            $demoRow1.durationjs();

        }
        $(document).ready(function() {
            $("#demoDurationRowBookedUpTo .duration-val").on("keyup", function() {

                var duration = "";
                var len = $("#demoDurationRowBookedUpTo .duration-val").length - 1;
                $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {

                    if (key == len) {
                        duration += $(this).val();
                    } else {
                        duration += $(this).val() + "-";
                    }
                });
                $("#can_be_booked_up_to_advance").val(duration)

            })

            if ("{{ $get_product['id'] }}" != "") {

                var durationData = "{{ $get_product['can_be_booked_up_to_advance'] }}"
                if (durationData == "") {
                    $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                        $(this).val("00");
                        $(this).keyup();
                    })
                } else {
                    var result = durationData.split('-');
                    $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                        $(this).val(result[key]);
                        $(this).keyup();
                    })
                }
            } else {
                $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                    $(this).val("00");
                    $(this).keyup();
                })
            }
        })
    </script>

    {{-- Cancelled Up To Advance Box --}}
    <script>
        $(function() {
            CancelledUpTo()
        });

        function CancelledUpTo() {

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

            if ("{{ $get_product['id'] }}" != "") {

                var durationData = "{{ $get_product['can_be_cancelled_up_to_advance'] }}"
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

    {{-- Add Upgrade Tour --}}
    <script>
        var tourUpgradeCount = "{{ $tour_upgrade_id }}";

        $(document).on("click", ".add_tour_upgrade", function(e) {
            $(this).attr('disabled', true);
            var DataID = $(this).data('val');
            var ParamArr = {
                'view': 'admin.product.excursion._tour_upgrade',
                'data': DataID,
            }
            getAppendPage(ParamArr, '.show_tour_upgrade_tbody' + DataID);
            $(".show_tour_upgrade" + DataID).removeClass("d-none");
            $(this).attr('disabled', false);
            e.preventDefault();
        });

        $(document).on("click", ".delete_tour_upgrade_row", function() {
            deleteMsg('Are you sure to delete ?').then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().closest('.row_tour_upgrade').remove();
                    var id = $(this).data("id");


                }

            });
        })
    </script>

    {{-- Add Period Pricing --}}
    <script>
        var tourPeriodCount = "{{ $period_id }}";

        $(document).on("click", ".add_period_pricing", function(e) {
            $(this).attr('disabled', true);
            var DataID = $(this).data('val');
            var ParamArr = {
                'view': 'admin.product.excursion._tour_period_pricing',
                'data': DataID,
            }
            getAppendPage(ParamArr, '.show_period_pricing_tbody' + DataID);
            $(".show_period_pricing" + DataID).removeClass("d-none");
            $(this).attr('disabled', false);
            $(this).attr('disabled', false);
            e.preventDefault();
        });

        $(document).on("click", ".delete_period_pricing_row", function() {
            deleteMsg('Are you sure to delete ?').then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().closest('.row_period_pricing').remove();
                    var id = $(this).data("id");


                }

            });
        })
    </script>

    {{-- Add Customer Group Percentage --}}
    <script>
        var GroupPercentageCount = "{{ $group_per_id }}";


        $(document).on("click", ".add_group_percent", function(e) {
            $(this).attr('disabled', true);
            var DataID = $(this).data('val');
            var ParamArr = {
                'view': 'admin.product.excursion._group_percentage',
                'data': DataID,
            }
            getAppendPage(ParamArr, '.show_group_percentage_tbody' + DataID);
            $(".show_group_percent" + DataID).removeClass("d-none");
            $(this).attr('disabled', false);
            $(this).attr('disabled', false);
            e.preventDefault();
        });

        $(document).on("click", ".delete_group_precentage_row", function() {
            deleteMsg('Are you sure to delete ?').then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().closest('.row_group_percentage').remove();
                    var id = $(this).data("id");


                }

            });
        })
    </script>

    {{-- Add Weeek Days --}}
    <script>
        var tourCount = "{{ $tour_id }}";
        $(document).on("click", ".add_week_days_price", function(e) {
            $(this).attr('disabled', true);
            var DataID = $(this).data('val');
            // getAppendPage(ParamArr, '.show_tour_price_tbody' + DataID);

            var SelectedWeekArr = [];
            $(".tour_option_week_days" + DataID).each(function(key, value) {
                SelectedWeekArr.push($(value).val());
            })

            var ParamArr = {
                'view': 'admin.product.excursion._tour_price',
                'data': DataID,
                'id': tourCount
            }


            if (SelectedWeekArr.length < 7) {
                getAppendPage(ParamArr, '.show_tour_price_tbody' + DataID);
                $(".show_tour_price" + DataID).removeClass("d-none");

                var wreekArr = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];


                var value = "";
                setTimeout(() => {

                    $(wreekArr).each(function(key, value) {
                        if ($.inArray(value, SelectedWeekArr) !== -1) {

                        } else {
                            $("#tour_option_week_days_" + DataID + "_" + tourCount).append(
                                "<option value=" + value + ">" +
                                value +
                                "</option>")
                        }
                    })
                    WeekWorkFn(DataID, tourCount, value);

                    tourCount++;
                    $(".single-select").select2();

                    setTimeout(() => {
                        $(this).attr('disabled', false);
                    }, 200);
                }, 500);

            } else {
                danger_msg("No More Weekdays Available..");
            }

            e.preventDefault();
        });

        $(document).on("change", ".tour_option_week_days", function() {
            var id = $(this).data("id");
            var tour = $(this).data("tour");
            var value = $(this).val();
            WeekWorkFn(id, tour, value)

        });


        function WeekWorkFn(id, tour, value) {
            $(".tour_option_week_days" + id).each(function(key, va) {
                var arrSelectedValue = $(this).val();
                var countID = $(this).data('tour');
                if (arrSelectedValue != value) {
                    var wreekArr = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',
                        'Sunday'
                    ];
                    $("#tour_option_week_days_" + id + "_" + countID).html("");
                    $(wreekArr).each(function(key, Weekvalue) {
                        var select = "";
                        var isShow = 0;
                        if (arrSelectedValue == Weekvalue) {
                            select = " selected";
                            var isShow = 1;
                        }
                        var SelectedWeekArr = [];
                        $(".tour_option_week_days" + id).each(function(key, selectvalue) {
                            SelectedWeekArr.push($(selectvalue).val());
                        })
                        if (value != Weekvalue) {
                            if ($.inArray(Weekvalue, SelectedWeekArr) !== -1) {

                            } else {
                                $("#tour_option_week_days_" + id + "_" + countID).append(
                                    "<option value=" + Weekvalue + " " + select +
                                    ">" +
                                    Weekvalue +
                                    "</option>");
                            }
                        }
                    })

                }

            })
        }
    </script>

    {{-- Delete Option Weekdays Rows --}}
    <script>
        $(document).on("click", ".delete_tour_row", function() {
            deleteMsg('Are you sure to delete ?').then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().closest('.row_week_tour').remove();
                    var id = $(this).data("id");
                    WeekWorkFn(id, "", "");

                }

            });
        })
    </script>

    <script>
        $(document).on("click", ".time_for_all_weekdays", function() {
            var id = $(this).data('id');
            if ($(this).prop('checked') == true) {
                $(".time_availble_div" + id).removeClass("d-none");
            } else {
                $(".time_availble_div" + id).addClass("d-none");

            }

        });

        $(document).on("click", ".time_for_all_dates", function() {
            var id = $(this).data('id');
            if ($(this).prop('checked') == true) {
                $(".time_availble_div" + id).removeClass("d-none");
            } else {
                $(".time_availble_div" + id).addClass("d-none");

            }

        });

        $(document).on("click", ".available_record", function() {
            if ($(this).prop('checked') == true) {
                var getId = $(this).attr('id');
                var count = $(this).data('id');

                if (getId == "days_available_" + count) {
                    var time_for_all_weekdays = $("#time_for_all_weekdays" + count).val();
                    if (time_for_all_weekdays == 0) {
                        $(".time_availble_div" + count).addClass("d-none");
                    }
                } else if (getId == "date_available_" + count) {
                    var time_for_all_dates = $("#time_for_all_dates" + count).val();
                    if (time_for_all_dates == 0) {
                        $(".time_availble_div" + count).addClass("d-none");
                    }
                } else {
                    $(".time_availble_div" + count).removeClass("d-none");

                }



                $(".available_record_div_" + count).addClass("d-none");
                $(".div_" + getId).removeClass("d-none");
                $(".div_" + getId).addClass("d-block");
            }
        });




        $(document).on("click", ".group_available_record", function() {
            if ($(this).prop('checked') == true) {
                var getId = $(this).attr('id');
                var count = $(this).data('id');

                console.log("getId", getId);
                if (getId == "group_days_available_" + count) {
                    var time_for_all_weekdays = $("#group_time_for_all_weekdays" + count).val();
                    if (time_for_all_weekdays == 0) {
                        $(".group_time_availble_div" + count).addClass("d-none");
                    }
                } else if (getId == "group_date_available_" + count) {
                    var time_for_all_dates = $("#group_time_for_all_dates" + count).val();
                    if (time_for_all_dates == 0) {
                        $(".group_time_availble_div" + count).addClass("d-none");
                    }
                } else {
                    $(".group_time_availble_div" + count).removeClass("d-none");

                }



                $(".group_available_record_div_" + count).addClass("d-none");
                $(".div_" + getId).removeClass("d-none");
                $(".div_" + getId).addClass("d-block");
            }
        });

        $(document).on("click", ".group_time_for_all_weekdays", function() {
            var id = $(this).data('id');
            if ($(this).prop('checked') == true) {
                $(".group_time_availble_div" + id).removeClass("d-none");
            } else {
                $(".group_time_availble_div" + id).addClass("d-none");

            }

        });

        $(document).on("click", ".group_time_for_all_dates", function() {
            var id = $(this).data('id');
            if ($(this).prop('checked') == true) {
                $(".group_time_availble_div" + id).removeClass("d-none");
            } else {
                $(".group_time_availble_div" + id).addClass("d-none");

            }

        });
    </script>

    {{-- Add Tour Availblity date --}}
    <script>
        $(document).on("click", '.add_tour_avail_date', function() {
            var count = $(this).attr("data-dataid");
            var id = $(this).attr("data-id");

            var dataArr = {
                'data': count,
                'tour_date_id': id
            };

            var ParamArr = {
                'view': 'admin.product.excursion._tour_date_time',
                'data': dataArr,
            }
            getAppendPage(ParamArr, "#tbody_tour_date_box_" + count);
            $(this).attr("data-id", parseInt(id) + parseInt(1));

        });

        $(document).on('click', ".delete_tour_date", function(e) {
            var length = $(".delete_tour_date").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.delete_tour_date_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

    {{-- Add Group Tour Availblity date --}}
    <script>
        $(document).on("click", '.add_group_tour_avail_date', function() {
            var count = $(this).attr("data-dataid");
            var id = $(this).attr("data-id");

            var dataArr = {
                'data': count,
                'tour_date_id': id
            };

            var ParamArr = {
                'view': 'admin.product.excursion._tour_group_date_time',
                'data': dataArr,
            }
            getAppendPage(ParamArr, "#tbody_tour_group_date_box_" + count);
            $(this).attr("data-id", parseInt(id) + parseInt(1));

        });

        $(document).on('click', ".delete_tour_group_date", function(e) {
            var length = $(".delete_tour_group_date").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.delete_tour_group_date_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

    {{-- Add Lodge Price Details --}}
    <script>
        $(document).on("click", ".add_lodge_price", function() {
            var count = $(this).data("dataid");
            var ParamArr = {
                'view': 'admin.product.excursion._lodge_price',
                'data': count,
            }
            getAppendPage(ParamArr, "#lodge_price_tbody" + count);

        });
        $(document).on('click', ".delete_lodge_price_row", function(e) {
            var length = $(".lodge_price_row").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.lodge_price_row').remove();
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

    {{-- Private Transfer Modal --}}
    <script>
        $(document).on("click", '.private_transfer_modal', function() {
            var count = $(this).data("dataid");
            var optionid = $(this).data("optionid");
            $(".carAppendData").html("");
            $(".carModal").modal('show');
            $.post("{{ route('admin.get_car_list') }}", {
                count: count,
                optionid: optionid,
                _token: "{{ csrf_token() }}"
            }, function(data) {
                $(".carAppendData").html(data);
            });
        });

        // Add car 

        $(document).on("click", '.add_car', function() {
            var data = $("#add_product").serializeArray();
            data.push({
                name: "CarOptionId",
                value: $(this).data("dataid")
            });
            $.ajax({
                type: "POST",
                url: "{{ route('admin.add_car_session') }}",
                datatype: 'JSON',
                data: data,

                success: function(response) {
                    $(".carModal").modal('hide');
                    success_msg("{{ translate('Car Add Successfully...') }}")
                }
            });


        });
    </script>

    <!-- Tooltip -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;

            $('#add_tooltip').click(function(e) {
                var ParamArr = {
                    'view': 'admin.product.excursion._tooltip',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_tooltip');
                e.preventDefault();
                count++;
            });



            $(document).on('click', ".delete_tooltip", function(e) {
                var length = $(".delete_tooltip").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.tooltip_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    {{-- Private Tour Price --}}
    <script>
        $(document).on('click', '.private_tour_price', function() {
            if ($(this).is(':checked')) {
                $(this).closest('.option_div').find('.maximum_minimum_box').addClass('d-none');
                $(this).closest('.option_div').find('.week_days_btn').addClass('d-none');
                $(this).closest('.option_div').find('.week_days_box').addClass('d-none');
                $(this).closest('.option_div').find('.transfer_option_box').addClass('d-none');
                $(this).closest('.option_div').find('.tour_price_box').addClass('d-none');
                $(this).closest('.option_div').find('.period_price_box').addClass('d-none');
                $(this).closest('.option_div').find('.group_percent_box').addClass('d-none');



                $(this).closest('.option_div').find('.private_tour_table').removeClass('d-none');
            } else {
                $(this).closest('.option_div').find('.private_tour_table').addClass('d-none');
                $(this).closest('.option_div').find('.maximum_minimum_box').removeClass('d-none');
                $(this).closest('.option_div').find('.week_days_btn').removeClass('d-none');
                $(this).closest('.option_div').find('.week_days_box').removeClass('d-none');
                $(this).closest('.option_div').find('.transfer_option_box').removeClass('d-none');
                $(this).closest('.option_div').find('.tour_price_box').removeClass('d-none');
                $(this).closest('.option_div').find('.period_price_box').removeClass('d-none');
                $(this).closest('.option_div').find('.group_percent_box').removeClass('d-none');

            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".minimize_btn", function() {
                if ($(this).text() == "+") {
                    $(this).text("-");
                } else {
                    $(this).text("+");
                }
                var rowid = $(this).data("rowid");
                $('#option_div' + rowid).slideToggle();
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('.editor').each(function(e) {
                CKEDITOR.replace(this.name);
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // CKEDITOR.replace('#booking_policy');
            CKEDITOR.replaceAll('footer_text');
            if ("{{ $get_product['id'] }}" != "") {
                var saleDate = "{{ $get_product['note_on_sale_date'] }}"
                var result = saleDate.split('to');
                $(".note_on_sale_date").flatpickr({
                    mode: 'range',
                    dateFormat: "Y-m-d",
                    defaultDate: [result[0], result[1]]
                });
            } else {
                $(".note_on_sale_date").flatpickr({
                    mode: 'range',
                    minDate: "today",
                    dateFormat: "Y-m-d",
                });
            }

            $(".blackout_date").flatpickr({
                minDate: "today",
                mode: "multiple",
                dateFormat: "Y-m-d",
                defaultDate: [<?php echo implode(',', array_unique(explode(',', $blackouDate))); ?>],

            });

            $(".option_available_date").flatpickr({
                mode: "multiple",
                dateFormat: "Y-m-d",
            });
        })
    </script>
    <script>
        function back() {
            window.history.back()
        }
    </script>

    <!-- Image Delete -->

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_thumbnail", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.imgs_div').remove();
                        $("input[name='video_thumbnail_dlt']").val('');
                        e.preventDefault();
                    }
                });

            });
            <?php if ($get_product['video_thumbnail']) { ?>
            $('.img-thumbnail-preview').show();
            <?php } ?>

            $(document).on('change', "#video_thumbnail_img", function(e) {
                $('.img-thumbnail-preview').show();
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_pop_img", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.img_pop_div').remove();
                        $("input[name='popup_image_dlt']").val('');
                        e.preventDefault();
                    }
                });

            });

            <?php if ($get_product['popup_image']) { ?>
            $('.img-pop-up-preview').show();
            <?php } ?>

            $(document).on('change', "#popup_image", function(e) {
                $('.img-pop-up-preview').show();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_pro_pop", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.popup_imgs').css("display", "none");
                        $("input[name='pro_popup_image_dlt']").val('');
                        $("input[name='pro_popup_image']").val('');
                        e.preventDefault();
                    }
                });

            });

            <?php if ($get_product['pro_popup_image']) { ?>
            $('.img-pro-preview').show();
            <?php } ?>

            $(document).on('change', "#pro_popup_image", function(e) {
                $('.img-pro-preview').show();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_popup_thumnail_image", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.popup_thumnail_imgs').css("display", "none");
                        $("input[name='pro_popup_thumnail_image_dlt']").val('');
                        $("input[name='pro_popup_thumnail_image']").val('');
                        e.preventDefault();
                    }
                });

            });

            <?php if ($get_product['pro_popup_thumnail_image']) { ?>
            $('.popup_thumnail_imgs').show();
            <?php } ?>

            $(document).on('change', "#pro_popup_thumnail_image", function(e) {
                $('.popup_thumnail_imgs').show();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_popup_video", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.popup_video').css("display", "none");
                        $("input[name='pro_popup_video_dlt']").val('');
                        $("input[name='pro_popup_video']").val('');
                        e.preventDefault();
                    }
                });

            });



        });
    </script>

@endsection
