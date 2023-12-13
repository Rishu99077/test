@extends('admin.layout.master')
@section('content')
    
    <form  method="POST"  action="{{ route('admin.hotel_page.add') }}" enctype="multipart/form-data">
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

        <button class="btn btn-success me-1 mb-1 backButton float-end"  type="submit"><span
                class="fas fa-save"></span>
            {{ $common['button'] }}
        </button>
        
        <div class="add_product add_product-effect-scale add_product-theme-1">

            <input type="radio" name="add_product"  checked id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
                    class="icon-general"></i></label> 

            <input type="radio" name="add_product"  id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Hotel Slider Images') }}"><i
                    class="icon-images"></i></label>   

            {{-- <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Affiliate about') }}"><i
                    class="icon-highlight"></i></label> --}}

            <input type="radio" name="add_product" id="tab7" class="tab-content-7 addProTab">
            <label for="tab7" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Amenities') }}"><i
                    class="icon-highlight"></i></label>

            {{-- <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('How it work') }}"><i
                    class="icon-faq"></i></label>         --}}

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Highlights') }}">
                <i class="icon-adver"></i></label>

            <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Faqs') }}"><i
                    class="icon-faq"></i></label>     

            <ul>

                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">        
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">

                                    <input id="" name="id" type="hidden" value="{{ $HotelPage['id'] }}" />
                                    <div class="row">
                                        <div class="col-md-6 content_title">
                                           <label class="form-label" for="duration_from">{{ translate('Title Icon') }}</label>
                                           <div class="input-group mb-3">
                                               <input class="form-control " type="file" name="title_icon" aria-describedby="basic-addon2" onchange="loadFile(event,'image_banner_3')" id="title_icon"/>
                                   
                                               <div class="invalid-feedback">
                                               </div>
                                           </div>
                                           <div class="col-lg-3 mt-2">
                                               <div class="avatar shadow-sm img-thumbnail position-relative blog-image-icon">
                                                   <div class="h-50 w-50  overflow-hidden position-relative">
                                                       <img src="{{ $HotelPage['title_icon'] != '' ? asset('uploads/MediaPage/' . $HotelPage['title_icon']) : asset('uploads/placeholder/placeholder.png') }}" id="image_banner_3" width="100" alt="" />
                                                   </div>
                                               </div>
                                           </div>
                                        </div> 

                                        
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">{{ translate('Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}" id="title" name="title[{{ $lang_id }}]"
                                                type="text"
                                                value="{{ getLanguageTranslate($HotelPageLanguage_hotel_page, $lang_id, $HotelPage['id'], 'title', 'hotel_id') }}" />
                                            @error('title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                      
                                    <div class="row">
                                        <div class="col-md-6 content_title">
                                           <label class="form-label" for="duration_from">{{ translate('Hotel View Icon') }}</label>
                                           <div class="input-group mb-3">
                                               <input class="form-control " type="file" name="hotel_view_icon" aria-describedby="basic-addon2" onchange="loadFile(event,'image_view')" id="hotel_view_icon"/>
                                   
                                               <div class="invalid-feedback">
                                               </div>
                                           </div>
                                           <div class="col-lg-3 mt-2">
                                               <div class="avatar shadow-sm img-thumbnail position-relative blog-image-icon">
                                                   <div class="h-50 w-50  overflow-hidden position-relative">
                                                       <img src="{{ $HotelPage['hotel_view_icon'] != '' ? asset('uploads/MediaPage/' . $HotelPage['hotel_view_icon']) : asset('uploads/placeholder/placeholder.png') }}" id="image_view" width="100" alt="" />
                                                   </div>
                                               </div>
                                           </div>
                                        </div> 

                                        
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">{{ translate('Hotel View') }}<span
                                                    class="text-danger">*</span>
                                            </label>

                                            <input class="form-control {{ $errors->has('hotel_view.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Hotel View') }}" id="hotel_view" name="hotel_view[{{ $lang_id }}]"
                                                type="text"
                                                value="{{ getLanguageTranslate($HotelPageLanguage_hotel_page, $lang_id, $HotelPage['id'], 'hotel_view', 'hotel_id') }}" />
                                            @error('hotel_view.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror   

                                        </div>
                                    </div>


                                    
                                    <div class="row">
                                        <div class="col-md-6 content_title">
                                           <label class="form-label" for="duration_from">{{ translate('Hotel Room Icon') }}</label>
                                           <div class="input-group mb-3">
                                               <input class="form-control " type="file" name="hotel_room_icon" aria-describedby="basic-addon2" onchange="loadFile(event,'image_room')" id="hotel_room_icon"/>
                                   
                                               <div class="invalid-feedback">
                                               </div>
                                           </div>
                                           <div class="col-lg-3 mt-2">
                                               <div class="avatar shadow-sm img-thumbnail position-relative blog-image-icon">
                                                   <div class="h-50 w-50  overflow-hidden position-relative">
                                                       <img src="{{ $HotelPage['hotel_room_icon'] != '' ? asset('uploads/MediaPage/' . $HotelPage['hotel_room_icon']) : asset('uploads/placeholder/placeholder.png') }}" id="image_room" width="100" alt="" />
                                                   </div>
                                               </div>
                                           </div>
                                        </div> 

                                        
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">{{ translate('Hotel Rooms') }}<span
                                                    class="text-danger">*</span>
                                            </label>

                                            <input class="form-control {{ $errors->has('hotel_rooms.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Hotel Rooms') }}" id="hotel_rooms" name="hotel_rooms[{{ $lang_id }}]"
                                                type="text"
                                                value="{{ getLanguageTranslate($HotelPageLanguage_hotel_page, $lang_id, $HotelPage['id'], 'hotel_room', 'hotel_id') }}" />
                                            @error('hotel_rooms.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror   

                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 content_title">
                                           <label class="form-label" for="duration_from">{{ translate('Bars Icon') }}</label>
                                           <div class="input-group mb-3">
                                               <input class="form-control " type="file" name="hotel_bar_icon" aria-describedby="basic-addon2" onchange="loadFile(event,'image_bar')" id="hotel_room_icon"/>
                                   
                                               <div class="invalid-feedback">
                                               </div>
                                           </div>
                                           <div class="col-lg-3 mt-2">
                                               <div class="avatar shadow-sm img-thumbnail position-relative blog-image-icon">
                                                   <div class="h-50 w-50  overflow-hidden position-relative">
                                                       <img src="{{ $HotelPage['hotel_bar_icon'] != '' ? asset('uploads/MediaPage/' . $HotelPage['hotel_bar_icon']) : asset('uploads/placeholder/placeholder.png') }}" id="image_bar" width="100" alt="" />
                                                   </div>
                                               </div>
                                           </div>
                                        </div> 

                                        
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">{{ translate('Bars') }}<span
                                                    class="text-danger">*</span>
                                            </label>

                                            <input class="form-control {{ $errors->has('hotel_bars.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Bars') }}" id="hotel_bars" name="hotel_bars[{{ $lang_id }}]"
                                                type="text"
                                                value="{{ getLanguageTranslate($HotelPageLanguage_hotel_page, $lang_id, $HotelPage['id'], 'hotel_bars', 'hotel_id') }}" />
                                            @error('hotel_bars.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror   

                                        </div>
                                    </div>


                                    <div class="col-md-12 content_title">

                                        <label class="form-label" for="title">{{ translate('Address') }}
                                        <span class="text-danger">*</span>
                                        </label>

                                        <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="3" cols="50"
                                        placeholder="{{ translate('Enter Location') }}" id="input_store_address_id" name="hotel_address">{{ $HotelPage['address'] }}</textarea>
                                        <input type="hidden" name="address_lattitude" id="address_lattitude"
                                        class="form-control" value="{{ $HotelPage['address_lattitude'] }}">
                                        <input type="hidden" name="address_longitude" id="address_longitude"
                                        class="form-control" value="{{ $HotelPage['address_longitude'] }}">

                                        <div class="invalid-feedback">
                                        </div>

                                    </div>

                                    <div class="col-md-6 content_title">
                                       <label class="form-label" for="duration_from">{{ translate('Side Image') }}
                                           <small>(792X450)</small> </label>
                                       <div class="input-group mb-3">
                                           <input class="form-control " type="file" name="side_image" aria-describedby="basic-addon2" onchange="loadFile(event,'image_banner_2')" id="side_image"/>
                               
                                           <div class="invalid-feedback">
                                           </div>
                                       </div>
                                       <div class="col-lg-3 mt-2">
                                           <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                               <div class="h-100 w-100  overflow-hidden position-relative">
                                                   <img src="{{ $HotelPage['side_image'] != '' ? asset('uploads/MediaPage/' . $HotelPage['side_image']) : asset('uploads/placeholder/placeholder.png') }}" id="image_banner_2" width="100" alt="" />
                                               </div>
                                           </div>
                                       </div>
                                    </div> 
                                    
                                    <div class="col-md-6 content_title">
                                       <label class="form-label" for="duration_from">{{ translate('Video URL') }} </label>
                                       <div class="input-group mb-3">
                                           <input class="form-control" type="text" name="video_url"  id="video_url"  value="{{$HotelPage['video_url']}}" />
                                       </div>
                                    </div>
                                    
                                    <div class="col-md-6 content_title">
                                       <label class="form-label" for="duration_from">{{ translate('Video thumbnail Image') }}</label>
                                       <div class="input-group mb-3">
                                           <input class="form-control " type="file" name="video_thumbnail" aria-describedby="basic-addon2" onchange="loadFile(event,'video_thum_banner')" id="video_thumbnail"/>
                               
                                           <div class="invalid-feedback">
                                           </div>
                                       </div>
                                       <div class="col-lg-3 mt-2">
                                           <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                               <div class="h-100 w-100  overflow-hidden position-relative">
                                                   <img src="{{ $HotelPage['video_thumbnail'] != '' ? asset('uploads/MediaPage/' . $HotelPage['video_thumbnail']) : asset('uploads/placeholder/placeholder.png') }}" id="video_thum_banner" width="100" alt="" />
                                               </div>
                                           </div>
                                       </div>
                                    </div>  
                    </div>
                </li>

                {{--Hotel Banners --}}
                <li class="tab-content tab-content-2 typography">        
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Hotel Slider Images') }}</h4>

                                    <div class="col-md-12">
                                       <div class="mb-3">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                                for="customFile">{{ translate('Hotel Slider Images') }} <span class="fas fa-info-circle"></span>
                                            </label>
                                            @php
                                                $data = 0;
                                            @endphp
                                            @foreach ($get_slider_images as $HSI)
                                                @include('admin.hotel_page._slider_images')
                                                @php
                                                    $data++;
                                                @endphp
                                            @endforeach
                                            @if (count($get_slider_images)==0)
                                                @include('admin.hotel_page._slider_images')
                                            @endif
                                            <div class="show_slider">
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
                                        @foreach ($get_hotel_highlights as $HHL)
                                            @include('admin.hotel_page._highlights')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_hotel_highlights))
                                            @include('admin.hotel_page._highlights')
                                        @endif

                                        <div class="show_choose">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button" id="add_choose"
                                                    title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>

                                    </div>     
                                </div>
                            </div>
                        </div>
                    </div>
                </li>  
                
                
                {{-- Amenities --}}
                <li class="tab-content tab-content-7 typography">        
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Amenities') }}</h4>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_hotel_amenities as $HA)
                                            @include('admin.hotel_page._amenities')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_hotel_amenities))
                                            @include('admin.hotel_page._amenities')
                                        @endif

                                        <div class="show_amenities">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button" id="add_amenities"
                                                    title='Add more'>
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
                        @php
                            $FAQ = 0;
                        @endphp
                        @foreach ($getHotelFaq as $FAQ_data)
                            @include('admin.hotel_page._faq')
                            @php
                                $FAQ++;
                            @endphp
                        @endforeach
                        @if (empty($getHotelFaq))
                            @include('admin.hotel_page._faq')
                        @endif

                        <div class="show_faqs">
                        </div>
                        <div class="row">
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm float-end" type="button" id="add_faq"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
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

