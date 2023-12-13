@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_page_premium_taxi_language = [];
        $TPT = getTableColumn('transfer_page_taxi');
    }
@endphp
<div class="row taxi_div">
    <div>
        <button class="delete_taxi bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="taxi_id[]" value="{{ $TPT['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Taxi name') }}
        </label>
        <input class="form-control {{ $errors->has('taxi_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Taxi name') }}" id="title" name="taxi_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_transfer_page_premium_taxi_language, $lang_id, $TPT['id'], 'title', 'transfer_page_taxi_id') }}" />
        @error('taxi_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Info') }}
        </label>
        <textarea class="form-control {{ $errors->has('taxi_info.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Information') }}" id="title" name="taxi_info[{{ $lang_id }}][]"
            type="text">{{ getLanguageTranslate($get_transfer_page_premium_taxi_language, $lang_id, $TPT['id'], 'information', 'transfer_page_taxi_id') }}</textarea>
        @error('taxi_info.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Icon') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="taxi_image[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $data }}{{ $TPT['id'] }}')"
                id="facility_image" />
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $TPT['image'] != '' ? asset('uploads/TransferPageImage/' . $TPT['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $data }}{{ $TPT['id'] }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Sort') }}
        </label>
        <input class="form-control" placeholder="{{ translate('Enter Sort') }}" id="sort" name="sort[]"
            type="text" value="{{ $TPT['sort'] }}" />
        @error('sort')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>


<script>
    CKEDITOR.replaceAll('footer_text');
</script>
