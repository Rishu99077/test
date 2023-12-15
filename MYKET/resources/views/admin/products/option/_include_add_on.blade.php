@if (isset($params_arr))
    @php
        $age_group_type = $params_arr['age_group_type'];
        $AddOnCount = $params_arr['AddOnCount'];
    @endphp
@endif
@php
    $add_on_id = '';
    if (isset($ProductOptionAddOn)) {
        $AddOnCount = $POAKey + 1;
        $add_on_id = $POA['add_on_id'];
    }
@endphp
<div class="pricing-addon price-block price_add_on_div">
    <div class="price-block-actions">
        <span class="remove_add_on_group float-right text-danger cursor-pointer">Remove</span>
    </div>
    <div class="addons-col">
        <div class="category-detail category-addon-name">
            <select name="add_on[{{ $AddOnCount }}]" id="" class="select2 form-control">
                {{-- @foreach ($AddOn as $value) --}}
                {{-- <option va/>lue="{{ $value['title'] }}">{{ $value['title'] }}</option> --}}
                {{-- @endforeach --}}

                <option value="1" {{ getSelected($add_on_id, 1) }}>1</option>
                <option value="2" {{ getSelected($add_on_id, 2) }}>2</option>
                <option value="3" {{ getSelected($add_on_id, 3) }}>3</option>
            </select>
        </div>
        <div class="price-block-pricing">
            <div class="pricing-table">
                <header class="pricing-table-row pricing-table-header">
                    <div class="pricing-table-col"> {{ translate('Number of People') }} </div>
                    <div class="pricing-table-col">{{ translate('Retail price') }}</div>
                    <div class="pricing-table-col commission_payout_header">
                        <div class="pricing-table-col">{{ translate('Commission') }} </div>
                        <div class="pricing-table-col">{{ translate('Payout per person') }}</div>
                    </div>
                </header>
                <div class="pricing_table_row">
                    @php
                        $tier_count = 1;
                        $next_input_text = 1;
                        $age_group_type = 'add_on';
                    @endphp
                    @if (isset($ProductOptionAddOnTiers))
                        @php

                            $ProductOptionAddOnTiers = App\Models\ProductOptionAddOnTiers::where(['add_on_id' => $POA['id'], 'option_id' => $optionId, 'product_id' => $tourId])->get();
                        @endphp
                        @foreach ($ProductOptionAddOnTiers as $POATKey => $POAT)
                            @include('admin.products.option.pricing._add_on_pricing_row')
                        @endforeach
                    @else
                        @include('admin.products.option.pricing._add_on_pricing_row')
                    @endif

                </div>
            </div>

            <button type="button" class="c-button c-button--medium c-button--text-standard add_include_price_tires"
                data-count="{{ $AddOnCount }}">{{ translate('Set up price tiers') }} </button>
        </div>
    </div>
</div>
