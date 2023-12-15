@if (isset($params_arr))
@php
$work_count = $params_arr['work_count'];
$work = array('work_image'=>'','work_title'=>'','work_desc'=>'');
@endphp
@endif

<div class="row work_div how_it_work">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($work_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_work" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-4 col-xl-4">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}</label>

            <input type="hidden" name="page_content_multi[how_it_work][{{ $work_count }}][hidden_work_image]" value="{{ $work['work_image'] != '' ? $work['work_image'] : '' }}">
            <input type="file" name="page_content_multi[how_it_work][{{ $work_count }}][work_image]" id="activies__{{ $work_count }}"
                value="" onchange="loadFile(event,'image_4_{{ $work_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_4_{{ $work_count }}"
                    src="{{ $work['work_image'] != '' ? url('uploads/pages', $work['work_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls" style="color:red;font-size:15px">*<span></label>
            <input id="activies_title_{{ $work_count }}" class="form-control work_title" name="page_content_multi[how_it_work][{{ $work_count }}][work_title]" type="text" value="{{ $work['work_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Description') }}</label>
            <input id="activies_title_desc_{{ $work_count }}" class="form-control activies_title_desc" name="page_content_multi[how_it_work][{{ $work_count }}][work_desc]" type="text" value="{{ $work['work_desc'] }}" placeholder="{{ translate('Enter Description') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>