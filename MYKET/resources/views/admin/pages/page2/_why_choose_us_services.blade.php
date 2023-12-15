@if (isset($params_arr))
@php
$why_choose_service_count = $params_arr['why_choose_service_count'];
$why_choose_us_services = array('why_choose_us_image'=>'','why_choose_us_title'=>'','why_choose_us_desc'=>'');
@endphp
@endif

<div class="row services_div why_choose_services">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($why_choose_service_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_services" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden" name="page_content_multi[why_choose_us][{{ $why_choose_service_count }}][hidden_why_choose_us_image]" value="{{ $why_choose_us_services['why_choose_us_image'] != '' ? $why_choose_us_services['why_choose_us_image'] : '' }}">
            <input type="file" name="page_content_multi[why_choose_us][{{ $why_choose_service_count }}][why_choose_us_image]" id="why_choose_{{ $why_choose_service_count }}"
                value="" onchange="loadFile(event,'image_4_{{ $why_choose_service_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_4_{{ $why_choose_service_count }}"
                    src="{{ $why_choose_us_services['why_choose_us_image'] != '' ? url('uploads/pages', $why_choose_us_services['why_choose_us_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls" style="color:red;font-size:15px">*<span></label>
            <input id="why_choose_title_{{ $why_choose_service_count }}" class="form-control why_choose_title" name="page_content_multi[why_choose_us][{{ $why_choose_service_count }}][why_choose_us_title]" type="text" value="{{ $why_choose_us_services['why_choose_us_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="why_choose_desc_{{ $why_choose_service_count }}" class="form-control why_choose_desc" name="page_content_multi[why_choose_us][{{ $why_choose_service_count }}][why_choose_us_desc]" type="text" value="{{ $why_choose_us_services['why_choose_us_desc'] }}" placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>