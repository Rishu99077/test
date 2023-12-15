@php
    if (isset($data['ProductOptionSetup'])) {
        $ProductOptionSetup = $data['ProductOptionSetup'];
        $ProductOptionDescription = $data['ProductOptionDescription'];
        $ProductOptionPricingList = $data['ProductOptionPricingList'];
        $ProductOptionAvailability = $data['ProductOptionAvailability'];
        $ProductOptionAvailabilityDescription = $data['ProductOptionAvailabilityDescription'];
    }
    
@endphp
<div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'optionSetup') }}" id="setup-vertical" role="tabpanel"
    aria-labelledby="setup-vertical-tab">
    @include('admin.products.option._optionSetup')
</div>
<div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'optionPrice') }}" id="option-price-vertical"
    role="tabpanel" aria-labelledby="option-price-vertical-tab">
    @include('admin.products.option._optionPrice')
</div>

<div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'optionAvailability') }}" id="option-availability-vertical"
    role="tabpanel" aria-labelledby="option-availability-vertical-tab">
    {{-- @include('admin.products.option._optionAvailability') --}}
</div>

<div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'optionDiscount') }}" id="option-discount-vertical"
    role="tabpanel" aria-labelledby="option-discount-vertical-tab">
    {{-- @include('admin.products.option._optionAvailability') --}}
</div>
