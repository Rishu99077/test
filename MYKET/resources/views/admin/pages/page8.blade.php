@extends('admin.layout.master')
@section('content')
    <?php
    $data = ['main_title', 'main_description', 'main_image', 'join_us_heading', 'customers_service_title', 'number_of_customers', 'engaged_partners_title', 'number_of_partners', 'footer_description', 'part_title', 'part_description', 'our_company_heading', 'unparalleled_partner_title', 'unparalleled_partner_main_description', 'unparalleled_partner_main_image', 'team_members_heading'];
    $data = getPagemeta($data, $language_id, $Page->id);
    
    $join_us_val = ['joinus_logo' => '', 'joinus_title' => '', 'joinus_desc' => ''];
    $why_join_us = getPagemeta_multi($join_us_val, $language_id, $Page->id, 'why_join_us');
    
    $our_company_val = ['our_company_logo' => '', 'our_company_title' => '', 'our_company_desc' => ''];
    $our_company = getPagemeta_multi($our_company_val, $language_id, $Page->id, 'our_company_data');
    
    $join_us_image_val = ['joinus_image' => ''];
    $why_join_us_images = getPagemeta_multi($join_us_image_val, $language_id, $Page->id, 'why_join_us_images');
    
    $slider_image_val = ['slider_image' => ''];
    $slider_images = getPagemeta_multi($slider_image_val, $language_id, $Page->id, 'slider_images');
    
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
                        <p class="p-10 ml-0">{{ translate('Partners') }}</p>
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
                                    role="tab">{{ translate('Partners') }}</a>
                                <div class="slide"></div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link join_us" data-toggle="tab" href="#join_us"
                                    role="tab">{{ translate('Why Join Us') }}</a>
                                <div class="slide"></div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link join_us_image" data-toggle="tab" href="#join_us_image"
                                    role="tab">{{ translate('Why Join Us Images') }}</a>
                                <div class="slide"></div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link slider_image" data-toggle="tab" href="#slider_image"
                                    role="tab">{{ translate('Footer Slider Images') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link our_company" data-toggle="tab" href="#our_company"
                                    role="tab">{{ translate('Our Company') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link unparalleled_partner" data-toggle="tab" href="#unparalleled_partner"
                                    role="tab">{{ translate('Unparalleled Partner ') }}</a>
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
                                            <label class="col-form-label">{{ translate('Title') }}</label>
                                            <input id="main_title" class="form-control main_title"
                                                name="page_content[main_title]" type="text"
                                                value="{{ $data['main_title'] }}"
                                                placeholder="{{ translate('Enter Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Description') }}</label>
                                            <textarea rows="2" name="page_content[main_description]" id="main_description"
                                                class="summernote main_description">{{ $data['main_description'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('main_image') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Partner Main Image') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('main_image') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image_5')" name="page_content[main_image]">
                                            @error('main_image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            <a href="#" class="profile-image">
                                                <img class="user-img img-circle img-css" id="image_5"
                                                    src="{{ $data['main_image'] != '' ? url('uploads/pages', $data['main_image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Customers Services Title') }}</label>
                                            <input id="customers_service_title"
                                                class="form-control customers_service_title"
                                                name="page_content[customers_service_title]" type="text"
                                                value="{{ $data['customers_service_title'] }}"
                                                placeholder="{{ translate('Enter Customers Services Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Number of Customers') }}</label>
                                            <input id="number_of_customers" class="form-control number_of_customers"
                                                name="page_content[number_of_customers]" type="text"
                                                value="{{ $data['number_of_customers'] }}"
                                                placeholder="{{ translate('Enter Number of Customers') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Engaged Partners Title') }}</label>
                                            <input id="engaged_partners_title" class="form-control engaged_partners_title"
                                                name="page_content[engaged_partners_title]" type="text"
                                                value="{{ $data['engaged_partners_title'] }}"
                                                placeholder="{{ translate('Enter Engaged Partners Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Number of Partners') }}</label>
                                            <input id="number_of_partners" class="form-control number_of_partners"
                                                name="page_content[number_of_partners]" type="text"
                                                value="{{ $data['number_of_partners'] }}"
                                                placeholder="{{ translate('Enter Number of Partners') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Footer Description') }}</label>
                                            <textarea rows="2" name="page_content[footer_description]" id="footer_description"
                                                class=" footer_description form-control">{{ $data['footer_description'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Part Title') }}</label>
                                            <input id="part_title" class="form-control part_title"
                                                name="page_content[part_title]" type="text"
                                                value="{{ $data['part_title'] }}"
                                                placeholder="{{ translate('Enter Part Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Part Description') }}</label>
                                            <textarea rows="2" name="page_content[part_description]" id="part_description"
                                                class="form-control part_description">{{ $data['part_description'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- JOIN US TAB --}}
                            <div class="tab-pane" id="join_us" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Why Join Us Heading') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="join_us_heading" class="form-control join_us_heading"
                                                name="page_content[join_us_heading]" type="text"
                                                value="{{ $data['join_us_heading'] }}"
                                                placeholder="{{ translate('Enter heading') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="show_activities">
                                    <?php $joinus_count = 0; ?>
                                    @if (count($why_join_us) == 0)
                                        <?php $join_us = $join_us_val; ?>
                                        @include('admin.pages.page8._why_join_us')
                                        <?php $joinus_count++; ?>
                                    @else
                                        @foreach ($why_join_us as $join_us)
                                            @include('admin.pages.page8._why_join_us')
                                            <?php $joinus_count++; ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button my-4">
                                        <button type="button" class="btn btn-primary btn-sm add_join_us"
                                            id="add_join_us"> <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="join_us_image" role="tabpanel">
                                <div class="show_join_us_images">
                                    <?php $joinus_image_count = 0; ?>
                                    @if (count($why_join_us_images) == 0)
                                        <?php $join_us_image = $join_us_image_val; ?>
                                        @include('admin.pages.page8._why_join_us_images')
                                        <?php $joinus_image_count++; ?>
                                    @else
                                        @foreach ($why_join_us_images as $join_us_image)
                                            @include('admin.pages.page8._why_join_us_images')
                                            <?php $joinus_image_count++; ?>
                                        @endforeach
                                    @endif
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-12 add_more_button my-4">
                                        <button type="button" class="btn btn-primary btn-sm add_join_image"
                                            id="add_join_image"> <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="tab-pane" id="slider_image" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Team members Heading') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="team_members_heading" class="form-control team_members_heading"
                                                name="page_content[team_members_heading]" type="text"
                                                value="{{ $data['team_members_heading'] }}"
                                                placeholder="{{ translate('Enter heading') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="show_slider_images">
                                    <?php $slider_image_count = 0; ?>
                                    @if (count($slider_images) == 0)
                                        <?php $slider_image = $slider_image_val; ?>
                                        @include('admin.pages.page8._slider_images')
                                        <?php $slider_image_count++; ?>
                                    @else
                                        @foreach ($slider_images as $slider_image)
                                            @include('admin.pages.page8._slider_images')
                                            <?php $slider_image_count++; ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button my-4">
                                        <button type="button" class="btn btn-primary btn-sm add_slider_image"
                                            id="add_slider_image"> <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Our Company in numbers tab --}}
                            <div class="tab-pane" id="our_company" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Our Company Heading') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="our_company_heading" class="form-control our_company_heading"
                                                name="page_content[our_company_heading]" type="text"
                                                value="{{ $data['our_company_heading'] }}"
                                                placeholder="{{ translate('Enter heading') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="show_our_company">
                                    <?php $our_company_count = 0; ?>
                                    @if (count($our_company) == 0)
                                        <?php $our_company = $our_company_val; ?>
                                        @include('admin.pages.page8._our_company')
                                        <?php $our_company_count++; ?>
                                    @else
                                        @foreach ($our_company as $our_company)
                                            @include('admin.pages.page8._our_company')
                                            <?php $our_company_count++; ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button my-4">
                                        <button type="button" class="btn btn-primary btn-sm add_our_company"
                                            id="add_our_company"> <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Unparalleled Partner --}}
                            <div class="tab-pane" id="unparalleled_partner" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Title') }}</label>
                                            <input id="unparalleled_partner_title"
                                                class="form-control unparalleled_partner_title"
                                                name="page_content[unparalleled_partner_title]" type="text"
                                                value="{{ $data['unparalleled_partner_title'] }}"
                                                placeholder="{{ translate('Enter Title') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Description') }}</label>
                                            <textarea rows="2" name="page_content[unparalleled_partner_main_description]"
                                                id="unparalleled_partner_main_description" class="summernote unparalleled_partner_main_description">{{ $data['unparalleled_partner_main_description'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('unparalleled_partner_main_image') ? 'has-danger' : '' }}">
                                            <label
                                                class="col-form-label">{{ translate('Unparalleled Partner Main Image') }}<span
                                                    class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('unparalleled_partner_main_image') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image_5')"
                                                name="page_content[unparalleled_partner_main_image]">
                                            @error('unparalleled_partner_main_image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            <a href="#" class="profile-image">
                                                <img class="user-img img-circle img-css" id="image_5"
                                                    src="{{ $data['unparalleled_partner_main_image'] != '' ? url('uploads/pages', $data['unparalleled_partner_main_image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane" id="meta_data" role="tabpanel">
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label class="col-form-label">{{ translate('Meta Keyword') }}</label>
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
                                                <label class="col-form-label">{{ translate('Meta Description') }}</label>
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
            var count = "{{ $joinus_count }}";
            $('#add_join_us').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page8._why_join_us',
                    'joinus_count': count
                }
                getAppendPage(ParamArr, '.show_activities');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_activity", function(e) {
                var length = $(".why_join_us").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.activities_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var count = "{{ $our_company_count }}";
            $('#add_our_company').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page8._our_company',
                    'our_company_count': count
                }
                getAppendPage(ParamArr, '.show_our_company');
                e.preventDefault();
                count++;
            });
        })
    </script>

    <!-- Join Us Images -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $joinus_image_count }}";
            $('#add_join_image').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page8._why_join_us_images',
                    'joinus_image_count': count
                }
                getAppendPage(ParamArr, '.show_join_us_images');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_join_image", function(e) {
                var length = $(".why_join_us_images").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.join_images_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

    <!-- Slider Images -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $slider_image_count }}";
            $('#add_slider_image').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page8._slider_images',
                    'slider_image_count': count
                }
                getAppendPage(ParamArr, '.show_slider_images');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_slider_image", function(e) {
                var length = $(".slider_images").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.slider_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
@endsection
