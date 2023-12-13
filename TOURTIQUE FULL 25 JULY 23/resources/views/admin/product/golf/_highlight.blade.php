@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_highlight_language = [];
        $GPH = getTableColumn('products_highlights');
    }
@endphp
<div class="row highlight_div">
    <div>
        <button class="delete_highlight bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="highlights_id[]" value="{{$GPH['id']}}">

    
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Disclaimer Title') }}
            </label>
            <input class="form-control {{ $errors->has('highlights_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Higlights Title') }}" id="title"
                name="highlights_title[{{ $lang_id }}][]" type="text"
                value="{{ getLanguageTranslate($get_product_highlight_language, $lang_id, $GPH['id'], 'title', 'highlight_id') }}" />
            @error('highlights_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <label class="form-label mt-2" for="title">{{ translate('Disclaimer Description') }}
            </label>
            <textarea
                class="form-control  footer_text footer_text_{{ $data }} {{ $errors->has('highlights_description.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Higlights Description') }}" id="footer_text_{{ $data }}"
                name="highlights_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_highlight_language, $lang_id, $GPH['id'], 'description', 'highlight_id') }}</textarea>
            @error('highlights_description.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
    <div class="mt-3">
        <hr>
    </div>
</div>



<script>
    CKEDITOR.replaceAll('footer_text_{{ $data }}');
</script>
