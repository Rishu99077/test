@if ($is_edit > 0)
    <h6 class="font-weight-bold">{{ $TransportationDescription ? $TransportationDescription->title : '' }}
        <span class="float-right text-danger edit_transportation">{{ translate('Edit') }}</span>
        <input type="hidden" value="{{ $ProductTransportation->id }}">
    </h6>
    <span>
        {{ $ProductTransportation->air_conditioning == 'yes' ? 'Air conditioned,' : '' }}
        {{ $ProductTransportation->wifi == 'yes' ? 'WiFi,' : '' }}

        @if ($ProductTransportation->private_shared != 'none')
            {{ $private_shared != '' ? ($ProductTransportation->private_shared == 'private' ? 'Private' : 'Shared') : '' }}
        @endif
        <span class="icofont icofont-ui-delete text-danger float-right pointer remove_trans"
            id="{{ $ProductTransportation->id }}"></span>
    </span>
@else
    <div class="counter-card-1 mb-2" id="counter_{{ $ProductTransportation->id }}">
        <h6 class="font-weight-bold">{{ $TransportationDescription ? $TransportationDescription->title : '' }}
            <span class="float-right text-danger edit_transportation">{{ translate('Edit') }}</span>
            <input type="hidden" value="{{ $ProductTransportation->id }}">
        </h6>
        <span>
            {{ $ProductTransportation->air_conditioning == 'yes' ? 'Air conditioned,' : '' }}
            {{ $ProductTransportation->wifi == 'yes' ? 'WiFi,' : '' }}
            @if ($ProductTransportation->private_shared != 'none')
                {{ $private_shared != '' ? ($ProductTransportation->private_shared == 'private' ? 'Private' : 'Shared') : '' }}
            @endif
            <span class="icofont icofont-ui-delete text-danger float-right pointer remove_trans"
                id="{{ $ProductTransportation->id }}"></span>
        </span>
    </div>
@endif
