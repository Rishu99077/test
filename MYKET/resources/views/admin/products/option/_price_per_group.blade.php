<div class="stepOne-form ">
    <div class="instructions">
        <div class="inputfield title_filed">
            <h6>{{ translate('Name (e.g. Summer 2020, German guide ...)') }}</h6>
            <input type="hidden" name="group_pricing_id"
                value="{{ isset($ProductOptionPricing) ? $ProductOptionPricing->id : '' }}">

            <input class="form-control input_txt w-50 price_group_name" id="price_group_name" name="price_group_name"
                errors=""
                value="{{ isset($ProductOptionPricingDescription) ? $ProductOptionPricingDescription->title : '' }}">
            <div class="col-form-alert-label">
            </div>
        </div>
        <div class="inputfield title_filed">
            <h6>{{ translate('Minimum groups per time slot') }}</h6>

            <input class="form-control input_txt w-10 minimum_group_participant" type="number"
                id="minimum_group_participant" name="minimum_group_participant"
                value="{{ isset($ProductOptionPricing) ? $ProductOptionPricing->minimum_participants : '' }}"
                errors="">
            <div class="col-form-alert-label">
            </div>
        </div>
        <div class="inputfield title_filed">
            <h6>{{ translate('Prices per group') }}</h6>
            <div class="pricing-categories"><!---->
                <section class="price-block-category is-basic-view">
                    <h3 class="price-block-title"> Group <!----></h3>
                    <div class="price-block-cols"><!----><!---->
                        <div class="price-block-pricing">
                            <div class="pricing-table">
                                <header class="pricing-table-row pricing-table-header">
                                    <div class="pricing-table-col"> {{ translate('Number of People') }} </div>
                                    <div class="pricing-table-col">{{ translate('Retail price') }} </div>
                                    <div class="pricing-table-col"> {{ translate('Commission') }} </div>
                                    <div class="pricing-table-col">{{ translate('Payout per group') }} </div>
                                </header>
                                <div class="pricing_table_row">
                                    @php
                                        $tier_count = 1;
                                        $next_input_text = 1;
                                        $booking_category_value = 'none';
                                        $age_group_type = 'group';
                                    @endphp
                                    @if (isset($ProductOptionPricingTiers))
                                        @php
                                            $ProductOptionPricingTiers = App\Models\ProductOptionPricingTiers::where(['pricing_id' => $optionPricingId, 'option_id' => $optionId, 'product_id' => $tourId])->get();
                                        @endphp
                                        @foreach ($ProductOptionPricingTiers as $POPTKey => $POPT)
                                            @include('admin.products.option.pricing._pricing_row')
                                        @endforeach
                                    @else
                                        @include('admin.products.option.pricing._pricing_row')
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" class="age_group_type_value"
                                name="age_group_type_value[{{ $age_group_type }}]" value="{{ $age_group_type }}">
                            <button type="button"
                                class="c-button c-button--medium c-button--text-standard add_price_tires"><!---->
                                {{ translate('Add additional group size') }} </button>
                        </div>
                    </div><!---->
                </section>
                {{-- <div class="price-block-pax price-block-category">
                        <div class="price-category-toggle">
                            <div class="toggle-category">
                                <div class="inline-input-container"><input id="pricing-category-pax" name=""
                                        type="checkbox" class="inline-checkbox"><label for="pricing-category-pax"
                                        class="checkbox-label">Additional persons</label></div>
                            </div>
                        </div><!---->
                    </div><!----><!----> --}}
            </div>
        </div>
        <div class="section title mt-4">
            <h6 class="section-question">
                {{ translate('Include an add-on') }}
            </h6>
            <div class="instructions">
                <p class="instruction">
                    {{ translate('Add-ons like child seats, special equipment, or extra services can enhance the experience of your activity.Note: if this option is connected to a booking system, you cannot use this feature. Please set up a new option with the add-on and separate price instead.') }}
                </p>
                <div class="group_add_on_div">
                    @if (isset($ProductOptionAddOn))
                        @foreach ($ProductOptionAddOn as $POAKey => $POA)
                            @include('admin.products.option._include_add_on')
                        @endforeach
                    @endif
                </div>
                <a type="button" class="cursor-pointer f-16 font-bold  text-custom include_add_on">+
                    {{ translate('Include an add-on') }}</a>
            </div>
        </div>
    </div>
    <div class="continueBtn">
        <button type="submit" id="" class="next action-button step-optionPricing-btn">
            <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
            {{ translate('Save and continue') }}</button>
    </div>
</div>