<!-- FAQ page -->
<script type="text/javascript">
   $(document).ready(function() {
      
       var count = '{{$FAQ}}';
       $('#add_faq').click(function(e) {
           var ParamArr = {
               'view': 'admin.hotel_page._faq',
               'data': count
           } 
           getAppendPage(ParamArr, '.show_faqs');
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_high", function(e) {
           var length = $(".delete_high").length;
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
<!-- add more faq -->
<script type="text/javascript">
        count = 1;
        $(document).on("click", ".add_more_faqs", function(e) {
            var DataID = $(this).data('val');
     
            var ParamArr = {
                'view': 'admin.hotel_page._add_more_faq',
                'data': DataID,
                'id': count,
            }
            getAppendPage(ParamArr, '.more_faq_' + DataID);
            e.preventDefault();
            count++;
        });

        $(document).on('click', ".delete_faqs", function(e) {
            var length = $(".delete_faqs").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.show_faq_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });
</script>

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


        $(document).on('click', ".delete_highlight", function(e) {
            var length = $(".highlight_div").length;
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



<script>
    $(document).ready(function() {
       var count = 1;
        $('#add_amenities').click(function(e) {

            var ParamArr = {
                'view': 'admin.hotel_page._amenities',
                'data': count
            }
            getAppendPage(ParamArr, '.show_amenities');

            e.preventDefault();
            count++;
        });
        });
</script>


<!-- Why chooose affiliate -->
<script type="text/javascript">
    $(document).ready(function() {
        var count = 1;
        $('#add_choose').click(function(e) {

            var ParamArr = {
                'view': 'admin.hotel_page._highlights',
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
                        'view': 'admin.hotel_page._slider_images',
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

@endsection
