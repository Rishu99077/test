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

    <script>
        //  var index = $('.highlight_div').length + 1;
         function getIndex(index){
             $data = index;
         }
    </script>

    <div class="col-md-6 mb-3">
        
        <label class="form-label" for="title">{{ translate('Higlights Title') }}<span class="text-danger">*</span></label>
        <input class="form-control index_high_title Langauge_{{ $lang_id }} {{ $errors->has('highlights_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Higlights Title') }}" id="highlights_title_{{ $lang_id }}_{{ $data }}"
            name="highlights_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_highlight_language, $lang_id, $GPH['id'], 'title', 'highlight_id') }}" />
        <div class="invalid-feedback" >
            
        </div>


        <label class="form-label" for="title">{{ translate('Higlights Description') }}<span class="text-danger">*</span>
            </label>
        <textarea class="form-control index_high_desc Langauge_{{ $lang_id }} footer_text footer_text_{{ $data }} {{ $errors->has('highlights_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Higlights Description') }}" id="highlights_description_{{ $lang_id }}_{{ $data }}" 
                name="highlights_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_highlight_language, $lang_id, $GPH['id'], 'description', 'highlight_id') }}</textarea>
        <div class="invalid-feedback">
        
        </div>
    </div>
    <div class="mt-3">
        <hr>
    </div>
</div>



<script>
      if($(".footer_text_{{ $data }}").length > 0){
             CKEDITOR.replaceAll('footer_text_{{ $data }}');
      }
</script>
