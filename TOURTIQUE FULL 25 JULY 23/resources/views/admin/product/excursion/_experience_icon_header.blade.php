@php
    $languages = getLanguage();

    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_product_experience_icon_language_upper = [];
        $PEIH = getTableColumn('product_experience_icon');
    }
@endphp
<div class="row header_expe_div">
    <div>
        <button class="delete_expe_header bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="header_exper_id[]" value="{{ $PEIH['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('header_exp_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Title') }}" id="header_exp_title_{{ $lang_id }}_{{ $data }}"
            name="header_exp_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_experience_icon_language_upper, $lang_id, $PEIH['id'], 'title', 'experience_icon_id') }}" />
        
        <div class="invalid-feedback">
            
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Icon Info') }}</label>
        <input class="form-control {{ $errors->has('header_exp_info.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Icon Info') }}" id="header_exp_info_{{ $lang_id }}_{{ $data }}"
            name="header_exp_info[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_experience_icon_language_upper, $lang_id, $PEIH['id'], 'information', 'experience_icon_id') }}" />
        
        <div class="invalid-feedback">
           
        </div>
       
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Icon') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="header_exp_icon[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'header_exp_icon{{ $data }}{{ $PEIH['id'] }}')"
                id="header_exp_icon" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $PEIH['image'] != '' ? asset('uploads/header_expericence_icons/' . $PEIH['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="header_exp_icon{{ $data }}{{ $PEIH['id'] }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
