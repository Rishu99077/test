@if (isset($params_arr))
    @php
        $banner_title_count = $params_arr['banner_title_count'];
        $banner_data = ['banner_title' => ''];
    @endphp
@endif

<div class="row banner_title_row">
    {{-- <div class="col-md-11">
        <div class="form-group mb-3 ">
            @if ($banner_title_count == 0)
                <label class="col-form-label">{{ translate('Banner Title') }}<span class="mandatory cls"
                        style="color:red;font-size:15px">*<span></label>
            @endif
            <input id="banner_title_{{ $banner_title_count }}" class="form-control banner_title" name="banner_title[]"
                type="text" value="{{ $GBT['meta_value'] }}" placeholder="{{ translate('Enter Banner Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div> --}}
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>
            <input id="banner_title_{{ $banner_title_count }}" class="form-control banner_title"
                name="page_content_multi[banner_title][{{ $banner_title_count }}][banner_title]" type="text"
                value="{{ $banner_data['banner_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-1">
        @if ($banner_title_count == 0)
            <button type="button" class="btn btn-success add_banner_title">
                <span class="fa fa-plus-square"></span>
            </button>
        @else
            <button type="button" class="btn btn-danger remove_banner_title">
                <span class="icofont icofont-delete-alt"></span>
            </button>
        @endif
    </div>
</div>
