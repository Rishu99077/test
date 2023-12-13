@php
    if (isset($append)) {
        $LOCS = getTableColumn('city_guide_page_locations');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_media bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="location_id[]" value="{{$LOCS['id']}}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Location label') }} </label>
        <input class="form-control {{ $errors->has('location_label') ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Location label') }}" id="title" name="location_label[]" type="text" value="{{ $LOCS['location_label'] }}" />
        @error('location_label')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Location Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="location_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo_{{$LOCS["id"]}}_{{$data}}')" id="location_image"/>
            
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $LOCS['location_image'] != '' ? asset('uploads/MediaPage/' . $LOCS['location_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo_{{$LOCS['id']}}_{{$data}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
