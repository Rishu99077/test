@php
    $languages = getLanguage();
    
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_over_ride_banner_language = [];
        $EXO = getTableColumn('over_ride_banner');
        $country = App\Models\Country::all();
    }
@endphp
<div class="row banner_div">
    <div>
        <button class="delete_banner bg-card btn btn-danger btn-sm float-end" type="button"
            data-id="{{ $EXO['id'] }}"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="over_ride_banner_id[]" value="{{ $EXO['id'] }}">

    <div class="col-md-6 content_title ">
        <label class="form-label" for="price">{{ translate('Country') }} </label>
        <select
            class="form-select single-select{{ $data }}_{{ $EXO['id'] }} country_{{ $data }}_{{ $EXO['id'] }}  {{ $errors->has('country') ? 'is-invalid' : '' }}"
            name="country[{{ $data }}][]" id="country{{ $data }}_{{ $EXO['id'] }}"
            onchange="getStateCity('country','','{{ $data }}')" multiple>
            <option value="">{{ translate('Select Country') }}</option>
            @foreach ($country as $C)
                <option value="{{ $C['id'] }}" {{ getSelectedInArray($C['id'], $EXO['country']) }}>
                    {{ $C['name'] }}
                </option>
            @endforeach
        </select>

        @error('country')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="banner_image[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $EXO['id'] }}_{{ $data }}')"
                id="banner_image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $EXO['banner_image'] != '' ? asset('uploads/our_team/' . $EXO['banner_image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $EXO['id'] }}_{{ $data }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6 mb-3">
        <label class="form-label" for="banner_title">{{ translate('Banner Title') }} </label>
        <input class="form-control {{ $errors->has('banner_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Banner Title') }}" id="banner_title"
            name="banner_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_over_ride_banner_language, $lang_id, $EXO['id'], 'banner_title', 'over_ride_banner_id') }}" />
        @error('banner_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">    
        <label class="form-label" for="title">{{ translate('Banner Description') }} </label>
        <textarea class="form-control footer_text footer_highlight_{{ $EXO['id'] }}_{{ $data }} {{ $errors->has('banner_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Banner Description') }}"
            id="footer_highlight_{{ $EXO['id'] }}_{{ $data }}" rows="5"
            name="banner_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_over_ride_banner_language, $lang_id, $EXO['id'], 'banner_description', 'over_ride_banner_id') }}</textarea>
        @error('banner_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 content_title ">
        <label class="form-label" for="price">{{ translate('Link') }} </label>
        <div class="input-group mb-3">
            <input class="form-control " type="text" name="link[]" aria-describedby="basic-addon2"
                value="{{ $EXO['link'] }}" id="link" />

            <div class="invalid-feedback">
            </div>
        </div>

    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".single-select{{ $data }}_{{ $EXO['id'] }}").select2();
        $(".multi-select").select2({
            placeholder: "Select",
        });
    })
</script>
<script>
    CKEDITOR.replaceAll('footer_highlight_{{ $EXO['id'] }}_{{ $data }}');
</script>
