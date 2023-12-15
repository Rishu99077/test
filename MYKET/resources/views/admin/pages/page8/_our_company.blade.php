@if (isset($params_arr))
    @php
        $our_company_count = $params_arr['our_company_count'];
        $our_company = ['our_company_logo' => '', 'our_company_title' => '', 'our_company_desc' => ''];
    @endphp
@endif

<div class="row activities_div our_company">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($our_company_count > 0)
            <button type="button" class="btn btn-danger btn-sm float-right delete_activity" id="remove_middle_slider">
                <span class="icofont icofont-delete-alt"></span>
            </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Join Us Logo') }}</label>

            <input type="hidden"
                name="page_content_multi[our_company_data][{{ $our_company_count }}][hidden_our_company_logo]"
                value="{{ $our_company['our_company_logo'] != '' ? $our_company['our_company_logo'] : '' }}">
            <input type="file"
                name="page_content_multi[our_company_data][{{ $our_company_count }}][our_company_logo]"
                id="company__{{ $our_company_count }}" value=""
                onchange="loadFile(event,'image_company_{{ $our_company_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_company_{{ $our_company_count }}"
                    src="{{ $our_company['our_company_logo'] != '' ? url('uploads/pages', $our_company['our_company_logo']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>
            <input id="activies_title_{{ $our_company_count }}" class="form-control our_company_title"
                name="page_content_multi[our_company_data][{{ $our_company_count }}][our_company_title]" type="text"
                value="{{ $our_company['our_company_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="activies_title_desc_{{ $our_company_count }}" class="form-control activies_title_desc"
                name="page_content_multi[our_company_data][{{ $our_company_count }}][our_company_desc]" type="text"
                value="{{ $our_company['our_company_desc'] }}" placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>
