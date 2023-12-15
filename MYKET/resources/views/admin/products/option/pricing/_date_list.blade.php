@if (isset($params_arr))
    @php
        $count = $params_arr['count'];
        $day = $params_arr['day'];
    @endphp
@endif
<li class="availability-day available-date" id={{ $count }}>
    <span class="fa fa-times text-danger cursor-pointer remove_date_time mr-2"></span>
    <input class="form-control input_txt valid_to datepickr w-25" id="valid_to" name="available_date[{{ $count }}]"
        errors="" value="{{ isset($DKEY) ? $DKEY : '' }}">
    <div class="show-date-{{ $count }}">
        <ul class="availability-time-list availability-time-list-{{ $count }}">
            @if (isset($DJ))
                @foreach ($DJ as $DKEY => $Ditem)
                    @if (gettype($Ditem) == 'string')
                        @php

                            $day = $count;
                            $time = explode(':', $Ditem);
                            $hour = $time[0];
                            $minute = $time[1];

                        @endphp
                        @include('admin.products.option.pricing._time_list')
                    @endif
                @endforeach
            @endif

        </ul>
    </div>
    <button type="button" class="c-button c-button--medium c-button--text-standard add-date-time"
        data-count="{{ $count }}" data-test-id="add-starting-time"><!---->
        <span class="fa fa-clock-o ">
        </span>
        <span class="text">{{ translate('Add starting time') }}</span>
    </button><!---->
</li>
