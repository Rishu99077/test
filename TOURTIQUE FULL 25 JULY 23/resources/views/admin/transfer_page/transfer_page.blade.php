@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.transfer_page.add') }}" enctype="multipart/form-data">
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

            <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Why Book a Transfer') }}"><i class="icon-additional"></i></label>

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Premium Taxi Slider') }}"><i class="icon-car"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Why book with us') }}"><i class="icon-customer"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('HightLights') }}"><i class="icon-highlight"></i></label>

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            for="title">{{ translate('Terms Conditions , Privacy ') }}
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('transfer_terms_conditions.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Enter ') }}" id="transfer_terms_conditions"
                                            name="transfer_terms_conditions[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_transfer_privacy, $lang_id, 'transfer_terms_conditions', 'title', 'meta_title') }}" />
                                        @error('transfer_terms_conditions.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 content_title">
                                        <label class="form-label" for="duration_from">{{ translate('Side Banner') }}
                                            <small>(350 × 780)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="side_banner"
                                                aria-describedby="basic-addon2" onchange="loadFile(event,'transfer_side_banner')"
                                                id="side_banner" />
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ isset($MetaGlobalSideBanner['image']) && $MetaGlobalSideBanner['image'] != '' ? asset('uploads/side_banner/' . $MetaGlobalSideBanner['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="transfer_side_banner" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input id="" name="id" type="hidden"
                                        value="{{ $get_transfer_page['id'] }}" />

                                    <div class="row mt-3">
                                        <h4 class="text-dark">{{ translate('Transfer Page Slider details') }}</h4>

                                        <div class="colcss">
                                            @php
                                                $data = 0;
                                            @endphp
                                            @foreach ($get_slider_images as $LSI)
                                                @include('admin.transfer_page._slider_images')
                                                @php
                                                    $data++;
                                                @endphp
                                            @endforeach
                                            @if (count($get_slider_images) == 0)
                                                @include('admin.transfer_page._slider_images')
                                            @endif
                                            <div class="show_overview">
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

                {{-- Why Book a Transfer  --}}
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Why Book a Transfer') }}</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                for="title">{{ translate('Main Heading ') }}
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('why_booking_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Enter Main Heading') }}" id="why_booking_heading"
                                                name="why_booking_heading[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_why_booking_heading, $lang_id, 'why_booking_heading', 'title', 'meta_title') }}" />
                                            @error('why_booking_heading.' . $lang_id)
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
                                        @foreach ($get_transfer_page_wbt as $GPF)
                                            @include('admin.transfer_page._why_book_transfer')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_transfer_page_wbt))
                                            @include('admin.transfer_page._why_book_transfer')
                                        @endif
                                        <div class="show_works">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                {{-- <button class="btn btn-success btn-sm float-end" type="button" id="add_works"
                                    title='Add more'> <span class="fa fa-plus"></span> {{ translate('Add more') }}</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Premium Taxi  --}}
                <li class="tab-content tab-content-3 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Premium Taxi Slider') }}</h4>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="title">{{ translate('Heading') }}
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('premium_taxi_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Enter Heading') }}" id="premium_taxi_heading"
                                            name="premium_taxi_heading[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_peremium_taxi_heading, $lang_id, 'premium_taxi_heading', 'title', 'meta_title') }}" />
                                        @error('premium_taxi_heading.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_transfer_page_premium_taxi as $TPT)
                                            @include('admin.transfer_page._premium_taxi')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_transfer_page_premium_taxi))
                                            @include('admin.transfer_page._premium_taxi')
                                        @endif
                                        <div class="show_taxi">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_premium_taxi" title='Add more'> <span
                                                        class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Why book with us  --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Why book with us') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_transfer_page_with_us as $TWU)
                                            @include('admin.transfer_page._book_with_us')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_transfer_page_with_us))
                                            @include('admin.transfer_page._book_with_us')
                                        @endif
                                        <div class="show_with">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_with" title='Add more'> <span class="fa fa-plus"></span>
                                                    {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- HightLights  --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('HightLights') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_transfer_page_highlights as $TPH)
                                            @include('admin.transfer_page._highlight')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_transfer_page_highlights))
                                            @include('admin.transfer_page._highlight')
                                        @endif
                                        <div class="show_high">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_high" title='Add more'> <span class="fa fa-plus"></span>
                                                    {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
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

    <!-- How it Work -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_works').click(function(e) {

                var ParamArr = {
                    'view': 'admin.transfer_page._why_book_transfer',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_works');

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

    <!-- Permium page -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_premium_taxi').click(function(e) {

                var ParamArr = {
                    'view': 'admin.transfer_page._premium_taxi',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_taxi');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_taxi", function(e) {
                var length = $(".delete_taxi").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.taxi_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Slider Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".over_view_row").length;

                var ParamArr = {
                    'view': 'admin.transfer_page._slider_images',
                    'data': count,
                }
                getAppendPage(ParamArr, '.show_overview');
                e.preventDefault();
                count++;

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

    <!-- WITH US page -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_with').click(function(e) {

                var ParamArr = {
                    'view': 'admin.transfer_page._book_with_us',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_with');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_with_us", function(e) {
                var length = $(".delete_with_us").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.with_us_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- HIGHLIGHTS page -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_high').click(function(e) {

                var ParamArr = {
                    'view': 'admin.transfer_page._highlight',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_high');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_high", function(e) {
                var length = $(".delete_high").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.high_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Gift Card Images -->
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
                            // $(html).insertAfter(".appenImage");
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
@endsection
