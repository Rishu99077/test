@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_about_us_choose_language = [];
        $CHO = getTableColumn('about_us_page_choose');
    }
@endphp
<div class="row fac_div">
    <div>
        <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="choose_id[]" value="{{$CHO['id']}}">


    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Why Choose Title') }}
        </label>
        <input class="form-control {{ $errors->has('choose_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Why Choose Title') }}" id="title" name="choose_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_about_us_choose_language, $lang_id, $CHO['id'], 'choose_title', 'about_page_choose_id') }}" />
        @error('choose_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="title">{{ translate('Why Choose Description') }} </label>
        <textarea class="form-control  {{ $errors->has('choose_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text footer_text_{{$CHO['id']}}_{{$data}}" placeholder="{{ translate('Enter Why Choose Description') }}" id="title" name="choose_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_about_us_choose_language, $lang_id, $CHO['id'], 'choose_description', 'about_page_choose_id') }}
        </textarea>
        @error('choose_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
       

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Why Choose Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="choose_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo_<?php echo $data; ?>')" id="choose_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $CHO['choose_image'] != '' ? asset('uploads/AboutUsPage/' . $CHO['choose_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo_<?php echo $data; ?>" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

<script>
    CKEDITOR.replaceAll('footer_text_{{$CHO["id"]}}_{{$data}}');
</script>
