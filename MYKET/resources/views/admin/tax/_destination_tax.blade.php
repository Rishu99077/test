@php
    $count = 0;
    if (isset($params_arr)) {
        $Countries = App\Models\Countries::where(['is_delete' => null])->get();
        $States = [];
        $Cities = [];
        $count = $params_arr['data'];
        $DT = getTableColumn('tax');
        $DT['title'] = '';
    }
@endphp
<div class="row">
    <input type="hidden" name="destination_tax_id[]" value="{{ $DT['id'] }}">
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('Title') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Title') }}</label>
            <input type="text" class="destination_title form-control" name="destination_title[]"
                placeholder="Enter title" value="{{ $DT['title'] }}">

            @error('destination_title')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('country') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('Country') }}</label>
            <select id="country_{{ $count }}" name="country[]" data-count="{{ $count }}"
                onchange="getStateCity('country','multiple',this)" class="form-control select2">
                <option value="" selected>{{ translate('Select') }}</option>
                @foreach ($Countries as $C)
                    <option value="{{ $C['id'] }}" {{ getSelected($C['id'], $DT['country']) }}>
                        {{ $C['name'] }}</option>
                @endforeach

            </select>
            @error('country')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('state') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('State') }}</label>
            <select id="state_{{ $count }}" name="state[]" data-count="{{ $count }}"
                onchange="getStateCity('state','multiple',this)" class="form-control select2">
                <option value="" disabled selected>{{ translate('Select') }}</option>
                @foreach ($States as $S)
                    <option value="{{ $S['id'] }}" {{ getSelected($S['id'], $DT['state']) }}>
                        {{ $S['name'] }}</option>
                @endforeach
            </select>
            @error('state')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group mb-3 {{ $errors->has('city') ? 'has-danger' : '' }}">
            <label class="col-form-label">{{ translate('City') }}</label>
            <select id="city_{{ $count }}" name="city[]" class="form-control select2">
                <option value="" disabled selected>{{ translate('Select') }}</option>
                @foreach ($Cities as $CI)
                    <option value="{{ $CI['id'] }}" {{ getSelected($CI['id'], $DT['city']) }}>
                        {{ $CI['name'] }}</option>
                @endforeach
            </select>
            @error('city')
                <div class="col-form-alert-label">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group mb-3 {{ $errors->has('tax_type') ? 'has-danger' : '' }}">
                    <label class="col-form-label">{{ translate('Tax Type') }}</label>
                    <select name="tax_type[]" id="" class="form-control">
                        <option value="percentage" {{ getSelected('percentage', $DT['tax_type']) }}>
                            {{ translate('Percentage') }}</option>
                        <option value="fixed" {{ getSelected('fixed', $DT['tax_type']) }}>{{ translate('Fixed') }}
                        </option>
                    </select>
                    @error('tax')
                        <div class="col-form-alert-label">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3 {{ $errors->has('tax') ? 'has-danger' : '' }}">
                    <label class="col-form-label">{{ translate('Tax Value') }}</label>
                    <input type="text" class="numberonly form-control" name="tax[]" value="{{ $DT['amount'] }}">
                    @error('tax')
                        <div class="col-form-alert-label">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-danger p-2 mt-4 remove_tax"><i class="fa fa-trash"></i></button>
    </div>
</div>
