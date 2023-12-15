@if (isset($params_arr))
    @php
        $tier_count = $params_arr['tier_count'];
        $next_input_text = $params_arr['next_input_text'];
        $booking_category_value = $params_arr['booking_category_value'];
        $age_group_type = $params_arr['age_group_type'];
        $checked = '';
        $Commissionchecked = '';
    @endphp
@endif
@php
    $retail_price = 0.0;
    $currency = 'INR';
    $commission = '30';
    if ($age_group_type == 'group') {
        $Commissionchecked = '';
    }
    $payout_per_person = 0.0;
    $from_no_of_people = 1;
@endphp

@if (isset($ProductOptionPricingTiers))
    @php

        $tier_count = $POPTKey + 1;
        $next_input_text = $POPT['no_of_people'];
        $from_no_of_people = $POPT['from_no_of_people'];
        $retail_price = $POPT['retail_price'];
        $payout_per_person = $POPT['payout_per_person'];

    @endphp
@else
    @php
        $from_no_of_people = $next_input_text;
        $next_input_text = $next_input_text + 50;
    @endphp
@endif
<div class="pricing-table-row-data {{ $age_group_type }}-pricing-table-row-data {{ $age_group_type . '_' . $tier_count }}"
    id="{{ $tier_count }}" data-type="{{ $age_group_type }}">
    <div class="pricing-table-col pricing-table-participants">
        <input type="hidden" name="no_of_to_people[{{ $age_group_type }}][{{ $tier_count }}]"
            id="{{ $age_group_type }}_no_of_to_people_{{ $tier_count }}" value="{{ $from_no_of_people }}">
        <span class="min-age {{ $age_group_type }}_no_of_people"
            id="{{ $age_group_type }}_no_of_people_{{ $tier_count }}">{{ $from_no_of_people }}</span><span>-</span>
        <div class="pricing-table-value base-textfield base-textfield-medium" required="required" min="1"
            value="50" type="number">
            <div class="base-textfield-container"><input
                    name="no_of_people[{{ $age_group_type }}][{{ $tier_count }}]"
                    id="{{ $age_group_type }}_no_of_people_input_{{ $tier_count }}"
                    class="base-input base-input-medium numberonly no_of_people_input {{ $age_group_type }}_no_of_people_input"
                    onkeyup="changeNumber(this,'{{ $age_group_type }}')" data-number={{ $tier_count }}
                    min="1" value="{{ $next_input_text }}" type="number"><!----></div>
            <!---->
        </div>
    </div>

    <div class="pricing-table-col">
        <div class="pricing-table-value base-textfield base-textfield-medium" min="0" required="required"
            value="152" name="retail-price" type="text" data-test-id="retail-price-input">
            <div class="base-textfield-container"><input
                    name="retail_price[{{ $age_group_type }}][{{ $tier_count }}]" value="{{ $retail_price }}"
                    class="base-input base-input-medium numberonly {{ $age_group_type }}_retail_price" min="0"
                    onkeyup="calculatePayout(this,'{{ $age_group_type }}')" data-number={{ $tier_count }}
                    name="retail-price" type="text" data-test-id="retail-price-input"><!---->
            </div><!---->
        </div>
        {{-- <span class="currency">INR</span> --}}
    </div>

    <div class="pricing-table-col {{ $age_group_type }}_commission_payout commission_payout {{ $Commissionchecked }} @if ($booking_category_value == 'free') d-none @endif"
        id="commission_payout_{{ $tier_count }}">
        <div class="pricing-table-col"><span>30%</span></div>
        <div class="pricing-table-col">
            <div class="pricing-table-value base-textfield base-textfield-medium" disabled="disabled" value="106.40">
                <div class="base-textfield-container">
                    <input class="base-input base-input-medium {{ $age_group_type }}_payout_per_person"
                        id="{{ $age_group_type }}_payout_per_person_{{ $tier_count }}"
                        value="{{ $payout_per_person }}" disabled="disabled"><!---->
                </div><!---->
            </div>
            {{-- <span class="currency">INR</span> --}}
        </div><!---->
    </div>

    @if ($tier_count > 1)
        <div class="pricing-table-col"><span class="fa fa-times text-danger remove_pricing_row cursor-pointer"></span>
        </div>
    @endif
</div>
