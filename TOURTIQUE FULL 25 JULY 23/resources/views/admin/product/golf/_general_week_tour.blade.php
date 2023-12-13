@php
    
    if (isset($append)) {
        $GPOGWT = getTableColumn('product_option_week_tour');
    }
@endphp
<div class="row row_week_tour mb-2">
    <div class="col-md-5">
        <input type="hidden" name="general_week_tour_id[]" value="{{ $GPOGWT['id'] }}">
        <select
            class="form-select single-select general_tour_option_week_days general_tour_option_week_days_{{ $id }}"
            name="general_tour_week[]" id="general_tour_option_week_days_{{ $id }}"
            data-tour="{{ $id }}">
            @if ($GPOGWT['id'] != '')
                @foreach ($wreekArr as $WA)
                    @if (!in_array($WA, $existWeek) || $GPOGWT['week_day'] == $WA)
                        <option {{ getSelected($GPOGWT['week_day'], $WA) }}>{{ $WA }}</option>
                    @endif
                @endforeach
            @else
            @endif
        </select>

    </div>
    <div class="col-md-5">
        <input class="form-control numberonly {{ $errors->has('general_tour_price') ? 'is-invalid' : '' }}"
            type="text" name="general_tour_price[]" placeholder="{{ translate('Price') }}"
            value="{{ $GPOGWT['adult'] }}" />
        @error('tour_price_adult')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-2">
        <button class="delete_tour_row bg-card btn btn-danger btn-sm " data-id="{{ $data }}" type="button">
            <span class="fa fa-trash"></span>
        </button>
    </div>
</div>
