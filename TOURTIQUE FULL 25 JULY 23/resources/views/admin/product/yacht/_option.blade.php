@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_option_language = [];
        $get_product_option_week_tour = [];
        $get_product_option_tour_upgrade = [];
        $get_product_option_period_pricing = [];
        $GPO = getTableColumn('products_options');
        $get_timings = App\Models\Timing::all();
    }
    $product_option_time = getDataFromDB('product_option_time', ['status' => 1]);
@endphp
<div class="row mb-2">
    <div class="bg-200 br-5 col-md-12 p-1">
        <button class="delete_option bg-card btn btn-danger btn-sm float-end" data-rowid="{{ $data }}"
            type="button"><span class="fa fa-trash"></span></button>
        <button class="minimize_btn bg-card btn btn-primary me-1 btn-sm float-end" type="button"
            data-rowid="{{ $data }}">-
        </button>
    </div>
</div>
<div class="row option_div" id="option_div{{ $data }}">

    <input type="hidden" name="options_id[{{ $data }}]" value="{{ $GPO['id'] }}">

    @php
        $ProductPrivateTourPrice = (array) getDataFromDB('product_option_private_tour_price', ['product_id' => $GPO['product_id'], 'product_option_id' => $GPO['id']], 'row');
        if (!$ProductPrivateTourPrice) {
            $ProductPrivateTourPrice = getTableColumn('product_option_private_tour_price');
        }
        if ($GPO['id'] != '') {
            if (count($get_timings) == 0) {
                $get_timings = App\Models\Timing::all();
            }
        }
    @endphp

   
    <div class="col-md-6">
        <label class="form-label" for="title">{{ translate('Tour Option') }}
        </label>
        <input class="form-control {{ $errors->has('tour_option.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Tour Option') }}" id="title"
            name="tour_option[{{ $lang_id }}][{{ $data }}]" type="text"
            value="{{ getLanguageTranslate($get_product_option_language, $lang_id, $GPO['id'], 'title', 'option_id') }}" />
        @error('tour_option.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="addtional_info">{{ translate('Additional Info') }}
        </label>
        <textarea class="form-control {{ $errors->has('addtional_info.' . $lang_id) ? 'is-invalid' : '' }}" cols="50"
            row="3" placeholder="{{ translate('Enter Additional Info') }}" id="addtional_info"
            name="addtional_info[{{ $lang_id }}][{{ $data }}]" type="text">{{ getLanguageTranslate($get_product_option_language, $lang_id, $GPO['id'], 'description', 'option_id') }}</textarea>
        @error('addtional_info.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
   
    @php
        $transferArr = getDataFromDB('product_transfer_option');
    @endphp

    <div class="mt-2" style="display: none;">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Tour Availability') }}</h5>
        <div class="form-check avia_div">
            <div class="row">
                <div class="col-md-1">
                    <input class="form-check-input available_record" id="daily_{{ $data }}" type="radio"
                        data-id="{{ $data }}" value="daily" name="available_type[{{ $data }}]"
                        checked="">
                    <label class="form-check-label" for="daily_{{ $data }}">{{ translate('Daily') }}</label>
                </div>
                <div class="col-md-4">
                    <input class="form-check-input available_record" data-id="{{ $data }}"
                        id="days_available_{{ $data }}"
                        {{ getChecked('days_available', $GPO['available_type']) }} type="radio"
                        value="days_available" name="available_type[{{ $data }}]">
                    <label class="form-check-label"
                        for="days_available_{{ $data }}">{{ translate('Select Days Available') }}</label>
                    <div
                        class="row div_days_available_{{ $data }} @if ($GPO['available_type'] == 'days_available') @else {{ ' d-none' }} @endif available_record_div_{{ $data }}">
                        <div class="col-md-12 content_title show_timings append_weekdays ">
                            @php
                                $product = json_decode($GPO['days_available']);
                                if ($product == '') {
                                    $product = [];
                                }
                            @endphp

                            <table class="table table-responsive bg-white">
                                <thead>
                                    <tr>
                                        <td colspan="2">{{ translate('Same Time For All Weekdays') }}

                                        </td>

                                        <td>
                                            <div class="form-check form-switch pl-0">
                                                <input class="form-check-input float-end time_for_all_weekdays"
                                                    id="time_for_all_weekdays{{ $data }}" type="checkbox"
                                                    {{ getChecked(1, $GPO['same_time_for_weekdays']) }}
                                                    value="{{ $GPO['same_time_for_weekdays'] }}"
                                                    data-id="{{ $data }}"
                                                    name="time_for_all_weekdays[{{ $data }}]">
                                            </div>
                                        </td>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $days_available = json_decode($GPO['days_available']);
                                        if ($days_available == '') {
                                            $days_available = [];
                                        }
                                    @endphp
                                    @foreach ($days_available as $daysKey => $GPDA)
                                        @php
                                            
                                            $NewWeekArr[$daysKey] = $GPDA;
                                        @endphp
                                    @endforeach

                                    @foreach ($get_timings as $timeKey => $GT)
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch pl-0">
                                                    <input class="form-check-input float-end timing_status"
                                                        id="timing_status" type="checkbox" value="Active"
                                                        {{ isset($NewWeekArr[$GT['day']]) ? ' checked' : '' }}
                                                        name="available_tour_week_time_status[{{ $data }}][{{ $GT['day'] }}]">
                                                </div>
                                            </td>
                                            <td>
                                                {{ $GT['day'] }}
                                            </td>
                                            <td style="min-width: 103px !important;">

                                                <select class="form-select multi-select available_tour_week_time"
                                                    name="available_tour_week_time[{{ $data }}][{{ $GT['day'] }}][]"
                                                    data-id="{{ $timeKey }}" data-dataid="{{ $data }}"
                                                    id="available_tour_week_time{{ $data }}{{ $timeKey }}"
                                                    multiple>
                                                    @foreach ($product_option_time as $POT)
                                                        <option value="{{ $POT->id }}"
                                                            {{ isset($NewWeekArr[$GT['day']]) ? getSelectedInArray($POT->id, $NewWeekArr[$GT['day']]) : '' }}>
                                                            {{ $POT->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <input class="form-check-input available_record" data-id="{{ $data }}"
                        id="date_available_{{ $data }}"
                        {{ getChecked('date_available', $GPO['available_type']) }} type="radio"
                        value="date_available" name="available_type[{{ $data }}]">

                    <label class="form-check-label"
                        for="date_available_{{ $data }}">{{ translate('Select Date Available') }}</label>
                    <div
                        class="div_date_available_{{ $data }} @if ($GPO['available_type'] == 'date_available') @else{{ ' d-none' }} @endif available_record_div_{{ $data }}">
                        {{-- <input class="form-control  option_available_date"
                            id="option_available_date{{ $data }}"
                            name="option_available_date[{{ $data }}]" type="text" placeholder="Y-m-d"
                            value="" /> --}}

                        <table class="table table-responsive bg-white">
                            <thead>
                                <tr>
                                    <td colspan="2">{{ translate('Same Time For All Dates') }}</td>
                                    <td>
                                        <div class="form-check form-switch pl-0">
                                            <input class="form-check-input float-end time_for_all_dates"
                                                id="time_for_all_dates{{ $data }}" type="checkbox"
                                                {{ getChecked(1, $GPO['same_time_for_dates']) }}
                                                value="{{ $GPO['same_time_for_dates'] }}"
                                                data-id="{{ $data }}"
                                                name="time_for_all_dates[{{ $data }}]">
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tbody_tour_date_box_{{ $data }}">
                                @php
                                    $tour_date_id = 0;
                                @endphp
                                @php
                                    $date_available = json_decode($GPO['date_available']);
                                    if ($date_available == '') {
                                        $date_available = [];
                                    }
                                @endphp
                                @foreach ($date_available as $dateKey => $DA)
                                    @include('admin.product.excursion._tour_date_time')
                                    @php
                                        $tour_date_id++;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <button class="btn btn-success btn-sm add_tour_avail_date"
                                            data-dataid="{{ $data }}" data-id="{{ $tour_date_id }}"
                                            type="button">
                                            <span class="fa fa-plus"></span>
                                            {{ translate('Add More') }}</button>
                                    </td>
                                </tr>

                            </tfoot>

                        </table>

                    </div>
                </div>
                @php
                    $available_type = 1;
                @endphp
                @if ($GPO['available_type'] == 'days_available')
                    @php
                        $available_type = $GPO['same_time_for_weekdays'];
                    @endphp
                @elseif($GPO['available_type'] == 'date_available')
                    @php
                        $available_type = $GPO['same_time_for_dates'];
                    @endphp
                @endif
                <div
                    class="col-md-3 time_availble_div{{ $data }} @if ($available_type == 0) {{ ' d-none' }} @endif">

                    <label class="form-check-label"
                        for="time_available">{{ translate('Select Available Time') }}</label>
                    <select class="form-select multi-select" name="option_available_time[{{ $data }}][]"
                        id="option_available_time{{ $data }}" multiple>
                        @foreach ($product_option_time as $POT)
                            <option value="{{ $POT->id }}"
                                {{ getSelectedInArray($POT->id, $GPO['time_available']) }}>{{ $POT->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12 content_title tour_price_box {{ $GPO['is_private_tour'] != 0 ? 'd-none' : '' }}">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Tour Price') }}</h5>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Adult Price') }}</th>
                    <th>{{ translate('Child Allowed') }}</th>
                    <th>{{ translate('Child Price') }}</th>
                    <th>{{ translate('Minimum food') }}</th>
                </tr>
            <tbody>
                @php
                    $ProductTourPriceDetails = (array) getDataFromDB('product_tour_price_details', ['product_id' => $GPO['product_id'], 'product_option_id' => $GPO['id']], 'row');
                    if (!$ProductTourPriceDetails) {
                        $ProductTourPriceDetails = getTableColumn('product_tour_price_details');
                    }
                @endphp
                <tr>

                    <td>
                        <input type="hidden" name="tour_price_details_id[{{ $data }}]"
                            value="{{ $ProductTourPriceDetails['id'] }}" />
                        <input
                            class="form-control numberonly {{ $errors->has('tour_price_adult') ? 'is-invalid' : '' }}"
                            type="text" name="tour_price_adult[{{ $data }}]"
                            placeholder="{{ translate('Adult Price') }}"
                            value="{{ $ProductTourPriceDetails['adult_price'] }}" />
                        @error('tour_price_adult')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>

                        <input class="form-check-input mt-2 tour_child_allowed" id="flexCheckDefault"
                            id="option_status" type="checkbox" name="tour_child_allowed[{{ $data }}]"
                            value="1"
                            @php if($GPO['product_id'] != "")
                                {
                                    if($ProductTourPriceDetails['child_allowed'] == 1)
                                    {
                                        echo " checked";
                                    }
                                }else{
                                    echo " checked";
        
                                } @endphp />
                    </td>
                    <td>

                        <input
                            class="form-control numberonly {{ $errors->has('tour_price_child') ? 'is-invalid' : '' }}"
                            type="text" name="tour_price_child[{{ $data }}]"
                            placeholder="{{ translate('Child Price') }}"
                            @php if($ProductTourPriceDetails['child_allowed'] != 1 && !isset($append) && $get_product['id'] != "")
                                    {
                                        echo "value=' N/A' readonly";
                                    }else{
                                        echo "value=".$ProductTourPriceDetails['child_price']."";
                                    } @endphp>
                        @error('tour_price_child')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('minimum_food') ? 'is-invalid' : '' }}"
                            type="text" name="minimum_food[{{ $data }}]"
                            placeholder="{{ translate('Minimum food') }}"
                            @php if($ProductTourPriceDetails['minimum_food'] == '0' && !isset($append)&& $get_product['id'] != "")
                            {
                                echo "value=' N/A' readonly";
                            }else{
                                echo "value=".$ProductTourPriceDetails['minimum_food']."";
                            } @endphp>
                        @error('minimum_food')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                </tr>
            </tbody>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>

    <div class="col-md-6 content_title " style="display: none;">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Room Details') }}
            <small>({{ translate('Enter no of person allowed in rooms') }})</small>
        </h5>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Adult') }}</th>
                    <th>{{ translate('Child') }}</th>
                    <th>{{ translate('Infant') }}</th>
                    <th>{{ translate('No Limit') }}</th>
                    <th>{{ translate('Price') }}</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $product_tour_room = (array) getDataFromDB('product_tour_room', ['product_id' => $GPO['product_id'], 'product_option_id' => $GPO['id']], 'row');
                    if (!$product_tour_room) {
                        $product_tour_room = getTableColumn('product_tour_room');
                    }
                    
                @endphp
                <tr>
                    <td>
                        <input type="hidden" name="product_tour_room_id[{{ $data }}]"
                            value="{{ $product_tour_room['id'] }}">
                        <input
                            class="form-control numberonly {{ $errors->has('tour_room_adult') ? 'is-invalid' : '' }}"
                            type="text" name="tour_room_adult[{{ $data }}]"
                            placeholder="{{ translate('Enter No. Of Adult Person') }}"
                            value="{{ $product_tour_room['adult'] }}" />
                        @error('tour_room_adult')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('tour_room_child') ? 'is-invalid' : '' }}"
                            type="text" name="tour_room_child[{{ $data }}]"
                            placeholder="{{ translate('Enter No. Of Child') }}"
                            value="{{ $product_tour_room['child'] }}" />
                        @error('tour_room_child')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('tour_room_infant') ? 'is-invalid' : '' }}"
                            type="text" name="tour_room_infant[{{ $data }}]"
                            placeholder="{{ translate('Enter No. Infant ') }}"
                            @php if($product_tour_room['infant_limit'] == 1)
                            {
                                echo "value=' No Limit' readonly";
                            }else{
                                echo "value=".$product_tour_room['infant']."";
                            } @endphp>
                        @error('tour_room_infant')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input class="form-check-input mt-2 tour_infant_limit" id="flexCheckDefault"
                            id="tour_infant_limit" type="checkbox" name="tour_infant_limit[{{ $data }}]"
                            value="1"
                            @php if($GPO['product_id'] != "")
                        {
                            if($product_tour_room['infant_limit'] == 1)
                            {
                                echo " checked";
                            }
                        } @endphp />
                    </td>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('tour_room_price') ? 'is-invalid' : '' }}"
                            type="text" name="tour_room_price[{{ $data }}]"
                            placeholder="{{ translate('Enter Room Price') }}"
                            value="{{ $product_tour_room['price'] }}" />
                        @error('tour_room_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <button
            class="btn btn-sm btn-success mb-1 ml-20 w-25 add_week_days_price {{ $GPO['is_private_tour'] != 0 ? 'd-none' : '' }} week_days_btn"
            type="button" data-val="{{ $data }}" {{ $ProductPrivateTourPrice['id'] }}> <span
                class="fa fa-plus"></span>
            {{ translate('Add Week Days Price') }}
        </button>
    </div>

    <div
        class="show_tour_price{{ $data }} @if (empty($get_product_option_week_tour)) {{ 'd-none' }} @endif  week_days_box {{ $GPO['is_private_tour'] != 0 ? 'd-none' : '' }}">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Week Days') }}</th>
                    <th>{{ translate('Adult Price') }}</th>
                    <th>{{ translate('Child Allowed') }}</th>
                    <th>{{ translate('Child Price') }}</th>
                    <th>{{ translate('Minimum food') }}</th>
                    <th>{{ translate('Action') }}</th>
                </tr>
            </thead>
            <tbody class="show_tour_price_tbody{{ $data }}">
                @php
                    
                    $id = 1;
                    $wreekArr = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    
                    $getWeek = getDataFromDB('product_option_week_tour', ['product_id' => $GPO['product_id'], 'product_option_id' => $GPO['id']]);
                    
                    $existWeek = [];
                    foreach ($getWeek as $key => $GW) {
                        $existWeek[] = $GW->week_day;
                    }
                @endphp

                @foreach ($get_product_option_week_tour as $KK => $GPOWT)
                    @if ($GPO['id'] == $GPOWT['product_option_id'])
                        @include('admin.product.yacht._tour_price')
                    @else
                        @php
                            $id = 0;
                        @endphp
                    @endif
                    @php
                        $id++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Add Group Percentage --}}
    {{-- <div class="group_percent_box {{ $GPO['is_private_tour'] != 0 ? 'd-none' : '' }}">
        <div>
            <button class="btn btn-sm btn-success mb-1 ml-20 w-25 add_group_percent" type="button"
                data-val="{{ $data }}"> <span class="fa fa-plus"></span>
                {{ translate('Add Group Percentage') }}
            </button>
        </div>

        <div
            class="show_group_percent{{ $data }} @if (empty($get_product_option_group_percentage)) {{ 'd-none' }} @endif">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>{{ translate('Number Of Passenger') }}</th>
                        <th>{{ translate('Default') }} %</th>
                        <th>{{ translate('Set As Default') }}</th>
                        <th>{{ translate('WeekDays') }} %</th>
                        <th>{{ translate('Set As Default') }}</th>
                        <th>{{ translate('Period Pricing') }} %</th>
                        <th>{{ translate('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="show_group_percentage_tbody{{ $data }}">
                    @php
                        $id = 1;
                        
                    @endphp
                    @foreach ($get_product_option_group_percentage as $GP => $GPOGP)
                        @if ($GPO['id'] == $GPOGP['product_option_id'])
                            @include('admin.product.excursion._group_percentage')
                        @else
                            @php
                                $id = 0;
                            @endphp
                        @endif
                        @php
                            $id++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

    </div> --}}

    {{-- <div class="col-md-12 content_title {{ $GPO['is_private_tour'] != 0 ? 'd-none' : '' }} transfer_option_box">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Transfer Option') }}</th>
                    <th>{{ translate('Adult Price') }}</th>
                    <th>{{ translate('Child Price') }}</th>
                    <th>{{ translate('Infant') }}</th>
                    <th>{{ translate('Sort') }}</th>

                </tr>
            </thead>

            <tbody>

                @php
                    if (!isset($append)) {
                        if ($get_product['id'] == '') {
                            $get_product_option_details = $transferArr;
                        } else {
                            $get_product_option_details = $GPO->get_product_option_details;
                        }
                    } else {
                        $get_product_option_details = $transferArr;
                    }
                    
                @endphp

                @foreach ($get_product_option_details as $key => $GPOD)
                    @php
                        if (!isset($append)) {
                            if ($get_product['id'] == '') {
                                $TR = $GPOD->title;
                                $is_input = $GPOD->is_input;
                                $GPOD = getTableColumn('product_option_details');
                            } else {
                                $TR = $GPOD['transfer_option'];
                                $is_input = $GPOD['is_input'];
                            }
                        } else {
                            $TR = $GPOD->title;
                            $is_input = $GPOD->is_input;
                            $GPOD = getTableColumn('product_option_details');
                        }
                        
                    @endphp
                    <tr>
                        <td>
                            <input type="hidden"
                                name="get_product_option_details_id[{{ $data }}][{{ $key }}]"
                                value="{{ $GPOD['id'] }}">
                            <input class="form-check-input mt-2" id="flexCheckDefault" id="option_status"
                                type="checkbox" name="option_status[{{ $data }}][{{ $key }}]"
                                value="1" {{ getChecked('1', $GPOD['status']) }} />
                        </td>
                        <td>
                            @if ($is_input == 1)
                                <input type="text" class="form-control" value="{{ $TR }}"
                                    name="transfer_option_name[{{ $data }}][{{ $key }}]">
                            @else
                                <input type="hidden" class="form-control" value="{{ $TR }}"
                                    name="transfer_option_name[{{ $data }}][{{ $key }}]">
                                <span class="fw-black ms-2">{{ $TR }}</span>
                            @endif
                            <input type="hidden" name="is_input[{{ $data }}][{{ $key }}]"
                                value="{{ $is_input }}">

                            @if ($TR == 'Private Transfer')
                                <a href="javascript:void(0)" class="fs--1 private_transfer_modal text-black"
                                    data-dataid="{{ $data }}"><span class="fas fa-plus-circle"></span> </a>
                            @endif
                        </td>
                        <td>
                            <input class="form-control numberonly {{ $errors->has('adult') ? 'is-invalid' : '' }}"
                                type="text" name="adult[{{ $data }}][{{ $key }}]"
                                placeholder="{{ translate('Adult Price') }}" value="{{ $GPOD['edult'] }}" />
                            @error('adult')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>

                        <td>
                            <input
                                class="form-control numberonly {{ $errors->has('child_price') ? 'is-invalid' : '' }}"
                                type="text" name="child_price[{{ $data }}][{{ $key }}]"
                                placeholder="{{ translate('Adult Price') }}" value="{{ $GPOD['child_price'] }}" />
                            @error('child_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                        <td>
                            <input class="form-control numberonly {{ $errors->has('infant') ? 'is-invalid' : '' }}"
                                type="text" name="infant[{{ $data }}][{{ $key }}]"
                                placeholder="{{ translate('Enter Infant') }}" value="{{ $GPOD['infant'] }}" />
                            @error('infant')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                        <td>
                            <input class="form-control numberonly {{ $errors->has('sort') ? 'is-invalid' : '' }}"
                                type="text" name="sort[{{ $data }}][{{ $key }}]"
                                placeholder="{{ translate('Enter Sort Order') }}" value="{{ $GPOD['sort'] }}" />
                            @error('sort')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div> --}}

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

<script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script>
    $("#available_tour_date_time{{ $data }}_{{ $tour_date_id }}").select2();
    $(".multi-select").select2();
    $(".available_tour_week_time").each(function(key, val) {
        var id = $(val).data("id");
        var dataid = $(val).data("dataid");
        $("#available_tour_week_time" + dataid + id).select2();
    })

    $(".available_tour_date_time").each(function(key, val) {

        var id = $(this).attr("id");
        var dataid = $(val).data("dataid");
        $("#" + id).select2();
    })

    $(".datetimepicker").flatpickr({

        enableTime: true,
        dateFormat: "Y-m-d H:i",


    });
</script>
