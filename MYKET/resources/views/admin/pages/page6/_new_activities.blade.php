@if (isset($params_arr))
@php
$activities_count = $params_arr['activities_count'];
$new_activity = array('activities_image'=>'','activity_title'=>'','activities_desc'=>'');
@endphp
@endif

<div class="row activities_div new_activities">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($activities_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_activity" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden" name="page_content_multi[new_activities][{{ $activities_count }}][hidden_activities_image]" value="{{ $new_activity['activities_image'] != '' ? $new_activity['activities_image'] : '' }}">
            <input type="file" name="page_content_multi[new_activities][{{ $activities_count }}][activities_image]" id="activies__{{ $activities_count }}"
                value="" onchange="loadFile(event,'image_4_{{ $activities_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_4_{{ $activities_count }}"
                    src="{{ $new_activity['activities_image'] != '' ? url('uploads/pages', $new_activity['activities_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls" style="color:red;font-size:15px">*<span></label>
            <input id="activies_title_{{ $activities_count }}" class="form-control activity_title" name="page_content_multi[new_activities][{{ $activities_count }}][activity_title]" type="text" value="{{ $new_activity['activity_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="activies_title_desc_{{ $activities_count }}" class="form-control activies_title_desc" name="page_content_multi[new_activities][{{ $activities_count }}][activities_desc]" type="text" value="{{ $new_activity['activities_desc'] }}" placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>