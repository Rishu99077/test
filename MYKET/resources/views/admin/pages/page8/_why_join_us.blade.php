@if (isset($params_arr))
    @php
        $joinus_count = $params_arr['joinus_count'];
        $join_us = ['joinus_logo' => '', 'joinus_title' => '', 'joinus_desc' => ''];
    @endphp
@endif

<div class="row activities_div why_join_us">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($joinus_count > 0)
            <button type="button" class="btn btn-danger btn-sm float-right delete_activity" id="remove_middle_slider">
                <span class="icofont icofont-delete-alt"></span>
            </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Join Us Logo') }}</label>

            <input type="hidden" name="page_content_multi[why_join_us][{{ $joinus_count }}][hidden_joinus_logo]"
                value="{{ $join_us['joinus_logo'] != '' ? $join_us['joinus_logo'] : '' }}">
            <input type="file" name="page_content_multi[why_join_us][{{ $joinus_count }}][joinus_logo]"
                id="activies__{{ $joinus_count }}" value=""
                onchange="loadFile(event,'image_4_{{ $joinus_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;" id="image_4_{{ $joinus_count }}"
                    src="{{ $join_us['joinus_logo'] != '' ? url('uploads/pages', $join_us['joinus_logo']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>
            <input id="activies_title_{{ $joinus_count }}" class="form-control joinus_title"
                name="page_content_multi[why_join_us][{{ $joinus_count }}][joinus_title]" type="text"
                value="{{ $join_us['joinus_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="activies_title_desc_{{ $joinus_count }}" class="form-control activies_title_desc"
                name="page_content_multi[why_join_us][{{ $joinus_count }}][joinus_desc]" type="text"
                value="{{ $join_us['joinus_desc'] }}" placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>
