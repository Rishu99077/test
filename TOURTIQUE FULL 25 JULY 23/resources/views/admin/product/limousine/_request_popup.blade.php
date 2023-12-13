@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    
    if (isset($append)) {
        $get_product_request_popup_language = [];
        $POPUP = getTableColumn('product_request_popup');
    }
@endphp
<div class="row popup_div">
    <div>
        <button class="delete_popup bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="popup_id[]" value="{{ $POPUP['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="request_description">{{ translate('Description') }}<span class="text-danger">*</span>
        </label>
        <input class="form-control"
            placeholder="{{ translate('Enter Description') }}" id="request_description_{{ $lang_id }}_{{ $data }}"
            name="request_description[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_request_popup_language, $lang_id, $POPUP['id'], 'description', 'request_popup_id') }}" />
        <div class="invalid-feedback">
            
        </div>    
    </div>
    <div class="mb-2 mt-2">
        <hr>
    </div>
</div>
