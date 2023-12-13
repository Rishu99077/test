@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_yatch_amenities_language = [];
        $_GYAL                          = getTableColumn('yacht_amenities');
    }
@endphp

<div class="row highlight_div mt-2">
    <div>
        <button class="delete_highlight bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span>
        </button>
    </div>
    <input type="hidden" name="amenities_ids[]" value="{{ $_GYAL['id'] }}" >
    <div class="row">
        <div class="col-md-6 mt-2"></div>
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end amenties_option" id="point_type_{{ $data }}"  {{ $_GYAL['type'] == 'point_type' || $_GYAL['type'] == ''  ? 'checked' :'' }} data-type="point_type" data-count="{{ $data }}"  type="radio" value="point_type" name="option_type[{{ $data }}]">
                <label class="fs-0" for="point_type_{{ $data }}">{{ translate('Point') }}</label>
            </div>
        </div>
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end amenties_option" id="desc_type_{{ $data }}"  {{ $_GYAL['type'] == 'desc_type'  ? 'checked' :'' }}  data-type="desc_type" data-count="{{ $data }}" type="radio" value="desc_type" name="option_type[{{ $data }}]">
                <label class="fs-0" for="desc_type_{{ $data }}">{{ translate('Description') }}</label>
            </div>
        </div>
    </div>
    <div class="row" id="amenties_row_{{ $data }}">        
        
            <div class="col-md-6 mb-3">
                <div>
                    <label class="form-label" for="title">
                        {{ translate('Title') }}
                    </label>
                    <input class="form-control {{ $errors->has('_amenties_title.' . $lang_id) ? 'is-invalid' : '' }}"
                        placeholder="{{ translate('Enter Higlights Title') }}" id="title"
                        name="heading_amenties_title[{{ $lang_id }}][]" type="text"
                        value="{{ getLanguageTranslate($get_yatch_amenities_language, $lang_id, $_GYAL['id'], 'title', 'amenities_id') }}" />
                    @error('_amenties_title.' . $lang_id)
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>               
            </div>
            

            
            @php 
                $amenti_key_count = 1;
            @endphp
            @if (empty($get_yatch_amenities_points))
                @include('admin.product.yacht.amenities_append._amenitie_point')
                @php 
                    $amenti_key_count++;
                @endphp
            @else

                @php
                    $get_yatch_amenities_points = App\Models\YachtAmenitiesPoints::where('product_id', $_GYAL['product_id'])->where('amenti_id', $_GYAL['id'])->get();
                @endphp
                @foreach ($get_yatch_amenities_points as $GYAP_key => $_GYAP_value)
                            @include('admin.product.yacht.amenities_append._amenitie_point')
                    @php
                        $amenti_key_count++;
                    @endphp
                @endforeach

            @endif
           
            @if($_GYAL['type'] != 'point_type' || $_GYAL['type'] == '')
            
                <div class="{{ $_GYAL['type'] }} col-md-6 mb-3 row_amenities_desc_{{ $data }}  {{ $_GYAL['type'] == 'desc_type' || $_GYAL['type'] != '' ? '' :'d-none' }}" >
                    <label class="form-label" for="title">
                        {{ translate('Description') }}
                    </label>
                    <textarea
                        class="form-control amenties_desc amenties_desc_{{ $data }} {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }}"
                        placeholder="{{ translate('Enter Description') }}" id="amenties_desc_{{ $data }}"
                        name="amenties_description[{{ $data }}][{{ $lang_id }}][]">{{ getLanguageTranslate($get_yatch_amenities_language, $lang_id, $_GYAL['id'], 'description', 'amenities_id') }}</textarea>
                    @error('amenties_description.' . $lang_id)
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror         
                </div>
            @endif

    </div>
    
    <div class="col-md-12 text-end ">
        <button class="btn btn-success btn-sm float-end m-1 amenties_point_btn{{ $data }} amenties_point" type="button" id="" data-count="{{ $data }}" title='Add more'><span class="fa fa-plus"></span> Add more</button>
    </div>
    <div class="mt-3">
        <hr>
    </div>
</div>



<script>
    if($("amenties_desc_{{ $data }}").length > 0){
    CKEDITOR.replaceAll('amenties_desc_{{ $data }}');}
</script>
