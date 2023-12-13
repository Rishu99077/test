@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_partner_page_book_language = [];
        $BOO = getTableColumn('partner_page_book');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_book bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="book_id[]" value="{{$BOO['id']}}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Book Title') }}
        </label>
        <input class="form-control {{ $errors->has('book_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Book Title') }}" id="title" name="book_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_partner_page_book_language, $lang_id, $BOO['id'], 'book_title', 'partner_page_book_id') }}" />
        @error('book_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="title">{{ translate('Book Description') }} </label>
        <textarea class="form-control  {{ $errors->has('book_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Book Description') }}" id="title" name="book_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_partner_page_book_language, $lang_id, $BOO['id'], 'book_description', 'partner_page_book_id') }}
        </textarea>
        @error('book_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Why Book us Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="book_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo{{$data}}{{$BOO['id']}}')" id="book_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $BOO['book_image'] != '' ? asset('uploads/PartnerPage/' . $BOO['book_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo{{$data}}{{$BOO['id']}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
