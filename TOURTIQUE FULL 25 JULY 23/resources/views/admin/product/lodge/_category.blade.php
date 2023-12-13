@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_category = [];
        $GPC = getTableColumn('product_categories');
    }
    
@endphp

<div class="row row_category_tour">
    <div class="col-md-5 content_title ">
        <label class="form-label " for="price">{{ translate('Category') }}
            <span class="text-danger">*</span></label>
        <select class="form-select single-select  {{ $errors->has('category.' . $data) ? 'is-invalid' : '' }} category"
            data-id="{{ $data }}" name="category[]" id="category_{{ $data }}">
            <option value="">{{ translate('Select Category') }}</option>
            @if ($GPC['id'] != '')
                @foreach ($categories as $item)
                    <option value="{{ $item['id'] }}" {{ getSelected($item['id'], $GPC['category']) }}>
                        {{ $item['name'] }}</option>
                @endforeach
            @else
            @endif
        </select>
        <div class="invalid-feedback">
        </div>
    </div>
    @php
        $SubCategory = App\Models\Category::select('categories.*', 'category_language.description as name')
            ->where('categories.parent', $GPC['category'])
            ->join('category_language', 'categories.id', '=', 'category_language.category_id')
            ->groupBy('categories.id')
            ->get();
    @endphp
    <div class="col-md-5 content_title ">
        <label class="form-label " for="price">{{ translate('Sub Category') }}
        </label>
        <select class="form-select multi-select sub_category {{ $errors->has('sub_category') ? 'is-invalid' : '' }}"
            name="sub_category[]" id="sub_category{{ $data }}">
            <option value="">{{ translate('Select Sub Category') }}</option>
            @if ($GPC['id'] != '')
                @foreach ($SubCategory as $item)
                    <option value="{{ $item->id }}" {{ getSelected($item->id, $GPC['sub_category']) }}>
                        {{ $item->name }}</option>
                @endforeach
            @endif

        </select>
        <div class="invalid-feedback">
        </div>
    </div>
    <div class="col-md-2 content_title align-self-md-end ">
        <button class="delete_category_row bg-card btn btn-danger btn-sm " data-id="{{ $data }}"
            type="button">
            <span class="fa fa-trash"></span>
        </button>
    </div>

</div>
<script>
    $('.category').select2();
    $('.sub_category').select2();
</script>
