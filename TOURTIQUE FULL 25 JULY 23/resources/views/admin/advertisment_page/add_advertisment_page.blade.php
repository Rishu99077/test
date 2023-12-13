@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.advertise_us_page.add') }}" enctype="multipart/form-data">
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
        <button class="btn btn-success me-1 mb-1 backButton float-end" type="submit"><span class="fas fa-save"></span>
            {{ $common['button'] }}
        </button>

        <div class="add_product add_product-effect-scale add_product-theme-1">
            <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
                    class="icon-general"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Advertisment Page Slider Images') }}"><i class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Advertise with us') }}"><i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Why Choose') }}"><i class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Footer Text') }}"><i class="icon-voucher"></i></label>

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-6 content_title">
                                        <h4 class="text-dark"> {{ translate('General') }}</h4>
                                    </div>
                                    <div class="col-md-6 content_title">
                                        {{-- <div class="form-check form-switch pl-0">
                                            <input class="form-check-input float-end status switch_button" id="status"
                                                type="checkbox" value="Active" name="status">
                                            <label class="form-check-label form-label" for="status">Status
                                            </label>
                                        </div> --}}
                                    </div>
                                    <input id="" name="id" type="hidden"
                                        value="{{ $get_advertise_us_page['id'] }}" />

                                    {{-- @foreach ($languages as $key => $L)
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="title">{{ translate('Banner Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Banner Title') }}" id="title"
                                                name="title[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'title', 'advertisment_page_id') }}" />
                                            @error('title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endforeach 

                                    @foreach ($languages as $key => $L)
                                        <div class="col-md-6">
                                            <label class="form-label" for="short_description">{{ translate('Banner Short Description') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('short_description.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Banner Short Description') }}" id="short_description"
                                                name="short_description[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'short_description', 'advertisment_page_id') }}" />
                                            @error('short_description.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endforeach --}}

                                   
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="description">{{ translate('Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Description') }}" id="description_{{ $lang_id }}"
                                            name="description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'description', 'advertisment_page_id') }}
                                         </textarea>
                                        <div class="invalid-feedback">

                                        </div>

                                    </div>

                                </div>
                                <div class="colcss">
                                    @php
                                        $overview_count = 0;
                                    @endphp
                                    @foreach ($get_banner_over_view as $GBO)
                                        @include('admin.advertisment_page._banner_overview')
                                        @php
                                            $overview_count++;
                                        @endphp
                                    @endforeach
                                    @if (count($get_banner_over_view) == 0)
                                        @include('admin.advertisment_page._banner_overview')
                                    @endif
                                    <div class="show_overview">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 add_more_button">
                                            <button class="btn btn-success btn-sm float-end" type="button"
                                                id="add_banner_overview" title='Add more'>
                                                <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- About us Page silder  --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Advertsiment Page Slider details') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_slider_images as $LSI)
                                            @include('admin.advertisment_page._slider_images')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (count($get_slider_images) == 0)
                                            @include('admin.advertisment_page._slider_images')
                                        @endif
                                        <div class="show_slider_view">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_slider" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Advertise With us  --}}
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Advertise With Us') }}</h4>

                                   
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="advertise_with_us_title">{{ translate('Advertise Title') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('advertise_with_us_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Advertise Title') }}"
                                                id="advertise_with_us_title"
                                                name="advertise_with_us_title[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'advertise_with_us_title', 'advertisment_page_id') }}" />

                                        </div>
                                    
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="title">{{ translate('Advertise Text') }}
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('advertise_with_us_desc.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Advertise Text') }}" id="advertise_title"
                                                name="advertise_with_us_desc[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'advertise_with_us_desc', 'advertisment_page_id') }}" />

                                        </div>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_advertise_with_us as $GAWU)
                                            @include('admin.advertisment_page._advertise_with_us')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_advertise_with_us))
                                            @include('admin.advertisment_page._advertise_with_us')
                                        @endif
                                        <div class="show_advertise">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_advertise" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </li>

                {{-- About Us Choose  --}}
                <li class="tab-content tab-content-3 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Why choose Tourtastique?') }}</h4>

                                    <div class="col-md-6 content_title mt-2">
                                        <label class="form-label" for="duration_from">{{ translate('Why choose Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="choose_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'upload_choose_logo')" id="choose_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_advertise_us_page['choose_image'] != '' ? Url('uploads/advertisment_page', $get_advertise_us_page['choose_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="upload_choose_logo" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="why_choose_title">{{ translate('Why Choose Title') }}</label>
                                            <input
                                                class="form-control {{ $errors->has('why_choose_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Why Choose Title') }}"
                                                id="why_choose_title" name="why_choose_title[{{ $lang_id }}]"
                                                type="text"
                                                value="{{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'why_choose_title', 'advertisment_page_id') }}" />

                                        </div>
                                    </div>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_advertise_choose as $CHO)
                                            @include('admin.advertisment_page._why_choose')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_advertise_choose))
                                            @include('admin.advertisment_page._why_choose')
                                        @endif
                                        <div class="show_choose">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_choose" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Footer Text  --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Footer Text') }}</h4>

                                    
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Footer text') }}
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('footer_text.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('footer text') }}" id="footer_text"
                                            name="footer_text[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'footer_text', 'advertisment_page_id') }}" />
                                        @error('footer_text.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate(' Footer Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('footer_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter footer  Description') }}" id="title"
                                            name="footer_description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_advertise_us_page_language, $lang_id, $get_advertise_us_page['id'], 'footer_description', 'advertisment_page_id') }}
                                         </textarea>
                                        @error('footer_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                               

                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replaceAll('footer_text');
    </script>

    <!-- Advertise With Us -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_advertise').click(function(e) {

                var ParamArr = {
                    'view': 'admin.advertisment_page._advertise_with_us',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_advertise');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_advertise", function(e) {
                var length = $(".delete_advertise").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.advertise_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Slider -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".slider_row").length;

                var ParamArr = {
                    'view': 'admin.advertisment_page._slider_images',
                    'data': count,
                }
                getAppendPage(ParamArr, '.show_slider_view');
                e.preventDefault();
                count++;

            });


            $(document).on('click', ".slidr_view_delete", function(e) {
                var length = $(".slidr_view_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.slider_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Slider Images -->
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
                            // $(html).insertAfter(".appenImage");
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

    <!-- Facilities -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_works').click(function(e) {

                var ParamArr = {
                    'view': 'admin.aboutus_page._facilities',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_works');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_media", function(e) {
                var length = $(".delete_media").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.fac_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Why choose -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.advertisment_page._why_choose',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_choose');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_choose", function(e) {
                var length = $(".delete_choose").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.choose_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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

    <!-- Banner Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $overview_count }}";
            $('#add_banner_overview').click(function(e) {
                var length = $(".over_view_row").length;
                console.log(length)
                if (length <= 3) {
                    var ParamArr = {
                        'view': 'admin.aboutus_page._banner_overview',
                        'data': count,
                        'overview_count': count,
                    }
                    getAppendPage(ParamArr, '.show_overview');
                    e.preventDefault();
                    count++;
                }
            });


            $(document).on('click', ".over_view_delete", function(e) {
                var length = $(".over_view_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.over_view_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>
@endsection
