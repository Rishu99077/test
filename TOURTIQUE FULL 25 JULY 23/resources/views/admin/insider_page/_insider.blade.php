@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $insider_language = [];
        $FAC = getTableColumn('insider');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_media bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="facility_id[]" value="{{ $FAC['id'] }}">

    
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }}
            </label>
            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Title') }}" id="title" name="title[{{ $lang_id }}][]"
                type="text"
                value="{{ getLanguageTranslate($insider_language, $lang_id, $FAC['id'], 'title', 'insider_id') }}" />
            @error('title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
        <div class="col-md-6">
            <label class="form-label" for="title">{{ translate('Description') }} </label>
            <textarea class="form-control  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                placeholder="{{ translate('Enter  Description') }}" id="title"
                name="description[{{ $lang_id }}][]">
            {{ getLanguageTranslate($insider_language, $lang_id, $FAC['id'], 'description', 'insider_id') }}</textarea>
            @error('description.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
  

    <div class="col-md-6 content_title mt-2">
        <label class="form-label" for="duration_from">{{ translate('Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="image[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $data }}{{ $FAC['id'] }}')" id="image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $FAC['image'] != '' ? asset('uploads/insider/' . $FAC['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $data }}{{ $FAC['id'] }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 content_title mt-2">
        <label class="form-label" for="duration_from">{{ translate('Video Link') }} </label>
        <div class="input-group mb-3">
            <input class="form-control " type="text" value="{{ $FAC['video_link'] }}"
                placeholder="{{ translate('Enter Video Link') }}" name="video_link[]" id="video_link" />

            <div class="invalid-feedback">
            </div>
        </div>

    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
