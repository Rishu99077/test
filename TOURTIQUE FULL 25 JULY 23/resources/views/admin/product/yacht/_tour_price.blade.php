@php
    
    if (isset($append)) {
        $GPO = getTableColumn('products_options');
        $GPOWT = getTableColumn('product_option_week_tour');
    }
@endphp

@php
    
    $ProductTourPriceDetails = (array) getDataFromDB('product_tour_price_details', ['product_id' => $GPO['product_id'], 'product_option_id' => $GPO['id']], 'row');
    if (!$ProductTourPriceDetails) {
        $ProductTourPriceDetails = getTableColumn('product_tour_price_details');
    }
@endphp
<tr class="row_week_tour">
    <td>
        <input type="hidden" name="week_tour_id[{{ $data }}][]" value="{{ $GPOWT['id']  }}">
        <select class="form-select single-select tour_option_week_days tour_option_week_days{{ $data }}"
            name="tour_week[{{ $data }}][]" id="tour_option_week_days_{{ $data }}_{{ $id }}"
            data-id="{{ $data }}" data-tour="{{ $id }}">
            @if ($GPOWT['id'] != '')
                @foreach ($wreekArr as $WA)
                    @if (!in_array($WA, $existWeek) || $GPOWT['week_day'] == $WA)
                        <option {{ getSelected($GPOWT['week_day'], $WA) }}>{{ $WA }}</option>
                    @endif
                @endforeach
            @else
            @endif
        </select>

    </td>

    <td>
        <input class="form-control numberonly {{ $errors->has('tour_price_adult') ? 'is-invalid' : '' }}" type="text"
            name="tour_week_price_adult[{{ $data }}][]" placeholder="{{ translate('Adult Price') }}"
            value="{{ $GPOWT['adult'] }}" />
        @error('tour_price_adult')
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
                            if($GPOWT['child_allowed'] == 1)
                            {
                                echo " checked";
                                $val = 1;
                            }else{
                                $val = 0;
                            }
                        }else{
                            echo " checked";
                            $val =1;

                        } @endphp />
        <input type="hidden" name="tour_week_child_allowed[{{ $data }}][]" value="{{ $val }}">
    </td>
    <td>

        <input class="form-control numberonly {{ $errors->has('tour_price_child') ? 'is-invalid' : '' }}"
            type="text" name="tour_week_price_child[{{ $data }}][]"
            placeholder="{{ translate('Child Price') }}"
            @php if($GPOWT['child_allowed'] != 1 && !isset($append) && $get_product['id'] != "")
                            {
                                echo "value=' N/A' readonly";
                            }else{
                                echo "value=".$GPOWT['child_price']."";
                            } @endphp>
        @error('tour_price_child')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    
    <td>
        <input class="form-control numberonly {{ $errors->has('minimum_food') ? 'is-invalid' : '' }}"
            type="text" name="tour_week_price_infant[{{ $data }}][]"
            placeholder="{{ translate('Minimum food') }}"
            @php if($GPOWT['minimum_food'] == '0' && !isset($append)&& $get_product['id'] != "")
                    {
                        echo "value=' N/A' readonly";
                    }else{
                        echo "value=".$GPOWT['minimum_food']."";
                    } @endphp>
        @error('minimum_food')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <button class="delete_tour_row bg-card btn btn-danger btn-sm " data-id="{{ $data }}" type="button">
            <span class="fa fa-trash"></span>
        </button>
    </td>
</tr>
