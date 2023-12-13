@php
    $languages = getLanguage();

    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_transfer_bus_type_language = [];
        $CBT = getTableColumn('transfer_bus_types');
        $country = App\Models\Country::all();
    }
    $get_bus_type = DB::table('bus_type')
        ->select('bus_type.*', 'bus_type_language.title')
        ->orderBy('bus_type.id', 'desc')
        ->where(['bus_type.status' => 'Active'])
        ->join('bus_type_language', 'bus_type.id', '=', 'bus_type_language.bus_type_id')
        ->groupBy('bus_type.id')
        ->get();
    
    $get_car_model = getDataFromDB('car_models', ['status' => 'Active']);
    
    $get_airport = getDataFromDB('airport_detail', ['status' => 'Active']);
    $get_zone = getDataFromDB('zones', ['status' => 'Active']);
    
@endphp
<div class="row bus_type_div">


    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}<span
                class="text-danger">*</span></label>
        <input class="form-control {{ $errors->has('bus_title.' . $lang_id) ? 'is-invalid' : '' }} mb-2"
            placeholder="{{ translate('Transfer Title') }}" id="bus_title{{ $lang_id }}"
            name="bus_title[{{ $lang_id }}]" type="text"
            value="{{ getLanguageTranslate($get_bus_transfer_language, $lang_id, $get_transfer['id'], 'title', 'transfer_id') }}" />
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label"
            for="short_description">{{ translate('Short Description') }}</label>
        <input class="form-control {{ $errors->has('bus_short_description.' . $lang_id) ? 'is-invalid' : '' }} mb-2"
            placeholder="{{ translate('Short Description') }}" id="bus_short_description{{ $lang_id }}"
            name="bus_short_description[{{ $lang_id }}]" type="text"
            value="{{ getLanguageTranslate($get_bus_transfer_language, $lang_id, $get_transfer['id'], 'short_description', 'transfer_id') }}" />
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label" for="title">{{ translate('information') }}</label>
        <textarea
            class="form-control footer_text footer_type_bus{{ $CBT['id'] }}{{ $data }} {{ $errors->has('bus_information.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Car Type Info') }}" id="footer_type_bus{{ $CBT['id'] }}{{ $data }}"
            name="bus_information[{{ $lang_id }}]">{{ getLanguageTranslate($get_bus_transfer_language, $lang_id, $get_transfer['id'], 'description', 'transfer_id') }}</textarea>
        @error('bus_information.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 content_title">
        <label class="form-label" for="duration_from">{{ translate('Bus Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="bus_image" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $CBT['id'] }}_{{ $data }}')"
                id="car_image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $CBT['car_image'] != '' ? asset('uploads/Transfer_images/' . $CBT['car_image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $CBT['id'] }}_{{ $data }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-lg-4  content_title box">
        <label class="form-label" for="bus_type">{{ translate('Bus type') }} </label>

        <select class="form-select multi-select" name="bus_type" id="bus_type">
            @foreach ($get_bus_type as $POT)
                <option value="{{ $POT->id }}" {{ getSelected($POT->id, $CBT['car_type']) }}>{{ $POT->title }}
                </option>
            @endforeach

        </select>
    </div>
    <div class="col-md-4 col-lg-4  content_title box">
        <label class="form-label" for="bus_model">{{ translate('Info') }} </label>
        <input type="text" name="bus_model" class="form-control" value="{{ $CBT['car_model'] }}">
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-4 content_title mb-3">
        <label class="form-label" for="country">{{ translate('Country') }} </label>
        <select
            class="form-select single-select country_bus{{ $data }}_{{ $CBT['id'] }}  {{ $errors->has('bus_country') ? 'is-invalid' : '' }}"
            name="bus_country" id="bus_country" onchange="getStateCityNew('country','')">
            <option value="">{{ translate('Select Country') }}</option>
            @foreach ($country as $C)
                <option value="{{ $C['id'] }}" {{ getSelected($C['id'], old('country', $CBT['country'])) }}>
                    {{ $C['name'] }}</option>
            @endforeach
        </select>

        @error('bus_country')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('State') }}</label>
        <select class="single-select form-control {{ $errors->has('bus_state') ? 'is-invalid' : '' }}" name="bus_state"
            id="bus_state" onchange="getStateCityNew('state','')">
            <option value="">{{ translate('Select State') }}</option>
        </select>
        @error('bus_state')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('City') }}</label>
        <select class="single-select form-control {{ $errors->has('bus_city') ? 'is-invalid' : '' }}" name="bus_city"
            id="bus_city">
            <option value="">{{ translate('Select City') }}</option>
        </select>
        @error('bus_city')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('Maximum Passengers up to') }}</label>
        <input type="text" class="form-control numberonly" name="bus_passengers" id="bus_passengers"
            value="{{ $CBT['passengers'] }}" placeholder="{{ translate('Maximum Passengers up to') }}">
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('Luggage Allowed') }}</label>
        <input type="text" class="form-control" name="bus_luggage_allowed" value="{{ $CBT['luggage_allowed'] }}"
            placeholder="{{ translate('Luggage Allowed') }}">
        @error('bus_luggage_allowed')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    

    <!-- ZONES -->
    <div class="row">

        @php
        $data = 0; @endphp
        @foreach ($get_bus_transfer_zones as $TBZZ)
            @include('admin.product.transfer._bus_zones')
            @php
                $data++;
            @endphp
        @endforeach
        @if (empty($get_bus_transfer_zones))
            @include('admin.product.transfer._bus_zones')
        @endif
        <div class="show_bus_zones">
        </div>
        <div class="row">
            <div class="col-md-12 add_bus_more_button">
                <button class="btn btn-success btn-sm float-end" type="button" id="add_bus_zones" title='Add more'>
                    <span class="fa fa-plus"></span> Add more</button>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="meet_greet" {{ getChecked(1, $CBT['meet_greet']) }}
                    type="checkbox" value="1" name="bus_meet_greet">
                <label class="fs-0" for="bus_meet_greet">{{ translate('Meet & Greet') }}</label>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="bus_free_cancelation"
                    {{ getChecked(1, $CBT['free_cancelation']) }} type="checkbox" value="1"
                    name="bus_free_cancelation">
                <label class="fs-0" for="bus_free_cancelation">{{ translate('Free Cancellation') }}</label>
            </div>
        </div>

        <div class="col-md-6">
            <label>{{ translate('Free Cancelation Info Icon') }}</label>
            <textarea class="form-control" placeholder="{{ translate('Free Cancelation Icon') }}" name="bus_cancelation_icon">{{ $CBT['cancelation_icon'] }}</textarea>
        </div>
        <div class="col-md-3">
            <label>{{ translate('No Hidden Cost') }}</label>
            <input type='text' name='bus_no_hidden_cost' class="form-control" id="bus_no_hidden_cost"
                value="{{ $CBT['no_hidden_cost'] }}">

        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="bus_free_upgrade"
                    {{ getChecked(1, $CBT['free_upgrade']) }} type="checkbox" value="1"
                    name="bus_free_upgrade">
                <label class="fs-0" for="bus_free_upgrade">{{ translate('Free Upgrade') }}</label>
            </div>
        </div>

        <div class="col-md-6">
            <label>{{ translate('Free Upgrade Info Icon') }}</label>
            <textarea class="form-control" placeholder="{{ translate('Free Upgrade Icon') }}" name="bus_upgrade_icon">{{ $CBT['upgrade_icon'] }}</textarea>
        </div>

    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    // CKEDITOR.replaceAll('footer_type_bus{{ $CBT['id'] }}{{ $data }}');
