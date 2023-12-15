<div class="stepOne-form ">
    <div class="instructions">
        <div class="inputfield title_filed">
            <h6>{{ translate('Name (e.g. Summer 2020, German guide...)') }}</h6>
            <input class="form-control input_txt w-50 price_name" id="price_name" name="price_name" errors=""
                value="{{ isset($ProductOptionPricingDescription) ? $ProductOptionPricingDescription->title : '' }}">
            <div class="col-form-alert-label">
            </div>
        </div>
        <div class="inputfield title_filed">
            <h6>{{ translate('Minimum participants per booking') }}</h6>

            <input class="form-control input_txt w-10 minimum_participant" type="number" id="minimum_participant"
                name="minimum_participant"
                value="{{ isset($ProductOptionPricing) ? $ProductOptionPricing->minimum_participants : '' }}"
                errors="">
            <div class="col-form-alert-label">
            </div>
        </div>
        <div class="inputfield title_filed">
            <h6>Prices per person</h6>
            <div class="pricing-categories">
                <div class="append_age_group">
                    @php
                        $age_group_type = 'adult';
                        $age_groups_arr = [];
                    @endphp
                    @if (isset($ProductOptionPricingDetails))
                        @foreach ($ProductOptionPricingDetails as $POPKey => $POP)
                            @php
                                $age_groups_arr[] = $POP['person_type'];
                            @endphp
                            @include('admin.products.option._age_group_section')
                        @endforeach
                    @else
                        @include('admin.products.option._age_group_section')
                    @endif
                </div>
                <div class="d-block add_age_group_div">
                    <h6 class="font-weight-bold">
                        {{ translate('Add Age Group') }}</h6>
                    <select name="add_age_group" id="add_age_group" class="form-control select2 w-25 add_age_group">
                        <option value="" selected disabled>{{ translate('Add Age Group') }}</option>
                        <option value="child" {{ in_array('child', $age_groups_arr) ? 'disabled' : '' }}>
                            {{ translate('Child') }}</option>
                        <option value="infant" {{ in_array('infant', $age_groups_arr) ? 'disabled' : '' }}>
                            {{ translate('Infant') }}
                        </option>
                    </select>
                </div>
                <div class="section title mt-4">
                    <h6 class="section-question">
                        {{ translate('Include an add-on') }}
                    </h6>
                    <div class="instructions">
                        <p class="instruction">
                            {{ translate('Add-ons like child seats, special equipment, or extra services can enhance the experience of your activity.Note: if this option is connected to a booking system, you cannot use this feature. Please set up a new option with the add-on and separate price instead.') }}
                        </p>
                        <div class="per_person_add_on_div">
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
            </div><!---->
        </div>
    </div>
    <div class="continueBtn">
        <button type="submit" id="" class="next action-button step-optionPricing-btn">
            <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
            {{ translate('Save and continue') }}</button>
    </div>
</div>
