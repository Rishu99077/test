@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_extras_options_language = [];
        $EXO = getTableColumn('transfer_extras_options');
        $extra_data = $data;
    }
@endphp
<div class="row extras_div">
    <div>
        <button class="delete_extras bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="extra_option_id[]" value="{{ $EXO['id']}}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Extra option Title') }}
        </label>
        <input class="form-control {{ $errors->has('option_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Extra option Title') }}" id="title"
            name="option_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_transfer_extras_options_language, $lang_id, $EXO['id'], 'option_title', 'extra_option_id') }}" />
        @error('option_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6">   
        <label class="form-label" for="title">{{ translate('Extra option Description') }} </label>
        <textarea
            class="form-control extra_option_{{$extra_data}} {{ $errors->has('option_description.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Extra option Description') }}" 
            name="option_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_extras_options_language, $lang_id, $EXO['id'], 'option_description', 'extra_option_id') }}</textarea>
        @error('option_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="extra_price">{{ translate('Extra Price') }}</label>
        <input type="text" class="form-control numberonly" name="extra_price[]" id="extra_price" value="{{$EXO['extra_price']}}" placeholder="{{ translate('Enter Extra Price') }}">
        
        <div class="invalid-feedback">
            
        </div>
        
    </div>
    <div class="col-md-2 mt-4">
        <div class="form-check form-switch pl-0">
            <input class="form-check-input float-end" id="arrival_{{$extra_data}}"
                {{ getChecked(1, $EXO['arrival']) }} type="checkbox" value="1"
                name="arrival[{{$extra_data}}][]">
            <label class="fs-0" for="arrival_{{$extra_data}}">{{ translate('Arrival') }}</label>
        </div>
    </div>  
     <div class="col-md-2 mt-4">
        <div class="form-check form-switch pl-0">
            <input class="form-check-input float-end" id="departure_{{$extra_data}}"
                {{ getChecked(1, $EXO['departure']) }} type="checkbox" value="1"
                name="departure[{{$extra_data}}][]">
            <label class="fs-0" for="departure_{{$extra_data}}">{{ translate('Departure') }}</label>
        </div>
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>
<script>
    CKEDITOR.replaceAll('extra_option_{{$extra_data}}');
</script>
