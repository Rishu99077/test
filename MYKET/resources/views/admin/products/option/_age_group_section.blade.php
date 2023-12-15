@if (isset($params_arr))
    @php
        $age_group_type = $params_arr['age_group_type'];

    @endphp
@endif
@php
    $booking_category = '';
    $age_range = 99;
    $checked = '';
    $Commissionchecked = '';
    $from_age_range = 0;
    if (isset($ProductOptionPricingDetails)) {
        $age_group_type = $POP['person_type'];
        $booking_category = $POP['booking_category'];
        $age_range = $POP['age_range'];
        $from_age_range = $POP['from_age_range'];

        if ($booking_category == 'not_permitted' || $booking_category == 'free_no_ticket') {
            $checked = 'd-none';
        } elseif ($booking_category == 'free') {
            $Commissionchecked = 'd-none';
        }
    }

@endphp
<input type="hidden" name="pricing_id" value="{{ isset($ProductOptionPricing) ? $ProductOptionPricing->id : '' }}">
<section class="price-block-category {{ $age_group_type }}_price_block_category">
    <h6 class="price-block-title font-bold"> {{ ucfirst($age_group_type) }} <!---->
        @if ($age_group_type == 'child' || $age_group_type == 'infant')
            <span class="remove_group float-right text-danger cursor-pointer">{{ translate('Remove') }}</span>
        @endif
    </h6>
    <div class="price-block-cols"><!----><!---->

        <div class="price-block-age">
            <h6 class="price-block-subtitle">{{ translate('Age range') }}</h6>
            <div class="age_block_div">
                <span class="age_range_{{ $age_group_type }}">{{ $from_age_range }}</span><span
                    class="price-block-to">-</span>

                <input type="hidden" class="age_range_to_{{ $age_group_type }}" name="age_to[{{ $age_group_type }}]"
                    value="{{ $from_age_range }}">
                <select name="age_from[{{ $age_group_type }}]" id="select_{{ $age_group_type }}"
                    onchange="changeAgeDropDown(this,'{{ $age_group_type }}')" class="form-control w-60 age_from">
                    @for ($i = 1; $i <= 99; $i++)
                        <option value="{{ $i }}" {{ getSelected($age_range, $i) }}>
                            {{ $i == 99 ? $i . '+' : $i }}</option>
                    @endfor
                    <!---->

                </select>
            </div>
            <!---->

        </div>

        <div class="price-block-booking-category">
            <h6 class="price-block-subtitle">
                {{ translate('Booking category') }}
                <i class="icon" style="width: 16px; height: 16px"><svg width="16" height="16"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8 14.25A6.257 6.257 0 0014.25 8 6.257 6.257 0 008 1.75 6.257 6.257 0 001.75 8 6.257 6.257 0 008 14.25zm5.48-11.73A7.7 7.7 0 0115.75 8a7.7 7.7 0 01-2.27 5.48A7.7 7.7 0 018 15.75a7.7 7.7 0 01-5.48-2.27A7.7 7.7 0 01.25 8a7.7 7.7 0 012.27-5.48A7.7 7.7 0 018 .25a7.7 7.7 0 015.48 2.27zM8.625 7c.207 0 .375.168.375.375V11.5a.375.375 0 01-.375.375h-1.25A.375.375 0 017 11.5V7.375C7 7.168 7.168 7 7.375 7h1.25zM8 3.594a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z"
                            fill-rule="evenodd"></path>
                    </svg> </i><!---->
            </h6>
            <ul class="radio-buttons-container form-radio">
                <li class="selection-item pricing_type_radio">
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" value="standard" class="booking_category"
                                name="{{ $age_group_type }}_booking_category"
                                {{ getChecked($booking_category, 'standard') }} checked>
                            <i class="helper"></i> {{ translate('Standard') }}
                        </label>
                    </div>
                </li>
                <li class="selection-item pricing_type_radio">
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" value="free" class="booking_category"
                                name="{{ $age_group_type }}_booking_category"
                                {{ getChecked($booking_category, 'free') }}>
                            <i class="helper"></i>{{ translate('Free - ticket') }}
                        </label>
                    </div>
                </li>
                <li class="selection-item pricing_type_radio">
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" value="free_no_ticket" class="booking_category"
                                name="{{ $age_group_type }}_booking_category"
                                {{ getChecked($booking_category, 'free_no_ticket') }}>
                            <i class="helper"></i>{{ translate('Free - no ticket required') }}
                        </label>
                    </div>
                </li>
                <li class="selection-item pricing_type_radio">
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" value="not_permitted" class="booking_category"
                                name="{{ $age_group_type }}_booking_category"
                                {{ getChecked($booking_category, 'not_permitted') }}>
                            <i class="helper"></i>{{ translate('Not permitted') }}
                        </label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="price-block-pricing {{ $checked }}">
            <div class="pricing-table">
                <header class="pricing-table-row pricing-table-header">
                    <div class="pricing-table-col"> {{ translate('Number of People') }} </div>
                    <div class="pricing-table-col">{{ translate('Retail price') }}</div>

                    <div class="pricing-table-col commission_payout_header {{ $Commissionchecked }}">
                        <div class="pricing-table-col"> {{ translate('Commission') }} </div>
                        <div class="pricing-table-col">{{ translate('Payout per person') }}</div>
                    </div>

                </header>
                <div class="pricing_table_row">
                    @php
                        $tier_count = 1;
                        $next_input_text = 1;
                        $booking_category_value = 'standard';

                    @endphp

                    @if (isset($ProductOptionPricingTiers))
                        @php
                            $ProductOptionPricingTiers = App\Models\ProductOptionPricingTiers::where(['pricing_details_id' => $POP['id'], 'pricing_id' => $optionPricingId, 'option_id' => $optionId, 'product_id' => $tourId])->get();
                        @endphp
                        @foreach ($ProductOptionPricingTiers as $POPTKey => $POPT)
                            @include('admin.products.option.pricing._pricing_row')
                        @endforeach
                    @else
                        @include('admin.products.option.pricing._pricing_row')
                    @endif

                </div>
            </div>
            <input type="hidden" class="age_group_type_value" name="age_group_type_value[{{ $age_group_type }}]"
                value="{{ $age_group_type }}">

            <button type="button" class="c-button c-button--medium c-button--text-standard add_price_tires">
                {{ translate('Set up price tiers') }} </button>

        </div>

    </div>

</section><!---->
