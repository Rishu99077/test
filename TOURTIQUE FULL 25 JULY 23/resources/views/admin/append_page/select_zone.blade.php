<option value="">Select</option>

@foreach ($data as $value)
    @if (isset($array))
        <option value="{{ $value['id'] }}" {{ getSelectedInArray($value['id'], $selectedCat) }}>
            {{ $value['zone_title'] }}
        </option>
    @else
        <option value="{{ $value['id'] }}" {{ getSelected($value['id'], $selectedCat) }}>{{ $value['zone_title'] }}</option>
    @endif
@endforeach
