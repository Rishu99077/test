@extends('admin.layout.master')
@section('content')
    <?php
    $data = ['banner_title', 'banner_description', 'banner_image', 'our_story_title', 'our_story_image', 'our_story_description', 'satisfied_customers', 'satisfied_customers_count', 'years_of_experience', 'years_of_experience_count', 'destinations', 'destinations_count', 'why_choose_us_heading', 'travel_experiences_title', 'travel_experiences_desc', 'our_partners_title', 'our_partners_desc', 'unleash_your_adventure_title', 'unleash_your_adventure_desc', 'our_service_title', 'our_service_descriptions'];
    $data = getPagemeta($data, $language_id, $Page->id);
    
    $why_choose_us_val = ['why_choose_us_image' => '', 'why_choose_us_title' => '', 'why_choose_us_desc' => ''];
    $why_choose_us = getPagemeta_multi($why_choose_us_val, $language_id, $Page->id, 'why_choose_us');
    
    $our_services_val = ['our_services_image' => '', 'our_services__additional_title' => ''];
    $our_service = getPagemeta_multi($our_services_val, $language_id, $Page->id, 'our_service');
    
    $get_adventure_img_val = ['adventure_image' => ''];
    $get_adventure_image = getPagemeta_multi($get_adventure_img_val, $language_id, $Page->id, 'adventure_images');
    
    ?>
    <style>
        .nav-tabs .slide {
            background: #1abc9c;
            width: calc(100% / 6);
            height: 4px;
            position: absolute;
            -webkit-transition: left 0.3s ease-out;
            transition: left 0.3s ease-out;
            bottom: 0;
        }

        .navlink i {
            font-size: 16px;
        }

        .nav-link {
            display: contents;
        }

        .nav-item {
            padding: 20px 0px;
        }

        .card .card-header span {
            font-weight: 500;
            color: black !important;
            font-size: 16px;
        }

        .card .card-header {
            background-color: transparent;
            padding: 0px 0px;
        }

        .page-wrapper .home_page ul li {
            background: #fff;
        }

        .page-wrapper .home_page .md-tabs .nav-link.active {
            background: #fff;
        }

        .page-wrapper .home_page ul li .slide {
            background-color: #fc5301 !important;
            height: 100%;
            bottom: 0px !important;
        }

        .page-wrapper .home_page .card-block {
            padding: 5px !important;
            padding-left: 1.25rem !important;
            background: #fff;
        }

        .page-body.home_page {
            box-shadow: 1px 3px 6px 0px #a59c9c;
        }

        .page-body.home_page label {
            font-family: 'ClashGrotesk-Medium' !important;
        }

        .page-body.home_page .row-header {
            border-top: 4px solid #f1590c;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .page-body.home_page .row-header p {
            margin-bottom: 0;
            color: #757575;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            margin-right: 10px;
        }

        .page-body.home_page #middle_slider .remove_div {
            border-top: 1px solid #e1e1e1;
            padding-top: 7px;
        }
    </style>
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.pages') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body home_page">
            <form id="main" method="post" action="{{ route('admin.pages.edit', encrypt($Page->id)) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row row-header">
                    <div class="col-md-12 col-xl-12 bg-white pl-0">
                        <p class="p-10 ml-0">{{ translate('About Us') }}</p>
                        <a href="{{ url(goPreviousUrl()) }}"
                            class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                            data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xl-12 bg-white pl-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link about_us active" data-toggle="tab" href="#about_us"
                                    role="tab">{{ translate('About Us') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link our_story" data-toggle="tab" href="#our_story"
                                    role="tab">{{ translate('Our Story') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link why_choose_us" data-toggle="tab" href="#why_choose_us"
                                    role="tab">{{ translate('Why Choose Us') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link travel_experience" data-toggle="tab" href="#travel_experience"
                                    role="tab">{{ translate('Travel Experience') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link partners" data-toggle="tab" href="#partners"
                                    role="tab">{{ translate('Partners') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link adventures" data-toggle="tab" href="#adventures"
                                    role="tab">{{ translate('Adventures') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link our_service" data-toggle="tab" href="#our_service"
                                    role="tab">{{ translate('Our Service') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link meta_data" data-toggle="tab" href="#meta_data"
                                    role="tab">{{ translate('Meta Data') }}</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs-left-content card-block w-100">
                            <div class="tab-pane active" id="about_us" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Banner Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="banner_title" class="form-control banner_title"
                                                name="page_content[banner_title]" type="text"
                                                value="{{ $data['banner_title'] }}"
                                                placeholder="{{ translate('Enter Banner Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Banner Description') }}</label>
                                            <textarea rows="2" name="page_content[banner_description]" id="banner_description"
                                                class="summernote banner_description">{{ $data['banner_description'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('banner_image') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('banner_image') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('banner_image') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image_5')" name="page_content[banner_image]">
                                            @error('banner_image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            <a href="#" class="profile-image">
                                                <img class="user-img img-circle img-css" id="image_5"
                                                    src="{{ $data['banner_image'] != '' ? url('uploads/pages', $data['banner_image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="our_story" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Our Story Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="our_story_title" class="form-control our_story_title"
                                                name="page_content[our_story_title]" type="text"
                                                value="{{ $data['our_story_title'] }}"
                                                placeholder="{{ translate('Enter story Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('our_story_image') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Our Story Image') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('our_story_image') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image_16')"
                                                name="page_content[our_story_image]">
                                            @error('our_story_image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            <a href="#" class="profile-image">
                                                <img class="user-img img-circle img-css" id="image_16"
                                                    src="{{ $data['our_story_image'] != '' ? url('uploads/pages', $data['our_story_image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Our Story Description') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="our_story_description" class="form-control our_story_description"
                                                name="page_content[our_story_description]" type="text"
                                                value="{{ $data['our_story_description'] }}"
                                                placeholder="{{ translate('Enter Story Description') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Satisfied Customers Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="satisfied_customers" class="form-control satisfied_customers"
                                                name="page_content[satisfied_customers]" type="text"
                                                value="{{ $data['satisfied_customers'] }}"
                                                placeholder="{{ translate('Enter Satisfied Customers') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Satisfied Customers Count') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="satisfied_customers_count"
                                                class="form-control satisfied_customers_count"
                                                name="page_content[satisfied_customers_count]" type="text"
                                                value="{{ $data['satisfied_customers_count'] }}"
                                                placeholder="{{ translate('Enter Satisfied Customers') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Years of Experience Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="years_of_experience" class="form-control years_of_experience"
                                                name="page_content[years_of_experience]" type="text"
                                                value="{{ $data['years_of_experience'] }}"
                                                placeholder="{{ translate('Enter Years of Experience') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Years of Experience Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="years_of_experience_count"
                                                class="form-control years_of_experience_count"
                                                name="page_content[years_of_experience_count]" type="text"
                                                value="{{ $data['years_of_experience_count'] }}"
                                                placeholder="{{ translate('Enter Years of Experience') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Destinations Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="destinations" class="form-control destinations"
                                                name="page_content[destinations]" type="text"
                                                value="{{ $data['destinations'] }}"
                                                placeholder="{{ translate('Enter Destination') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Destinations Count') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="destinations_count" class="form-control destinations_count"
                                                name="page_content[destinations_count]" type="text"
                                                value="{{ $data['destinations_count'] }}"
                                                placeholder="{{ translate('Enter Destination') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="why_choose_us" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Why Choose Us Heading') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="why_choose_us_heading" class="form-control why_choose_us_heading"
                                                name="page_content[why_choose_us_heading]" type="text"
                                                value="{{ $data['why_choose_us_heading'] }}"
                                                placeholder="{{ translate('Enter heading') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="show_why_choose_services">
                                    <?php $why_choose_service_count = 0; ?>
                                    @if (count($why_choose_us) == 0)
                                        <?php $why_choose_us_services = $why_choose_us_val; ?>
                                        @include('admin.pages.page2._why_choose_us_services')
                                        <?php $why_choose_service_count++; ?>
                                    @else
                                        @foreach ($why_choose_us as $why_choose_us_services)
                                            @include('admin.pages.page2._why_choose_us_services')
                                            <?php $why_choose_service_count++; ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button my-4">
                                        <button type="button" class="btn btn-primary btn-sm add_why_choose_service"
                                            id="add_why_choose_service"> <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="travel_experience" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Travel Experiences Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="travel_experiences_title"
                                                class="form-control travel_experiences_title"
                                                name="page_content[travel_experiences_title]" type="text"
                                                value="{{ $data['travel_experiences_title'] }}"
                                                placeholder="{{ translate('Enter Travel Experiences Title') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Travel Experiences Description') }}</label>
                                            <textarea rows="2" name="page_content[travel_experiences_desc]" id="travel_experiences_desc"
                                                class="summernote travel_experiences_desc">{{ $data['travel_experiences_desc'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="partners" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Our Partners Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="our_partners_title" class="form-control our_partners_title"
                                                name="page_content[our_partners_title]" type="text"
                                                value="{{ $data['our_partners_title'] }}"
                                                placeholder="{{ translate('Enter Our Partners Title') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Our Partners Description') }}</label>
                                            <textarea rows="2" name="page_content[our_partners_desc]" id="our_partners_desc"
                                                class="summernote our_partners_desc">{{ $data['our_partners_desc'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="adventures" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('unleash Your Adventure Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="unleash_your_adventure_title"
                                                class="form-control unleash_your_adventure_title"
                                                name="page_content[unleash_your_adventure_title]" type="text"
                                                value="{{ $data['unleash_your_adventure_title'] }}"
                                                placeholder="{{ translate('Enter Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('unleash Your Adventure Description') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="unleash_your_adventure_desc"
                                                class="form-control unleash_your_adventure_desc"
                                                name="page_content[unleash_your_adventure_desc]" type="text"
                                                value="{{ $data['unleash_your_adventure_desc'] }}"
                                                placeholder="{{ translate('Enter Description') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row wizard p-4 ">
                                            <div class="col-md-12 show_adventure_images">
                                                @php
                                                    $adventure_img_count = 0;
                                                @endphp
                                                @if (count($get_adventure_image) == 0)
                                                    @php $adventure_Img = $get_adventure_img_val; @endphp
                                                    @include('admin.pages.page2._adventure_images')
                                                    <?php $adventure_img_count++; ?>
                                                @else
                                                    @foreach ($get_adventure_image as $adventure_Img)
                                                        @include('admin.pages.page2._adventure_images')
                                                        <?php
                                                        $adventure_img_count++;
                                                        ?>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="col-md-12 add_more_button my-4">
                                                <button type="button" class="btn btn-primary btn-sm add_adventure_img"
                                                    id="add_adventure_img"> <span class="fa fa-plus"></span>
                                                    {{ translate('Add More') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="our_service" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Our Service Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="our_service_title" class="form-control our_service_title"
                                                name="page_content[our_service_title]" type="text"
                                                value="{{ $data['our_service_title'] }}"
                                                placeholder="{{ translate('Enter Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Our Service Descriptions') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="our_service_descriptions"
                                                class="form-control our_service_descriptions"
                                                name="page_content[our_service_descriptions]" type="text"
                                                value="{{ $data['our_service_descriptions'] }}"
                                                placeholder="{{ translate('Enter Descriptions') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row wizard p-4 ">
                                            <div class="col-md-12 show_our_services">
                                                @php
                                                    $our_services_count = 0;
                                                @endphp
                                                @if (count($our_service) == 0)
                                                    @php $our_services = $our_services_val; @endphp
                                                    @include('admin.pages.page2._additional_our_services')
                                                    @php
                                                        $our_services_count++;
                                                    @endphp
                                                @else
                                                    @foreach ($our_service as $our_services)
                                                        @include('admin.pages.page2._additional_our_services')
                                                        @php
                                                            $our_services_count++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="col-md-12 add_more_button my-4">
                                                <button type="button" class="btn btn-primary btn-sm add_more_service"
                                                    id="add_more_service"> <span class="fa fa-plus"></span>
                                                    {{ translate('Add More') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="meta_data" role="tabpanel">
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label class="col-form-label">{{ translate('Meta Keyword') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="meta_keyword" class="form-control meta_keyword"
                                                    name="meta_keyword" type="text"
                                                    value="{{ isset($MetaData) ? $MetaData->keyword : '' }}"
                                                    placeholder="{{ translate('Enter Meta Keyword') }}">
                                                <div class=" col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label class="col-form-label">{{ translate('Meta Description') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <textarea name="meta_description" id="meta_description" class="form-control meta_description" cols="30"
                                                    rows="10">{{ isset($MetaData) ? $MetaData->description : '' }}</textarea>

                                                <div class=" col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-12 p-1 text-right bg-white">
                        <button class="btn btn-primary " type="submit"
                            id="add_home_page_btn">{{ translate('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $why_choose_service_count }}";
            $('#add_why_choose_service').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page2._why_choose_us_services',
                    'why_choose_service_count': count
                }
                getAppendPage(ParamArr, '.show_why_choose_services');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_services", function(e) {
                var length = $(".why_choose_services").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.services_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $adventure_img_count }}";
            $('#add_adventure_img').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page2._adventure_images',
                    'adventure_img_count': count
                }
                getAppendPage(ParamArr, '.show_adventure_images');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_adv_img", function(e) {
                var length = $(".adventure_slider_row").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.adventure_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $our_services_count }}";
            $('#add_more_service').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page2._additional_our_services',
                    'our_services_count': count
                }
                getAppendPage(ParamArr, '.show_our_services');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_our_services", function(e) {
                var length = $(".our_services").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.our_services_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
@endsection
