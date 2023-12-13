@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.city_guide.add') }}" enctype="multipart/form-data">
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
                title="{{ translate('City Guide Slider Images') }}"><i class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('About') }}"><i
                    class="icon-adver"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Highlights') }}">
                <i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Faqs') }}">
                <i class="icon-faq"></i></label>

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark"> {{ translate('General') }}</h4>

                                    <input id="" name="id" type="hidden"
                                        value="{{ $get_city_guide['id'] }}" />

                                    <div class="col-md-12 content_title mt-2">
                                        <div class="form-check form-switch pl-0">
                                            <input class="form-check-input float-end status switch_button"
                                                {{ getChecked('Active', old('status', $get_city_guide['status'])) }}
                                                id="status" type="checkbox" value="Active" name="status">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-2 content_title ">
                                        <label class="form-label" for="price">{{ translate('Country') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="form-select single-select country  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                            name="country" id="country" onchange="getStateCity('country')">
                                            <option value="">{{ translate('Select Country') }}</option>
                                            @foreach ($country as $C)
                                                <option value="{{ $C['id'] }}"
                                                    {{ getSelected($C['id'], old('country', $get_city_guide['country'])) }}>
                                                    {{ $C['name'] }}</option>
                                            @endforeach
                                        </select>

                                        @error('country')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    <div class="col-md-4 mt-2">
                                        <label class="form-label" for="title">{{ translate('State') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                            name="state" id="state" onchange="getStateCity('state')">
                                            <option value="">{{ translate('Select State') }}</option>

                                        </select>
                                        @error('state')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mt-2">
                                        <label class="form-label" for="title">{{ translate('City') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                            name="city" id="city">
                                            <option value="">{{ translate('Select City') }}</option>

                                        </select>
                                        @error('city')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 content_title mt-2">
                                        <label class="form-label" for="duration_from">{{ translate('Banner Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="image"
                                                aria-describedby="basic-addon2" onchange="loadFile(event,'image_banner')"
                                                id="image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_city_guide['image'] != '' ? asset('uploads/MediaPage/' . $get_city_guide['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="image_banner" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-4 mt-2">
                                        <label class="form-label" for="title">{{ translate('Main Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Main Title') }}" id="title"
                                            name="title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_city_guide_language, $lang_id, $get_city_guide['id'], 'title', 'city_guide_id') }}" />
                                        @error('title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                   

                                    <div class="col-md-4 content_title mt-2">
                                        <label class="form-label" for="link">{{ translate('Button Link') }} </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="button_link"
                                                id="button_link" value="{{ $get_city_guide['button_link'] }}" />
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label" for="title">{{ translate('Button Text') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('button_text.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Button Text') }}" id="button_text"
                                                name="button_text[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_city_guide_language, $lang_id, $get_city_guide['id'], 'button_text', 'city_guide_id') }}" />
                                            @error('button_text.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="title">{{ translate('Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Description') }}" id="title" name="description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_city_guide_language, $lang_id, $get_city_guide['id'], 'description', 'city_guide_id') }}
                                        </textarea>
                                        @error('description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label" for="sort_order">{{ translate('Sort Order') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control numberonly"
                                            placeholder="{{ translate('Sort Order') }}" id="sort_order"
                                            name="sort_order" type="text"
                                            value="{{ $get_city_guide['sort_order'] }}" />

                                    </div>


                                    <div class="col-md-12 content_title mt-2">
                                        <label class="form-label" for="title">{{ translate('Google Address') }}
                                        </label>
                                        <textarea class="form-control {{ $errors->has('google_address') ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Enter Location') }}" id="input_store_address_id" name="google_address">{{ old('google_address', $get_city_guide['google_address']) }}</textarea>

                                        <input type="hidden" name="address_lattitude" id="address_lattitude"
                                            class="form-control" value="{{ $get_city_guide['address_lattitude'] }}">
                                        <input type="hidden" name="address_longitude" id="address_longitude"
                                            class="form-control" value="{{ $get_city_guide['address_longitude'] }}">

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- <div class="col-md-6 content_title">
                                        <label class="form-label" for="duration_from">{{ translate('Bottom Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="bottom_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'image_banner_2')" id="bottom_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_city_guide['bottom_image'] != '' ? asset('uploads/MediaPage/' . $get_city_guide['bottom_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="image_banner_2" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-6 content_title mt-2">
                                        <label class="form-label" for="duration_from">{{ translate('Video URL') }}
                                        </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="video_url" id="video_url"
                                                value="{{ $get_city_guide['video_url'] }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 content_title mt-2">
                                        <label class="form-label"
                                            for="duration_from">{{ translate('Video thumbnail Image') }}</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="video_thumbnail"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'video_thum_banner')" id="video_thumbnail" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_city_guide['video_thumbnail'] != '' ? asset('uploads/MediaPage/' . $get_city_guide['video_thumbnail']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="video_thum_banner" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 content_title mt-2">
                                        <label class="form-label" for="link">{{ translate('Link') }} </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="link" id="link"
                                                value="{{ $get_city_guide['link'] }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 content_title mt-2">
                                        <label class="form-label"
                                            for="duration_from">{{ translate('Side Banner Image') }} </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="side_banner_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'image_banner_3')" id="side_banner" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_city_guide['side_banner'] != '' ? asset('uploads/MediaPage/' . $get_city_guide['side_banner']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="image_banner_3" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- City Guide silder  --}}
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('City Slider details') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_slider_images as $LSI)
                                            @include('admin.City_guide._slider_images')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (count($get_slider_images) == 0)
                                            @include('admin.City_guide._slider_images')
                                        @endif
                                        <div class="show_overview">
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

                {{-- About Tab  --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark"> {{ translate('About') }}</h4>


                                    <div class="col-md-6">
                                        <label class="form-label" for="location_heading">{{ translate('Heading') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('location_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Heading') }}" id="location_heading"
                                            name="location_heading[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_city_guide_language, $lang_id, $get_city_guide['id'], 'location_heading', 'city_guide_id') }}" />
                                        @error('location_heading.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="title">{{ translate('Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('location_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Description') }}" id="title"
                                            name="location_description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_city_guide_language, $lang_id, $get_city_guide['id'], 'location_description', 'city_guide_id') }}
                                            </textarea>
                                        @error('location_description.' . $lang_id)
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


                {{-- Highlight --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Highlights') }}</h4>


                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_city_highlights as $HHL)
                                            @include('admin.City_guide._highlights')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_city_highlights))
                                            @include('admin.City_guide._highlights')
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


                {{-- Faqs --}}
                <li class="tab-content tab-content-6 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Faqs') }}</h4>


                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="faq_heading">{{ translate('Faq Heading') }}
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('faq_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Enter Faq Heading') }}" id="faq_heading"
                                            name="faq_heading[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_city_guide_language, $lang_id, $get_city_guide['id'], 'faq_heading', 'city_guide_id') }}" />
                                        @error('faq_heading.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_city_faqs as $CGF)
                                            @include('admin.City_guide._faqs')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_city_faqs))
                                            @include('admin.City_guide._faqs')
                                        @endif

                                        <div class="show_faqs">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_faqs" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
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

    <!-- Highlights -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.City_guide._highlights',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_choose');

                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_high", function(e) {
                var length = $(".delete_high").length;
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


    <!-- FAQS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_faqs').click(function(e) {

                var ParamArr = {
                    'view': 'admin.City_guide._faqs',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_faqs');

                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_faqs", function(e) {
                var length = $(".delete_faqs").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.faqs_div').remove();
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
                var length = $(".over_view_row").length;

                var ParamArr = {
                    'view': 'admin.City_guide._slider_images',
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
    <script>
        $(document).ready(function() {

            var state = "{{ old('state', $get_city_guide['state']) }}";
            var city = "{{ old('city', $get_city_guide['city']) }}";
            if (state != "") {
                setTimeout(() => {
                    getStateCity("country", state);
                    setTimeout(() => {
                        getStateCity("state", city);
                    }, 500);
                }, 500);
            }

            // Get Category By Country
            $(".country").change(function() {
                var country = $(this).val();
            })

        });
    </script>
@endsection
