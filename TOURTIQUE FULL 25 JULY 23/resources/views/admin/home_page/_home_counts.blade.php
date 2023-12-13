@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $GHC = getTableColumn('home_count');
        $get_home_count_language=[];
    }
@endphp
<div class="row faq_div">
    <div>
        {{-- <button class="delete_faq bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button> --}}
    </div>
    <input type="hidden" name="home_counts_id[]" value="{{ $GHC['id'] }}">
    <div class="row">
        {{-- {{ getLanguageTranslate($get_affiliate_page_work_language, $lang_id, $GPF['id'], 'home_counts_title', 'affiliate_page_work_id') }} --}}

        
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }}
            </label>
            <input class="form-control {{ $errors->has('home_counts_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter  Title') }}" id="title"
                name="home_counts_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_home_count_language, $lang_id, $GHC['id'],'title', 'home_count_id') }}" />
            @error('home_counts_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Number') }}
            </label>
            <input class="form-control numberonly {{ $errors->has('home_counts_number') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Number') }}" id="home_counts_number" name="home_counts_number[]"
                type="text" value="{{ $GHC['number'] }}" />
            @error('home_counts_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 content_title">
            <label class="form-label" for="duration_from">{{ translate('Image') }}
                <small>(792X450)</small> </label>
            <div class="input-group mb-3">
                <input class="form-control " type="file" name="home_counts_image[]" aria-describedby="basic-addon2"
                    onchange="loadFile(event,'home_counts_image<?php echo $data; ?>')" id="home_counts_image" />
                <div class="invalid-feedback">
                </div>
            </div>
            <div class="col-lg-3 mt-2">
                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                    <div class="h-100 w-100  overflow-hidden position-relative">
                        <img src="{{ $GHC['image'] != '' ? asset('uploads/home_page/home_counts/' . $GHC['image']) : asset('uploads/placeholder/placeholder.png') }}"
                            id="home_counts_image<?php echo $data; ?>" width="100" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
