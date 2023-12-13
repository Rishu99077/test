@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_water_sport_language = [];
        $GYWS = getTableColumn('product_yacht_water_sport');
    }
@endphp
<div class="row water_div">
    <div>
        <button class="delete_water bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="water_id[]" value="{{$GYWS['id']}}">
    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="water_sport_title">{{ translate('Title') }}
        </label>
        <input class="form-control {{ $errors->has('water_sport_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="water_sport_title_{{ $lang_id }}_{{ $data }}" name="water_sport_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_product_water_sport_language, $lang_id, $GYWS['id'], 'title', 'product_yacht_water_sport_id') }}" />
        
        <div class="invalid-feedback">
            
        </div>
        
    </div>
   

    <div class="col-md-5" >
        <label class="form-label" for="water_price">{{ translate('Price') }}</label>
        <input class="form-control numberonly" placeholder="{{ translate('Price') }}" id="water_price_{{ $data }}"  name="water_price[]" type="text" value="{{ $GYWS['price'] }}" />
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-5">
        <label class="form-label" for="water_quantity">{{ translate('Quantity') }}</label>
        <input class="form-control numberonly" placeholder="{{ translate('Quantity') }}" id="water_quantity_{{ $data }}"  name="water_quantity[]" type="text" value="{{ $GYWS['quantity'] }}" />
        <div class="invalid-feedback"></div>
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
