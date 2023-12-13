@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_yatch_fetaure_highlight_language = [];
        $GYFH = getTableColumn('yacht_feature_highlight');
    }
@endphp
<div class="row row_feature_highlight">
    <input type="hidden" name="feature_highlight_id[]" value="{{$GYFH['id']}}">
    
        <div class="col-md-5">
            <label class="form-label" for="title">{{ translate('Feature Highlight Text') }}
            </label>
            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
                name="feature_highlight_title[{{ $lang_id }}][]" type="text"
                value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_fetaure_highlight_language, $lang_id, $GYFH['id'], 'title', 'feature_highlight_id')) }}" />
            <div class="invalid-feedback">

            </div>
        </div>
    <div class="col-md-2">
        <button class="delete_feature_highlight btn btn-danger btn-sm mt-5" type="button">
            <span class="fa fa-trash"></span>
        </button>
    </div>
</div>
