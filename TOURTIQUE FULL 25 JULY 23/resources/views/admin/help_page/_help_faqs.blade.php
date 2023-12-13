@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $HelpPageLanguageDescription       = [];
        $get_help_page_highlights_language = [];
        $HPL                               = getTableColumn('help_faq_descriptions');
        $hl_cnt_                           =0;
    } else {
        $get_help_page_descripton_language = App\Models\HelpPageLanguage::where('help_page_id', 1)
            ->where('highlights_id', $TPH['id'])
            ->get();
    }
@endphp
<div class="row mb-3 show_faq_div">
    <input type="hidden" value="{{ $HPL['id'] }}" name="get_help_page_descripton_language_id[{{ $data }}][]">
   
    <div class="col-md-5 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('heading.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Heading ') }}" id="title"
            name="title[{{ $data }}][{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($HelpPageLanguageDescription, $lang_id, $HPL['id'], 'title', 'help_faq_description_id') }}" />
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label" for="title">{{ translate('Description') }}</label>
        <textarea
            class="form-control footer_text_{{ $data }}_{{ $hl_cnt_ }} {{ $errors->has('heading.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Description ') }}" id="title"
            name="description[{{ $data }}][{{ $lang_id }}][]" type="text" value="">{{ getLanguageTranslate($HelpPageLanguageDescription, $lang_id, $HPL['id'], 'description', 'help_faq_description_id') }}</textarea>
    </div>
    
    <div class="col-md-2 text-center">
        <div class="d-flex align-items-end h-100"><button class="delete_faqs bg-card btn btn-danger btn-sm float-end"
                type="button"><span class="fa fa-trash"></span></button></div>
    </div>
</div>

<script>
    // CKEDITOR.replaceAll('footer_text_{{ $data }}_{{ $hl_cnt_ }}');
</script>
