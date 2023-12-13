@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_blog_page_featured_language = [];
        $BPF = getTableColumn('blog_page_featured');
    }
@endphp
<div class="row faq_div">
    <div>
       <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button> 
    </div>
    <input type="hidden" name="featured_id[]" value="{{$BPF['id']}}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Featured Title') }}</label>
        <input class="form-control {{ $errors->has('featured_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Featured Title') }}" id="title" name="featured_title[{{ $lang_id }}][]"
            type="text" value="{{ getLanguageTranslate($get_blog_page_featured_language, $lang_id, $BPF['id'], 'featured_title', 'blog_featured_id') }}" />
        @error('featured_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
       
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Featured Location') }} </label>
        <input class="form-control" placeholder="{{ translate('Enter Featured Location') }}" id="featured_location" name="featured_location[]"
            type="text" value="{{ $BPF['featured_location'] }}" />
        
    </div>   


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Featured Link') }} </label>
        <input class="form-control" placeholder="{{ translate('Enter Featured Link') }}" id="featured_link" name="featured_link[]"
            type="text" value="{{ $BPF['featured_link'] }}" />
        
    </div>   

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Featured Image') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" <?php if ($BPF['blog_featured_image'] == '') { ?> required <?php } ?> name="blog_featured_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo_{{$data}}{{$BPF['id']}}')" id="blog_featured_image_{{ $data }}"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $BPF['blog_featured_image'] != '' ? asset('uploads/BlogPage/' . $BPF['blog_featured_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo_{{$data}}{{$BPF['id']}}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>


<script>
    CKEDITOR.replaceAll('footer_text');
</script>