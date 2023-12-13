@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_yatch_fetaure_highlight_language = [];
        $GYFH = getTableColumn('yacht_feature_highlight');
        $feature_highlight_count = $data;
    }
@endphp
<div class="row row_feature_highlight mt-3">
    <input type="hidden" name="facilites_highlight_id[]" value="{{ $GYFH['id'] }}">
    <div>
        
            <button class="delete_feature_highlight btn btn-danger btn-sm mt-5" style="float: right;" type="button">
                <span class="fa fa-trash"></span>
            </button>
    </div>
    
    <div class="col-md-6 mt-2">
        <label class="form-label" for="title">{{ translate('Onsite Facilities Title') }}
        </label>
        <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
            name="facilites_highlight_title[{{ $lang_id }}][]" type="text"
            value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_fetaure_highlight_language, $lang_id, $GYFH['id'], 'title', 'feature_highlight_id')) }}" />
        <div class="invalid-feedback">

        </div>
    </div>

    <div class="col-md-6 mt-2">
        <label class="form-label" for="title">{{ translate('Onsite Facilities Text') }}
        </label>
        <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
            name="facilites_highlight_text[{{ $lang_id }}][]" type="text"
            value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_fetaure_highlight_language, $lang_id, $GYFH['id'], 'description', 'feature_highlight_id')) }}" />
        <div class="invalid-feedback">

        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="facilities_image">{{ translate('Image') }} <small>(792X450)</small> </label>
        <input class="form-control {{ $errors->has('facilities_image') ? 'is-invalid' : '' }}" id="facilities_image"
            name="facilities_image[]" type="file"
            onchange="loadFile(event,'upload_adv_{{ $feature_highlight_count }}')" />
        @error('adver_image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="overflow-hidden position-relative">
                    <img src="{{ $GYFH['image'] != '' ? url('uploads/product_images', $GYFH['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        style="height: 50px;width: 50px;" id="upload_adv_{{ $feature_highlight_count }}" width="50%"
                        alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-check form-switch pl-0">
            <input class="form-check-input float-end excursion_status"
            {{ getChecked('Active', old('highlight_status', $GYFH['status'])) }}
            id="highlight_status{{$data}}{{$GYFH['id']}}" type="checkbox" >
            <label class="form-check-label form-label"
                for="highlight_status{{$GYFH['id']}}">{{ translate('Status') }}
            </label>
            <input type="hidden" name="highlight_status[]" value="{{$GYFH['status']}}" id="highli{{$data}}{{$GYFH['id']}}">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
       $('#highlight_status{{$data}}{{$GYFH['id']}}').click(function(e) {
            if ($(this).is(':checked') == true) {
                $('#highli{{$data}}{{$GYFH['id']}}').val('Active');
            } else {
                $('#highli{{$data}}{{$GYFH['id']}}').val('Deactive');
            }
       });
    });

</script>
