@php
    if (isset($append)) {
        $TZZ = getTableColumn('transfer_zones');
    }
    $get_airport  = getDataFromDB('airport_detail', ['status' => 'Active']);
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    $get_zone     = getDataFromDB('zones', ['status' => 'Active']);

@endphp



<div class="row zones_div">
    <div>
        <button class="delete_car_zones bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="zone_id[]" value="{{ $TZZ['id'] }}">

    <div class="col-md-3 content_title mb-3">
        <label class="form-label" for="title">{{ translate('Airport') }} </label>
        <select class="form-select single-select airport{{$data}}{{$TZZ['id']}}  {{ $errors->has('airport') ? 'is-invalid' : '' }}"
            name="airport[]" id="airport{{$data}}{{$TZZ['id']}}" >
            <option value="">{{ translate('Select Airport') }}</option>
            @foreach ($get_airport as $air_key => $air_value)
                <option value="{{ $air_value->id }}"
                    {{ getSelected($air_value->id, old('airport', $TZZ['airport_id'] )) }}>
                    {{ $air_value->name }}</option>
            @endforeach
        </select>
    </div>

    @if($TZZ['id']!='')
        <div class="col-md-2 content_title mb-3">
            <label class="form-label" for="title">{{ translate('To') }} {{ translate('(Choose Zone)') }} </label>
            <?php 
                $selected_airport_id = '"'.$TZZ['airport_id'].'"';
                $zone_data = App\Models\Zones::where('airport','LIKE', '%'.$selected_airport_id.'%')
                                ->where('status', 'Active')->get();
            ?> 
            <select class="form-select single-select zone{{$data}}{{$TZZ['id']}}  {{ $errors->has('zone') ? 'is-invalid' : '' }}"
                name="zone[]" id="zone{{$data}}{{$TZZ['id']}}">
                @foreach ($zone_data as $zone_key => $zone_value)
                    <option value="{{ $zone_value->id }}"
                        {{ getSelected($zone_value->id, old('zone', $TZZ['zone_id'] )) }}>
                        {{ $zone_value->zone_title }}</option>
                @endforeach       
            </select>
        </div> 
    @else
        <div class="col-md-2 content_title mb-3">
            <label class="form-label" for="title">{{ translate('To') }} {{ translate('(Choose Zone)') }} </label>
            <select class="form-select single-select  zone{{$data}}{{$TZZ['id']}} {{ $errors->has('zone') ? 'is-invalid' : '' }}"
                name="zone[]" id="zone{{$data}}{{$TZZ['id']}}">
            
            </select>
        </div>
    @endif

    <div class="col-md-2 mb-2">
        <label class="form-label" for="price">{{ translate('Price') }}</label>
        <input class="form-control numberonly {{ $errors->has('price') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Price ') }}" id="price" name="price[]" type="text"
            value="{{ $TZZ['price'] }}" />
        @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-3 mb-2">
        <label class="form-label" for="airport_parking_fee">{{ translate('Airport Parking Fee Arrival Only') }}</label>
        <input class="form-control numberonly {{ $errors->has('airport_parking_fee') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Airport Parking Fee ') }}" id="airport_parking_fee" name="airport_parking_fee[]" type="text"
            value="{{ $TZZ['airport_parking_fee'] }}" />
        @error('airport_parking_fee')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-2 mb-2">
        <label class="form-label" for="airport_parking_fee"></label>
        <br>
        <input class="form-check-input mt-2" id="flexCheckDefault" type="checkbox" name="zone_status[{{ $data }}]" value="1" 
        @php if($TZZ['id'] != ""){
            if($TZZ['zone_status'] == 1){
                echo "checked";
            }
        }@endphp >
    </div>



    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    $('.single-select').select2();
</script>

<script type="text/javascript">

    $(document).on('change', ".airport{{$data}}{{$TZZ['id']}}", function(e) {
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
                $("#zone{{$data}}{{$TZZ['id']}}").closest(".zones_div").find('#zone{{$data}}{{$TZZ['id']}}').html(response);
                
            }
        });

    });
</script>

<script type="text/javascript">

    $(document).on('change', ".zone{{$data}}{{$TZZ['id']}}", function(e) {
        var zone_id = $(this).val();

        var airport_id =  $(".zone{{$data}}{{$TZZ['id']}}").closest(".zones_div").find('.airport{{$data}}{{$TZZ['id']}}').val()
        

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
                // $("#zone{{$data}}{{$TZZ['id']}}").closest(".zones_div").find('#zone{{$data}}{{$TZZ['id']}}').html(response);
                
            }
        });

    });
</script>

