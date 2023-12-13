@php
    
    if (isset($append)) {
        $get_product_lodge_language = [];
        $PLP = getTableColumn('product_lodge_price_details');
    }
@endphp
<tr class="lodge_price_row">
    <td>
        <input type="hidden" id="lodge_price_id" name="lodge_price_id[{{ $data }}][]" value="{{ $PLP['id'] }}"/>
        <input class="form-control  {{ $errors->has('lodge_price_title') ? 'is-invalid' : '' }}" type="text"
            name="lodge_price_title[{{ $data }}][]" placeholder="{{ translate('Enter Title') }}"
            value="{{ $PLP['title'] }}" />
        @error('lodge_price_title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <input class="form-control datetimepickerout datetimepicker {{ $errors->has('lodge_price_from_date') ? 'is-invalid' : '' }}"
            type="text" name="lodge_price_from_date[{{ $data }}][]" placeholder="{{ translate('From Date') }}"
            value="{{ $PLP['from_date'] }}" />
        @error('lodge_price_from_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <input class="form-control datetimepickerout datetimepicker {{ $errors->has('lodge_price_to_date') ? 'is-invalid' : '' }}"
            type="text" name="lodge_price_to_date[{{ $data }}][]"
            placeholder="{{ translate('From Date') }}" value="{{ $PLP['to_date'] }}" />
        @error('lodge_price_to_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <input class="form-control numberonly {{ $errors->has('lodge_price') ? 'is-invalid' : '' }}" type="text"
            name="lodge_price[{{ $data }}][]" placeholder="{{ translate('Enter Price') }}"
            value="{{ $PLP['price'] }}" />
        @error('lodge_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <button type="button" class="bg-card btn btn-danger btn-sm delete_lodge_price_row"> <span
                class="fa fa-trash"></span> </button>
    </td>
</tr>

<script>
    $(".datetimepickerout").flatpickr({
        minDate: 'today',
        enableTime: false,
        dateFormat: "Y-m-d",
    });
</script>