</script>

<script>
    $(document).ready(function() {

        var state = "{{ $CBT['state'] }}";
        var city = "{{ $CBT['city'] }}";
        // alert(state);
        if (state != "") {
            setTimeout(() => {
                getStateCityNew("country", state);
                setTimeout(() => {
                    getStateCityNew("state", city);
                }, 500);
            }, 500);
        }

        // Get Category By Country
        $(".country_bus{{ $data }}_{{ $CBT['id'] }}").change(function() {
            var bus_country = $(this).val();
        })

    });
</script>

<script>
        // $(document).ready(function() {
        function getStateCityNew(type, selectedCat = "", count = '') {
         
            var bus_country = $("#bus_country" + count).val();
           
            var bus_state = $("#bus_state" + count).val();
            $.ajax({
                "type": "POST",
                "data": {
                    country: bus_country,
                    state: bus_state,
                    type: type,
                    selectedCat: selectedCat,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.get_state_city') }}",
                success: function(response) {
                    if (type == "country") {
                        $("#bus_state" + count).html(response);
                    } else {
                        $("#bus_city" + count).html(response);
                    }
                }
            })
        }
        // })
    </script>


<!-- Zones -->
<script type="text/javascript">
    $(document).ready(function() {
        var count = 1;

        $('#add_bus_zones').click(function(e) {
            var ParamArr = {
                'view': 'admin.product.transfer._bus_zones',
                'data': count
            }
            getAppendPage(ParamArr, '.show_bus_zones');
            e.preventDefault();
            count++;
        });


        $(document).on('click', ".delete_zones", function(e) {
            var length = $(".delete_zones").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.bus_zones_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', ".delete_pdf", function(e) {

            deleteMsg('Are you sure to delete ?').then((result) => {
                if (result.isConfirmed) {
                    $('.image_pdf').val(0);
                    $(this).parent().closest('.pdf_div').remove();
                    // e.preventDefault();
                }
            });

        });
    });
</script>

{{-- Booked Up To Advance Box --}}
<script>
    $(function() {
        BookedUpTo()
    });

    function BookedUpTo() {

        var $demoRow1 = $('<div id="demoDurationRowBookedUpTo" class="demo-row">');

        var $subsection1 = $('<div class="section-row">').append($demoRow1);


        $("#BookedUpTo_{{ $data }}_{{ $CBT['id'] }}").append($subsection1);
        $demoRow1.durationjs();

    }
    $(document).ready(function() {
        $("#demoDurationRowBookedUpTo .duration-val").on("keyup", function() {

            var duration = "";
            var len = $("#demoDurationRowBookedUpTo .duration-val").length - 1;
            $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {

                if (key == len) {
                    duration += $(this).val();
                } else {
                    duration += $(this).val() + "-";
                }
            });
            $("#can_be_booked_up_to_advance").val(duration)

        })

        if ("{{ $CBT['id'] }}" != "") {

            var durationData = "{{ $CBT['can_be_booked_up_to_advance'] }}"
            if (durationData == "") {
                $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                    $(this).val("00");
                    $(this).keyup();
                })
            } else {
                var result = durationData.split('-');
                $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                    $(this).val(result[key]);
                    $(this).keyup();
                })
            }
        } else {
            $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                $(this).val("00");
                $(this).keyup();
            })
        }
    })
