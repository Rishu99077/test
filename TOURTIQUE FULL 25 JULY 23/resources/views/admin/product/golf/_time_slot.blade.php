@php
    if (isset($append)) {
        $GTS = getTableColumn('golf_time_slots');
        $adver_count = $data;
    }
    $get_timings = App\Models\Timing::where('is_close', 0)->get();
@endphp
<div class="row time_slot_div">
    <div>
        <button class="delete_time_slot bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="time_slot_id[]" value="{{ $GTS['id'] }}">
    
    <div class="col-md-4 mb-3">
        <label class="form-label" for="adver_title">{{ translate('Day') }} </label>

        <select class="form-select form-control single-select slot_day" name="slot_day[]" id="slot_day">
            <option value="">{{ translate('Select Day') }}</option>
            @foreach ($get_timings as $C)
                <option value="{{ $C['id'] }}"
                    {{ getSelected($C['id'], old('slot_day', $GTS['slot_day'])) }}>
                    {{ $C['day'] }}</option>
            @endforeach
        </select>
       
    </div>

    <div class="col-md-4">
        <label class="form-label" for="timepicker1">{{ translate('From Time') }}</label>
        <input class="form-control datetimepicker slot_from_time" id="timepicker1"
           name="slot_from_time[]" type="text" placeholder="H:i"
           data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
           value="{{ $GTS['slot_from_time'] }}" />

     </div>

     <div class="col-md-4">
        <label class="form-label" for="timepicker1">{{ translate('To Time') }}</label>
        <input class="form-control datetimepicker slot_to_time" id="timepicker1"
           name="slot_to_time[]" type="text" placeholder="H:i"
           data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
           value="{{ $GTS['slot_to_time'] }}" />

     </div>
    
    <div class="mb-2 mt-2">
        <hr>
    </div>
</div>
<script>
    CKEDITOR.replaceAll('adver_desc_{{ $adver_count }}');
</script>
<script type="text/javascript">
    $(".datetimepicker").flatpickr({
        enableTime:true,
        noCalendar:true,
        dateFormat:'H:i',
        disableMobile:true,
    }); 
</script>
