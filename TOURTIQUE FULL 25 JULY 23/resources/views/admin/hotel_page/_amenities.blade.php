@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_hotel_amenities_language = [];
        $HA = getTableColumn('hotel_amenities');
    }
@endphp
<div class="row highlight_div">
    <div>
        <button class="delete_highlight bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="Amenity_id[]" value="{{$HA['id']}}">
       
    
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }} </label>
            <textarea class="form-control  {{ $errors->has('amenity_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Amenity') }}" id="title" name="amenity_title[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_hotel_amenities_language, $lang_id, $HA['id'], 'title', 'amenity_id') }}
            </textarea>
            @error('amenity_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
