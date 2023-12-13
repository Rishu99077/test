@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_tooltip_language = [];
        $PTT = getTableColumn('product_tooltip');
    }
@endphp
<div class="row tooltip_div">
    <div>
        <button class="delete_tooltip bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="tooltip_id[]" value="">

    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="tooltip_title">{{ translate('Tool tip Title') }}
        </label>
        <input class="form-control {{ $errors->has('tooltip_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Tool tip Title') }}" id="tooltip_title"
            name="tooltip_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_tooltip_language, $lang_id, $PTT['id'], 'tooltip_title', 'tooltip_id') }}" />
        @error('tooltip_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <label class="form-label" for="tooltip_title">{{ translate('Tool tip Description') }}
        </label>
        <textarea
            class="form-control   {{ $errors->has('tooltip_description.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Tool tip Description') }}" id="footer_text_{{ $data }}"
            name="tooltip_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_tooltip_language, $lang_id, $PTT['id'], 'tooltip_description', 'tooltip_id') }}</textarea>
        @error('tooltip_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
        
    <div class="mt-3">
        <hr>
    </div>
</div>



