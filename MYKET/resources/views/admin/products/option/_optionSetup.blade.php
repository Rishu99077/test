<div class="stepOne-form">
    <div class="title_stepOne">
        <h2>{{ translate('Option setup') }}</h2>
    </div>
    <div class="section title">

        <h6 class="section-question">
            {{ translate('Option title') }}
            <a href="#" target="_blank" class="learnMore">{{ translate('Learn more') }} </a>
        </h6>
        <div class="instructions">
            <p class="instruction">
                {{ translate(' Option title section becomes editable if there is more than one option. If there is only one it will be the same as the activity title. If you offer multiple options, write a short title that clearly explains how this option differs from the others.') }}
            </p>

        </div>
    </div>
    <!-- Example Box -->
    <div class="examples">
        <div class="example-grid-container">
            <div class="good-examples">
                <h3 class="examples-title"> {{ translate('Examples') }} </h3>
                <ul>
                    <li>
                        <p><span><i class="fa fa-check"
                                    aria-hidden="true"></i></span>{{ translate('Guided tour in French') }}
                        </p>
                    </li>
                    <li>
                        <p><span><i class="fa fa-check" aria-hidden="true"></i></span>{{ translate('Private tour') }}
                        </p>
                    </li>
                    <li>
                        <p><span><i class="fa fa-check"
                                    aria-hidden="true"></i></span>{{ translate('Entry ticket with lunch') }}</p>
                    </li>
                </ul>
            </div>
            <div class="bad-examples">
                <h3 class="examples-title"> {{ translate('Examples') }} </h3>
                <ul>
                    <li>
                        <p><span><i class="fa fa-times"
                                    aria-hidden="true"></i></span>{{ translate('Rome: Vatican Museums Guided Tour in French') }}
                        </p>
                    </li>
                    <li>
                        <p><span><i class="fa fa-times"
                                    aria-hidden="true"></i></span>{{ translate('Exclusive private tour for just you and three loved ones') }}
                        </p>
                    </li>
                    <li>
                        <p><span><i class="fa fa-times" aria-hidden="true"></i></span>{{ translate('Tour') }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form enctype="multipart/form-data" action="" id="setpOptionSetupForm">
        @csrf
        <div class="inputfield title_filed">
            <input class="form-control input_txt w-75" id="option_title"
                value="{{ @$ProductOptionDescription->title }}" maxlength="60" minlength="1" name="option_title"
                errors="">
            <div class=" col-form-alert-label">

            </div>
        </div>
        <div class="inputfield title_filed product_code">
            <h5>{{ translate('Option reference code') }}</h5>
            <div class="instructions">
                <p class="instruction">
                    {{ translate('Add a reference code to help you keep track of which option the customer has booked. This is mainly for your records and won’t be seen by the customer.') }}
                </p>

            </div>
            <input class="form-control input_txt w-75" id="reference_code"
                value="{{ @$ProductOptionSetup->reference_code }}" maxlength="60" minlength="1" name="reference_code"
                errors="">

            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="inputfield title_filed product_code">
            <h5>{{ translate('Option description') }}</h5>
            <div class="instructions">
                <p class="instruction">
                    {{ translate('Leave this section empty unless the option titles alone can’t clearly explain the differences between your options.') }}
                </p>

            </div>
            <textarea name="option_description" class="form-control input_txt w-7" id="option_description" cols="30"
                rows="10">{{ @$ProductOptionDescription->description }}</textarea>

            <div class="col-form-alert-label">
            </div>
        </div>
        <div class="inputfield title_filed product_code">
            <div class="checkbox-fade fade-in-primary">
                <label>
                    <input type="checkbox" name="likely_to_sell_out"
                        {{ getChecked(@$ProductOptionSetup->likely_to_sell_out, 'yes') }} value="yes">
                    <span class="cr">
                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                    </span> <span>{{ translate('Likely to sell out') }}</span>
                </label>
            </div>
        </div>

        <div class="inputfield title_filed product_code">
            <h5>{{ translate('Activity setup') }}
            </h5>

            <div class="instructions mt-3">
                <div class="instructions mb-3">
                    <h5>{{ translate('Is this a private activity?') }}</h5>
                    <p class="instruction">
                        {{ translate('This means that only one group or person can participate in this activity. There won’t be other customers in the same activity.') }}
                    </p>
                </div>
                <ul class="instruction private-activity-radio form-radio">
                    <li class="selection-item private_activity_radio">
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" value="Non-private"
                                    {{ getChecked(@$ProductOptionSetup->is_private, 'no') }} class="private_activity"
                                    name="private_activity" checked="checked">
                                <i class="helper"></i>{{ translate('No') }}

                            </label>
                        </div>
                    </li>
                    <li class="selection-item private_activity_radio">
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" value="Private"
                                    {{ getChecked(@$ProductOptionSetup->is_private, 'yes') }} class="private_activity"
                                    name="private_activity">
                                <i class="helper"></i>{{ translate('Yes') }}
                            </label>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="instructions mt-3">
                <div class="instructions mb-3">
                    <p class="instruction">
                        {{ translate('Will the customer skip the existing line to get in? If so, which line?') }}</p>

                </div>
                <ul class="instruction existing-line-radio form-radio">
                    <li class="selection-item existing_line_radio">
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" value="no"
                                    {{ getChecked(@$ProductOptionSetup->existing_line, 'no') }} class="existing_line"
                                    name="existing_line">
                                <i class="helper"></i>{{ translate('No') }}

                            </label>
                        </div>
                    </li>
                    <li class="selection-item existing_line_radio">
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" value="yes"
                                    {{ getChecked(@$ProductOptionSetup->existing_line, 'yes') }} class="existing_line"
                                    name="existing_line">
                                <i class="helper"></i>{{ translate('Yes') }}
                            </label>
                        </div>
                    </li>
                </ul>
                @php
                    $existing_line_class = 'd-none';
                    $existing_line_type = '';
                    if (@$ProductOptionSetup->existing_line) {
                        if ($ProductOptionSetup->existing_line == 'yes') {
                            $existing_line_class = '';
                            $existing_line_type = $ProductOptionSetup->existing_line_type;
                        }
                    }
                @endphp
                <div class="existing_line_div mb-4 ml-5 pl-3 {{ $existing_line_class }}">

                    <select name="existing_line_type" id="existing_line_type"
                        class="form-control select2 w-25 existing_line_type" aria-placeholder="Choose Type">
                        <option value="" selected disabled>Choose type </option>
                        <option value="ticket_line" {{ getSelected($existing_line_type, 'ticket_line') }}>
                            {{ translate('Skip the line to get tickets') }}
                        </option>
                        <option value="through_separate_entrance"
                            {{ getSelected($existing_line_type, 'through_separate_entrance') }}>
                            {{ translate('Skip the line through a separate entrance') }} </option>
                        <option value="through_express_security_check"
                            {{ getSelected($existing_line_type, 'through_express_security_check') }}>
                            {{ translate('Skip the line through express security check') }} </option>
                        <option value="through_express_elevators"
                            {{ getSelected($existing_line_type, 'through_express_elevators') }}>
                            {{ translate('Skip the line through express elevators') }} </option>
                    </select>
                    <div class=" col-form-alert-label">
                    </div>
                </div>
            </div>

            <div class="instructions mt-3">
                <div class="instructions mb-3">
                    <p class="instruction">{{ translate('Is the activity wheelchair accessible?') }}</p>

                </div>
                <ul class="instruction wheelchair-accessibility-radio form-radio">
                    <li class="selection-item wheelchair_accessibility_radio">
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" value="no"
                                    {{ getChecked(@$ProductOptionSetup->wheelchair_accessibility, 'no') }}
                                    class="wheelchair_accessibility" name="wheelchair_accessibility"
                                    checked="checked">
                                <i class="helper"></i>{{ translate('No') }}

                            </label>
                        </div>
                    </li>
                    <li class="selection-item wheelchair_accessibility_radio">
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" value="yes"
                                    {{ getChecked(@$ProductOptionSetup->wheelchair_accessibility, 'yes') }}
                                    class="wheelchair_accessibility" name="wheelchair_accessibility">
                                <i class="helper"></i>{{ translate('Yes') }}
                            </label>
                        </div>
                    </li>
                </ul>

            </div>

            <div class=" col-form-alert-label">
            </div>
        </div>

        <div class="inputfield title_filed product_code">
            <h5>{{ translate('Time and length') }}
            </h5>
            <p>{{ translate('Some activities start and stop at specific times. Others allow customers to use their ticket anytime within a certain amount of time, like a 2-day city pass.') }}
            </p>
            <div class="instructions">
                <div class="instructions mb-3">
                    <p class="instruction">{{ translate('Which best describes your activity?') }}</p>

                    <ul class="instruction existing-line-radio form-radio mt-3">
                        <li class="selection-item time_length_radio">
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" value="duration"
                                        {{ getChecked(@$ProductOptionSetup->time_length, 'duration') }}
                                        class="time_length" name="time_length">
                                    <i
                                        class="helper"></i>{{ translate('It lasts for a specific amount of time (duration)') }}
                                    <small class="d-block">{{ translate('Example: 3-hour guided tour') }}</small>

                                </label>
                            </div>
                            @php
                                $duration_class = 'd-none';
                                $validity_class = 'd-none';
                                $duration_time = '';
                                $validity_time = '';
                                $duration_time_type = '';
                                $validity_time_type = '';
                                $existing_line_type = '';
                                $validity_type = '';
                                $validity_time_type_div = 'd-none';

                                if (@$ProductOptionSetup->time_length) {
                                    if ($ProductOptionSetup->time_length != 'none') {
                                        if ($ProductOptionSetup->time_length == 'duration') {
                                            $duration_class = 'd-flex ';
                                            $duration_time = $ProductOptionSetup->duration_time;
                                            $duration_time_type = $ProductOptionSetup->duration_time_type;
                                        } else {
                                            $validity_type = $ProductOptionSetup->validity_type;
                                            $validity_class = '';
                                            if ($validity_type != 'time_selected') {
                                                $validity_time_type_div = 'd-flex';
                                                $validity_time = $ProductOptionSetup->validity_time;
                                                $validity_time_type = $ProductOptionSetup->validity_time_type;
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <div class="duration_div ml-4 pl-2 {{ $duration_class }}">
                                <input type="number" class="form-control w-10" name="duration_time"
                                    value="{{ $duration_time }}">
                                <select name="duration_time_type" class="form-control w-25 duration_time_type"
                                    id="duration_time_type">
                                    <option value="" selected disabled>Please
                                        {{ translate('Select') }}
                                    </option>
                                    <option value="minute" {{ getSelected($duration_time_type, 'minute') }}>
                                        {{ translate('Minute(s)') }}
                                    </option>
                                    <option value="hour" {{ getSelected($duration_time_type, 'hour') }}>
                                        {{ translate('Hour(s)') }}
                                    </option>
                                    <option value="day" {{ getSelected($duration_time_type, 'day') }}>
                                        {{ translate('Day(s)') }}
                                    </option>
                                </select>
                                <div class="col-form-alert-label">
                                </div>
                            </div>
                        </li>
                        <li class="selection-item time_length_radio">
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" value="validity"
                                        {{ getChecked(@$ProductOptionSetup->time_length, 'validity') }}
                                        class="time_length" name="time_length">
                                    <i
                                        class="helper"></i>{{ translate('Customers can use their ticket anytime during a certain period (validity)') }}
                                    <small
                                        class="d-block">{{ translate('Example: museum tickets that can be used anytime during opening hours') }}</small>
                                </label>
                            </div>

                            <div class="validity_div ml-4 pl-2 {{ $validity_class }}">
                                <select name="validity_type" class="form-control w-50 validity_type"
                                    id="validity_type">
                                    <option value="" selected disabled>{{ translate('Please select') }}
                                    </option>
                                    <option value="time_booked" {{ getSelected($validity_type, 'time_booked') }}>
                                        {{ translate('Valid for a period of time from date booked') }} </option>
                                    <option value="time_activated"
                                        {{ getSelected($validity_type, 'time_activated') }}>
                                        {{ translate('Valid for a period of time from first activation') }} </option>
                                    <option value="time_selected" {{ getSelected($validity_type, 'time_selected') }}>
                                        {{ translate('Valid on the date booked') }}
                                    </option>
                                </select>
                                <div class="col-form-alert-label">
                                </div>

                                <div class="validity_time_type_div ml-4 pl-2 {{ $validity_time_type_div }} mt-2">
                                    <input type="number" class="form-control w-10" name="validity_time"
                                        id="validity_time" value="{{ $validity_time }}">
                                    <select name="validity_time_type" class="form-control w-25"
                                        id="validity_time_type">
                                        <option value="" selected disabled>
                                            {{ translate('Please select') }}
                                        </option>
                                        <option value="minute" {{ getSelected($validity_time_type, 'minute') }}>
                                            {{ translate('Minute(s)') }}
                                        </option>
                                        <option value="hour" {{ getSelected($validity_time_type, 'hour') }}>
                                            {{ translate('Hour(s)') }}
                                        </option>
                                        <option value="day" {{ getSelected($validity_time_type, 'day') }}>
                                            {{ translate('Day(s)') }}
                                        </option>
                                    </select>
                                    <div class="col-form-alert-label">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class=" col-form-alert-label">
            </div>
        </div>

        <div class="inputfield title_filed product_code">
            <h5>{{ translate('Confirming bookings and cut-off time') }}
            </h5>
            <div class="instructions">
                <div class="instructions mb-3">
                    <p class="instruction">
                        {{ translate('The cut-off time is the very latest you accept new bookings before the activity starts.') }}
                    </p>
                    <p class="instruction">
                        {{ translate('Since many customers book right before they want to start their activity, having a cut-off time of 30 minutes or less can lead to 50% more bookings than longer cut-off times.') }}
                    </p>

                </div>
                <div class="cut_off_time_div">
                    <h6 class="font-weight-bold">
                        {{ translate('How far in advance do you stop accepting new bookings before the activity starts?') }}
                    </h6>
                    <select name="cut_off_time" id="cut_off_time" class="form-control w-25 cut_off_time">
                        <option value="" selected disabled>
                            {{ translate('Select') }}
                        </option>

                        @for ($i = 0; $i <= 18; $i++)
                            <option value="{{ $i * 5 }}"
                                {{ getSelected(@$ProductOptionSetup->cut_off_time, $i * 5) }}>{{ $i * 5 }}
                                {{ translate('Minutes') }}
                            </option>
                        @endfor

                    </select>
                    <div class="col-form-alert-label">
                    </div>
                </div>

            </div>
        </div>

        <div class="continueBtn">
            <button type="submit" id="" class="next action-button step-optionSetup-btn">
                <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                {{ translate('Save and continue') }}</button>
        </div>
    </form>
</div>
