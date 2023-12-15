@if (isset($params_arr))
@php
$dest_count = $params_arr['dest_count'];
$destination = array('destination_image'=>'','destination_title'=>'');
@endphp
@endif

<div class="row activities_div top_destinations">
    <div class="col-md-12 col-xl-12 remove_div">
        @if ($dest_count > 0)
        <button type="button" class="btn btn-danger btn-sm float-right delete_destination" id="remove_middle_slider">
            <span class="icofont icofont-delete-alt"></span>
        </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden" name="page_content_multi[top_destinations][{{ $dest_count }}][hidden_destination_image]" value="{{ $destination['destination_image'] != '' ? $destination['destination_image'] : '' }}">
            <input type="file" name="page_content_multi[top_destinations][{{ $dest_count }}][destination_image]" id="activies__{{ $dest_count }}"
                value="" onchange="loadFile(event,'image_4_{{ $dest_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_4_{{ $dest_count }}"
                    src="{{ $destination['destination_image'] != '' ? url('uploads/pages', $destination['destination_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Title') }}<span class="mandatory cls" style="color:red;font-size:15px">*<span></label>
            <input id="activies_title_{{ $dest_count }}" class="form-control destination_title" name="page_content_multi[top_destinations][{{ $dest_count }}][destination_title]" type="text" value="{{ @$destination['destination_title'] }}" placeholder="{{ translate('Enter Title') }}">
            <div class=" col-form-alert-label">
            </div>
        </div>
    </div>
</div>