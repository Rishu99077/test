@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_medial_social_language = [];
        $media_mension_social = getTableColumn('media_mension_social');
    }
@endphp
<div class="row faq_div">
    <div class="col-md-2 mb-3">
        <div class="form-group form-check form-switch pl-0">
            <input class="form-check-input float-end status switch_button"   id="status{{ $data }}" type="checkbox"
                value="Active" {{ $media_mension_social['status'] == 'Active' ? 'checked':'' }} name="status[]">
            <label class="form-check-label form-label" for="status{{ $data }}">Status
            </label>
        </div>
    </div>
    <div class="col-md-10 mb-3">
        <button class="delete_media bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="social_id[]" value="{{ $media_mension_social['id'] }}">
   
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('social_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Title') }}" id="social_title"
            name="social_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_medial_social_language, $lang_id, $media_mension_social['id'], 'title', 'social_id') }}" />
        @error('social_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Social Icon ') }} </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="icons[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'image_banner<?php echo $data; ?>')" id="icons" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $media_mension_social['image'] != '' ? url('uploads/MediaPage/media_mension_slider', $media_mension_social['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="image_banner{{ $data }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="link">{{ translate('Link') }} </label>
        <input class="form-control  {{ $errors->has('link') ? 'is-invalid' : '' }} "
            placeholder="{{ translate('Link') }}" value="{{ $media_mension_social['link'] }}" id="link"
            name="link[]" />
        @error('link')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
