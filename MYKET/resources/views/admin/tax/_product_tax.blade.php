@php
    $count = 0;
    if (isset($params_arr)) {
        $count = $params_arr['data'];
        $get_session_language = getLang();

        $language_id = $get_session_language['id'];
        $get_product = App\Models\Product::where(['products.is_delete' => null, 'products.status' => 'Active', 'products.is_approved' => 'Approved'])
            ->where('slug', '!=', '')
            ->where('products_description.language_id', $language_id)
            ->select('products.*', 'products_description.title', 'products_description.language_id')
            ->leftJoin('products_description', 'products.id', '=', 'products_description.product_id')
            ->get();

        $PT = getTableColumn('tax');
        $PT['title'] = '';
    }
@endphp
<div class="row">
    <input type="hidden" name="product_tax_id[]" value="{{ $PT['id'] }}">

    <div class="col-md-4">
        <div class="form-group mb-3 {{ $errors->has('Title') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Title') }}</label>
            <input type="text" class="category_title form-control" name="product_title[]" placeholder="Enter title"
                value="{{ $PT['title'] }}">

            @error('product_title')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group mb-3 {{ $errors->has('product') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Product') }}</label>
            <select id="product_{{ $count }}" name="product[]" data-count="{{ $count }}"
                class="form-control select2">
                <option value="" selected>{{ translate('Select') }}</option>
                @foreach ($get_product as $C)
                    <option value="{{ $C['id'] }}" {{ getSelected($C['id'], $PT['products']) }}>
                        {{ $C['title'] }}</option>
                @endforeach

            </select>
            @error('product')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('tax') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Tax') }}</label>
            <input type="text" class="numberonly form-control" name="product_tax[]" value="{{ $PT['amount'] }}">
            @error('tax')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('tax_type') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Tax Type') }}</label>
            <select name="product_tax_type[]" id="" class="form-control">
                <option value="percentage" {{ getSelected('percentage', $PT['tax_type']) }}>
                    {{ translate('Percentage') }}</option>
                <option value="fixed" {{ getSelected('fixed', $PT['tax_type']) }}>{{ translate('Fixed') }}</option>
            </select>
            @error('tax')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-danger p-2 mt-4 remove_tax"><i class="fa fa-trash"></i></button>
    </div>

</div>
