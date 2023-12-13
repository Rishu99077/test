@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_media_blog_language = [];
        $MBD = getTableColumn('media_blog');
    }
@endphp
<div class="row media_blog_div">
    <div>
        <button class="delete_media_blog bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="media_blog_id[]" value="{{ $MBD['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Blog Description') }}
        </label>
        <textarea class="form-control  {{ $errors->has('blog_description.' . $lang_id) ? 'is-invalid' : '' }} "
            placeholder="{{ translate('Enter Blog Description') }}" id="title" rows="8"
            name="blog_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_media_blog_language, $lang_id, $MBD['id'], 'description', 'media_blog_id') }}
        </textarea>
    </div>


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Media blog video') }} </label>
        <div class="input-group mb-3">
            <input class="form-control " type="text" value="{{ $MBD['media_video'] }}" name="media_video[]"
                aria-describedby="basic-addon2" id="media_video" />
            {{-- <input class="form-control " type="text" readonly value="{{ $MBD['media_video'] }}" /> --}}
            <div class="invalid-feedback">
            </div>
        </div>
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Media Blog Thumbnail Image') }} </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="media_image[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $MBD['id'] }}_{{ $data }}')"
                id="work_image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $MBD['media_image'] != '' ? asset('uploads/MediaBlog/' . $MBD['media_image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $MBD['id'] }}_{{ $data }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

<!-- <script>
    CKEDITOR.replaceAll('footer_text_{{ $MBD['id'] }}_{{ $data }}');
</script> -->
