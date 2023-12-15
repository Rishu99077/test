<input type="hidden" name="ProductTransportationId"
    value="{{ $ProductTransportation ? $ProductTransportation->id : '' }}">
<input type="hidden" name="id" value="{{ $ProductTransportation ? $ProductTransportation->transportation_id : '' }}">
@if ($Transportation['capacity'] == 'yes')
    <div class="inputfield title_filed product_code">
        <h6 class="font-weight-bold">{{ translate('Capacity') }}</h6>
        <input type="number" name="capacity" id="capacity"
            value="{{ $ProductTransportation ? $ProductTransportation->capacity : '' }}" class="form-control w-75">
        <div class=" col-form-alert-label">
        </div>
    </div>
@endif
@if ($Transportation['air_conditioning'] == 'yes')
    <div class="inputfield title_filed product_code mt-3">
        <h6 class="font-weight-bold">
            {{ translate('Does this transport have air conditioning?') }}</h6>
        <ul class="form-radio">
            <li class="selection-item radio-with-explanation">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio" value="no" checked name="air_conditioning">
                        <i class="helper"></i>{{ translate('No') }}
                    </label>
                </div>
            </li>
            <li class="selection-item radio-with-explanation">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio"
                            {{ $ProductTransportation ? ($ProductTransportation->air_conditioning == 'yes' ? 'checked' : '') : '' }}
                            value="yes" name="air_conditioning">
                        <i class="helper"></i>{{ translate('Yes') }}
                    </label>
                </div>
            </li>

        </ul>
        <div class=" col-form-alert-label">
        </div>
    </div>
@endif
@if ($Transportation['wifi'] == 'yes')
    <div class="inputfield title_filed product_code mt-3">
        <h6 class="font-weight-bold">
            {{ translate('Does this transport have WiFi?') }}</h6>
        <ul class="form-radio">
            <li class="selection-item radio-with-explanation">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio" value="no" checked name="wifi">
                        <i class="helper"></i>{{ translate('No') }}
                    </label>
                </div>
            </li>
            <li class="selection-item radio-with-explanation">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio"
                            {{ $ProductTransportation ? ($ProductTransportation->wifi == 'yes' ? 'checked' : '') : '' }}
                            value="yes" name="wifi">
                        <i class="helper"></i>{{ translate('Yes') }}
                    </label>
                </div>
            </li>

        </ul>
        <div class=" col-form-alert-label">
        </div>
    </div>
@endif
@if ($Transportation['private_shared'] == 'yes')
    <div class="inputfield title_filed product_code mt-3">
        <h6 class="font-weight-bold">
            {{ translate('Private / shared') }}</h6>
        <ul class="form-radio">
            <li class="selection-item radio-with-explanation">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio" value="private" checked name="private_shared">
                        <i class="helper"></i>{{ translate('Private') }}
                    </label>
                </div>
            </li>
            <li class="selection-item radio-with-explanation">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio"
                            {{ $ProductTransportation ? ($ProductTransportation->private_shared == 'shared' ? 'checked' : '') : '' }}
                            value="shared" name="private_shared">
                        <i class="helper"></i>{{ translate('Shared') }}
                    </label>
                </div>
            </li>

        </ul>
        <div class="col-form-alert-label">
        </div>
    </div>
@endif
