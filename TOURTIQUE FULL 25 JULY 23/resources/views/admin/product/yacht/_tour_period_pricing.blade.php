@php
    
    if (isset($append)) {
        $GPO = getTableColumn('products_options');
        $GPOPP = getTableColumn('product_option_period_pricing');
    }
@endphp

<tr class="row_period_pricing">
    <td>
        <input type="hidden" name="option_period_pricing_id_[{{ $data }}][]" value="{{ $GPOPP['id'] }}">
        <input type="hidden" name="period_pricing_id[{{ $data }}][]" value="{{ $GPOPP['id'] }}">
        <input type="text" class="form-control datetimepickerdate " value="{{ $GPOPP['from_date'] }}"
            name="period_pricing_from_date[{{ $data }}][]">
    </td>
    <td>

        <input type="text" class="form-control datetimepickerdate " value="{{ $GPOPP['to_date'] }}"
            name="period_pricing_to_date[{{ $data }}][]">
    </td>

    <td>
        <input class="form-control numberonly {{ $errors->has('tour_period_price_adult') ? 'is-invalid' : '' }}"
            type="text" name="tour_period_price_adult[{{ $data }}][]"
            placeholder="{{ translate('Adult Price') }}" value="{{ $GPOPP['adult_price'] }}" />
        @error('tour_period_price_adult')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>

        <input class="form-check-input mt-2 tour_child_allowed" id="flexCheckDefault" id="option_status" type="checkbox"
            name="" value="1"
            @php if($GPO['product_id'] != "")
                        {
                            if($GPOPP['child_allowed'] == 1)
                            {
                                echo " checked";
                                $val = 1;
                            }else{
                                $val = 0;
                            }
                        }else{
                            echo " checked";
                            $val = 1;
                        } @endphp />
        <input type="hidden" name="period_pricing_child_allowed[{{ $data }}][]" value="{{ $val }}">
    </td>
    <td>

        <input class="form-control numberonly {{ $errors->has('tour_period_price_child') ? 'is-invalid' : '' }}"
            type="text" name="tour_period_price_child[{{ $data }}][]"
            placeholder="{{ translate('Child Price') }}"
            @php if($GPOPP['child_allowed'] != 1 && !isset($append) && $get_product['id'] != "")
                            {
                                echo "value=' N/A' readonly";
                            }else{
                                echo "value=".$GPOPP['child_price']."";
                            } @endphp>
        @error('tour_period_price_child')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>

        <input class="form-check-input mt-2 tour_infant_allowed" id="flexCheckDefault" id="option_status"
            type="checkbox" name="" value="1"
            @php if($GPO['product_id'] != "")
                    {
                            if($GPOPP['infant_allowed'] == 1)
                            {
                                echo " checked";
                                $val = 1;
                            }else{
                                $val = 0;
                            }
                        }else{
                            echo " checked";
                            $val = 1;
                        } @endphp />
        <input type="hidden" name="period_pricing_infant_allowed[{{ $data }}][]" value="{{ $val }}">

    </td>
    <td>
        <input class="form-control numberonly {{ $errors->has('period_price_infant') ? 'is-invalid' : '' }}"
            type="text" name="period_price_infant[{{ $data }}][]"
            placeholder="{{ translate('Infant Price') }}"
            @php if($GPOPP['infant_allowed'] != 1 && !isset($append)&& $get_product['id'] != "")
                    {
                        echo "value=' N/A' readonly";
                    }else{
                        echo "value=".$GPOPP['infant_price']."";
                    } @endphp>
        @error('period_price_infant')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <button class="delete_period_pricing_row bg-card btn btn-danger btn-sm " data-id="{{ $data }}"
            type="button">
            <span class="fa fa-trash"></span>
        </button>
    </td>
</tr>

<script>
    $(".datetimepickerdate").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
</script>
