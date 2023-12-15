<div class="stepOne-form ">
    <div class="instructions">

        <input type="hidden" name="price_availability_id" value="{{ isset($PricingId) ? $PricingId : '' }}">
        <div class="inputfield title_filed availability-block-form">

            <h6>{{ translate('Validity of this season') }}</h6>
            <h6 class="f-14">
                {{ translate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.') }}
            </h6>
            <div class="availability-form-item availability-block-validity">

                <div class="validity-from">
                    <label for="validity-from" class="input-label"> {{ translate('Valid from') }} </label>

                    <input class="form-control input_txt  valid_from datepickr" id="valid_from" name="valid_from"
                        errors=""
                        value="{{ isset($ProductOptionAvailability) ? $ProductOptionAvailability->valid_from : '' }}">
                </div>
                <div class="validity-to"><label for="validity-to" class="input-label"> {{ translate('to') }} </label>
                    <div class="datepicker" id="validity-to" data-test-id="validity-to" name="validityTo">

                        <input class="form-control input_txt valid_to datepickr" id="valid_to" name="valid_to"
                            errors=""
                            value="{{ isset($ProductOptionAvailability) ? $ProductOptionAvailability->valid_to : '' }}">
                    </div>
                </div>
            </div>
            {{-- <input type="hidden" name="group_pricing_id"
                value="{{ isset($ProductOptionPricing) ? $ProductOptionPricing->id : '' }}"> --}}

            <div class="col-form-alert-label">
            </div>
        </div>
        @php
            $weekArr = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        @endphp
        <div class="inputfield title_filed ">
            <h6> {{ translate('Weekly starting times') }}</h6>
            <h6 class="f-14">
                {{ translate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.') }}
            </h6>
            @foreach ($weekArr as $WA)
                <ul class="availability-days">
                    <li class="availability-day">
                        <span class="name-day">{{ Str::ucfirst($WA) }}</span>
                        <div class="day-{{ $WA }}">
                            <ul class="availability-time-list time-list-{{ $WA }}">
                                @php
                                    $timeJson = '';
                                @endphp
                                @if (isset($ProductOptionAvailability))
                                    @php
                                        $timeJson = json_decode($ProductOptionAvailability->time_json);
                                    @endphp
                                @endif
                                @if ($timeJson != '' && isset($timeJson->$WA))
                                    @foreach ($timeJson->$WA as $TKEY => $TJ)
                                        @php
                                            $day = $WA;
                                            $time = explode(':', $TJ);
                                            $hour = $time[0];
                                            $minute = $time[1];
                                        @endphp
                                        @include('admin.products.option.pricing._time_list')
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <button type="button" class="c-button c-button--medium c-button--text-standard add-time"
                            data-test-id="add-starting-time-{{ $WA }}" data-day={{ $WA }}><!---->
                            <span class="fa fa-clock-o ">
                            </span>
                            <span class="text"> {{ translate('Add starting time') }}</span>
                        </button><!---->
                    </li>
                </ul>
            @endforeach

        </div>
        <div class="inputfield title_filed ">
            <h6>{{ translate('Single/special dates') }}</h6>
            <h6 class="f-14">
                {{ translate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.') }}
            </h6>
            <ul class="availability-days AppendAviableDate">
                @php
                    $dateJson = '';
                    $count = 0;
                @endphp
                @if (isset($ProductOptionAvailability))
                    @php
                        $dateJson = json_decode($ProductOptionAvailability->date_json);

                    @endphp
                    @if ($dateJson != '')
                        @foreach ($dateJson as $DKEY => $DJ)
                            @include('admin.products.option.pricing._date_list')
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    @endif
                @endif
            </ul>
            <button type="button" class="btn btn-primary btn-outline-primary btn-round text-primary add-date">
                {{ translate('Add new date') }}
            </button><!---->
        </div>
    </div>
</div>