</script>

{{-- Cancelled Up To Advance Box --}}
<script>
    $(function() {
        CancelledUpTo()
    });

    function CancelledUpTo() {

        var $demoRow1 = $('<div id="demoDurationRowCancelledUpTo" class="demo-row">');

        var $subsection1 = $('<div class="section-row">').append($demoRow1);


        $("#CancelledUpTo_{{ $data }}_{{ $CBT['id'] }}").append($subsection1);
        $demoRow1.durationjs();

    }
    $(document).ready(function() {
        $("#demoDurationRowCancelledUpTo .duration-val").on("keyup", function() {

            var duration = "";
            var len = $("#demoDurationRowCancelledUpTo .duration-val").length - 1;
            $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {

                if (key == len) {
                    duration += $(this).val();
                } else {
                    duration += $(this).val() + "-";
                }
            });
            $("#can_be_cancelled_up_to_advance").val(duration)

        })

        if ("{{ $CBT['id'] }}" != "") {

            var durationData = "{{ $CBT['can_be_cancelled_up_to_advance'] }}"
            if (durationData == "") {
                $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                    $(this).val("00");
                    $(this).keyup();
                })
            } else {
                var result = durationData.split('-');
                $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                    $(this).val(result[key]);
                    $(this).keyup();
                })
            }
        } else {
            $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                $(this).val("00");
                $(this).keyup();
            })
        }
    })
</script>
