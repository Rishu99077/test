<option value="">{{ translate('Select') }}</option>

@foreach ($data as $value)
    <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
@endforeach
