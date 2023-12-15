@php

    if (isset($data['ProductOption'])) {
        $ProductOption = $data['ProductOption'];
    }
@endphp
@if (@$ProductOption)

    @foreach ($ProductOption as $PO)
        @php
            $ProductOptionDescription = App\Models\ProductOptionDescription::where(['product_id' => $PO['product_id'], 'option_id' => $PO['id'], 'language_id' => $language_id])->first();
        @endphp
        <div class="option-card" tour-id="{{ $PO['product_id'] }}" style="height: auto;">
            <div class="option-card__header">
                <h3 class="option-card__title">
                    @if (isset($PO['reference_code']))
                        {{ $PO['reference_code'] }}
                    @else
                        {{ 'Default' }}
                    @endif
                    |
                    @if (isset($ProductOptionDescription))
                        {{ $ProductOptionDescription['title'] }}
                    @else
                        {{ 'Not specified' }}
                    @endif
                    <p class="option-card__subtitle">{{ translate('Option ID') }} :
                        {{ $PO['id'] }}
                    </p>
                </h3>
                <div class="option-actions">
                    <a id="editOption" data-option={{ $PO['id'] }} href="#"
                        class="main-button c-button c-button--small c-button--outlined-standard editOption"><!---->
                        Edit option </a><!---->
                    {{-- <button class=" btn btn-danger btn-sm"> --}}
                    <span class="fa fa-times cursor-pointer text-danger f-18 remove_option"
                        data-option={{ $PO['id'] }}></span>
                    {{-- </button> --}}
                </div>
            </div><!---->
            <dl class="option-details">
                <dt class="option-details-title"> {{ translate('Status') }} </dt>
                <dd class="option-details-value"> {{ translate('Temporary') }} </dd><!----><!---->
                <dt class="option-details-title"> {{ translate('Booking Engine') }} </dt>
                <dd class="option-details-value"> {{ translate('Automatically accept') }}
                    new
                    bookings </dd>
                <dt class="option-details-title"> {{ translate('Cut-off time') }}: </dt>
                <dd class="option-details-value">
                    @if ($PO['cut_off_time'] != '')
                        {{ $PO['cut_off_time'] }} {{ translate('Minutes') }}
                    @endif
                </dd>
                <dt class="option-details-title"> {{ translate('Type') }} </dt>
                <dd class="option-details-value">{{ $PO['is_private'] }} </dd>
                <!---->
            </dl>
            <div class="option-card__pricing"><!----><!----><!---->
            </div>
            <!----><!----><!---->
        </div>
    @endforeach
@endif
