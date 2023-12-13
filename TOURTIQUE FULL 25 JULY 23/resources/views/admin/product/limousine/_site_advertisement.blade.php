@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_site_adver_language = [];
        $GPSD = getTableColumn('product_site_advertisement');
    }
@endphp
<div class="row  adver_div">
    <div>
        <button class="delete_adver bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="adver_id[]" value="{{ $GPSD['id'] }}">
   
    <div class="col-md-6 mb-3">
        <label class="form-label" for="adver_title">{{ translate('Advertisement Title') }}<span class="text-danger">*</span>
        </label>
        <input class="form-control {{ $errors->has('adver_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Advertisement Title') }}" id="adver_title_{{ $lang_id }}_{{ $data }}"
            name="adver_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_site_adver_language, $lang_id, $GPSD['id'], 'title', 'site_advertisement_id') }}" />
       
        <div class="invalid-feedback">
            
        </div>

        <label class="form-label" for="adver_desc">{{ translate('Advertisement Description') }}<span class="text-danger">*</span>
        </label>
        <textarea class="form-control  {{ $errors->has('adver_desc.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Advertisement Sort Description') }}" id="adver_desc_{{ $lang_id }}_{{ $data }}" rows="5"
            name="adver_desc[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_site_adver_language, $lang_id, $GPSD['id'], 'description', 'site_advertisement_id') }}</textarea>
        
        <div class="invalid-feedback">
           
        </div>
       
    </div>


    <div class="col-md-6">
        <label class="form-label" for="adver_image">{{ translate('Image') }} <small>(792X450)</small> </label>
        <input class="form-control {{ $errors->has('adver_image') ? 'is-invalid' : '' }}" id="adver_image" name="adver_image[]" type="file" onchange="loadFile(event,'upload_adv_{{$data}}_{{$GPSD['id']}}')"  />
        @error('adver_image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GPSD['image'] != '' ? asset('uploads/product/' . $GPSD['image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_adv_{{$data}}_{{$GPSD['id']}}" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="link">{{ translate('Link') }}

        </label>
        <input class="form-control" id="adver_link" name="adver_link[]"
            value="{{ old('adver_link.*', $GPSD['link']) }}" type="text" value="" />

    </div>
    <div class="mb-2 mt-2">
        <hr>
    </div>
</div>
