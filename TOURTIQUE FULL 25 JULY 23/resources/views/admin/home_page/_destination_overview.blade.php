@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $HDO = getTableColumn('home_destination_overview');
        $get_destination_overview_language=[];
    }
@endphp
<div class="row overview_div">
    <div>
         <button class="delete_overview bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button> 
    </div>
    <input type="hidden" name="overview_id[]" value="{{ $HDO['id'] }}">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Overview Title') }}
            </label>
            <input class="form-control {{ $errors->has('overview_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter  Overview Title') }}" id="title"
                name="overview_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_destination_overview_language, $lang_id, $HDO['id'],'title', 'destination_overview_id') }}" />
            @error('overview_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label" for="overview_link">{{ translate('Link') }}
            </label>
            <input class="form-control {{ $errors->has('overview_link') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Link') }}" id="overview_link" name="overview_link[]"
                type="text" value="{{ $HDO['link'] }}" />
            @error('overview_link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="overview_location">{{ translate('Location') }}
            </label>
            <input class="form-control {{ $errors->has('overview_location') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Location') }}" id="overview_location" name="overview_location[]"
                type="text" value="{{ $HDO['location'] }}" />
            @error('overview_location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 content_title">
            <label class="form-label" for="duration_from">{{ translate('Image') }}
                <small>(255X355)</small> </label>
            <div class="input-group mb-3">
                <input class="form-control " type="file" name="overview_image[]" aria-describedby="basic-addon2"
                    onchange="loadFile(event,'overview_image{{$data}}{{$HDO['id']}}')" id="overview_image" />
                <div class="invalid-feedback">
                </div>
            </div>
            <div class="col-lg-3 mt-2">
                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                    <div class="h-100 w-100  overflow-hidden position-relative">
                        <img src="{{ $HDO['image'] != '' ? asset('uploads/home_page/destination_overview/' . $HDO['image']) : asset('uploads/placeholder/placeholder.png') }}"
                            id="overview_image{{$data}}{{$HDO['id']}}" width="100" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
