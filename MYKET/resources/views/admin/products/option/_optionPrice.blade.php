<div class="stepOne-form ">
    <div class="title_stepOne">
        <h2>{{ translate('Pricing') }}</h2>
    </div>
    <div class="section title price_type_div">
        <h6 class="section-question">
            What type of pricing do you use?

        </h6>
        <div class="instructions">

            <ul class="pricing-type-radio form-radio">
                <li class="selection-item pricing_type_radio">
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" value="person" class="pricing_type"
                                {{ getChecked(@$ProductOptionSetup->pricing_type, 'person') }} id="pricing_type_person"
                                name="pricing_type" checked="checked">
                            <i class="helper"></i>{{ translate('Price Per Person') }}
                            <small
                                class="d-block">{{ translate('Lets you offer different prices for adults, teenagers, children, etc. Use this for public activities.') }}</small>
                        </label>
                    </div>
                </li>
                <li class="selection-item pricing_type_radio">
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" value="group"
                                {{ getChecked(@$ProductOptionSetup->pricing_type, 'group') }} class="pricing_type"
                                id="pricing_type_group" name="pricing_type">
                            <i class="helper"></i>{{ translate('Price Per Group') }}
                            <small
                                class="d-block">{{ translate('Customers pay one price for their entire group. This is often used for private activities.') }}</small>
                        </label>
                    </div>
                </li>
            </ul>

            <div class="saved_pricing_list">
                @include('admin.products.option.pricing._saved_pricing_list')
            </div>
            <p>{{ translate('To charge each person individually as well, create a new option after you submit your activity for our team to review.') }}
            </p>
            <div class="continueBtn">
                @php
                    $checkCountClass = '';
                    if (isset($ProductOptionPricingList)) {
                        if (count($ProductOptionPricingList) > 0) {
                            $checkCountClass = 'd-none';
                        }
                    }
                @endphp

                <button type="button" id=""
                    class="next action-button float-left add-new-price {{ $checkCountClass }}">
                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                    {{ translate('Add new pricing') }}
                </button>

                <form enctype="multipart/form-data" action="" id="setpOptionForm">
                    @csrf
                    <button type="submit" id=""
                        class="next action-button float-left step-option-btn float-right">
                        <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                        {{ translate('Save and continue') }}
                    </button>
                </form>
            </div>
        </div>

    </div>
    <form enctype="multipart/form-data" action="" id="setpOptionPricingForm">
        @csrf
        <div class="price_per_person d-none">
            @include('admin.products.option._price_per_person')
        </div>

        <div class="price_per_group d-none">
            @include('admin.products.option._price_per_group')
        </div>
    </form>

</div>
