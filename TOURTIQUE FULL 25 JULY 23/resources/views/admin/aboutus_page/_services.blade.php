@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_about_us_service_language = [];
        $APS = getTableColumn('about_us_services');
    }
@endphp
<div class="row sevice_div">
    <div>
        <button class="delete_service bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="service_id[]" value="{{$APS['id']}}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="service_title">{{ translate('Service Title') }}
        </label>
        <input class="form-control {{ $errors->has('service_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Service Title') }}" id="service_title" name="service_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_about_us_service_language, $lang_id, $APS['id'], 'service_title', 'about_us_services_id') }}" />
        @error('service_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
