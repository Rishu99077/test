@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.join_us_page.add') }}" enctype="multipart/form-data">
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
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Join Page Slider Images') }}"><i
                    class="icon-images"></i></label>         


            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Become a Partner') }}"><i
                    class="icon-voucher"></i></label>

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Why Join Us') }}"><i class="icon-faq"></i></label>    


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
                                    <input id="" name="id" type="hidden" value="{{ $get_join_us_page['id'] }}" />

                                   
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Banner Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Banner Title') }}" id="title"
                                            name="title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_join_us_page_language, $lang_id, $get_join_us_page['id'], 'title', 'join_page_id') }}" />
                                        @error('title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-6">
                                        <label class="form-label" for="short_description">{{ translate('Banner Short Description') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('short_description.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Banner Short Description') }}" id="short_description"
                                            name="short_description[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_join_us_page_language, $lang_id, $get_join_us_page['id'], 'short_description', 'join_page_id') }}" />
                                        @error('short_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                
                                
                                    <div class="col-md-6">
                                        <label class="form-label" for="description">{{ translate('Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Description') }}" id="title" name="description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_join_us_page_language, $lang_id, $get_join_us_page['id'], 'description', 'join_page_id') }}
                                         </textarea>
                                        @error('description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                   

                                    {{-- <div class="col-md-6 content_title mt-2">
                                        <label class="form-label" for="duration_from">{{ translate('Banner Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="banner_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'upload_work_logo')" id="banner_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_join_us_page['banner_image'] != '' ? Url('uploads/join_page', $get_join_us_page['banner_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="upload_work_logo" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
                                <div class="colcss">
                                    @php
                                        $overview_count = 0;
                                    @endphp
                                    @foreach ($get_banner_over_view as $GBO)
                                        @include('admin.join_page._banner_overview')
                                        @php
                                            $overview_count++;
                                        @endphp
                                    @endforeach
                                    @if (count($get_banner_over_view) == 0)
                                        @include('admin.join_page._banner_overview')
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


                {{-- Join Page silder  --}}           
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                       <div class="card mb-3">
                          <div class="card-body ">
                             <div class="row">
                                <h4 class="text-dark">{{ translate('Join Page Slider details') }}</h4>
                                <div class="colcss">
                                    @php
                                        $data = 0;
                                    @endphp
                                    @foreach ($get_slider_images as $LSI)
                                        @include('admin.join_page._slider_images')
                                        @php
                                            $data++;
                                        @endphp
                                    @endforeach
                                    @if (count($get_slider_images) == 0)
                                        @include('admin.join_page._slider_images')
                                    @endif
                                    <div class="show_image">
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

                {{-- Become a Partner Text  --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Become a Partner') }}</h4>

                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Become a Partner') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('become_partner_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('footer text') }}" id="become_partner_title"
                                            name="become_partner_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_join_us_page_language, $lang_id, $get_join_us_page['id'], 'become_partner_title', 'join_page_id') }}" />
                                        @error('become_partner_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                               
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Become a Partner Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('become_partner_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Become a Partner Description') }}" id="title" name="become_partner_description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_join_us_page_language, $lang_id, $get_join_us_page['id'], 'become_partner_description', 'join_page_id') }}
                                         </textarea>
                                        @error('become_partner_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    

                                    <div class="col-md-6 content_title mt-2">
                                        <label class="form-label" for="duration_from">{{ translate('Why Join Us Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="become_partner_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'upload_become_logo')" id="become_partner_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_join_us_page['become_partner_image'] != '' ? Url('uploads/join_page', $get_join_us_page['become_partner_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="upload_become_logo" width="100" alt="" />
                                                </div>
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
                                    <h4 class="text-dark">{{ translate('Why Join US') }}</h4>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_join_choose as $CHO)
                                            @include('admin.join_page._why_choose')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_join_choose))
                                            @include('admin.join_page._why_choose')
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

            </ul>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replaceAll('footer_text');
    </script>

    <!-- Slider Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".over_image_row").length;
                
                    var ParamArr = {
                        'view': 'admin.join_page._slider_images',
                        'data': count,
                    }
                    getAppendPage(ParamArr, '.show_image');
                    e.preventDefault();
                    count++;
                
            });


            $(document).on('click', ".over_image_delete", function(e) {
                var length = $(".over_image_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.over_image_row').remove();
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

    <!-- Why choose -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.join_page._why_choose',
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
