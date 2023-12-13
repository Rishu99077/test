<div class="row">
    <input type="hidden" name="single_group_percentage_id" value="">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Main Title') }}
        </label>
        <input class="form-control {{ $errors->has('main_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Main Title') }}" id="main_title_{{ $lang_id }}" name="main_title[]"
            type="text" value="" />

        <div class="invalid-feedback">

        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="title">{{ translate('Group Percentage') }}
        </label>
        <input class="form-control {{ $errors->has('single_group_percentage.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Group Percentage') }}" id="group_single_group_percentage_{{ $lang_id }}"
            name="group_single_group_percentage[{{ $lang_id }}]" type="text" value="" />

        <div class="invalid-feedback">

        </div>

    </div>

    <div class="col-md-6">
        <label class="form-label" for="single_group_addtional_info">{{ translate('Additional Info') }}
        </label>
        <textarea class="form-control {{ $errors->has('single_group_addtional_info.' . $lang_id) ? 'is-invalid' : '' }}"
            cols="50" row="3" placeholder="{{ translate('Enter Additional Info') }}"
            id="group_single_group_addtional_info_{{ $lang_id }}"
            name="group_single_group_addtional_info[{{ $lang_id }}]" type="text"></textarea>

        <div class="invalid-feedback">

        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-6 content_title ">
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td>
                        <input class="form-check-input mt-2 " id="group_per_tax_allowed" type="checkbox"
                            name="group_per_tax_allowed" value="1" />
                        <label for="group_per_tax_allowed" class="fs-0 mt-1">{{ translate('Tax') }}</label>
                    </td>
                    <td>
                        <div class="input-group mb-3">
                            <input class="form-control numberonly" type="text"
                                placeholder="{{ translate('Enter Tax ') }}" name="group_per_tax" value=""
                                aria-label="Username" aria-describedby="basic-addon1"><span class="input-group-text"
                                id="basic-addon1">%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="col-md-6 content_title">
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td> <input class="form-check-input mt-2 " id="tax_check" type="checkbox"
                            name="group_per_service_charge" value="1" />
                        <label for="group_per_service_charge"
                            class="fs-0 mt-1">{{ translate('Service Charge') }}</label>
                    </td>
                    <td>
                        <div class="input-group mb-3"><input class="form-control numberonly" type="text"
                                placeholder="{{ translate('Enter Service Charge') }}" name="group_per_service_amount"
                                value="" aria-label="Username" aria-describedby="basic-addon1"><span
                                class="input-group-text" id="basic-addon1">{{ translate('Amount') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="mt-2">
    <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Tour Availability') }}</h5>
    <div class="form-check avia_div">
        <div class="row">
            <div class="col-md-1">
                <input class="form-check-input group_available_record" id="group_daily_{{ $data }}"
                    type="radio" data-id="{{ $data }}" value="daily" name="group_available_type"
                    checked="">
                <label class="form-check-label" for="group_daily_{{ $data }}">{{ translate('Daily') }}</label>
            </div>
            <div class="col-md-4">
                <input class="form-check-input group_available_record" data-id="{{ $data }}"
                    id="group_days_available_{{ $data }}" type="radio" value="days_available"
                    name="group_available_type">
                <label class="form-check-label"
                    for="group_days_available_{{ $data }}">{{ translate('Select Days Available') }}</label>
                <div
                    class="row div_group_days_available_{{ $data }} group_available_record_div_{{ $data }}">
                    <div class="col-md-12 content_title show_timings append_weekdays ">
                        @php
                            $product = json_decode($get_product_group_percentage['days_available']);
                            if ($product == '') {
                                $product = [];
                            }
                        @endphp
                        <table class="table table-responsive bg-white">
                            <thead>
                                <tr>
                                    <td colspan="2">
                                        {{ translate('Same Time For All Weekdays') }}
                                    </td>

                                    <td>
                                        <div class="form-check form-switch pl-0">
                                            <input class="form-check-input float-end group_time_for_all_weekdays"
                                                id="group_time_for_all_weekdays{{ $data }}" type="checkbox"
                                                value="" data-id="{{ $data }}"
                                                name="group_time_for_all_weekdays">
                                        </div>
                                    </td>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $days_available = json_decode($get_product_group_percentage['days_available']);
                                    if ($days_available == '') {
                                        $days_available = [];
                                    }
                                    $get_timings = App\Models\Timing::where('is_close', 0)->get();
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
                                                    name="group_available_tour_week_time_status[{{ $GT['day'] }}]">
                                            </div>
                                        </td>
                                        <td>
                                            {{ $GT['day'] }}
                                        </td>
                                        <td style="min-width: 103px !important;">

                                            <select class="form-select multi-select available_tour_week_time"
                                                name="group_available_tour_week_time[{{ $GT['day'] }}][]"
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
                <input class="form-check-input group_available_record" data-id="{{ $data }}"
                    id="group_date_available_{{ $data }}"
                    {{ getChecked('date_available', $get_product_group_percentage['available_type']) }} type="radio"
                    value="date_available" name="group_available_type">

                <label class="form-check-label"
                    for="group_date_available_{{ $data }}">{{ translate('Select Date Available') }}</label>
                <div
                    class="div_group_date_available_{{ $data }} @if ($get_product_group_percentage['available_type'] == 'date_available') @else{{ ' d-none' }} @endif group_available_record_div_{{ $data }}">

                    <table class="table table-responsive bg-white">
                        <thead>
                            <tr>
                                <td colspan="2">{{ translate('Same Time For All Dates') }}
                                </td>
                                <td>
                                    <div class="form-check form-switch pl-0">
                                        <input class="form-check-input float-end group_time_for_all_dates"
                                            id="group_time_for_all_dates{{ $data }}" type="checkbox"
                                            value="" data-id="" name="group_time_for_all_dates">
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="tbody_tour_group_date_box_{{ $data }}">
                            @php
                                $tour_date_id = 0;
                            @endphp
                            @php
                                $date_available = json_decode($get_product_group_percentage['date_available']);
                                if ($date_available == '') {
                                    $date_available = [];
                                }
                            @endphp
                            @foreach ($date_available as $dateKey => $DA)
                                @include('admin.product.excursion._buggy_group_timing')
                                @php
                                    $tour_date_id++;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <button class="btn btn-success btn-sm add_group_tour_avail_date"
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
            @if ($get_product_group_percentage['available_type'] == 'days_available')
                @php
                    $available_type = $get_product_group_percentage['same_time_for_weekdays'];
                @endphp
            @elseif($get_product_group_percentage['available_type'] == 'date_available')
                @php
                    $available_type = $get_product_group_percentage['same_time_for_dates'];
                @endphp
            @endif
            <div
                class="col-md-3 group_time_availble_div{{ $data }} @if ($available_type == 0) {{ ' d-none' }} @endif">

                <label class="form-check-label" for="time_available">{{ translate('Select Available Time') }}</label>
                <select class="form-select multi-select" name="group_option_available_time[]"
                    id="option_available_time{{ $data }}" multiple>
                    @foreach ($product_option_time as $POT)
                        <option value="{{ $POT->id }}"
                            {{ getSelectedInArray($POT->id, $get_product_group_percentage['time_available']) }}>
                            {{ $POT->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>

<div class="col-md-12 content_title ">
    <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Group Price') }}
        <small>({{ translate('Enter default price') }})</small>
    </h5>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>{{ translate('Group Price') }}</th>
                {{-- <th>{{ translate('Child Allowed') }}</th>
                <th>{{ translate('Child Price') }}</th>
                <th>{{ translate('Infant Allowed') }}</th>
                <th>{{ translate('Infant') }}</th> --}}
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <input
                        class="form-control numberonly {{ $errors->has('deafult_group_price') ? 'is-invalid' : '' }}"
                        style="width: 25%" type="text" name="deafult_group_price"
                        placeholder="{{ translate('Group Price') }}"
                        value="{{ $get_product_group_percentage['group_price'] }}" />
                    @error('deafult_group_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </td>

            </tr>

        </tbody>
    </table>
</div>

<div class="col-md-12 content_title ">
    <table class="private_tour_table table table-responsive ">
        <thead>
            <tr>
                <th>{{ translate('Group Price') }}</th>
                <th>{{ translate('Number Of Pax') }}</th>
                <th>{{ translate('Action') }}</th>
            </tr>
        </thead>
        <tbody class="show_single_group_percentage">
            @php
                $data = 0;
                $single_group_percentage_id = 0;
                
            @endphp
            @foreach ($get_product_group_percentage_details as $GPGPD)
                @include('admin.product.excursion._single_group_percentage')
                @php
                    
                    $data++;
                    $single_group_percentage_id++;
                @endphp
            @endforeach

            @if (count($get_product_group_percentage_details) <= 0)
                @include('admin.product.excursion._single_group_percentage')
            @endif

        </tbody>
    </table>
</div>

<div class="row mt-3">
    <div class="col-md-12 add_more_button">
        <button class="btn btn-success btn-sm float-end" type="button" id="add_single_group_percentage"
            title='Add more'>
            <span class="fa fa-plus"></span>
            {{ translate('Add More') }}</button>
    </div>
</div>
