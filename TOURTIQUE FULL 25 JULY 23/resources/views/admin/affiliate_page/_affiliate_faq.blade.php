@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_affiliate_page_faq_language = [];
        $FAQS = getTableColumn('pages_faq');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="faq_id[]" value="{{$FAQS['id']}}">
    
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Affiliate Faq Title') }}
            </label>
            <input class="form-control {{ $errors->has('question.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Affiliate Faq Title') }}" id="title" name="question[{{ $lang_id }}][]"
                type="text"
                value="{{ getLanguageTranslate($get_affiliate_page_faq_language, $lang_id, $FAQS['id'], 'question', 'page_faq_id') }}" />
            @error('question.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label" for="title">{{ translate('Affiliate Faq Answer') }} </label>
            <textarea class="form-control  {{ $errors->has('answer.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Affiliate Faq Answer') }}" id="title" name="answer[{{ $lang_id }}][]">{{ getLanguageTranslate($get_affiliate_page_faq_language, $lang_id, $FAQS['id'], 'answer', 'page_faq_id') }}
            </textarea>
            @error('answer.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
   
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
