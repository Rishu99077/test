@php
    $languages = getLanguage();

    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];

    if (isset($append)) {
        $get_transfer_car_type_language = [];
        $CRT = getTableColumn('transfer_car_types');
        $country = App\Models\Country::all();
    }
    $get_car_type = DB::table('car_type')
        ->select('car_type.*', 'car_type_language.title')
        ->orderBy('car_type.id', 'desc')
        ->where(['car_type.status' => 'Active'])
        ->join('car_type_language', 'car_type.id', '=', 'car_type_language.car_type_id')
        ->groupBy('car_type.id')
        ->get();
    
    $get_car_model = getDataFromDB('car_models', ['status' => 'Active']);
    
    $get_airport = getDataFromDB('airport_detail', ['status' => 'Active']);
    $get_zone = getDataFromDB('zones', ['status' => 'Active']);
    
@endphp
<div class="row car_type_div">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}<span
                class="text-danger">*</span></label>
        <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }} mb-2"
            placeholder="{{ translate('Transfer Title') }}" id="title_{{ $lang_id }}"
            name="title[{{ $lang_id }}]" type="text"
            value="{{ getLanguageTranslate($get_transfer_language, $lang_id, $get_transfer['id'], 'title', 'transfer_id') }}" />
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label"
            for="short_description">{{ translate('Short Description') }}</label>
        <input class="form-control {{ $errors->has('short_description.' . $lang_id) ? 'is-invalid' : '' }} mb-2"
            placeholder="{{ translate('Short Description') }}" id="short_description_{{ $lang_id }}"
            name="short_description[{{ $lang_id }}]" type="text"
            value="{{ getLanguageTranslate($get_transfer_language, $lang_id, $get_transfer['id'], 'short_description', 'transfer_id') }}" />
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label" for="title">{{ translate('information') }}</label>
        <textarea
            class="form-control footer_text footer_type_{{ $CRT['id'] }}{{ $data }} {{ $errors->has('information.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Car Type Info') }}" id="footer_type_{{ $CRT['id'] }}{{ $data }}"
            name="information[{{ $lang_id }}]">{{ getLanguageTranslate($get_transfer_language, $lang_id, $get_transfer['id'], 'description', 'transfer_id') }}</textarea>
        @error('information.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 content_title">
        <label class="form-label" for="duration_from">{{ translate('Car Image') }}
            <small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="car_image" aria-describedby="basic-addon2"
                onchange="loadFile(event,'upload_work_logo_{{ $CRT['id'] }}_{{ $data }}')"
                id="car_image" />

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-100  overflow-hidden position-relative">
                    <img src="{{ $CRT['car_image'] != '' ? asset('uploads/Transfer_images/' . $CRT['car_image']) : asset('uploads/placeholder/placeholder.png') }}"
                        id="upload_work_logo_{{ $CRT['id'] }}_{{ $data }}" width="100" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-lg-4  content_title box">
        <label class="form-label" for="car_type">{{ translate('Car type') }} </label>

        <select class="form-select multi-select" name="car_type" id="car_type">
            @foreach ($get_car_type as $POT)
                <option value="{{ $POT->id }}" {{ getSelected($POT->id, $CRT['car_type']) }}>{{ $POT->title }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-4 col-lg-4  content_title box">
        <label class="form-label" for="car_model">{{ translate('Info') }} </label>
        <input type="text" name="car_model" class="form-control" value="{{ $CRT['car_model'] }}">
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-4 content_title mb-3">
        <label class="form-label" for="country">{{ translate('Country') }} </label>
        <select
            class="form-select single-select country_{{ $data }}_{{ $CRT['id'] }}  {{ $errors->has('country') ? 'is-invalid' : '' }}"
            name="country" id="country" onchange="getStateCity('country','')">
            <option value="">{{ translate('Select Country') }}</option>
            @foreach ($country as $C)
                <option value="{{ $C['id'] }}" {{ getSelected($C['id'], old('country', $CRT['country'])) }}>
                    {{ $C['name'] }}</option>
            @endforeach
        </select>

        @error('country')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('State') }}</label>
        <select class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state"
            id="state" onchange="getStateCity('state','')">
            <option value="">{{ translate('Select State') }}</option>
        </select>
        @error('state')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('City') }}</label>
        <select class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city"
            id="city">
            <option value="">{{ translate('Select City') }}</option>
        </select>
        @error('city')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('Maximum Passengers up to') }}</label>
        <input type="text" class="form-control numberonly" name="passengers" id="passengers"
            value="{{ $CRT['passengers'] }}" placeholder="{{ translate('Maximum Passengers up to') }}">
        <div class="invalid-feedback">
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('Luggage Allowed') }}</label>
        <input type="text" class="form-control" name="luggage_allowed" value="{{ $CRT['luggage_allowed'] }}"
            placeholder="{{ translate('Luggage Allowed') }}">
        @error('luggage_allowed')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label" for="title">{{ translate('Journey Time') }}</label>
        <input type="text" class="form-control" name="journey_time" value="{{ $get_transfer['journey_time'] }}"
            placeholder="{{ translate('Journey Time') }}">
        @error('journey_time')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

   
    <div class="col-md-4 mb-3">
        <label class="form-label" for="product_type">{{ translate('Product Type') }}</label>
        <select class="single-select form-control {{ $errors->has('product_type') ? 'is-invalid' : '' }}"
            name="product_type" id="product_type">
            <option value="car" {{ getSelected('car', $get_transfer['product_type']) }}>{{ translate('Car') }}
            </option>
            <option value="bus" {{ getSelected('bus', $get_transfer['product_type']) }}>{{ translate('Bus') }}
            </option>
        </select>
        @error('product_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <!-- ZONES -->
    <div class="row">

        @php
        $data = 0; @endphp
        @foreach ($get_transfer_zones as $TZZ)
            @include('admin.product.transfer._zones')
            @php
                $data++;
            @endphp
        @endforeach
        @if (empty($get_transfer_zones))
            @include('admin.product.transfer._zones')
        @endif
        <div class="show_zones">
        </div>
        <div class="row">
            <div class="col-md-12 add_more_button">
                <button class="btn btn-success btn-sm float-end" type="button" id="add_zones" title='Add more'>
                    <span class="fa fa-plus"></span> Add more</button>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="product_bookable"
                    {{ getChecked(1, $CRT['product_bookable']) }} type="checkbox" value="1"
                    name="product_bookable">
                <label class="fs-0" for="product_bookable">{{ translate('Door to Door') }}</label>
            </div>
        </div>

        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="meet_greet" {{ getChecked(1, $CRT['meet_greet']) }}
                    type="checkbox" value="1" name="meet_greet">
                <label class="fs-0" for="meet_greet">{{ translate('Meet & Greet') }}</label>
            </div>
        </div>

    </div>
    {{-- <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Free Cancelation') }}</h5> --}}
    <div class="row">
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="free_cancelation"
                    {{ getChecked(1, $CRT['free_cancelation']) }} type="checkbox" value="1"
                    name="free_cancelation">
                <label class="fs-0" for="free_cancelation">{{ translate('Free Cancellation') }}</label>
            </div>
        </div>

        <div class="col-md-6">
            <label>{{ translate('Free Cancelation Info Icon') }}</label>
            <textarea class="form-control" placeholder="{{ translate('Free Cancelation Icon') }}" name="cancelation_icon">{{ $CRT['cancelation_icon'] }}</textarea>
        </div>
        <div class="col-md-3">
            <label>{{ translate('No Hidden Cost') }}</label>
            <input type='text' name='no_hidden_cost' class="form-control" id="no_hidden_cost"
                value="{{ $CRT['no_hidden_cost'] }}">

        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mt-2">
            <div class="form-check form-switch pl-0">
                <input class="form-check-input float-end" id="free_upgrade" {{ getChecked(1, $CRT['free_upgrade']) }}
                    type="checkbox" value="1" name="free_upgrade">
                <label class="fs-0" for="free_upgrade">{{ translate('Free Upgrade') }}</label>
            </div>
        </div>

        <div class="col-md-6">
            <label>{{ translate('Free Upgrade Info Icon') }}</label>
            <textarea class="form-control" placeholder="{{ translate('Free Upgrade Icon') }}" name="upgrade_icon">{{ $CRT['upgrade_icon'] }}</textarea>
        </div>

    </div>

    {{-- <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Free Cancelation') }}</h5>
    <div class="row">
        <div class="col-md-6">
            <label>{{ translate('Free Cancelation Info') }}</label>
            <input type='text' name='cancelation_info' class="form-control" id="cancelation_info"
                value="{{ $CRT['cancelation_info'] }}">

        </div>
        <div class="col-md-6">
            <label>{{ translate('Free Cancelation Icon') }}</label>
            <textarea class="form-control" placeholder="{{ translate('Free Cancelation Icon') }}" name="cancelation_icon">{{ $CRT['cancelation_icon'] }}</textarea>
        </div>
    </div> --}}

    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    // CKEDITOR.replaceAll('footer_type_{{ $CRT['id'] }}{{ $data }}');
</script>

<script>
    $(document).ready(function() {

        var state = "{{ $CRT['state'] }}";
        var city = "{{ $CRT['city'] }}";

        if (state != "") {
            setTimeout(() => {
                getStateCity("country", state);
                setTimeout(() => {
                    getStateCity("state", city);
                }, 500);
            }, 500);
        }

        // Get Category By Country
        $(".country_{{ $data }}_{{ $CRT['id'] }}").change(function() {
            var country = $(this).val();
        })

    });
</script>

<!-- Zones -->
<script type="text/javascript">
    $(document).ready(function() {
        var count = 1;

        $('#add_zones').click(function(e) {
            var ParamArr = {
                'view': 'admin.product.transfer._zones',
                'data': count
            }
            getAppendPage(ParamArr, '.show_zones');
            e.preventDefault();
            count++;
        });


        $(document).on('click', ".delete_car_zones", function(e) {
            var length = $(".delete_car_zones").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.zones_div').remove();
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


        $("#BookedUpTo_{{ $data }}_{{ $CRT['id'] }}").append($subsection1);
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

        if ("{{ $CRT['id'] }}" != "") {

            var durationData = "{{ $CRT['can_be_booked_up_to_advance'] }}"
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


        $("#CancelledUpTo_{{ $data }}_{{ $CRT['id'] }}").append($subsection1);
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

        if ("{{ $CRT['id'] }}" != "") {

            var durationData = "{{ $CRT['can_be_cancelled_up_to_advance'] }}"
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
