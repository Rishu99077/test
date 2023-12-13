@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_affiliate_page_work_language = [];
        $GPF = getTableColumn('affiliate_page_work');
    }
@endphp
<div class="row faq_div">
    <div>
        <!-- <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button> -->
    </div>
    <input type="hidden" name="work_id[]" value="{{$GPF['id']}}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Work Title') }} </label>
        <input class="form-control {{ $errors->has('work_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Work Title') }}" id="title" name="work_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_affiliate_page_work_language, $lang_id, $GPF['id'], 'work_title', 'affiliate_page_work_id') }}" />
        @error('work_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <label class="form-label" for="title">{{ translate('Work Description') }} </label>
        <textarea class="form-control  {{ $errors->has('work_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Work Description') }}" id="title" name="work_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_affiliate_page_work_language, $lang_id, $GPF['id'], 'work_description', 'affiliate_page_work_id') }}
        </textarea>
        @error('work_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
       

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('How it work Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="work_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo_<?php echo $data; ?>')" id="work_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <input type="hidden" name="already_work_image[]" value="{{ $GPF['work_image'] }}">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $GPF['work_image'] != '' ? asset('uploads/Affiliate_Page/' . $GPF['work_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo_<?php echo $data; ?>" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
