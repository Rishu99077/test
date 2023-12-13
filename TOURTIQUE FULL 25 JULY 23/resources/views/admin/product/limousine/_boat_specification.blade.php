@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_yatch_boat_specification_language = [];
        $GYA                          = getTableColumn('yacht_boat_specification');
    }
@endphp
<div class="row row_amenities new_class p-3 m-1 mb-3">
    <input type="hidden" name="boat_specification_id[]" value="{{$GYA['id']}}">
   
    <div class="col-md-5">
        <label class="form-label" for="title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
            name="boat_specification_key_title[{{ $lang_id }}][]" type="text"
            value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_boat_specification_language, $lang_id, $GYA['id'], 'title', 'boat_specification_id')) }}" />
        <div class="invalid-feedback">

        </div>

        <label class="form-label" for="title">{{ translate('Text') }}
        </label>
        <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
            name="boat_specification_key_text[{{ $lang_id }}][]" type="text"
            value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_boat_specification_language, $lang_id, $GYA['id'], 'content', 'boat_specification_id')) }}" />
        <div class="invalid-feedback">

        </div>
    </div>
    
    <div class="col-md-2">
        <button class="delete_amenities btn btn-danger btn-sm mt-4" type="button">
            <span class="fa fa-trash"></span>
        </button>
    </div>
</div>
