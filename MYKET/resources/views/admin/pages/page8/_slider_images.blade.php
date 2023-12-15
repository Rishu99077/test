@if (isset($params_arr))
@php
$slider_image_count = $params_arr['slider_image_count'];
$slider_image = array('slider_image'=>'');
@endphp
@endif

<div class="row slider_div slider_images">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($slider_image_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_slider_image" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Footer Slider Images') }}</label>

            <input type="hidden" name="page_content_multi[slider_images][{{ $slider_image_count }}][hidden_slider_image]" value="{{ $slider_image['slider_image'] != '' ? $slider_image['slider_image'] : '' }}">
            <input type="file" name="page_content_multi[slider_images][{{ $slider_image_count }}][slider_image]" id="activies__{{ $slider_image_count }}"
                value="" onchange="loadFile(event,'image_slider_5_{{ $slider_image_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_slider_5_{{ $slider_image_count }}"
                    src="{{ $slider_image['slider_image'] != '' ? url('uploads/pages', $slider_image['slider_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
</div>