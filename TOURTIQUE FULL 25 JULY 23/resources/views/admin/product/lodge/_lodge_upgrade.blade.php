@php
    
    if (isset($append)) {
        $GPL = getTableColumn('product_lodge');
        $GLOLU = getTableColumn('product_option_tour_upgrade');
    }
@endphp

<tr class="row_lodge_upgrade">
    <td>
        <input type="hidden" name="option_lodge_upgrade_id_[{{ $data }}][]" value="{{ $GLOLU['id'] }}">
        <input type="hidden" name="lodge_upgrade_id[{{ $data }}][]" value="{{ $GLOLU['id'] }}">
        <input type="text" class="form-control" value="{{ $GLOLU['title'] }}"
            name="lodge_upgrade_title[{{ $data }}][]">
    </td>

    <td>
        <input class="form-control numberonly {{ $errors->has('lodge_upgrade_price_adult') ? 'is-invalid' : '' }}"
            type="text" name="lodge_upgrade_price_adult[{{ $data }}][]"
            placeholder="{{ translate('Adult Price') }}" value="{{ $GLOLU['adult_price'] }}" />
        @error('lodge_upgrade_price_adult')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>

        <input class="form-check-input mt-2 tour_child_allowed" id="flexCheckDefault" id="option_status" type="checkbox"
            name="" value="1"
            @php if($GPL['product_id'] != "")
                        {
                            if($GLOLU['child_allowed'] == 1)
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
        <input type="hidden" name="lodge_upgrade_child_allowed[{{ $data }}][]" value="{{ $val }}">
    </td>
    <td>

        <input class="form-control numberonly {{ $errors->has('lodge_upgrade_price_child') ? 'is-invalid' : '' }}"
            type="text" name="lodge_upgrade_price_child[{{ $data }}][]"
            placeholder="{{ translate('Child Price') }}"
            @php if($GLOLU['child_allowed'] != 1 && !isset($append) && $get_product['id'] != "")
                            {
                                echo "value=' N/A' readonly";
                            }else{
                                echo "value=".$GLOLU['child_price']."";
                            } @endphp>
        @error('lodge_upgrade_price_child')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>

        <input class="form-check-input mt-2 tour_infant_allowed" id="flexCheckDefault" id="option_status"
            type="checkbox" name="" value="1"
            @php if($GPL['product_id'] != "")
                    {
                            if($GLOLU['infant_allowed'] == 1)
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
        <input type="hidden" name="lodge_upgrade_infant_allowed[{{ $data }}][]" value="{{ $val }}">

    </td>
    <td>
        <input class="form-control numberonly {{ $errors->has('lodge_upgrade_price_infant') ? 'is-invalid' : '' }}"
            type="text" name="lodge_upgrade_price_infant[{{ $data }}][]"
            placeholder="{{ translate('Infant Price') }}"
            @php if($GLOLU['infant_allowed'] != 1 && !isset($append)&& $get_product['id'] != "")
                    {
                        echo "value=' N/A' readonly";
                    }else{
                        echo "value=".$GLOLU['infant_price']."";
                    } @endphp>
        @error('lodge_upgrade_price_infant')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <button class="delete_lodge_upgrade_row bg-card btn btn-danger btn-sm " data-id="{{ $GLOLU['id'] }}"
            type="button">
            <span class="fa fa-trash"></span>
        </button>
    </td>
</tr>
