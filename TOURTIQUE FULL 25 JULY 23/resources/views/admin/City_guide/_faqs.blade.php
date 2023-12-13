@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_city_faqs_language = [];
        $CGF = getTableColumn('city_guide_faq');
    }
@endphp
<div class="row faqs_div">
    <div>
        <button class="delete_faqs bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="faq_id[]" value="{{$CGF['id']}}">

    
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }}
            </label>
            <input class="form-control {{ $errors->has('faq_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Title') }}" id="title" name="faq_title[{{ $lang_id }}][]"
                type="text" value="{{ getLanguageTranslate($get_city_faqs_language, $lang_id, $CGF['id'], 'title', 'faq_id') }}" />
            @error('faq_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <label class="form-label" for="title">{{ translate('Description') }} </label>
            <textarea class="form-control  {{ $errors->has('faq_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text footer_text_{{$data}}{{$CGF['id']}}" placeholder="{{ translate('Enter Description') }}" id="title" name="faq_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_city_faqs_language, $lang_id, $CGF['id'], 'description', 'faq_id') }}
            </textarea>
            @error('faq_description.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    

    
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
<script>
    CKEDITOR.replaceAll('footer_text_{{$data}}{{$CGF['id']}}');
</script>