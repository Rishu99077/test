@if (isset($params_arr))
    @php
        $day = $params_arr['day'];
    @endphp
@endif

<li class="availability-time availability-time-{{ $day }}" data-day="{{ $day }}">
    <div class="start-time">
        <div class="base-select base-select-time base-select-small base-select-auto" id="start_time_hour"
            name="start_time_hour">
            <div class="base-select-container">
                <span class="f-14">{{ translate('hr') }}</span>
                <select id="start_time_hour" name="start_time_hour[{{ $day }}][]"
                    class="base-select-input base-select-input-small base-select-input-auto"><!---->
                    @for ($i = 0; $i < 24; $i++)
                        <option value="{{ $i }}" {{ getSelected(@$hour, $i) }}> {{ $i }} </option>
                    @endfor

                </select>
            </div><!---->
        </div><span class="separator">:</span>
        <div class="base-select base-select-time base-select-small base-select-auto" id="start_time_minute"
            name="start_time_minute">
            <div class="base-select-container">
                <span class="f-14">{{ translate('mi') }}</span>
                <select id="start_time_minute" name="start_time_minute[{{ $day }}][]"
                    class="base-select-input base-select-input-small base-select-input-auto"><!---->
                    @for ($i = 0; $i <= 11; $i++)
                        <option value="{{ $i * 5 }}" {{ getSelected(@$minute, $i * 5) }}> {{ $i * 5 }}
                        </option>
                    @endfor

                </select>
            </div><!---->
        </div>
    </div>
    <span class="fa fa-times text-danger cursor-pointer remove_time"></span>
</li>
