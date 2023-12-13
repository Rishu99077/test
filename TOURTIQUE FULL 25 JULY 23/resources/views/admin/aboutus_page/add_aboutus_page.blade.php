@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.about_us_page.add') }}" enctype="multipart/form-data">
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
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('About us Page Slider Images') }}"><i
         class="icon-images"></i></label> 

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Our Vision') }}"><i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Details') }}"><i
                    class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Facilities') }}"><i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Why Choose') }}"><i class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab7" class="tab-content-7 addProTab">
            <label for="tab7" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Service List') }}"><i class="icon-extra"></i></label>    

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark"> {{ translate('General') }}</h4>

                                    <input id="" name="id" type="hidden"
                                        value="{{ $get_about_us_page['id'] }}" />

                                  
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="title">{{ translate('Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}" id="title"
                                                name="title[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'title', 'about_us_page_id') }}" />
                                            @error('title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                   
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="title">{{ translate('Description') }}
                                            </label>
                                            <textarea class="form-control  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                                placeholder="{{ translate('Enter Description') }}" id="title" name="description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'description', 'about_us_page_id') }}
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
                                                onchange="loadFile(event,'upload_work_logo')"
                                                id="banner_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_about_us_page['banner_image'] != '' ? Url('uploads/AboutUsPage',$get_about_us_page['banner_image'])  : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="upload_work_logo" width="100"
                                                        alt="" />
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
                                     @include('admin.aboutus_page._banner_overview')
                                     @php
                                         $overview_count++;
                                     @endphp
                                 @endforeach
                                 @if (count($get_banner_over_view) == 0)
                                     @include('admin.aboutus_page._banner_overview')   
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
                 <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                       <div class="card mb-3">
                          <div class="card-body ">
                             <div class="row">
                                <h4 class="text-dark">{{ translate('About us Page Slider details') }}</h4>
                                <div class="colcss">
                                    @php
                                        $data = 0;
                                    @endphp
                                    @foreach ($get_slider_images as $LSI)
                                        @include('admin.aboutus_page._slider_images')
                                        @php
                                            $data++;
                                        @endphp
                                    @endforeach
                                    @if (count($get_slider_images) == 0)
                                        @include('admin.aboutus_page._slider_images')
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

                {{-- About Us Our Vision  --}}
                <li class="tab-content tab-content-3 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Our Vision') }}</h4>

                                   
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="vision_title">{{ translate('Vision Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('vision_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Vision Title') }}" id="vision_title"
                                            name="vision_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'vision_title', 'about_us_page_id') }}" />
                                        @error('vision_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                  

                                    
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Vision Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('vision_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Vision Description') }}" id="title"
                                            name="vision_description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'vision_description', 'about_us_page_id') }}
                                        </textarea>
                                        @error('vision_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                   

                                    <div class="col-md-6 content_title">
                                        <label class="form-label" for="duration_from">{{ translate('Vision Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="vision_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'vision_image_')" id="vision_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_about_us_page['vision_image'] != '' ? asset('uploads/AboutUsPage/' . $get_about_us_page['vision_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="vision_image_" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- About Us Details  --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Details') }}</h4>

                                   
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="detail_title">{{ translate('Detail Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('detail_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Detail Title') }}" id="detail_title"
                                            name="detail_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'detail_title', 'about_us_page_id') }}" />
                                        @error('detail_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                               
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Detail Description') }}
                                        </label>
                                        <textarea class="form-control  {{ $errors->has('detail_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                            placeholder="{{ translate('Enter Detail Description') }}" id="title"
                                            name="detail_description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'detail_description', 'about_us_page_id') }}
                                        </textarea>
                                        @error('detail_description.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                   

                                    <div class="col-md-6 content_title">
                                        <label class="form-label" for="duration_from">{{ translate('About Us Image') }}
                                            <small>(792X450)</small> </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control " type="file" name="detail_image"
                                                aria-describedby="basic-addon2"
                                                onchange="loadFile(event,'detail_image_')" id="detail_image" />

                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                <div class="h-100 w-100  overflow-hidden position-relative">
                                                    <img src="{{ $get_about_us_page['detail_image'] != '' ? asset('uploads/AboutUsPage/' . $get_about_us_page['detail_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        id="detail_image_" width="100" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- About Us Facilities  --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Facilities') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_about_us_facility as $GPF)
                                            @include('admin.aboutus_page._facilities')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_about_us_facility))
                                            @include('admin.aboutus_page._facilities')
                                        @endif
                                        <div class="show_works">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_works" title='Add more'>
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
                <li class="tab-content tab-content-6 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Why choose Tourtastique?') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_about_us_choose as $CHO)
                                            @include('admin.aboutus_page._why_choose')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_about_us_choose))
                                            @include('admin.aboutus_page._why_choose')
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


                {{-- Service List  --}}
                <li class="tab-content tab-content-7 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Service List') }}</h4>

                                    
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Service Heading Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('service_heading_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Service Heading Title') }}" id="service_heading_title"
                                            name="service_heading_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_about_us_page_language, $lang_id, $get_about_us_page['id'], 'service_heading_title', 'about_us_page_id') }}" />
                                        @error('service_heading_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                  

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_about_us_service as $APS)
                                            @include('admin.aboutus_page._services')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_about_us_service))
                                            @include('admin.aboutus_page._services')
                                        @endif
                                        <div class="show_service">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_service" title='Add more'>
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

    <!-- Slider -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".slider_row").length;
                
                    var ParamArr = {
                        'view': 'admin.aboutus_page._slider_images',
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


    <!-- Why choose -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.aboutus_page._why_choose',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_choose');

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


    <!-- Services -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_service').click(function(e) {

                var ParamArr = {
                    'view': 'admin.aboutus_page._services',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_service');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_service", function(e) {
                var length = $(".delete_service").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.sevice_div').remove();
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


    <!-- Facilities -->
    <script type="text/javascript">
      $(document).ready(function() {
          var count = "{{ $overview_count}}";
          $('#add_banner_overview').click(function(e) {
            var length = $(".over_view_row").length;
            console.log("length",length)
            if(length <= 3){
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
