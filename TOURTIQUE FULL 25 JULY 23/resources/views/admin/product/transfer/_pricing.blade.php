@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $TPC = getTableColumn('transfer_pricing');
    }
    $get_car_type = DB::table('car_type')
                    ->select('car_type.*', 'car_type_language.title')
                    ->orderBy('car_type.id', 'desc')
                    ->where(['car_type.status' => 'Active'])
                    ->join("car_type_language", 'car_type.id', '=', 'car_type_language.car_type_id')
                    ->groupBy('car_type.id')
                    ->get();    
@endphp
<div class="row pricing_div">
    <div>
        <button class="delete_pricing bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="pricing_id[]" value="{{$TPC['id']}}">
    
    <div class="row">
        <div class="col-md-3 col-lg-3">
            <label class="form-label" for="price">{{ translate('Car type') }}</label>
           
            <select class="form-select multi-select" name="car_type[]" id="car_type">
                @foreach ($get_car_type as $POT)
                    <option value="{{ $POT->id }}"
                        {{ isset($TPC['car_type']) ? getSelectedInArray($POT->id, $TPC['car_type']) : '' }}
                        >{{ $POT->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="price_per_car">{{ translate('Price Per Car one way') }}</label>
            <input class="form-control numberonly {{ $errors->has('price_per_car') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Price Per Car one way') }}"  id="price_per_car"
                name="price_per_car[]" type="text" value="{{ $TPC['price_per_car'] }}" />
            @error('price_per_car')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>    
    </div>    


    <div class="row">

        <div class="col-md-12 content_title">
            <label class="form-label" for="title">{{ translate('Airport') }} </label>
            <textarea class="form-control"  placeholder="{{ translate('Enter Location') }}" name="airport_address[]">{{$TPC['airport_address'] }}</textarea>
        </div>
        <div class="col-md-12 content_title">
            <label class="form-label" for="title">{{ translate('To') }} {{ translate('(Choose Zone)') }} </label>
            <textarea class="form-control"  placeholder="{{ translate('Enter Location') }}" name="zone_address[]">{{  $TPC['zone_address'] }}</textarea>
        </div>
    </div> 

    <div class="mt-3">
        <hr>
    </div>
</div>

{{-- Google Api Code --}}

<script>
    $(document).ready(function() {
        var x = document.getElementById("store_address_id");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "{{ translate('Get Location Not Supported') }}";
            }
        }

        function showPosition(position) {
            console.log(position);
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
        }
    });
</script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('input_store_address_id_{{$TPC['id']}}_{{$data}}');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#address_lattitude_{{$TPC['id']}}_{{$data}}').val(place.geometry['location'].lat());
                $('#address_longitude_{{$TPC['id']}}_{{$data}}').val(place.geometry['location'].lng());
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('input_store_zone_id_{{$TPC['id']}}_{{$data}}');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#zone_lattitude_{{$TPC['id']}}_{{$data}}').val(place.geometry['location'].lat());
                $('#zone_longitude_{{$TPC['id']}}_{{$data}}').val(place.geometry['location'].lng());
            });
        }
    });
</script>
