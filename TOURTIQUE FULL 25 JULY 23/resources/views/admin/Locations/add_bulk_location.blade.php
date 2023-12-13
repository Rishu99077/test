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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button">
                <span class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3 " method="post" id="add_bulk" enctype="multipart/form-data" action="">
        @csrf    

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_locations['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_locations['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>


                        <div class="col-md-6 content_title ">
                            <label class="form-label" for="price">{{ translate('Zone') }}  </label>
                            <select class="form-select single-select zone  {{ $errors->has('zone') ? 'is-invalid' : '' }}" name="zone" id="zone">
                              <option value="">{{ translate('Select Zone') }}</option>
                              @foreach ($zones as $val_zone)
                                  <option value="{{ $val_zone['id'] }}"
                                      {{ getSelected($val_zone['id'], old('zone', $get_locations['zone'])) }}>
                                      {{ $val_zone['zone_title'] }}</option>
                              @endforeach
                            </select>

                            <div class="invalid-feedback">
                                      
                            </div>

                            
                        </div>


                        <div class="col-md-6">
                            <label class="form-label" for="location_title">{{ translate('Location') }}<span class="text-danger">*</span></label>
                            <input class="form-control location_title" placeholder="{{ translate('Location') }}" id="location_title" name="location_title" type="text" value="{{ $get_locations['location_title'] }}" />

                           <div class="invalid-feedback">
                                      
                            </div>
                        </div>


                        <div class="col-md-12 content_title">
                            <label class="form-label" for="title">{{ translate('Google Address') }} <span class="text-danger">*</span> </label>
                            
                            <textarea class="form-control google_address {{ $errors->has('google_address') ? 'is-invalid' : '' }}"  placeholder="{{ translate('Enter Google Address') }}" id="google_address" name="google_address">{{ old('google_address', $get_locations['google_address']) }}</textarea>

                            <input type="hidden" name="address_lattitude" id="address_lattitude" class="form-control" value="{{ $get_locations['address_lattitude'] }}">
                            <input type="hidden" name="address_longitude" id="address_longitude" class="form-control" value="{{ $get_locations['address_longitude'] }}">

                            <div class="invalid-feedback">
                                      
                            </div>

                        </div>
                        
                       
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit" > <span class="fas fa-save"></span> {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-3 mb-3">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body pt-0">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                aria-labelledby="tab-dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc"
                                id="dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc">
                                <div class="table-responsive scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ translate('Zone') }}</th>
                                                <th scope="col">{{ translate('Location') }}</th>
                                                <th scope="col">{{ translate('Address') }}</th>
                                                <th class="text-end" scope="col">{{ translate('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="new_data">
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    
                                </div>
                            </div>
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

<script src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places" type="text/javascript"></script>
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


{{-- Add BULK LOCATION --}}

<script>
    $('body').on("submit", "#add_bulk", function(e) {
       
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('admin.locations.add') }}",
            datatype: 'JSON',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response.error);
                // return false;
                if (response.error) {
                    $.each(response.error, function(index, value) {
                            if (value != '') {
                                
                                var index = index.replace(".", "_");
                                // alert(index);
                                if (index == "passengers") {

                                    var focusDiv = $('input[name^=' + index + ']');
                                    $('input[name^=' + index + ']').addClass(
                                        'is-invalid');
                                    // $('#pick_option_invalid').addClass('d-block');
                                    $('input[name^=' + index + ']').focus();
                                    // $('#pick_option_invalid').html(
                                    //     value);

                                    var $cl = $('input[name^=' + index + ']').closest(
                                        '.tab-content');


                                } else if (index == "duration") {

                                    $('#' + index).addClass('is-invalid');
                                    var $cl = $('#demoDurationRow').closest(
                                        '.tab-content');
                                    var focusDiv = $('#demoDurationRow');


                                } else if (index == "address") {

                                    $('#google_address').addClass('is-invalid');
                                    var $cl = $('#google_address').closest(
                                        '.tab-content');
                                    var focusDiv = $('#google_address');

                                } else {

                                    $('#' + index).addClass('is-invalid');
                                    var $cl = $('#' + index).closest('.tab-content');
                                    var focusDiv = $('#' + index);
                                }


                                var ClassName = $($cl).removeClass("tab-content typography").attr("class");

                                $('input[name="add_product"]').each(function() {
                                    if ($(this).hasClass(ClassName)) {
                                        $(this).prop('checked', true);
                                    }
                                    // $(".typography").css("display", "none");
                                })
                                $("li." + ClassName).css("display", "block");
                                $("li." + ClassName).addClass("typography");
                                $("li." + ClassName).addClass("tab-content");

                                $('#' + index).parent().find('.invalid-feedback').html(value);

                                setTimeout(() => {
                                    $(focusDiv).focus();
                                }, 500);


                            }
                        });
                } else {
                    success_msg("Location {{ $common['button'] }} Successfully...");

                    var zone           = $('.zone option:selected').text();
                    var location_title = $(".location_title").val();
                    var address        = $(".google_address").val();

                    var html = '';
                    html+='<tr class="row_loc">';
                        html+='<td>'+zone+'</td>';
                        html+='<td>'+location_title+'</td>';
                        html+='<td>'+address+'</td>';
                        html+='<td class="text-end"><button class="btn btn-danger delete_loc" type="button"><span class="fa fa-trash"></span></button></td>';
                    html+='</tr>';
                    $(".new_data").append(html);

                    // $('.zone').prop('disabled', true);
                    $(".location_title").val('');
                    $(".google_address").val('');

                    $('.invalid-feedback').html('');

                    $('.location_title').removeClass('is-invalid');
                    $('.google_address').removeClass('is-invalid');


                }
            }
        });
        return false;
    });
</script>
<script type="text/javascript">
    $('body').on("click", ".delete_loc", function(e) {
        alert("dh");
        var length = $(".delete_loc").length;
       
          deleteMsg('Are you sure to delete ?').then((result) => {
              if (result.isConfirmed) {
                  $(this).parent().closest('.row_loc').remove();
                  e.preventDefault();
              }
          });
       
    });
</script>


@endsection
