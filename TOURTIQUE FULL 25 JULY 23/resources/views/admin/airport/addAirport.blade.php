@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
                <a href="#" style="width: auto;">
                    {{-- <span class="fas fa-list-alt"></span> --}}
                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>
        <div class="col-auto ms-auto">
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button"><span
                    class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.airport.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_airport['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_airport['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>
                        
                    

                        <div class="col-md-12 content_title">
                            <label class="form-label" for="title">{{ translate('Airport Name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"  placeholder="{{ translate('Enter Location') }}" id="input_store_address_id" name="name">{{ old('name', $get_airport['name']) }}</textarea>
                            <input type="hidden" name="address_lattitude" id="address_lattitude"
                                class="form-control" value="{{ $get_airport['address_lattitude'] }}">
                            <input type="hidden" name="address_longitude" id="address_longitude"
                                class="form-control" value="{{ $get_airport['address_longitude'] }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6 content_title ">
                            <label class="form-label" for="price">{{ translate('Country') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-select single-select country  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                name="country" id="country" onchange="getStateCity('country')">
                                <option value="">{{ translate('Select Country') }}</option>
                                @foreach ($country as $C)
                                    <option value="{{ $C['id'] }}"
                                        {{ getSelected($C['id'], old('country', $get_airport['country'])) }}>
                                        {{ $C['name'] }}</option>
                                @endforeach
                            </select>

                            @error('country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('State') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select
                                class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state" onchange="getStateCity('state')">
                                <option value="">{{ translate('Select State') }}</option>

                            </select>
                            @error('state')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('City') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select
                                class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                name="city" id="city">
                                <option value="">{{ translate('Select City') }}</option>

                            </select>
                            @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       
                       
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
<script>
    $(document).ready(function() {

        var state = "{{ old('state', $get_airport['state']) }}";
        var city = "{{ old('city', $get_airport['city']) }}";
        if (state != "") {
            setTimeout(() => {
                getStateCity("country", state);
                setTimeout(() => {
                    getStateCity("state", city);
                }, 500);
            }, 500);
        }
      
        // Get Category By Country
        $(".country").change(function() {
            var country = $(this).val();
        })

    });
</script>

{{-- Google Api Code --}}

<script>
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
</script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAELluF20dF7ItbE0y2efe500Lbc8kesKI&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('input_store_address_id');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#address_lattitude').val(place.geometry['location'].lat());
            $('#address_longitude').val(place.geometry['location'].lng());
        });
    }
</script>

@endsection
