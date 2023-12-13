@php
    $languages = getLanguage();
    if (isset($append)) {
        $SML = getTableColumn('social_media_links');
    }
@endphp
<div class="row media_div">
    <input type="hidden" name="link_id[]" value="{{ $SML['id'] }}">

    <div class="col-md-5 content_title">
        <label class="form-label" for="duration_from">{{ translate('Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="media_icon[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $SML['id'] }}_{{ $data }}')"
                id="media_icon" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $SML['media_icon'] != '' ? asset('uploads/setting/' . $SML['media_icon']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $SML['id'] }}_{{ $data }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 content_title ">
        <label class="form-label" for="price">{{ translate('Link') }} </label>
        <div class="input-group mb-3">
            <input class="form-control " type="text" name="link[]" aria-describedby="basic-addon2"
                value="{{ $SML['link'] }}" id="link" />

            <div class="invalid-feedback">
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <label class="form-label" for="price">{{ translate('Status') }} </label>
        <select class="form-select single-select" name="media_status[]">
            <option value="Active">{{ translate('Active') }} </option>
            <option value="Deactive"{{ $SML['media_status'] == 'Deactive' ? 'selected' : '' }}>
                {{ translate('Deactive') }}
            </option>
        </select>
    </div>


    <div class="col-md-1 mt-4">
        <button class="delete_media bg-card btn btn-danger btn-sm float-end" type="button"
            data-id="{{ $SML['id'] }}"><span class="fa fa-trash"></span></button>
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".single-select{{ $data }}_{{ $SML['id'] }}").select2();
        $(".multi-select").select2({
            placeholder: "Select",
        });
    })
</script>
<script>
    CKEDITOR.replaceAll('footer_highlight_{{ $SML['id'] }}_{{ $data }}');
</script>
