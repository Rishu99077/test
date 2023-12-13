@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_affiliate_page_choose_language = [];
        $WCU = getTableColumn('affiliate_page_choose');
    }
@endphp
<div class="row choose_div">
    <div>
        <button class="delete_choose_div bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="affiliate_choose_id[]" value="{{$WCU['id']}}">
  
    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('How it work Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="choose_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_choose_logo_<?php echo $data; ?>')" id="choose_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $WCU['choose_image'] != '' ? asset('uploads/Affiliate_Page/' . $WCU['choose_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_choose_logo_<?php echo $data; ?>" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Why choose Description') }} </label>
        <textarea class="form-control  {{ $errors->has('choose_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Why choose Description') }}" id="title" name="choose_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_affiliate_page_choose_language, $lang_id, $WCU['id'], 'choose_description', 'affiliate_page_choose_id') }}
        </textarea>
        @error('choose_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
