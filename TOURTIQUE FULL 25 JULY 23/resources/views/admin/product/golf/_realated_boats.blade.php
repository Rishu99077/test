@php
    if (isset($append)) {
        $GYRB = getTableColumn('product_yacht_relatedboats');
        $get_session_language  = getSessionLang();
        $lang_id = $get_session_language['id'];
        $get_boats = App\Models\Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->where('products.status', 'Active')
            ->where('products.product_type', 'golf')
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->where('product_language.language_id',$lang_id)
            ->groupBy('products.id')->get();
    }
@endphp

<div class="row boats_div">
    <div>
        <button class="delete_boats bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="boat_id[]" value="">
    <div class="col-md-4 content_title">
        <label class="form-label" for="price">{{ translate('Golf Cources') }}
            <span class="text-danger">*</span>
        </label>
        <select class="form-select single-select boat  {{ $errors->has('boat') ? 'is-invalid' : '' }}"
            name="boat[]" id="boat">
            <option value="">{{ translate('Select Golf') }}</option>
            @foreach ($get_boats as $C)
                <option value="{{ $C['id'] }}"
                    {{ getSelected($C['id'], old('boat', $GYRB['boat_id'])) }}>
                    {{ $C['title'] }}</option>
            @endforeach
        </select>

    </div>
    

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".single-select").select2();
    })
</script>

