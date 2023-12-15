@if (isset($ProductOptionPricingList))
    <div class="saved-pricing-blocks">

        @foreach ($ProductOptionPricingList as $POP)
            @php
                if (!isset($optionId)) {
                    $optionId = $POP['option_id'];
                    $productID = $POP['product_id'];
                }

                $ProductOptionPricingDescription = App\Models\ProductOptionPricingDescription::where(['pricing_id' => $POP['id'], 'option_id' => $optionId, 'product_id' => $productID, 'language_id' => $language_id])->first();
            @endphp

            <div class="pricing-display" pricing-index="1698392">
                <div class="pricing-block-header">
                    <h5 class="pricing-block-title"> {{ @$ProductOptionPricingDescription->title }} <!----></h5>
                    {{-- $ProductOptionPricingDescription->title --}}
                    <div class="pricing-actions">
                        <button type="button" class="c-button c-button--medium c-button--text-standard edit_discount"
                            data-index="{{ $POP['id'] }}"><!----> {{ translate('Add /Edit discount') }}
                        </button>
                        <button type="button"
                            class="c-button c-button--medium c-button--text-standard edit_availability"
                            data-index="{{ $POP['id'] }}"><!----> {{ translate('Add /Edit availability') }}
                        </button>
                        <button type="button" class="c-button c-button--medium c-button--text-standard edit_pricing"
                            data-index="{{ $POP['id'] }}" data-type={{ $POP['pricing_type'] }}><!---->
                            {{ translate('Add /Edit pricing') }}
                        </button>
                        {{-- $ProductOptionPricing->id --}}
                        <span class="fa fa-times cursor-pointer text-danger remove_pricing"></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
