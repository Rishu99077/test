@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $GPF                          = getTableColumn('top_destinations');
        $get_top_destination_language = [];
        $get_country                  = App\Models\Country::get();
        $top_data                     = $params_arr['top_data'];
    }else{
        $get_top_destination_language = App\Models\TopDestinationLanguage::where('top_destination_id',$GPF['id'])->get();
    }
@endphp
<div class="row top_destination_div">
    <div>
        <button class="delete_top_destination bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="top_destination_id[]" value="{{ $GPF['id'] }}">
    <div class="row">
        
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }}
            </label>
            <input class="form-control  {{ $errors->has('destination_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter  Title') }}" id="title"
                name="destination_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_top_destination_language, $lang_id, $GPF['id'],'title', 'top_destination_id') }}" />
            @error('destination_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        

        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Location') }}
            </label>
            <input class="form-control location {{ $errors->has('location') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Location') }}" id="location_{{$top_data}}" name="location[]" type="text"
                value="{{ $GPF['location'] }}" />
            @error('location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Link') }}
            </label>
            <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Link') }}" id="location" name="link[]" type="text"
                value="{{ $GPF['link'] }}" />
            @error('link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4 content_title ">
            <label class="form-label" for="price">{{ translate('Country') }}
                <span class="text-danger">*</span>
            </label>
            {{-- {{ getSelected($C['id'], old('country', $get_product['country'])) }} --}}
            <select class="form-select  country  {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country[]"
                id="country{{ $top_data }}" onchange="getStateCity('country','',{{ $top_data }})">
                <option value="">{{ translate('Select Country') }}</option>
                @foreach ($get_country as $country_key => $value)
                    <option value="{{ $value['id'] }}"
                        {{ getSelected($value['id'], old('country.' . $top_data, $GPF['country'])) }}>{{ $value['name'] }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="title">{{ translate('State') }}<span class="text-danger">*</span>
            </label>
            <select class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state[]"
                id="state{{ $top_data }}" onchange="getStateCity('state','',{{ $top_data }})">
                <option value="">{{ translate('Select State') }}</option>
                @if ($GPF['country'] != '')
                    @php
                        $get_state = App\Models\States::where('country_id', $GPF['country'])->get();
                    @endphp
                    @foreach ($get_state as $key => $state_value)
                        <option value="{{ $state_value['id'] }}"
                            {{ getSelected($state_value['id'], old('state.' . $top_data, $GPF['state'])) }}>
                            {{ $state_value['name'] }}</option>
                    @endforeach
                @endif
            </select>
            @error('state')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="title">{{ translate('City') }}<span class="text-danger">*</span>
            </label>
            <select class=" form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city[]"
                id="city{{ $top_data }}">
                <option value="">{{ translate('Select City') }}</option>
                @if ($GPF['state'] != '')
                    @php
                        $get_city = App\Models\City::where('state_id', $GPF['state'])->get();
                    @endphp
                    @foreach ($get_city as $city_key => $city_value)
                        <option value="{{ $city_value['id'] }}"
                            {{ getSelected($city_value['id'], old('city.' . $top_data, $GPF['city'])) }}>
                            {{ $city_value['name'] }}</option>
                    @endforeach
                @endif
            </select>
            @error('city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 content_title">
            <label class="form-label" for="duration_from">{{ translate('Image') }}
                <small>(792X450)</small> </label>
            <div class="input-group mb-3">
                <input class="form-control " type="file" name="top_destination_image[]"
                    aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo_<?php echo $top_data; ?>')"
                    id="top_destination_image" />
                <div class="invalid-feedback">
                </div>
            </div>
            <div class="col-lg-3 mt-2">
                <input type="hidden" name="already_work_image[]" value="{{ $GPF['image'] }}">
                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                    <div class="h-100 w-100  overflow-hidden position-relative">
                        <img src="{{ $GPF['image'] != '' ? asset('uploads/home_page/top_destinations/' . $GPF['image']) : asset('uploads/placeholder/placeholder.png') }}"
                            id="upload_work_logo_<?php echo $top_data; ?>" width="100" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
 
