@if (isset($params_arr))
@php
$joinus_image_count = $params_arr['joinus_image_count'];
$join_us_image = array('joinus_image'=>'');
@endphp
@endif

<div class="row join_images_div why_join_us_images">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($joinus_image_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_join_image" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Join Us Images') }}</label>

            <input type="hidden" name="page_content_multi[why_join_us_images][{{ $joinus_image_count }}][hidden_joinus_image]" value="{{ $join_us_image['joinus_image'] != '' ? $join_us_image['joinus_image'] : '' }}">
            <input type="file" name="page_content_multi[why_join_us_images][{{ $joinus_image_count }}][joinus_image]" id="activies__{{ $joinus_image_count }}"
                value="" onchange="loadFile(event,'image_join_5_{{ $joinus_image_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_join_5_{{ $joinus_image_count }}"
                    src="{{ $join_us_image['joinus_image'] != '' ? url('uploads/pages', $join_us_image['joinus_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
</div>