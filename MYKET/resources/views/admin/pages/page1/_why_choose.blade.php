@if (isset($params_arr))
    @php
        $why_choose_count = $params_arr['why_choose_count'];
        $Why_Choose = ['why_choose_image' => '', 'why_choose_title' => '', 'why_choose_desc' => ''];
    @endphp
@endif

<div class="row why_choose_row">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($why_choose_count > 0)
            <button type="button" class="btn btn-danger btn-sm float-right" id="remove_why_choose"> <span
                    class="icofont icofont-delete-alt"></span>
            </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden"
                name="page_content_multi[why_choose_data][{{ $why_choose_count }}][hidden_why_choose_image]"
                value="{{ $Why_Choose['why_choose_image'] != '' ? $Why_Choose['why_choose_image'] : '' }}">
            <input type="file" name="page_content_multi[why_choose_data][{{ $why_choose_count }}][why_choose_image]"
                id="why_choose_image{{ $why_choose_count }}" value=""
                onchange="loadFile(event,'image_8_{{ $why_choose_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;" id="image_8_{{ $why_choose_count }}"
                    src="{{ $Why_Choose['why_choose_image'] != '' ? url('uploads/pages', $Why_Choose['why_choose_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}</label>
            <input id="why_choose_title_{{ $why_choose_count }}" class="form-control why_choose_title"
                name="page_content_multi[why_choose_data][{{ $why_choose_count }}][why_choose_title]" type="text"
                value="{{ $Why_Choose['why_choose_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="why_choose_desc_{{ $why_choose_count }}" class="form-control why_choose_desc"
                name="page_content_multi[why_choose_data][{{ $why_choose_count }}][why_choose_desc]" type="text"
                value="{{ $Why_Choose['why_choose_desc'] }}" placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>
