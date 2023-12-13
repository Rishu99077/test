@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_middle_slider_images_language = [];
        $MSI  = getTableColumn('pages_slider');
    }
@endphp
<div class="row middle_slider_row">
    <div>
        <button class="middle_slider_delete bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="middle_slider_id[]" value="{{ $MSI['id'] }}">


    
    {{--<div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('middle_slider_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Title') }}" id="middle_slider_title" name="middle_slider_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_middle_slider_images_language, $lang_id, $MSI['id'], 'title', 'pages_slider_id') }}" />
        @error('middle_slider_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="col-md-6">
        <label class="form-label" for="description">{{ translate('Description') }}</label>
        <textarea class="form-control footer_text  {{ $errors->has('middle_slider_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Description') }}" id="footer_text" name="middle_slider_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_middle_slider_images_language, $lang_id, $MSI['id'], 'description', 'pages_slider_id') }}</textarea>
        @error('middle_slider_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>--}}



    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Home Slider Image') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="middle_slider_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'middle_slider_image_{{$data}}{{$MSI['id']}}')" id="middle_slider_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $MSI['image'] != '' ? asset('uploads/slider_images/' . $MSI['image']) : asset('uploads/placeholder/placeholder.png') }}" id="middle_slider_image_{{$data}}{{$MSI['id']}}" width="100" alt="" /> 
                </div>
            </div>
        </div>
    </div> 
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

