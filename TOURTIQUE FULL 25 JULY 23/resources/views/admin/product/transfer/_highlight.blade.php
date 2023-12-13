@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_highlights_language = [];
        $THS = getTableColumn('transfer_highlights');
    }
@endphp
<div class="row highlights_div">
    <div>
        <button class="delete_highlight bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="highlights_id[]" value="">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Higlights Title') }}
        </label>
        <input class="form-control {{ $errors->has('highlights_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Higlights Title') }}" id="title"
            name="highlights_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_transfer_highlights_language, $lang_id, $THS['id'], 'title', 'highlights_id') }}" />
        @error('highlights_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="col-md-6">    
        <label class="form-label" for="title">{{ translate('Higlights Description') }}
        </label>
        <textarea
            class="form-control footer_text footer_highlight_{{ $data }} {{ $errors->has('highlights_description.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Higlights Description') }}" id="footer_highlight_{{ $data }}"
            name="highlights_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_highlights_language, $lang_id, $THS['id'], 'description', 'highlights_id') }}</textarea>
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
    CKEDITOR.replaceAll('footer_highlight_{{ $data }}');
</script>
