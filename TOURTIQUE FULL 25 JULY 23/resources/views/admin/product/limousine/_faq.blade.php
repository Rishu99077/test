@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
$lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_faq_language = [];
        $GPF = getTableColumn('products_highlights');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="faq_id[]" value="{{$GPF['id']}}">
    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Faq Title') }}<span class="text-danger">*</span>
        </label>
        <input class="form-control {{ $errors->has('question.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Faq Title') }}" id="question_{{ $lang_id }}_{{ $data }}" name="question[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_product_faq_language, $lang_id, $GPF['id'], 'question', 'faq_id') }}" />
        
        <div class="invalid-feedback">
            
        </div>
        

        <label class="form-label" for="title">{{ translate('Faq Answer') }}<span class="text-danger">*</span>
        </label>
        <textarea class="form-control  {{ $errors->has('answer.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Faq Answer') }}" id="answer_{{ $lang_id }}_{{ $data }}" name="answer[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_faq_language, $lang_id, $GPF['id'], 'answer', 'faq_id') }}
        </textarea>
        
        <div class="invalid-feedback">
            
        </div>
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
