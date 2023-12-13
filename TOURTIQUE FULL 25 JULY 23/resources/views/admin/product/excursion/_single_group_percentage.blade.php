@php
    $languages = getLanguage();
    if (isset($append)) {
        $get_product_group_percentage_language = [];
        $get_product_option_week_tour = [];
        $get_product_option_tour_upgrade = [];
        $get_product_option_period_pricing = [];
        $get_product_option_group_percentage = [];
        $GPGPD = getTableColumn('product_group_percentage_details');
        $get_timings = App\Models\Timing::all();
    }
    $product_option_time = getDataFromDB('product_option_time', ['status' => 1]);
    
@endphp
{{-- <div class="row mb-2 single_group_percentage_div"> --}}
{{-- <div>
        <button class="delete_single_group_percentage bg-card btn btn-danger btn-sm float-end"
            data-rowid="{{ $data }}" type="button"><span class="fa fa-trash"></span></button>
    </div> --}}

<tr class="group_percentage_tr_{{ $data }}">
    <td>
        <input type="hidden" name="single_group_percentage_details_id[{{ $data }}]" value="{{ $GPGPD['id'] }}">
        <input type="text" class="form-control" placeholder="{{ translate('Group Price') }}"
            value="{{ $GPGPD['group_price'] }}" name="group_price[{{ $data }}]">
    </td>
    <td>
        <input class="form-control numberonly " type="text" name="number_of_pax[{{ $data }}]"
            placeholder="{{ translate('Number Of Pax') }}" value="{{ $GPGPD['number_of_pax'] }}">
    </td>
    <td>
        <button class="delete_single_group_percentage bg-card btn btn-danger btn-sm float-end"
            data-rowid="{{ $data }}" type="button"><span class="fa fa-trash"></span></button>
    </td>
</tr>

{{-- </div> --}}
