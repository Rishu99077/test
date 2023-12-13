@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $help_pages_slider_language = [];
        $HPG = getTableColumn('pages_slider');
    }
@endphp
<div class="row with_us_div">
    <div>
        <button class="delete_with_us bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="help_banner_id[]" value="{{$HPG['id']}}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('with_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Title') }}" id="title" name="slider_title[{{ $lang_id }}][]"
            type="text" value="{{ getLanguageTranslate($help_pages_slider_language, $lang_id, $HPG['id'], 'title', 'pages_slider_id') }}" />
        @error('with_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">

        <label class="form-label" for="title">{{ translate('Description') }} </label>
        <textarea
            class="form-control footer_text  "
            placeholder="{{ translate('Enter  Description') }}" 
            name="slider_description[{{ $lang_id }}][]">{{ getLanguageTranslate($help_pages_slider_language, $lang_id, $HPG['id'], 'description', 'pages_slider_id') }}</textarea>
        @error('highlights_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
       

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_with_us_logo_{{$data}}{{$HPG['id']}}')" id="facility_image"/>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $HPG['image'] != '' ? asset('uploads/slider_images/' . $HPG['image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_with_us_logo_{{$data}}{{$HPG['id']}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
