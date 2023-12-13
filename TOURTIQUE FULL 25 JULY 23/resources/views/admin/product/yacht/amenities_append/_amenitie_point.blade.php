@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_yatch_amenities_points_language = [];
        $_GYAP_value = getTableColumn('yacht_amenities_points');
    }
@endphp

<div class="row row_amenities row_amenities_{{ $data }}">
    <input type="hidden" name="aminities_point_id[{{ $data }}][]" value="{{$_GYAP_value['id']}}">
    
    <div class="col-md-5">
        <label class="form-label" for="title">{{ translate('Amenities Text') }}
        </label>
        <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
            name="aminities_point_key_title[{{ $data }}][{{ $lang_id }}][]" type="text"
            value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_amenities_points_language, $lang_id, $_GYAP_value['id'], 'title', 'point_amenities_id')) }}" />
        <div class="invalid-feedback"></div>
    </div>
    
    <div class="col-md-2">
        <button class="delete_amenities btn btn-danger btn-sm mt-4" type="button">
            <span class="fa fa-trash"></span>
        </button>
    </div>
</div>

