@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_partner_page_facility_language = [];
        $FAC = getTableColumn('partner_page_facility');
    }
@endphp
<div class="row facilities_div">
    <div>
        <button class="delete_media bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="facility_id[]" value="{{$FAC['id']}}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Facilities Title') }}
        </label>
        <input class="form-control {{ $errors->has('facility_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Facilities Title') }}" id="title" name="facility_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_partner_page_facility_language, $lang_id, $FAC['id'], 'facility_title', 'partner_page_facility_id') }}" />
        @error('facility_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
      

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
