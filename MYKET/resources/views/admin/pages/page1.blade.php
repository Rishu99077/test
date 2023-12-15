@extends('admin.layout.master')
@section('content')

    <?php
    $data = ['recommended_tours_title', 'top_destination_title', 'adventure_awaits_title', 'unforgettable_cultural_title', 'cultural_attractions_title', 'travel_experiences_title', 'travel_experiences_desc', 'our_partners_title', 'our_partners_desc', 'recommended_tours_category', 'adventure_awaits_category', 'cultural_attractions_category', 'why_choose_us_title'];
    $data = getPagemeta($data, $language_id, $Page->id);
    
    $banner_title_val = ['banner_title' => ''];
    $Banner_title = getPagemeta_multi($banner_title_val, $language_id, $Page->id, 'banner_title');
    
    $middle_slider_val = ['slider_image' => '', 'middle_slider_title' => '', 'middle_slider_link' => '', 'middle_slider_desc' => '', 'middle_slider_cloud'];
    $middle_slider = getPagemeta_multi($middle_slider_val, $language_id, $Page->id, 'middle_slider_data');
    
    $why_choose_val = ['why_choose_image' => '', 'why_choose_title' => '', 'why_choose_desc' => ''];
    $why_choose = getPagemeta_multi($why_choose_val, $language_id, $Page->id, 'why_choose_data');
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

        .page-wrapper .home_page .card-block #banner .col-md-1 .add_banner_title {
            margin-top: 33px;
            padding: 8px 12px !important;
        }

        .page-wrapper .home_page .card-block #banner .col-md-1 .remove_banner_title {
            padding: 8px 11px !important;
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
                        <p class="p-10 ml-0">{{ translate('Home') }}</p>
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
                                <a class="nav-link banner active" data-toggle="tab" href="#banner"
                                    role="tab">{{ translate('General') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link middle_slider" data-toggle="tab" href="#middle_slider"
                                    role="tab">{{ translate('Middle Slider') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link why_choose" data-toggle="tab" href="#why_choose"
                                    role="tab">{{ translate('Why Choose') }}</a>
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
                            <div class="tab-pane active" id="banner" role="tabpanel">
                                <div>
                                    @php
                                        $banner_title_count = 0;
                                    @endphp
                                    @if (count($Banner_title) == 0)
                                        @php $banner_data = $banner_title_val; @endphp
                                        @include('admin.pages.page1._banner_title')
                                        @php
                                            $banner_title_count++;
                                        @endphp
                                    @else
                                        @foreach ($Banner_title as $banner_data)
                                            @include('admin.pages.page1._banner_title')
                                            @php
                                                $banner_title_count++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    <div class="append_banner_title"></div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Recommended Tours Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="recommended_tours_title"
                                                    class="form-control recommended_tours_title"
                                                    name="page_content[recommended_tours_title]" type="text"
                                                    value="{{ $data['recommended_tours_title'] }}"
                                                    placeholder="{{ translate('Enter Recommended Tours Title') }}">
                                                <div class=" col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Recommended Tours Category') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>

                                                <select name="page_content[recommended_tours_category][]" id=""
                                                    class="select2 form-control recommended_tours_category" multiple>
                                                    @php

                                                        $recommended_tours_category = isset($data['recommended_tours_category']) ? explode(',', $data['recommended_tours_category']) : [];

                                                    @endphp
                                                    @foreach ($ProductType as $PT)
                                                        <option value="{{ $PT['id'] }}"
                                                            {{ getSelectedInArray($PT['id'], $recommended_tours_category) }}>
                                                            {{ $PT['title'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Top Destinations Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="top_destination_title" class="form-control top_destination_title"
                                                    name="page_content[top_destination_title]" type="text"
                                                    value="{{ $data['top_destination_title'] }}"
                                                    placeholder="{{ translate('Enter Explore Top Destinations Title') }}">
                                                <div class=" col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Adventures Await Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="adventure_awaits_title"
                                                    class="form-control adventure_awaits_title"
                                                    name="page_content[adventure_awaits_title]" type="text"
                                                    value="{{ $data['adventure_awaits_title'] }}"
                                                    placeholder="{{ translate('Enter Adventures Await Title') }}">
                                                <div class=" col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Adventures Await Category') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>

                                                <select name="page_content[adventure_awaits_category][]" id=""
                                                    class="select2 form-control adventure_awaits_category" multiple>
                                                    @php

                                                        $adventure_awaits_category = isset($data['adventure_awaits_category']) ? explode(',', $data['adventure_awaits_category']) : [];

                                                    @endphp
                                                    @foreach ($ProductType as $PT)
                                                        <option value="{{ $PT['id'] }}"
                                                            {{ getSelectedInArray($PT['id'], $adventure_awaits_category) }}>
                                                            {{ $PT['title'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Unforgettable Cultural Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="unforgettable_cultural_title"
                                                    class="form-control unforgettable_cultural_title"
                                                    name="page_content[unforgettable_cultural_title]" type="text"
                                                    value="{{ $data['unforgettable_cultural_title'] }}"
                                                    placeholder="{{ translate('Enter Unforgettable Cultural Title') }}">
                                                <div class="col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label class="col-form-label">{{ translate('Why Choose Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="why_choose_us_title" class="form-control why_choose_us_title"
                                                    name="page_content[why_choose_us_title]" type="text"
                                                    value="{{ $data['why_choose_us_title'] }}"
                                                    placeholder="{{ translate('Enter Why Choose Title') }}">
                                                <div class="col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Cultural Attractions Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
                                                <input id="cultural_attractions_title"
                                                    class="form-control cultural_attractions_title"
                                                    name="page_content[cultural_attractions_title]" type="text"
                                                    value="{{ $data['cultural_attractions_title'] }}"
                                                    placeholder="{{ translate('Enter Cultural Attractions Title') }}">
                                                <div class="col-form-alert-label">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Cultural Attractions Category') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>

                                                <select name="page_content[cultural_attractions_category][]"
                                                    id=""
                                                    class="select2 form-control cultural_attractions_category" multiple>
                                                    @php

                                                        $cultural_attractions_category = isset($data['cultural_attractions_category']) ? explode(',', $data['cultural_attractions_category']) : [];

                                                    @endphp
                                                    @foreach ($ProductType as $PT)
                                                        <option value="{{ $PT['id'] }}"
                                                            {{ getSelectedInArray($PT['id'], $cultural_attractions_category) }}>
                                                            {{ $PT['title'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 ">
                                                <label
                                                    class="col-form-label">{{ translate('Travel Experiences Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
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
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 ">
                                                <label class="col-form-label">{{ translate('Our Partners Title') }}<span
                                                        class="mandatory cls"
                                                        style="color:red;font-size:15px">*<span></label>
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
                            </div>
                            <div class="tab-pane" id="middle_slider" role="tabpanel">
                                <div>
                                    @php
                                        $middle_slider_count = 0;
                                    @endphp
                                    @if (count($middle_slider) == 0)
                                        @php $Middle_slider = $middle_slider_val; @endphp
                                        @include('admin.pages.page1._middle_slider')
                                        @php
                                            $middle_slider_count++;
                                        @endphp
                                    @else
                                        @foreach ($middle_slider as $Middle_slider)
                                            @include('admin.pages.page1._middle_slider')
                                            @php
                                                $middle_slider_count++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    <div class="append_middle_slider"></div>
                                    <button type="button" class="btn btn-primary btn-sm add_middle_slider"
                                        id="add_middle_slider"> <span class="fa fa-plus"></span>
                                        {{ translate('Add') }}</button>
                                </div>
                            </div>
                            <div class="tab-pane" id="why_choose" role="tabpanel">
                                <div>
                                    @php
                                        $why_choose_count = 0;
                                    @endphp
                                    @if (count($why_choose) == 0)
                                        @php $why_choose = $why_choose_val; @endphp
                                        @include('admin.pages.page1._why_choose')
                                        @php
                                            $why_choose_count++;
                                        @endphp
                                    @else
                                        @foreach ($why_choose as $Why_Choose)
                                            @include('admin.pages.page1._why_choose')
                                            @php
                                                $why_choose_count++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    <div class="append_why_choose"></div>
                                    <button type="button" class="btn btn-primary btn-sm add_why_choose"
                                        id="add_why_choose"> <span class="fa fa-plus"></span>
                                        {{ translate('Add') }}</button>
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
    <script>
        $(document).ready(function() {

            $(".cultural_attractions_category").select2();
            $(".adventure_awaits_category").select2();
            $(".recommended_tours_category").select2();
            // Add BAnner Title
            $(".add_banner_title").click(function(e) {

                var count = $('.banner_title_row').length;
                var ParamArr = {
                    'view': 'admin.pages.page1._banner_title',
                    'banner_title_count': count
                }
                getAppendPage(ParamArr, '.append_banner_title');
                e.preventDefault();

            });

            // Remove Banner Title
            $(document).on('click', ".remove_banner_title", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {

                        $(this).parent().parent().remove();
                        $(".banner_title").each(function(index, value) {
                            $(this).attr("id", "banner_title_" + index)
                        })
                        e.preventDefault();
                    }
                });

            });

            // Add Middle Slider 
            $(".add_middle_slider").click(function(e) {

                var count = $('.middle_slider_row').length;
                var ParamArr = {
                    'view': 'admin.pages.page1._middle_slider',
                    'middle_slider_count': count
                }
                getAppendPage(ParamArr, '.append_middle_slider');
                e.preventDefault();

            });

            // // Remove Middle Slider
            $(document).on('click', "#remove_middle_slider", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {

                        $(this).parent().parent().remove();
                        $(".middle_slider_row").each(function(index, value) {
                            $(this).attr("id", "remove_div" + index)
                        })
                        e.preventDefault();
                    }
                });
            });


            // Add Why Choose
            $(".add_why_choose").click(function(e) {

                var count = $('.why_choose_row').length;
                var ParamArr = {
                    'view': 'admin.pages.page1._why_choose',
                    'why_choose_count': count
                }
                getAppendPage(ParamArr, '.append_why_choose');
                e.preventDefault();

            });
            // // Remove Why choose
            $(document).on('click', "#remove_why_choose", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {

                        $(this).parent().parent().remove();
                        $(".why_choose_row").each(function(index, value) {
                            $(this).attr("id", "remove_div" + index)
                        })
                        e.preventDefault();
                    }
                });
            });
        });

        // Add Product 
        // $(document).on("submit", "#add_home_page", function(e) {
        //     e.preventDefault();
        //     // $("#add_home_page_btn").prop("disabled", true);
        //     var formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('admin.pages') }}",
        //         datatype: 'JSON',
        //         data: formData,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         success: function(response) {
        //             if (response.error) {
        //                 $.each(response.error, function(index, value) {
        //                     if (value != '') {
        //                         $('.tab-pane').each(function(key, value) {
        //                             $(this).removeClass("active");
        //                             $(".nav-link").removeClass("active");
        //                             $(this).find(".form-control-danger").removeClass(
        //                                 'form-control-danger');
        //                             $(this).find(".has-danger").removeClass(
        //                                 'has-danger');
        //                             $(this).find(".col-form-alert-label").html('');
        //                         })
        //                         var index = index.replace(/\./g, '_');
        //                         if ($('#' + index).parent().parent().parent().parent()
        //                             .parent().hasClass("tab-pane")) {
        //                             $('#' + index).parent().parent().parent().parent()
        //                                 .parent()
        //                                 .addClass(
        //                                     "active");
        //                         } else {
        //                             $('#' + index).parent().parent().parent().parent()
        //                                 .parent().parent()
        //                                 .addClass(
        //                                     "active");
        //                         }
        //                         $('#' + index).addClass('form-control-danger');
        //                         $('#' + index).focus();
        //                         $('#' + index).parent().addClass('has-danger');
        //                         $('.nav-link').each(function(key, value) {
        //                             // var checkDiv = $(".tab-content").find("#" + index);
        //                             var activePane = $(".tab-content").find(
        //                                 '.tab-pane.active').attr("id");
        //                             var checkAttr = $(value).hasClass(
        //                                 activePane);
        //                             if (checkAttr) {
        //                                 $(value)
        //                                     .addClass(
        //                                         "active")
        //                                 return false;
        //                             }
        //                         })
        //                         $('#' + index).parent().find('.col-form-alert-label ')
        //                             .html(value[0]);

        //                     }
        //                     return false;
        //                 });
        //             } else {
        //                 success_msg("Product {{ $common['button'] }} Successfully...")
        //             }
        //         }
        //     });
        //     setTimeout(() => {
        //         $("#add_product_btn").prop("disabled", false);
        //     }, 500);

        // });
    </script>
@endsection
@endsection
