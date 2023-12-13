@php
    $languages = getLanguage();
    $get_session_language = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_page_wbt_language = [];
        $GPF = getTableColumn('transfer_page_why_book_transfer');
    }
@endphp
<div class="row faq_div">
    <div>
        <!-- <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button> -->
    </div>
    <input type="hidden" name="transfer_why_book_id[]" value="{{ $GPF['id'] }}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('why_book_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Title') }}" id="title" name="why_book_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_transfer_page_wbt_language, $lang_id, $GPF['id'], 'title', 'why_book_id') }}" />
        @error('why_book_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <label class="form-label" for="title">{{ translate('Description') }} </label>
        <textarea class="form-control  {{ $errors->has('why_book_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
            placeholder="{{ translate('Enter Description') }}" id="title"
            name="why_book_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_transfer_page_wbt_language, $lang_id, $GPF['id'], 'description', 'why_book_id') }}
        </textarea>
        @error('why_book_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Icon') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="why_book_icon[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_<?php echo $data; ?>')" id="facility_image" />
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $GPF['image'] != '' ? asset('uploads/TransferPageImage/' . $GPF['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_<?php echo $data; ?>" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>


<script>
    CKEDITOR.replaceAll('footer_text');
</script>
