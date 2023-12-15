@extends('admin.layout.master')
@section('content')
    <?php
    $data = ['banner_title', 'banner_description', 'banner_image', 'contact_info_title', 'contact_info_description', 'phone_number', 'contact_email', 'contact_address', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'about_us_footer_title', 'copyright_footer_text', 'about_us_footer_description'];
    $data = getPagemeta($data, $language_id, $Page->id);
    
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
                        <p class="p-10 ml-0">{{ translate('Contact Us') }}</p>
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
                                <a class="nav-link banner active" data-toggle="tab" href="#contacts"
                                    role="tab">{{ translate('Contacts') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link middle_slider" data-toggle="tab" href="#contact_info"
                                    role="tab">{{ translate('Contacts Info') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link footer" data-toggle="tab" href="#footer"
                                    role="tab">{{ translate('Footer') }}</a>
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
                            <div class="tab-pane active" id="contacts" role="tabpanel">
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
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('banner_image') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Banner Image') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('banner_image') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image_6')" name="page_content[banner_image]">
                                            @error('banner_image')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            <a href="#" class="profile-image">
                                                <img class="user-img img-circle img-css" id="image_6"
                                                    src="{{ $data['banner_image'] != '' ? url('uploads/pages', $data['banner_image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
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
                                </div>
                            </div>
                            <div class="tab-pane" id="contact_info" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Contact Info Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="contact_info_title" class="form-control contact_info_title"
                                                name="page_content[contact_info_title]" type="text"
                                                value="{{ $data['contact_info_title'] }}"
                                                placeholder="{{ translate('Enter Title') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('Contact Info Description') }}</label>
                                            <textarea rows="2" name="page_content[contact_info_description]" id="contact_info_description"
                                                class="summernote contact_info_description">{{ $data['contact_info_description'] }}</textarea>
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Mobile Number') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="phone_number" class="form-control phone_number"
                                                name="page_content[phone_number]" type="text"
                                                value="{{ $data['phone_number'] }}"
                                                placeholder="{{ translate('Enter Your Mobile Number') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Email') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="contact_email" class="form-control contact_email"
                                                name="page_content[contact_email]" type="text"
                                                value="{{ $data['contact_email'] }}"
                                                placeholder="{{ translate('Enter Your Email') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Address') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="contact_address" class="form-control contact_address"
                                                name="page_content[contact_address]" type="text"
                                                value="{{ $data['contact_address'] }}"
                                                placeholder="{{ translate('Enter Your Address') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Facebook link') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="facebook_link" class="form-control facebook_link"
                                                name="page_content[facebook_link]" type="text"
                                                value="{{ $data['facebook_link'] }}"
                                                placeholder="{{ translate('Enter facebook link') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Instagram link') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="instagram_link" class="form-control instagram_link"
                                                name="page_content[instagram_link]" type="text"
                                                value="{{ $data['instagram_link'] }}"
                                                placeholder="{{ translate('Enter instagram link') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Twitter link') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="twitter_link" class="form-control twitter_link"
                                                name="page_content[twitter_link]" type="text"
                                                value="{{ $data['twitter_link'] }}"
                                                placeholder="{{ translate('Enter Twitter link') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('linkedin link') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="linkedin_link" class="form-control linkedin_link"
                                                name="page_content[linkedin_link]" type="text"
                                                value="{{ $data['linkedin_link'] }}"
                                                placeholder="{{ translate('Enter linkedin link') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="footer" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('About us Footer Title') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="about_us_footer_title" class="form-control about_us_footer_title"
                                                name="page_content[about_us_footer_title]" type="text"
                                                value="{{ $data['about_us_footer_title'] }}"
                                                placeholder="{{ translate('Enter about us footer title') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 ">
                                            <label class="col-form-label">{{ translate('Copyright Footer Text') }}<span
                                                    class="mandatory cls" style="color:red;font-size:15px">*<span></label>
                                            <input id="copyright_footer_text" class="form-control copyright_footer_text"
                                                name="page_content[copyright_footer_text]" type="text"
                                                value="{{ $data['copyright_footer_text'] }}"
                                                placeholder="{{ translate('Enter Copyright footer text') }}">
                                            <div class="col-form-alert-label">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 ">
                                            <label
                                                class="col-form-label">{{ translate('About us Footer Description') }}</label>
                                            <textarea rows="2" name="page_content[about_us_footer_description]" id="about_us_footer_description"
                                                class="summernote about_us_footer_description">{{ $data['about_us_footer_description'] }}</textarea>
                                            <div class="col-form-alert-label">
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
@endsection
