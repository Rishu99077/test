@if (isset($params_arr))
    @php
        $count = $params_arr['count'];
        $day = $params_arr['day'];
    @endphp
@endif
<li class="availability-day available-discount-date d-flex" id={{ $count }}>
    <span class="fa fa-times text-danger cursor-pointer remove_date_time mr-2"></span>
    <input class="form-control input_txt valid_to datepickr w-25" id="valid_to" name="available_date[{{ $count }}]"
        errors="" value="{{ isset($DKEY) ? $DKEY : '' }}">
    <input type="text" class="form-control w-25 ml-2 numberonly" name="discount_date[{{ $count }}]"
        placeholder="Enter Discount Percentage" value="{{ @$DJ }}">

</li>
