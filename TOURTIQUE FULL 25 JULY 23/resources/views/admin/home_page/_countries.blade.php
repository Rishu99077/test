@php
    $languages = getLanguage();
    if (isset($append)) {
        $GCC = getTableColumn('home_country');
    }
    $country  = getDataFromDB('countries');
@endphp

<div class="row country_div">
    <div>
         <button class="delete_country bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button> 
    </div>
    <input type="hidden" name="home_country_id[{{ $data }}][]" value="{{ $GCC['id'] }}">



    <div class="row">
    
        
        <div class="col-md-4 content_title ">
            <label class="form-label" for="price">{{ translate('Country') }}
                <span class="text-danger">*</span>
            </label>
            <select class="form-select single-select country{{ $id }}{{$GCC['id']}}  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                name="search_country[{{ $data }}][]" id="country" onchange="getStateCity('country')">
                <option value="">{{ translate('Select Country') }}</option>
                @foreach ($country as $C)
                    <option value="{{ $C->id }}" {{ getSelected($C->id, old('country', $GCC['search_country'])) }}>
                        {{ $C->name }}</option>
                @endforeach
            </select>

            <div class="invalid-feedback">

            </div>

        </div>
        

        @if($GCC['id']!='')
            <div class="col-md-4">
                <label class="form-label" for="title">{{ translate('State') }}<span
                        class="text-danger">*</span>
                </label>
                <?php 
                    $data_state = App\Models\States::where('country_id',$GCC['search_country'])->get();
                ?> 
                <select class="single-select form-control state{{ $id }}{{$GCC['id']}} {{ $errors->has('state') ? 'is-invalid' : '' }}"
                    name="search_state[{{ $data }}][]" id="state" onchange="getStateCity('state')">
                    <option value="">{{ translate('Select State') }}</option>
                    @foreach ($data_state as $zone_key => $zone_value)
                    <option value="{{ $zone_value->id }}"
                        {{ getSelected($zone_value->id, $GCC['search_state'] ) }}>
                        {{ $zone_value->name }}</option>
                    @endforeach    

                </select>
                @error('state')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @else
            <div class="col-md-4">
                <label class="form-label" for="title">{{ translate('State') }}<span
                        class="text-danger">*</span>
                </label>
                <select
                    class="single-select form-control state{{ $id }}{{$GCC['id']}} {{ $errors->has('state') ? 'is-invalid' : '' }}"
                    name="search_state[{{ $data }}][]" id="state" onchange="getStateCity('state')">
                    <option value="">{{ translate('Select State') }}</option>

                </select>
                @error('state')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif    
    
        @if($GCC['id']!='')
            <div class="col-md-4">
                <label class="form-label" for="title">{{ translate('State') }}<span
                        class="text-danger">*</span>
                </label>
                <?php 
                    $data_city = App\Models\City::where('state_id',$GCC['search_state'])->get();
                ?> 
                <select class="single-select form-control city{{ $id }}{{$GCC['id']}} {{ $errors->has('city') ? 'is-invalid' : '' }}"
                    name="search_city[{{ $data }}][]" id="city">
                    <option value="">{{ translate('Select City') }}</option>
                    @foreach ($data_city as $zone_key => $zone_value)
                    <option value="{{ $zone_value->id }}"
                        {{ getSelected($zone_value->id, $GCC['search_city'] ) }}>
                        {{ $zone_value->name }}</option>
                    @endforeach    
                </select>
                @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @else
            <div class="col-md-4">
                <label class="form-label" for="title">{{ translate('City') }}<span
                        class="text-danger">*</span>
                </label>
                <select
                    class="single-select form-control city{{ $id }}{{$GCC['id']}} {{ $errors->has('city') ? 'is-invalid' : '' }}"
                    name="search_city[{{ $data }}][]" id="city">
                    <option value="">{{ translate('Select City') }}</option>

                </select>
                @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif    


        <div class="col-md-4 content_title">
            <label class="form-label" for="duration_from">{{ translate('City Image') }} </label>
            <div class="input-group mb-3">
                <input class="form-control " type="file" name="city_image[{{ $data }}][]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_client_logo{{$id}}{{$GCC['id']}}')" id="city_image"/>

                <div class="invalid-feedback">
                </div>
            </div>
        </div>   
        <div class="col-lg-4 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GCC['image'] != '' ? asset('uploads/home_page/zone/' . $GCC['image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_client_logo{{$id}}{{$GCC['id']}}" width="50%" alt="" />
                </div>
            </div>
        </div>
        <input type="hidden" name="city_image_value[{{ $data }}][]" value="{{$GCC['image']}}">

    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".single-select").select2();                                                    
    });
</script>

 <script>
        // $(document).ready(function() {
        function getStateCity(type, selectedCat = "", count = '') {
        // alert('ddfdsf');
            
            var country = $(".country{{ $id }}{{$GCC['id']}}" + count).val();
            var state   = $(".state{{ $id }}{{$GCC['id']}}" + count).val();
            // alert(state);

            $.ajax({
                "type": "POST",
                "data": {
                    country: country,
                    state: state,
                    type: type,
                    selectedCat: selectedCat,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.get_state_city') }}",
                success: function(response) {
                    if (type == "country") {
                        $(".state{{ $id }}{{$GCC['id']}}").closest(".country_div").find('.state{{ $id }}{{$GCC['id']}}').html(response);
                    } else {
                        $(".city{{ $id }}{{$GCC['id']}}").closest(".country_div").find('.city{{ $id }}{{$GCC['id']}}').html(response);
                    }
                }
            })
        }
        // })
    </script>
