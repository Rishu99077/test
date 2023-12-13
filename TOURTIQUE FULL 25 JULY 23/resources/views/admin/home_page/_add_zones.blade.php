@php
    $languages = getLanguage();
    if (isset($append)) {
        $GHZ = getTableColumn('home_zones');
        $GCC = getTableColumn('home_country');
    }
    $get_home_country = App\Models\HomeCountry::where(['home_zone_id' => $GHZ['id']])->get();
    
@endphp

<div class="row zones_div">
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-dark mt-3">{{ translate('Zones') }}</h4>
        </div>
        <div class="col-md-6">
            <button class="delete_zones bg-card btn btn-danger btn-sm float-end" type="button">
                <span class="fa fa-trash"></span>
            </button>
        </div>
    </div>
    <input type="hidden" name="zone_id[]" value="{{ $GHZ['id'] }}">

    <div class="row bg-light">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Sort Order') }}
            </label>
            <input class="form-control numberonly {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Number') }}" id="sort_order" name="sort_order[]" type="text"
                value="{{ $GHZ['number'] }}" />
            @error('sort_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Zone Name') }}
            </label>
            <input class="form-control  {{ $errors->has('zone_name') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Zone Name') }}" id="zone_name" name="zone_name[]" type="text"
                value="{{ $GHZ['zone_name'] }}" />
        </div>

        <h4 class="text-dark mt-3">{{ translate('Country search') }}</h4>
        <div class="colcss">
            @php
                $id = 0;
            @endphp
            @foreach ($get_home_country as $GCC)
                @include('admin.home_page._countries')
                @php
                    $id++;
                @endphp
            @endforeach
            @if (empty($get_home_country))
                @include('admin.home_page._countries')
            @endif

            <div class="show_country{{ $data }}">
            </div>
            <div class="row">
                <div class="col-md-12 add_more_button">
                    <button class="btn btn-success btn-sm float-end add_countries" type="button" title='Add more'
                        data-val="{{ $data }}">
                        <span class="fa fa-plus"></span> {{ translate('Add countries') }}</button>
                </div>
            </div>

        </div>

    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
