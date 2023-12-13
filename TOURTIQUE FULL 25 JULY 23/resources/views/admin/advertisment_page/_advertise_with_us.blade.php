@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_advertise_with_us_language = [];
        $GAWU = getTableColumn('advertise_with_us');
    }
@endphp
<div class="row advertise_div">
    <div>
        <button class="delete_advertise bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="facility_id[]" value="{{ $GAWU['id'] }}">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('facility_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Title') }}" id="title"
            name="facility_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_advertise_with_us_language, $lang_id, $GAWU['id'], 'title', 'advertise_with_us_id') }}" />
        @error('facility_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>
    <div class="col-md-6">   
        <label class="form-label" for="title">{{ translate('Description') }}
        </label>
        <textarea
            class="form-control  {{ $errors->has('facility_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text footer_text_{{ $GAWU['id'] }}_{{ $data }}"
            placeholder="{{ translate('Enter Description') }}" id="title"
            name="facility_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_advertise_with_us_language, $lang_id, $GAWU['id'], 'description', 'advertise_with_us_id') }}
        </textarea>
        @error('facility_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Facilities Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="facility_image[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo{{$data}}{{$GAWU['id']}}')" id="image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $GAWU['image'] != '' ? asset('uploads/advertisment_page/' . $GAWU['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo{{$data}}{{$GAWU['id']}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 content_title">
        <div class="form-check form-switch pl-0">
            <label class="form-check-label form-label" for="sort_order">Sort Order </label>
            <input class="form-control numberonly  sort_order" id="sort_order" type="text" value="{{ $GAWU['sort_order'] }}" name="sort_order[]">
            
        </div>   
    </div>


    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

<script>
    CKEDITOR.replaceAll('footer_text_{{ $GAWU['id'] }}_{{ $data }}');
</script>
