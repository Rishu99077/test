@extends('admin.layout.master')
@section('content')
    <?php
    $data = ['banner_title', 'banner_description', 'banner_image', 'new_activity_heading'];
    $data = getPagemeta($data, $language_id, $Page->id);
    
    $new_activities_val = ['activities_image' => '', 'activity_title' => '', 'activities_desc' => ''];
    $new_activities = getPagemeta_multi($new_activities_val, $language_id, $Page->id, 'new_activities');
    
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
                        <p class="p-10 ml-0">{{ translate('Blogs') }}</p>
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
                                    role="tab">{{ translate('Blogs') }}</a>
                                <div class="slide"></div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link new_activity" data-toggle="tab" href="#new_activity"
                                    role="tab">{{ translate('New Activity') }}</a>
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
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
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

                            <div class="tab-pane" id="new_activity" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('New Activity Heading') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="new_activity_heading" class="form-control new_activity_heading"
                                                name="page_content[new_activity_heading]" type="text"
                                                value="{{ $data['new_activity_heading'] }}"
                                                placeholder="{{ translate('Enter heading') }}">
                                            <div class=" col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="show_activities">
                                    <?php $activities_count = 0; ?>
                                    @if (count($new_activities) == 0)
                                        <?php $new_activity = $new_activities_val; ?>
                                        @include('admin.pages.page6._new_activities')
                                        <?php $activities_count++; ?>
                                    @else
                                        @foreach ($new_activities as $new_activity)
                                            @include('admin.pages.page6._new_activities')
                                            <?php $activities_count++; ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button my-4">
                                        <button type="button" class="btn btn-primary btn-sm add_activity"
                                            id="add_activity"> <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
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
            var count = "{{ $activities_count }}";
            $('#add_activity').click(function(e) {
                var ParamArr = {
                    'view': 'admin.pages.page6._new_activities',
                    'activities_count': count
                }
                getAppendPage(ParamArr, '.show_activities');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_activity", function(e) {
                var length = $(".new_activities").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.activities_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
@endsection
