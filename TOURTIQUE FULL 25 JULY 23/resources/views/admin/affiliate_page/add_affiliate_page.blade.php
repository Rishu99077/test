@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.affiliate_page.add') }}" enctype="multipart/form-data">
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

        <button class="btn btn-success me-1 mb-1 backButton float-end" type="submit"><span class="fas fa-save"></span>
            {{ $common['button'] }}
        </button>

        <div class="add_product add_product-effect-scale add_product-theme-1">

            {{-- <input type="radio" name="add_product"  id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
                    class="icon-general"></i></label> --}}

            <input type="radio" name="add_product" checked id="tab2" class="tab-content-first addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Slider Images') }}"><i class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Affiliate about') }}"><i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('How it work') }}"><i class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Why choose affiliate') }}">
                <i class="icon-adver"></i></label>

            <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Faqs') }}"><i
                    class="icon-faq"></i></label>

            <ul>
                <input id="" name="id" type="hidden" value="{{ $get_affiliate_page['id'] }}" />
                {{-- General Tab  
                <li class="tab-content tab-content-first typography">        
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">

                                    <input id="" name="id" type="hidden" value="{{ $get_affiliate_page['id'] }}" />

                                  
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">{{ translate('Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}" id="title" name="title[{{ $lang_id }}]"
                                                type="text"
                                                value="{{ getLanguageTranslate($get_affiliate_page_language, $lang_id, $get_affiliate_page['id'], 'title', 'affiliate_page_id') }}" />
                                            @error('title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                   
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}

                {{-- Affiliate Slider details --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Affiliate Slider details') }}</h4>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                                for="customFile">{{ translate('Slider Image') }} <span
                                                    class="fas fa-info-circle"></span>
                                            </label>
                                            @php
                                                $data = 0;
                                            @endphp
                                            @foreach ($get_slider_images as $HSI)
                                                @include('admin.affiliate_page._slider_images')
                                                @php
                                                    $data++;
                                                @endphp
                                            @endforeach
                                            @if (count($get_slider_images) == 0)
                                                @include('admin.affiliate_page._slider_images')
                                            @endif
                                            <div class="show_slider">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 add_more_button">
                                                    <button class="btn btn-success btn-sm float-end" type="button"
                                                        id="add_slider" title='Add more'>
                                                        <span class="fa fa-plus"></span>
                                                        {{ translate('Add more') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Affiliate about --}}
                <li class="tab-content tab-content-3 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Affiliate about details') }}</h4>


                                    <div class="col-md-6">
                                        <label class="form-label" for="about_title">{{ translate('About Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('about_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('About Title') }}" id="about_title"
                                            name="about_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_affiliate_page_language, $lang_id, $get_affiliate_page['id'], 'about_title', 'affiliate_page_id') }}" />
                                        @error('about_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="price">{{ translate('About Description') }}
                                        </label>

                                        <textarea class="form-control {{ $errors->has('about_description.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                                            id="about_description" name="about_description[{{ $lang_id }}]" placeholder="Enter About Description">{{ getLanguageTranslate($get_affiliate_page_language, $lang_id, $get_affiliate_page['id'], 'about_description', 'affiliate_page_id') }}</textarea>
                                        @error('about_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    <div class="col-md-6 content_title">
                                        <label class="form-label"
                                            for="duration_from">{{ translate('Upload about small Image') }} </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="about_image_1"
                                                aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo')"
                                                id="about_image_1" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_affiliate_page['about_image_1'] != '' ? asset('uploads/Affiliate_Page/' . $get_affiliate_page['about_image_1']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="upload_logo" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 content_title">
                                        <label class="form-label"
                                            for="duration_from">{{ translate('Upload big image') }} </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="about_image_2"
                                                aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo_2')"
                                                id="about_image_2" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_affiliate_page['about_image_2'] != '' ? asset('uploads/Affiliate_Page/' . $get_affiliate_page['about_image_2']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="upload_logo_2" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>


                {{-- Affiliate How it work --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">

                                    <h4 class="text-dark">{{ translate('How it work') }}</h4>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label" for="how_its_work_heading">{{ translate('How its Work Heading') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input class="form-control {{ $errors->has('how_its_work_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('How its Work Heading') }}" id="how_its_work_heading"
                                                name="how_its_work_heading[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_HiW_heading, $lang_id,'affilat_page_how_its_work_heading','title','meta_title') }}" />
                                            @error('how_its_work_heading.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_affiliate_page_work as $GPF)
                                            @include('admin.affiliate_page._how_it_work')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (count($get_affiliate_page_work) == 0)
                                            @include('admin.affiliate_page._how_it_work')
                                        @endif

                                        <div class="show_works">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <!-- <button class="btn btn-success btn-sm float-end" type="button" id="add_works" title='Add more'>
                                                            <span class="fa fa-plus"></span> {{ translate('Add more') }}</button> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>


                {{-- Affiliate Why choose affiliate --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Why choose affiliate') }}</h4>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label" for="why_choose_heading">{{ translate('Why choose heading') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input class="form-control {{ $errors->has('why_choose_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Why choose heading') }}" id="why_choose_heading"
                                                name="why_choose_heading[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_choose_heading, $lang_id,'affilat_page_choose_heading','title','meta_title') }}" />
                                            @error('why_choose_heading.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_affiliate_page_choose as $WCU)
                                            @include('admin.affiliate_page._why_choose')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (count($get_affiliate_page_choose) == 0)
                                            @include('admin.affiliate_page._why_choose')
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

                {{-- Faq Tab --}}
                <li class="tab-content tab-content-6 typography">
                    
                    <div class="colcss">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label" for="faq_heading">{{ translate('Faq Heading') }}<span
                                        class="text-danger">*</span>
                                </label>
                                <input class="form-control {{ $errors->has('faq_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Faq Heading') }}" id="faq_heading"
                                    name="faq_heading[{{ $lang_id }}]" type="text"
                                    value="{{ getLanguageTranslate($get_faq_heading, $lang_id,'affilate_page_faq_heading','title','meta_title') }}" />
                                @error('faq_heading.' . $lang_id)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        @php
                            $data = 0;
                        @endphp
                        @foreach ($get_affiliate_page_faq as $FAQS)
                            @include('admin.affiliate_page._affiliate_faq')
                            @php
                                $data++;
                            @endphp
                        @endforeach
                        @if (empty($get_affiliate_page_faq))
                            @include('admin.affiliate_page._affiliate_faq')
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

            </ul>
        </div>

    </form>

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

    <!-- How it Work -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_works').click(function(e) {

                var ParamArr = {
                    'view': 'admin.affiliate_page._how_it_work',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_works');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_choose_div", function(e) {
                var length = $(".choose_div").length;
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


    <!-- Why chooose affiliate -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.affiliate_page._why_choose',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_choose');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_faq", function(e) {
                var length = $(".delete_faq").length;
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

    <!--Affiliate FAQS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_faqs').click(function(e) {

                var ParamArr = {
                    'view': 'admin.affiliate_page._affiliate_faq',
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


    <!-- Slider Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".slider_row").length;

                var ParamArr = {
                    'view': 'admin.affiliate_page._slider_images',
                    'data': count,
                }
                getAppendPage(ParamArr, '.show_slider');
                e.preventDefault();
                count++;

            });


            $(document).on('click', ".slider_delete", function(e) {
                var length = $(".slider_delete").length;
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
@endsection
