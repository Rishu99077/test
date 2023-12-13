@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
              <a href="#" style="width: auto;">
                  <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
              </a>
            </li>
            <li>
                <a href="#" style="width: auto;">
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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button">
                <span class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.golf_courses.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_golf_courses['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_golf_courses['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                       
                        <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Main Title') }}<span
                              class="text-danger">*</span>
                           </label>
                           <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Main Title') }}" id="title" name="title[{{ $lang_id }}]"
                              type="text"
                              value="{{ getLanguageTranslate($get_golf_courses_language, $lang_id, $get_golf_courses['id'], 'title', 'golf_course_id') }}" />
                           @error('title.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        


                        <div class="col-md-12">
                            <label class="form-label" for="location">{{ translate('Location') }}</label>
                            <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" placeholder="{{ translate('Location') }}" id="location" name="location" type="text" value="{{ $get_golf_courses['location'] }}" />                
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="holes">{{ translate('Holes') }}</label>
                                <input class="form-control numberonly" placeholder="{{ translate('Holes') }}" id="holes" name="holes" type="text" value="{{ $get_golf_courses['holes'] }}" />                
                            </div>


                            <div class="col-md-4">
                                <label class="form-label" for="yards">{{ translate('Yards') }}</label>
                                <input class="form-control numberonly" placeholder="{{ translate('Yards') }}" id="yards" name="yards" type="text" value="{{ $get_golf_courses['yards'] }}" />                
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="pars">{{ translate('Pars') }}</label>
                                <input class="form-control numberonly" placeholder="{{ translate('Pars') }}" id="pars" name="pars" type="text" value="{{ $get_golf_courses['pars'] }}" />                
                            </div>
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

<script src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('google_address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#address_lattitude').val(place.geometry['location'].lat());
            $('#address_longitude').val(place.geometry['location'].lng());
        });
    }
</script>    
@endsection
