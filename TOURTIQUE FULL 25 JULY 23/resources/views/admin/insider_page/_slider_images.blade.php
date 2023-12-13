@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $LSI  = getTableColumn('pages_slider');
    }

@endphp
<div class="row over_view_row">
    <div>
        <button class="over_view_delete bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="over_view_id[]" value="{{$LSI['id']}}">
       
    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Golf Slider Image') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="slider_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'slider_image_{{$data}}{{$LSI['id']}}')" id="slider_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $LSI['image'] != '' ? asset('uploads/slider_images/' . $LSI['image']) : asset('uploads/placeholder/placeholder.png') }}" id="slider_image_{{$data}}{{$LSI['id']}}" width="100" alt="" /> 
                </div>
            </div>
        </div>
    </div> 
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

