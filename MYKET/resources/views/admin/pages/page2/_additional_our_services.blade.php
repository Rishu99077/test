@if (isset($params_arr))
@php
$our_services_count = $params_arr['our_services_count'];
$our_services = array('our_services_image'=>'','our_services__additional_title'=>'');
@endphp
@endif

<div class="row our_services_div our_services">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($our_services_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_our_services" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden" name="page_content_multi[our_service][{{ $our_services_count }}][hidden_our_services_image]" value="{{ $our_services['our_services_image'] != '' ? $our_services['our_services_image'] : '' }}">
            <input type="file" name="page_content_multi[our_service][{{ $our_services_count }}][our_services_image]" id="our_service_{{ $our_services_count }}"
                value="" onchange="loadFile(event,'image_14_{{ $our_services_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_14_{{ $our_services_count }}"
                    src="{{ $our_services['our_services_image'] != '' ? url('uploads/pages', $our_services['our_services_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls" style="color:red;font-size:15px">*<span></label>
            <input id="our_service_add_title_{{ $our_services_count }}" class="form-control our_service_add_title" name="page_content_multi[our_service][{{ $our_services_count }}][our_services__additional_title]" type="text" value="{{ $our_services['our_services__additional_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>