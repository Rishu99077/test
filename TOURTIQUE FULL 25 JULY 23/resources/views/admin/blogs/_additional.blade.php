@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_blog_additional_language = [];
        $BAV = getTableColumn('blogs_aditional_headline');
    }
@endphp
<div class="row faq_div">
    <div>
        <button class="delete_book bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="addtional_headline_id[]" value="{{ $BAV['id'] }}">

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Image') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="additional_image[]" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_banner')" id="additional_image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $BAV['image'] != '' ? asset('uploads/blogs/' . $BAV['image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_banner" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-6 mb-3">
            <label class="form-label" for="additional_title">{{ translate('Title') }}
            </label>
            <input class="form-control {{ $errors->has('additional_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Title') }}" id="additional_title"
                name="additional_title[{{ $lang_id }}][]" type="text"
                value="{{ getLanguageTranslate($get_blog_additional_language, $lang_id, $BAV['id'], 'title', 'blog_aditional_id') }}" />
            @error('additional_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
         </div>
         
         <div class="col-md-6">   
            <label class="form-label" for="title">{{ translate('Description') }}
            </label>
            <textarea class="form-control footer_text {{ $errors->has('additional_description.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Description') }}"
                id="additional_description{{ $lang_id }}_{{ $data }}"
                name="additional_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_blog_additional_language, $lang_id, $BAV['id'], 'description', 'blog_aditional_id') }}
            </textarea>
            @error('additional_description.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.footer_text').each(function(e) {
            console.log("this.id", this.id)
            CKEDITOR.replace(this.id, {
                format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
                extraPlugins: 'colorbutton,colordialog',
                removeButtons: 'PasteFromWord'
            });
        });
    });
</script>
