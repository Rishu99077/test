@php
    $count = 0;
    if (isset($params_arr)) {
        $count = $params_arr['data'];
        $get_session_language = getLang();

        $language_id = $get_session_language['id'];
        $get_category = App\Models\Categories::orderBy('id', 'desc')
            ->where(['status' => 'Active'])
            ->whereNull('is_delete')
            ->get();

        $categories = [];
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id'] = $value['id'];
                $row['status'] = $value['status'];
                $categories[] = $row;
            }
        }

        $CT = getTableColumn('tax');
        $CT['title'] = '';
    }
@endphp
<div class="row">
    <input type="hidden" name="category_tax_id[]" value="{{ $CT['id'] }}">

    <div class="col-md-5">
        <div class="form-group mb-3 {{ $errors->has('Title') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Title') }}</label>
            <input type="text" class="category_title form-control" name="category_title[]" placeholder="Enter title"
                value="{{ $CT['title'] }}">

            @error('destination_title')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('category') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Category') }}</label>
            <select id="category_{{ $count }}" name="category[]" data-count="{{ $count }}"
                class="form-control select2">
                <option value="" selected>Select</option>
                @foreach ($categories as $C)
                    <option value="{{ $C['id'] }}" {{ getSelected($C['id'], $CT['category']) }}>
                        {{ $C['title'] }}</option>
                @endforeach

            </select>
            @error('category')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('tax_type') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Tax Type') }}</label>
            <select name="category_tax_type[]" id="" class="form-control">
                <option value="percentage" {{ getSelected('percentage', $CT['tax_type']) }}>Percentage</option>
                <option value="fixed" {{ getSelected('fixed', $CT['tax_type']) }}>Fixed</option>
            </select>
            @error('tax')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('tax') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Tax Value') }}</label>
            <input type="text" class="numberonly form-control" name="category_tax[]" value="{{ $CT['amount'] }}">
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
