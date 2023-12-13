@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_transfer_option_language = [];
        $GYTO = getTableColumn('product_yacht_transfer_option');
    }
@endphp
<div class="row transfer_option_div">
    <div>
        <button class="delete_transfer_option bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="transfer_id[]" value="{{ $GYTO['id'] }}">
    
    <div class="col-md-6 mb-3">
        <label class="form-label" for="transfer_option_title">{{ translate('Title') }}<span class="text-danger">*</span>
        </label>
        <input class="form-control {{ $errors->has('transfer_option_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Title') }}" id="transfer_option_title_{{ $lang_id }}_{{ $data }}" name="transfer_option_title[{{ $lang_id }}][]"
            type="text"
            value="{{ getLanguageTranslate($get_product_transfer_option_language, $lang_id, $GYTO['id'], 'title', 'product_yacht_transfer_option_id') }}" />
        
            <div class="invalid-feedback">
                
            </div>
       
    </div>

    <div class="col-md-5" >
        <label class="form-label" for="transfer_option_price">{{ translate('Price') }}<span class="text-danger">*</span></label>
        <input class="form-control numberonly" placeholder="{{ translate('Price') }}" id="transfer_option_price_{{ $data }}"  name="transfer_option_price[]" type="text" value="{{ $GYTO['price'] }}" />
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-5">
        <label class="form-label" for="transfer_option_quantity">{{ translate('Quantity') }}<span class="text-danger">*</span></label>
        <input class="form-control numberonly" placeholder="{{ translate('Quantity') }}" id="transfer_option_quantity_{{ $data }}"  name="transfer_option_quantity[]" type="text" value="{{ $GYTO['quantity'] }}" />
        <div class="invalid-feedback"></div>
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
