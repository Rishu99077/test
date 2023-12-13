@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_HotelFaqLanguage = [];
        $FAQS = getTableColumn('hotel_faqs');
    }
@endphp
<div class="row mb-3 show_faq_div">
    <input type="hidden" value="faq_title_id[]">
    
        <div class="col-md-5 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }}</label>
            <input class="form-control {{ $errors->has('heading.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Heading ') }}" id="title" name="faq_title[{{$data}}][][{{ $lang_id }}]" type="text" value="{{ getLanguageTranslate($get_HotelFaqLanguage, $lang_id, $FAQS['id'], 'title', 'faqs_id') }}" />
        </div>
   

    <div class="col-md-2 text-center"><div class="d-flex align-items-end h-100"><button class="delete_faqs bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button></div></div>
</div>