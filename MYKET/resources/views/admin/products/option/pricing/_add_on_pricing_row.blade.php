@if (isset($params_arr))
    @php
        $tier_count = $params_arr['tier_count'];
        $next_input_text = $params_arr['next_input_text'];
        $age_group_type = $params_arr['age_group_type'];
        $AddOnCount = $params_arr['AddOnCount'];

    @endphp
@endif
@php
    $retail_price = 0.0;
    $currency = 'INR';
    $commission = '30';
    $payout_per_person = 0.0;
    $from_no_of_people = 1;
    if (isset($ProductOptionAddOnTiers)) {
        $tier_count = $POATKey + 1;
        $from_no_of_people = $POAT['from_no_of_people'];
        $next_input_text = $POAT['no_of_people'];
        $retail_price = $POAT['retail_price'];
        $payout_per_person = $POAT['payout_per_person'];
    } else {
        $from_no_of_people = $next_input_text;
        $next_input_text = $next_input_text + 50;
    }
@endphp
<div class="pricing-table-row-data {{ $age_group_type }}-pricing-table-row-data-{{ $AddOnCount }}"
    id="{{ $tier_count }}" data-type="{{ $age_group_type }}">
    <div class="pricing-table-col pricing-table-participants">
        <input type="hidden" name="add_on_no_of_to_people[{{ $AddOnCount }}][{{ $tier_count }}]"
            id="{{ $age_group_type }}_no_of_to_people_{{ $AddOnCount }}_{{ $tier_count }}"
            value="{{ $from_no_of_people }}">

        <span class="min-age {{ $age_group_type }}_no_of_people_{{ $AddOnCount }}"
            id="{{ $age_group_type }}_no_of_people_{{ $AddOnCount }}_{{ $tier_count }}">{{ $from_no_of_people }}</span><span>-</span>
        <div class="pricing-table-value base-textfield base-textfield-medium" required="required" min="1"
            value="50" type="number">
            <div class="base-textfield-container"><input
                    name="add_on_no_of_people[{{ $AddOnCount }}][{{ $tier_count }}]"
                    id="{{ $age_group_type }}_no_of_people_input_{{ $AddOnCount }}_{{ $tier_count }}"
                    class="base-input base-input-medium numberonly no_of_people_input {{ $age_group_type }}_no_of_people_input_{{ $AddOnCount }}"
                    onkeyup="changeNumber(this,'{{ $age_group_type }}','{{ $AddOnCount }}')"
                    data-number={{ $tier_count }} min="1" value="{{ $next_input_text }}"
                    type="number"><!----></div>
            <!---->
        </div>
    </div>

    <div class="pricing-table-col">
        <div class="pricing-table-value base-textfield base-textfield-medium" min="0" required="required"
            value="152" name="retail-price" type="text" data-test-id="retail-price-input">
            <div class="base-textfield-container"><input
                    name="add_on_retail_price[{{ $AddOnCount }}][{{ $tier_count }}]" value="{{ $retail_price }}"
                    class="base-input base-input-medium numberonly {{ $age_group_type }}_retail_price_{{ $AddOnCount }}"
                    min="0" onkeyup="calculatePayout(this,'{{ $age_group_type }}','{{ $AddOnCount }}')"
                    data-number={{ $tier_count }} name="retail-price" type="text"
                    data-test-id="retail-price-input"><!---->
            </div><!---->
        </div><span class="currency">{{ translate('INR') }}</span>
    </div>
    <div class="pricing-table-col {{ $age_group_type }}_commission_payout_{{ $AddOnCount }} commission_payout"
        id="commission_payout_{{ $AddOnCount }}_{{ $tier_count }}">
        <div class="pricing-table-col"><span>30%</span></div>
        <div class="pricing-table-col">
            <div class="pricing-table-value base-textfield base-textfield-medium" disabled="disabled" value="106.40">
                <div class="base-textfield-container">
                    <input
                        class="base-input base-input-medium {{ $age_group_type }}_payout_per_person_{{ $AddOnCount }}"
                        id="{{ $age_group_type }}_payout_per_person_{{ $AddOnCount }}_{{ $tier_count }}"
                        value="{{ $payout_per_person }}" disabled="disabled"><!---->
                </div><!---->
            </div><span class="currency">{{ translate('INR') }}</span>
        </div><!---->
    </div>
    @if ($tier_count > 1)
        <div class="pricing-table-col"><span class="fa fa-times text-danger remove_add_on_pricing_row cursor-pointer"
                data-count="{{ $AddOnCount }}"></span>
        </div>
    @endif
</div>
