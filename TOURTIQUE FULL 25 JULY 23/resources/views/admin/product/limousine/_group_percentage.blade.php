@php
    
    if (isset($append)) {
        $GPO = getTableColumn('products_options');
        $GPOGP = getTableColumn('product_option_group_percent');
    }
@endphp


<tr class="row_group_percentage">
    <td>
        <input type="hidden" name="option_group_percentage_id_[{{ $data }}][]" value="{{ $GPOGP['id'] }}">
        <input type="hidden" name="group_percentage_id[{{ $data }}][]" value="{{ $GPOGP['id'] }}">
        <input type="text" class="form-control numberonly" placeholder="{{ translate('Number Of Passenger') }}"
            value="{{ $GPOGP['number_of_passenger'] }}" name="group_percentage_no_passenger[{{ $data }}][]">
    </td>

    <td>
        <input class="form-control numberonly {{ $errors->has('tour_upgrade_price_adult') ? 'is-invalid' : '' }}"
            type="text" name="group_percentage_default_price[{{ $data }}][]"
            placeholder="{{ translate('Default') }} %" value="{{ $GPOGP['default_percentage'] }}" />
        @error('group_percentage_default_price')
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
                            if($GPOGP['weekdays_set_default'] == 1)
                            {
                                echo " checked";
                                $val = 1;
                            }else{
                                $val = 0;
                            }
                        }else{
                         
                            $val = 0;
                        } @endphp />
        <input type="hidden" name="group_percent_week_set_default[{{ $data }}][]"
            value="{{ $val }}">
    </td>
    <td>

        <input class="form-control numberonly {{ $errors->has('tour_upgrade_price_child') ? 'is-invalid' : '' }}"
            type="text" name="group_percentage_weekdays_price[{{ $data }}][]"
            placeholder="{{ translate('WeekDays') }} %"
            @php if($GPOGP['weekdays_set_default'] != 1 )
                            {
                                echo "value=' N/A' readonly";
                            }else{
                                echo "value=".$GPOGP['weekdays_percentage']."";
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
                            if($GPOGP['period_set_default'] == 1)
                            {
                                echo " checked";
                                $val = 1;
                            }else{
                                $val = 0;
                            }
                        }else{
                            
                            $val = 0;
                        } @endphp />
        <input type="hidden" name="group_percent_period_set_default[{{ $data }}][]"
            value="{{ $val }}">

    </td>
    <td>
        <input class="form-control numberonly {{ $errors->has('tour_upgrade_price_infant') ? 'is-invalid' : '' }}"
            type="text" name="group_percentage_period_price[{{ $data }}][]"
            placeholder="{{ translate('Period') }} %"
            @php if($GPOGP['period_set_default'] != 1 )
                    {
                        echo "value=' N/A' readonly";
                    }else{
                        echo "value=".$GPOGP['period_percentage']."";
                    } @endphp>
        @error('group_percentage_period_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </td>
    <td>
        <button class="delete_group_precentage_row bg-card btn btn-danger btn-sm " data-id="{{ $data }}"
            type="button">
            <span class="fa fa-trash"></span>
        </button>
    </td>
</tr>
