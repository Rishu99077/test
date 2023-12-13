@php
    $product_option_time = getDataFromDB('product_option_time', ['status' => 1]);
    if (isset($append)) {
        $tour_date_id = isset($data['tour_date_id']) ? $data['tour_date_id']  : $tour_date_id;
        $data = isset($data['data']) ? $data['data'] : $data;
        $dateKey = '';
        $DA = [];
    }
    
@endphp
<tr class="delete_tour_date_div">
    <td style="width:60%">
        <input class="form-control datetimepickerdate" id="" value="{{ $dateKey }}"
            name="tour_avaliable_date[{{ $data }}][]" type="text" placeholder="Y-m-d" value="" />
    </td>
    <td style="width:40%">
        <select class="form-select multi-date-select available_tour_date_time"
            name="available_tour_date_time[{{ $data }}][{{ $tour_date_id }}][]" data-dataid="{{ $data }}"
            id="available_tour_date_time{{ $data }}_{{ $tour_date_id }}" multiple>
            @foreach ($product_option_time as $POT)
                <option value="{{ $POT->id }}" {{ getSelectedInArray($POT->id, $DA) }}>
                    {{ $POT->title }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <button class="delete_tour_date btn btn-danger btn-sm" type="button" data-id="{{ $tour_date_id }}"> <span
                class="fa fa-trash"></span>
        </button>
    </td>
</tr>

<script>
    $("#available_tour_date_time{{ $data }}_{{ $tour_date_id }}").select2();
    $(".available_tour_date_time").each(function(key, val) {
        var id     = $(this).attr("id");
        var dataid = $(val).data("dataid");
        $("#" + id).select2();
    })
    $(".datetimepickerdate").flatpickr({
        minDate: "today",
        enableTime: false,
        dateFormat: "Y-m-d",
    });
</script>
