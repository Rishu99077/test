@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_page_with_us_language = [];
        $TWU = getTableColumn('transfer_page_with_us');
    }
@endphp
<div class="row with_us_div">
    <div>
        <button class="delete_with_us bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="with_us_id[]" value="{{$TWU['id']}}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('with_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Title') }}" id="title" name="with_title[{{ $lang_id }}][]"
            type="text" value="{{ getLanguageTranslate($get_transfer_page_with_us_language, $lang_id, $TWU['id'], 'title', 'with_us_id') }}" />
        @error('with_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
       

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Why Book with us Icon') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="with_us_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_with_us_logo_{{$data}}{{$TWU['id']}}')" id="facility_image"/>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $TWU['image'] != '' ? asset('uploads/TransferPageImage/' . $TWU['image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_with_us_logo_{{$data}}{{$TWU['id']}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
