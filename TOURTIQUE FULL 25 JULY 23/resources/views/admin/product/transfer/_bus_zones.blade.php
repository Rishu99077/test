@php
    
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $TBZZ = getTableColumn('transfer_zones');
    }
    $get_airport = getDataFromDB('airport_detail', ['status' => 'Active']);
    
    $get_zone = getDataFromDB('zones', ['status' => 'Active']);
    
@endphp

<div class="row bus_zones_div">
    <div>
        <button class="delete_zones bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="bus_zone_id[]" value="{{ $TBZZ['id'] }}">

    <div class="col-md-3 content_title mb-3">
        <label class="form-label" for="title">{{ translate('Airport') }} </label>
        <select
            class="form-select single-select bus_airport{{ $data }}{{ $TBZZ['id'] }}  {{ $errors->has('bus_airport') ? 'is-invalid' : '' }}"
            name="bus_airport[]" id="bus_airport{{ $data }}{{ $TBZZ['id'] }}">
            <option value="">{{ translate('Select Airport') }}</option>
            @foreach ($get_airport as $air_key => $air_value)
                <option value="{{ $air_value->id }}"
                    {{ getSelected($air_value->id, old('bus_airport', $TBZZ['airport_id'])) }}>
                    {{ $air_value->name }}</option>
            @endforeach
        </select>
    </div>

    @if ($TBZZ['id'] != '')
        <div class="col-md-2 content_title mb-3">
            <label class="form-label" for="title">{{ translate('To') }} {{ translate('(Choose Zone)') }} </label>
            <?php
            $selected_airport_id = '"' . $TBZZ['airport_id'] . '"';
            $zone_data = App\Models\Zones::where('airport', 'LIKE', '%' . $selected_airport_id . '%')
                ->where('status', 'Active')
                ->get();
            ?>
            <select
                class="form-select single-select bus_zone{{ $data }}{{ $TBZZ['id'] }}  {{ $errors->has('bus_zone') ? 'is-invalid' : '' }}"
                name="bus_zone[]" id="bus_zone{{ $data }}{{ $TBZZ['id'] }}">
                @foreach ($zone_data as $zone_key => $zone_value)
                    <option value="{{ $zone_value->id }}"
                        {{ getSelected($zone_value->id, old('bus_zone', $TBZZ['zone_id'])) }}>
                        {{ $zone_value->zone_title }}</option>
                @endforeach
            </select>
        </div>
    @else
        <div class="col-md-2 content_title mb-3">
            <label class="form-label" for="title">{{ translate('To') }} {{ translate('(Choose Zone)') }} </label>
            <select
                class="form-select single-select  bus_zone{{ $data }}{{ $TBZZ['id'] }} {{ $errors->has('bus_zone') ? 'is-invalid' : '' }}"
                name="bus_zone[]" id="bus_zone{{ $data }}{{ $TBZZ['id'] }}">

            </select>
        </div>
    @endif

    <div class="col-md-2 mb-2">
        <label class="form-label" for="adult_price">{{ translate('Adult Price') }}</label>
        <input class="form-control numberonly {{ $errors->has('adult_price') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Price ') }}" id="adult_price" name="bus_adult_price[]" type="text"
            value="{{ $TBZZ['adult_price'] }}" />
        @error('adult_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-2 mb-2">
        <label class="form-label" for="child_price">{{ translate('Child Price') }}</label>
        <input class="form-control numberonly {{ $errors->has('child_price') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Price ') }}" id="child_price" name="bus_child_price[]" type="text"
            value="{{ $TBZZ['child_price'] }}" />
        @error('child_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-2 mb-2">
        <label class="form-label"
            for="bus_airport_parking_fee">{{ translate('Airport Parking Fee Arrival Only') }}</label>
        <input class="form-control numberonly {{ $errors->has('bus_airport_parking_fee') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Airport Parking Fee ') }}" id="bus_airport_parking_fee"
            name="bus_airport_parking_fee[]" type="text" value="{{ $TBZZ['airport_parking_fee'] }}" />
        @error('bus_airport_parking_fee')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-1 mb-2">
        <label class="form-label" for="bus_airport_parking_fee"></label>
        <br>
        <input class="form-check-input mt-2" id="flexCheckDefault" type="checkbox"
            name="bus_zone_status[{{ $data }}]" value="1"
            @php if($TBZZ['id'] != ""){
            if($TBZZ['zone_status'] == 1){
                echo "checked";
            }
        } @endphp>
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    $('.single-select').select2();
</script>

<script type="text/javascript">
    $(document).on('change', ".bus_airport{{ $data }}{{ $TBZZ['id'] }}", function(e) {
        var airport = $(this).val();
        var selectedCat = 'airport';
        $.ajax({
            "type": "POST",
            "data": {
                airport: airport,
                selectedCat: selectedCat,
                _token: "{{ csrf_token() }}"
            },
            url: "{{ route('admin.get_zones') }}",
            success: function(response) {
                // console.log(response);
                $("#bus_zone{{ $data }}{{ $TBZZ['id'] }}").closest(".bus_zones_div")
                    .find(
                        '#bus_zone{{ $data }}{{ $TBZZ['id'] }}').html(response);

            }
        });

    });
</script>

<script type="text/javascript">
    $(document).on('change', ".bus_zone{{ $data }}{{ $TBZZ['id'] }}", function(e) {
        var zone_id = $(this).val();

        var airport_id = $(".bus_zone{{ $data }}{{ $TBZZ['id'] }}").closest(".bus_zones_div").find(
            '.airport{{ $data }}{{ $TBZZ['id'] }}').val()


        $.ajax({
            "type": "POST",
            "data": {
                zone_id: zone_id,
                airport_id: airport_id,
                _token: "{{ csrf_token() }}"
            },
            url: "{{ route('admin.get_locations') }}",
            success: function(response) {
                // console.log(response);
                // $("#zone{{ $data }}{{ $TBZZ['id'] }}").closest(".bus_zones_div").find('#zone{{ $data }}{{ $TBZZ['id'] }}').html(response);

            }
        });

    });
</script>
