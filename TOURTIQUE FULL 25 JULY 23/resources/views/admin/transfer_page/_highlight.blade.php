@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_page_highlights_language = [];
        $TPH = getTableColumn('transfer_page_highlights');
    }
@endphp
<div class="row high_div">
    <div>
        <button class="delete_high bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="highlights_id[]" value="{{$TPH['id']}}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Higlights Title') }}
        </label>
        <input class="form-control {{ $errors->has('highlights_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Higlights Title') }}" id="title"
            name="highlights_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_transfer_page_highlights_language, $lang_id, $TPH['id'], 'title', 'transfer_page_highlight_id') }}" />
        @error('highlights_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <label class="form-label" for="title">{{ translate('Higlights Description') }} </label>
        <textarea
            class="form-control footer_text footer_text_{{ $data }} {{ $errors->has('highlights_description.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Higlights Description') }}" id="footer_text_{{ $data }}"
            name="highlights_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_page_highlights_language, $lang_id, $TPH['id'], 'description', 'transfer_page_highlight_id') }}</textarea>
        @error('highlights_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Highlights Icon') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="high_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_high_logo_{{$data}}{{$TPH['id']}}')" id="facility_image"/>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $TPH['image'] != '' ? asset('uploads/TransferPageImage/' . $TPH['image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_high_logo_{{$data}}{{$TPH['id']}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="col-md-6 mb-3">
        <label class="form-label" for="sort_order">{{ translate('Sort Order') }}</label>
            <input class="form-control numberonly"
                placeholder="{{ translate('Enter Sort Order') }}" id="sort_order"
                name="sort_order[]" type="text" value="{{$TPH['sort_order']}}" />
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
