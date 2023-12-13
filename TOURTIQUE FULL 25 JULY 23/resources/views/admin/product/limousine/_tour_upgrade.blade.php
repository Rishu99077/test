@php
    
    if (isset($append)) {
        $GPO = getTableColumn('products_options');
        $GPOTU = getTableColumn('product_option_tour_upgrade');
    }
@endphp

<tr class="row_tour_upgrade">
    <td>
        <input type="hidden" name="option_tour_upgrade_id_[{{ $data }}][]" value="{{ $GPOTU['id'] }}">
        <input type="hidden" name="tour_upgrade_id[{{ $data }}][]" value="{{ $GPOTU['id'] }}">
        <input type="text" class="form-control" value="{{ $GPOTU['title'] }}"
            name="tour_upgrade_title[{{ $data }}][]">
    </td>

    <td>
        <input class="form-control numberonly {{ $errors->has('tour_upgrade_price_adult') ? 'is-invalid' : '' }}"
            type="text" name="tour_upgrade_price_adult[{{ $data }}][]"
            placeholder="{{ translate('Adult Price') }}" value="{{ $GPOTU['adult_price'] }}" />
        @error('tour_upgrade_price_adult')
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
                            if($GPOTU['child_allowed'] == 1)
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
        <input type="hidden" name="tour_upgrade_child_allowed[{{ $data }}][]" value="{{ $val }}">
    </td>
    <td>

        <input class="form-control numberonly {{ $errors->has('tour_upgrade_price_child') ? 'is-invalid' : '' }}"
            type="text" name="tour_upgrade_price_child[{{ $data }}][]"
            placeholder="{{ translate('Child Price') }}"
            @php if($GPOTU['child_allowed'] != 1 && !isset($append) && $get_product['id'] != "")
                            {
                                echo "value=' N/A' readonly";
                            }else{
                                echo "value=".$GPOTU['child_price']."";
                            } @endphp>
        @error('tour_upgrade_price_child')
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
                            if($GPOTU['infant_allowed'] == 1)
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
        <input type="hidden" name="tour_upgrade_infant_allowed[{{ $data }}][]" value="{{ $val }}">

    </td>
    <td>
        <input class="form-control numberonly {{ $errors->has('tour_upgrade_price_infant') ? 'is-invalid' : '' }}"
            type="text" name="tour_upgrade_price_infant[{{ $data }}][]"
            placeholder="{{ translate('Infant Price') }}"
            @php if($GPOTU['infant_allowed'] != 1 && !isset($append)&& $get_product['id'] != "")
                    {
                        echo "value=' N/A' readonly";
                    }else{
                        echo "value=".$GPOTU['infant_price']."";
                    } @endphp>
        @error('tour_upgrade_price_infant')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <button class="delete_tour_upgrade_row bg-card btn btn-danger btn-sm " data-id="{{ $data }}"
            type="button">
            <span class="fa fa-trash"></span>
        </button>
    </td>
</tr>
