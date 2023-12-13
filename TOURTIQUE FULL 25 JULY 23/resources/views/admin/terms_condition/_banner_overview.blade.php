@php
    $languages = getLanguage();
    if (isset($append)) {
        $get_banner_over_view_language = [];
        $GBO                           = getTableColumn('banner_overview');
        $overview_count                = $params_arr['overview_count'];
    }

@endphp
<div class="row over_view_row">
    <div>
        <button class="over_view_delete bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="over_view_id[]" value="{{$GBO['id']}}">


    @foreach ($languages as $key => $L)
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Overview Title') }}({{ $L['title'] }})
            </label>
            <?php
                $language_title = '';
                if($GBO['id'] != ''){
                    $BannerOverviewLanguage = App\Models\BannerOverviewLanguage::where('overview_id',$GBO['id'])->where('langauge_id',$L['id'])->first();
                    if($BannerOverviewLanguage){
                        $language_title  = $BannerOverviewLanguage->title;
                    }
                }
                ?>
            <input class="form-control {{ $errors->has('over_view_title.' . $L['id']) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Overview Title') }}" id="title" name="over_view_title[{{ $L['id'] }}][]"
                type="text"
                language_id="{{$L['id']}}"
                id_="{{$GBO['id']}}"
                
                value="{{ $language_title }}" />
            @error('over_view_title.' . $L['id'])
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    @endforeach
       

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Overview Icon') }}</label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="overview_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'overview_image_<?php echo $overview_count; ?>')" id="overview_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $GBO['image'] != '' ? asset('uploads/advertisment_page/banner_overview/' . $GBO['image']) : asset('uploads/placeholder/placeholder.png') }}" id="overview_image_<?php echo $overview_count; ?>" width="100" alt="" /> 
                </div>
            </div>
        </div>
    </div> 
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

