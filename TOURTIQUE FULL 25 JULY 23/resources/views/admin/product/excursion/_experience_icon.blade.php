@php
    $languages = getLanguage();
    
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_product_experience_icon_language = [];
        $PEI  = getTableColumn('product_experience_icon');
    }
@endphp
<div class="row expe_div">
    <div>
        <button class="delete_expe bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="exper_id[]" value="{{$PEI['id']}}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('exp_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Title') }}" id="exp_title_{{ $lang_id }}_{{ $data }}" name="exp_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_product_experience_icon_language, $lang_id, $PEI['id'], 'title', 'experience_icon_id') }}" />
        
        <div class="invalid-feedback">
            
        </div>
       
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Icon') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="exp_icon[]" aria-describedby="basic-addon2" onchange="loadFile(event,'slider_image_{{$data}}{{$PEI['id']}}')" id="exp_icon"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $PEI['image'] != '' ? asset('uploads/expericence_icons/' . $PEI['image']) : asset('uploads/placeholder/placeholder.png') }}" id="slider_image_{{$data}}{{$PEI['id']}}" width="100" alt="" /> 
                </div>
            </div>
        </div>
    </div> 
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

