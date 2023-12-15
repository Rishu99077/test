@if (isset($params_arr))
@php
$affiliate_count = $params_arr['affiliate_count'];
$affiliate = array('choose_affiliate_image'=>'','choose_title'=>'','choose_desc'=>'');
@endphp
@endif

<div class="row chhose_div why_choose_affiliate">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($affiliate_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_choose" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}</label>

            <input type="hidden" name="page_content_multi[why_choose_affiliate][{{ $affiliate_count }}][hidden_choose_affiliate_image]" value="{{ $affiliate['choose_affiliate_image'] != '' ? $affiliate['choose_affiliate_image'] : '' }}">
            <input type="file" name="page_content_multi[why_choose_affiliate][{{ $affiliate_count }}][choose_affiliate_image]" id="activies__{{ $affiliate_count }}"
                value="" onchange="loadFile(event,'image_choose_{{ $affiliate_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_choose_{{ $affiliate_count }}"
                    src="{{ $affiliate['choose_affiliate_image'] != '' ? url('uploads/pages', $affiliate['choose_affiliate_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls" style="color:red;font-size:15px">*<span></label>
            <input id="activies_title_{{ $affiliate_count }}" class="form-control choose_title" name="page_content_multi[why_choose_affiliate][{{ $affiliate_count }}][choose_title]" type="text" value="{{ $affiliate['choose_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>