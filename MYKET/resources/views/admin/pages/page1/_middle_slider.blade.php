@if (isset($params_arr))
    @php
        $middle_slider_count = $params_arr['middle_slider_count'];
        $Middle_slider = ['slider_image' => '', 'middle_slider_title' => '', 'middle_slider_link' => '', 'middle_slider_desc' => '', 'middle_slider_cloud' => ''];
    @endphp
@endif

<div class="row middle_slider_row">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($middle_slider_count > 0)
            <button type="button" class="btn btn-danger btn-sm float-right" id="remove_middle_slider"> <span
                    class="icofont icofont-delete-alt"></span>
            </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden"
                name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][hidden_slider_image]"
                value="{{ $Middle_slider['slider_image'] != '' ? $Middle_slider['slider_image'] : '' }}">
            <input type="file"
                name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][slider_image]"
                id="slider_image_{{ $middle_slider_count }}" value=""
                onchange="loadFile(event,'image_7_{{ $middle_slider_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;" id="image_7_{{ $middle_slider_count }}"
                    src="{{ $Middle_slider['slider_image'] != '' ? url('uploads/pages', $Middle_slider['slider_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>
            <input id="middle_slider_title_{{ $middle_slider_count }}" class="form-control middle_slider_title"
                name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][middle_slider_title]"
                type="text" value="{{ $Middle_slider['middle_slider_title'] }}"
                placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
        {{-- <div class="media-left">
            <div class="checkbox-fade fade-in-primary">
                <label>
                    <input type="hidden"
                        name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][middle_slider_cloud]"
                        value="no">
                    <input type="checkbox" id="middle_slider_cloud_{{ $middle_slider_count }}"
                        name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][middle_slider_cloud]"
                        {{ getChecked('yes', @$Middle_slider['middle_slider_cloud']) }} value="yes">
                    <span class="cr">
                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                    </span> <span>Show Cloud</span>
                </label>
            </div>
        </div> --}}
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Link') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>
            <input id="middle_slider_link_{{ $middle_slider_count }}" class="form-control middle_slider_link"
                name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][middle_slider_link]"
                type="text" value="{{ $Middle_slider['middle_slider_link'] }}"
                placeholder="{{ translate('Enter any Link') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="middle_slider_desc_{{ $middle_slider_count }}" class="form-control middle_slider_desc"
                name="page_content_multi[middle_slider_data][{{ $middle_slider_count }}][middle_slider_desc]"
                type="text" value="{{ $Middle_slider['middle_slider_desc'] }}"
                placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>
