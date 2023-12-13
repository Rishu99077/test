@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_hotel_highlights_language = [];
        $HHL = getTableColumn('hotel_page');
    }
@endphp
<div class="row highlight_div">
    <div>
        <button class="delete_highlight bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="highlight_id[]" value="{{$HHL['id']}}">
  
   
    <div class="col-md-6">
        <label class="form-label" for="price">{{ translate('Title') }} </label>
        <input type="text" name="highlight_title[{{ $lang_id }}][]" class="form-control" placeholder="Enter {{ translate('Title') }}" value="{{ getLanguageTranslate($get_hotel_highlights_language, $lang_id, $HHL['id'], 'title', 'highlight_id') }}">
        
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="highlight_description">{{ translate('Description') }} </label>
        <textarea class="form-control  footer_text" placeholder="{{ translate('Enter Description') }}" id="highlight_description" name="highlight_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_hotel_highlights_language, $lang_id, $HHL['id'], 'description', 'highlight_id') }}
        </textarea>
    </div>  

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
