@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_help_page_highlights_language = [];
        $TPH = getTableColumn('transfer_page_highlights');
        $get_help_page_language = [];
    } else {
        $data   = $TPH_cnt;
        $get_help_page_language = App\Models\HelpPageLanguage::where('help_page_id', 1)
            ->where('highlights_id', $TPH['id'])
            ->get();
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_high bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" value="{{ $TPH['id'] }}" name="help_highlight_id[]">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Heading') }}</label>
        <input class="form-control {{ $errors->has('heading.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Heading ') }}" id="title"
            name="heading[{{ $data }}][{{ $lang_id }}]" type="text"
            value="{{ getLanguageTranslate($get_help_page_highlights_language, $lang_id, $TPH['id'], 'title', 'highlights_id') }}" />
    </div>
    
    <div class="colcss">
        @php
            $hl_cnt_ = 0;
        @endphp
        @foreach ($get_help_page_language as $HPL)
            @include('admin.help_page._help_faqs')
            @php
                $hl_cnt_++;
            @endphp
        @endforeach
        @if (count($get_help_page_language) == 0)
            @include('admin.help_page._help_faqs')
        @endif
        <div class="show_faqs{{ $data }}">
        </div>
        <div class="row">
            <div class="col-md-12 add_more_button">
                <button class="btn btn-success btn-sm float-end add_more_faqs" type="button" title='Add more'
                    data-val="{{ $data }}"><span class="fa fa-plus"></span>
                    {{ translate('Add More Highlights') }}</button>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    if ($(".footer_text_{{ $data }}").length > 0) {
        CKEDITOR.replaceAll('footer_text_{{ $data }}');
    }
</script>
