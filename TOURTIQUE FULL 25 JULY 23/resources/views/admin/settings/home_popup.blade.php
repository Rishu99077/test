@extends('admin.layout.master')
@section('content')
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
    <form action="{{ route('admin.home_popup') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="colcss">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group form-check form-switch pl-0">
                        <input class="form-check-input float-end status switch_button" id="popup_status"
                            {{ $Homepopup['popup_status'] === 'Active' ? 'checked' : '' }} type="checkbox" value="Active"
                            name="popup_status">
                    </div>
                </div>

                <div class="col-md-6 content_title">
                    <label class="form-label" for="duration_from">{{ translate('Pop Up Image') }}
                    </label>
                    <div class="input-group mb-3">
                        <input class="form-control " type="file" name="pro_popup_image" aria-describedby="basic-addon2"
                            onchange="loadFile(event,'popup_image')" id="pro_popup_image" />
                        <input type="hidden" name="pro_popup_image_dlt" value="{{ $Homepopup['popup_image'] }}">
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls popup_imgs img-pro-preview"
                        style="display:none;">

                        <div>
                            <button class="delete_pro_pop bg-card btn btn-danger btn-sm float-end" type="button"><span
                                    class="fa fa-trash"></span></button>
                        </div>
                        <div class="h-100 w-100  overflow-hidden position-relative">
                            <img style="width: 100px;height: 100px;"
                                src="{{ $Homepopup['popup_image'] != '' ? asset('uploads/product_images/' . $Homepopup['popup_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                id="popup_image" width="100" alt="" />
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 content_title">
                    <label class="form-label" for="price">{{ translate('Pop Up Video Link') }}
                    </label>

                    <input class="form-control" placeholder="{{ translate('Pop Up Link') }}" id="title"
                        name="pro_popup_link" type="text" value="{{ $Homepopup['popup_link'] }}" />
                </div>

                <div class="col-md-6 content_title">
                    <label class="form-label" for="duration_from">{{ translate(' Pop Up Thumnail Image') }}
                    </label>
                    <div class="input-group mb-3">
                        <input class="form-control " type="file" name="pro_popup_thumnail_image"
                            aria-describedby="basic-addon2" onchange="loadFile(event,'home_popup_thumnail_image_')"
                            id="pro_popup_thumnail_image" />
                        <input type="hidden" name="pro_popup_thumnail_image_dlt"
                            value="{{ $Homepopup['thumbnail_image'] }}">

                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls popup_thumnail_imgs"
                        style="display:none;">

                        <div>
                            <button class="delete_popup_thumnail_image bg-card btn btn-danger btn-sm float-end"
                                type="button"><span class="fa fa-trash"></span></button>
                        </div>

                        <div class="h-100 w-100  overflow-hidden position-relative">
                            <img style="width: 100px;height: 100px;"
                                src="{{ $Homepopup['thumbnail_image'] != '' ? asset('uploads/product_images/popup_image/' . $Homepopup['thumbnail_image']) : asset('uploads/placeholder/placeholder.png') }}"
                                id="home_popup_thumnail_image_" width="100" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6 content_title">
                    <label class="form-label" for="price">{{ translate('Redirection Link') }}
                    </label>

                    <input class="form-control" placeholder="{{ translate('Redirection Link') }}" id="title"
                        name="redirection_link" type="text" value="{{ $Homepopup['link'] }}" />
                </div>

                <div class="col-md-6 content_title">
                    <label class="form-label" for="duration_from">{{ translate('Pop Up Video') }}</label>
                    <div class="input-group mb-3">
                        <input class="form-control " type="file" name="pro_popup_video" aria-describedby="basic-addon2"
                            id="pro_popup_video" />
                        <input type="hidden" name="pro_popup_video_dlt" value="{{ $Homepopup['video'] }}">
                        <div class="invalid-feedback">
                        </div>
                    </div>

                    @if ($Homepopup['video'] != '')
                        <div class="avatar popup_video shadow-sm img-thumbnail position-relative blog-image-cls">
                            <div class="h-100 w-100  overflow-hidden position-relative">
                                @if ($Homepopup['video'] != '')
                                    <button class="delete_popup_video bg-card btn btn-danger btn-sm float-end"
                                        type="button"><span class="fa fa-trash"></span></button>
                                    <video width="150" height="150"
                                        src="{{ asset('uploads/product_images/popup_image/' . $Homepopup['video']) }}"
                                        controls>
                                    </video>
                                @endif

                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @foreach($HomepopupLanguage as $key => $value)
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"
                            for="price">{{ translate('Pop Up Title') }}
                        </label>

                        <input class="form-control" placeholder="{{ translate('Pop Up Title') }}"
                            id="pro_popup_title_{{ $lang_id }}" name="title[{{ $lang_id }}]" type="text"
                             value="{{$value['title']}}" />
                        <div class="invalid-feedback">

                        </div>

                    </div>
               
                    <div class="col-md-6">
                        <label class="form-label"
                            for="popup_heading">{{ translate('Pop Up Description') }}<span
                                class="text-danger">*</span>
                        </label>
                        <textarea class="form-control editor {{ $errors->has('pro_popup_desc.' . $lang_id) ? 'is-invalid' : '' }}"
                            rows="8" id="pro_popup_desc_{{ $lang_id }}" name="description[{{ $lang_id }}]"
                            placeholder="{{ translate('Pop Up Description') }}">{{ $value['description'] }}</textarea>

                        <div class="invalid-feedback">

                        </div>
                    </div>
                </div>
            @endforeach    

            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-end"> <span class="fa fa-save"></span>
                        {{ translate('Save') }}</button>
                </div>
            </div>
        </div>

    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_pro_pop", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.popup_imgs').css("display", "none");
                        $("input[name='pro_popup_image_dlt']").val('');
                        $("input[name='pro_popup_image']").val('');
                        e.preventDefault();
                    }
                });

            });

            <?php if ($Homepopup['popup_image']) { ?>
            $('.img-pro-preview').show();
            <?php } ?>

            $(document).on('change', "#pro_popup_image", function(e) {
                $('.img-pro-preview').show();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_popup_thumnail_image", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.popup_thumnail_imgs').css("display", "none");
                        $("input[name='pro_popup_thumnail_image_dlt']").val('');
                        $("input[name='pro_popup_thumnail_image']").val('');
                        e.preventDefault();
                    }
                });

            });

            <?php if ($Homepopup['thumbnail_image']) { ?>
            $('.popup_thumnail_imgs').show();
            <?php } ?>

            $(document).on('change', "#pro_popup_thumnail_image", function(e) {
                $('.popup_thumnail_imgs').show();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_popup_video", function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.popup_video').css("display", "none");
                        $("input[name='pro_popup_video_dlt']").val('');
                        $("input[name='pro_popup_video']").val('');
                        e.preventDefault();
                    }
                });

            });

        }); <
        />
    </script>
@endsection
