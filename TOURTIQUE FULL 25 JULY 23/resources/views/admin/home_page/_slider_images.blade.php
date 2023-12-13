@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_slider_images_language = [];
        $HSI  = getTableColumn('pages_slider');
    }
@endphp
<div class="row slider_row">
    <div>
        <button class="slider_delete bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="slider_img_id[]" value="{{ $HSI['id'] }}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('slider_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Title') }}" id="slider_title" name="slider_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_slider_images_language, $lang_id, $HSI['id'], 'title', 'pages_slider_id') }}" />
        @error('slider_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="col-md-6">
        <label class="form-label" for="description">{{ translate('Description') }}</label>
        <input class="form-control {{ $errors->has('slider_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Description') }}" id="slider_description" name="slider_description[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_slider_images_language, $lang_id, $HSI['id'], 'description', 'pages_slider_id') }}" />

        @error('slider_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Home Slider Image') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="slider_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'slider_image_{{$data}}{{$HSI['id']}}')" id="slider_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $HSI['image'] != '' ? asset('uploads/slider_images/' . $HSI['image']) : asset('uploads/placeholder/placeholder.png') }}" id="slider_image_{{$data}}{{$HSI['id']}}" width="100" alt="" /> 
                </div>
            </div>
        </div>
    </div> 
    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('logo') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="logo_main[]" aria-describedby="basic-addon2" onchange="loadFile(event,'logo_{{$data}}{{$HSI['id']}}')" id="logo_main"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $HSI['main_logo'] != '' ? asset('uploads/slider_images/main_logo/' . $HSI['main_logo']) : asset('uploads/placeholder/placeholder.png') }}" id="logo_{{$data}}{{$HSI['id']}}" width="100" alt="" /> 
                </div>
            </div>
        </div>
    </div> 
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

