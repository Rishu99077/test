@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_media_page_article_language = [];
        $GPF = getTableColumn('media_mension_page_article');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_media bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="article_id[]" value="{{ $GPF['id'] }}">
    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Article Title') }}
        </label>
        <input class="form-control {{ $errors->has('article_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Article Title') }}" id="title"
            name="article_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_media_page_article_language, $lang_id, $GPF['id'], 'article_title', 'media_mension_article_id') }}" />
        @error('article_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror


        

        <label class="form-label" for="title">{{ translate('Article Description') }}
        </label>
        <textarea
            class="form-control  {{ $errors->has('article_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text footer_text_{{ $GPF['id'] }}_{{ $data }}"
            placeholder="{{ translate('Enter Article Description') }}" id="title"
            name="article_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_media_page_article_language, $lang_id, $GPF['id'], 'article_description', 'media_mension_article_id') }}
        </textarea>
        @error('article_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
   
    <div class="col-md-6">
        <label class="form-label" for="city">{{ translate('City') }} </label>
        <input class="form-control  {{ $errors->has('city') ? 'is-invalid' : '' }} "
            placeholder="{{ translate('Enter City') }}" value="{{ $GPF['city'] }}" id="city" name="city[]"
        />
        @error('city')
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
    CKEDITOR.replaceAll('footer_text_{{ $GPF['id'] }}_{{ $data }}');
</script>
