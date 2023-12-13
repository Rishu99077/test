@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_additional_info_language = [];
        $GPAI = getTableColumn('products_addtional_info');
    }
@endphp
<div class="row info_div">
    <div>
        <button class=" delete_info bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="info_id[]" value="{{ $GPAI['id'] }}">

   
    <div class="col-md-6">
        <label class="form-label" for="title">{{ translate('Additional Info Title') }}
        </label>
        <input class="form-control {{ $errors->has('info_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Additional Info Title') }}" id="info_title_{{ $lang_id }}_{{ $data }}"
            name="info_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_additional_info_language, $lang_id, $GPAI['id'], 'description', 'product_additional_info_id') }}" />
        
            <div class="invalid-feedback">
                
            </div>
       
    </div>
   
    <div class="col-md-6">
        <label class="form-label" for="title">{{ translate('Attach Document') }}
        </label>
        <input class="form-control {{ $errors->has('info_doc') ? 'is-invalid' : '' }}" id="info_doc" name="info_doc[]"
            type="file" value="" />
        @error('info_doc')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GPAI['image'] != '' ? asset('uploads/product/' . $GPAI['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_client_logo" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 mt-2">
        <hr>
    </div>
</div>
