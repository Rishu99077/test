@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_transfer_option_language = [];
        $GYTO = getTableColumn('product_yacht_transfer_option');
        $hotels_count = $data;

        $get_hotels = App\Models\HotelPage::select('hotel_page.*', 'hotel_page_language.title','hotel_page_language.hotel_room','hotel_page_language.hotel_view','hotel_page_language.hotel_bars')
                        ->orderBy('hotel_page.id', 'desc')
                        ->where(['hotel_page.is_delete' => 0])
                        ->join("hotel_page_language", 'hotel_page.id', '=', 'hotel_page_language.hotel_id')
                        ->groupBy('hotel_page.id')
                        ->get();
    }
@endphp
<div class="row transfer_option_div">
    <div>
        <button class="delete_transfer_option bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="hotels_id[]" value="{{ $GYTO['id'] }}">

    <div class="col-md-6 content_title ">
        <label class="form-label " for="price">{{ translate('Hotel') }}
            <span class="text-danger">*</span></label>
        <select class="form-select single-select hotel"
            data-id="{{ $data }}" name="hotel[]" id="category_{{ $data }}">
            <option value="">{{ translate('Select Hotel') }}</option>
 
                @foreach ($get_hotels as $item)
                    <option value="{{ $item['id'] }}" {{ getSelected($item['id'], $GYTO['hotel']) }}>
                        {{ $item['title'] }}</option>
                @endforeach
          
        </select>
        <div class="invalid-feedback">
        </div>
    </div>


    <div class="col-md-6">
        <label class="form-label" for="link">{{ translate('Link') }}</label>
        <input class="form-control" placeholder="{{ translate('Link') }}" id="link"
            name="link[]" type="text" value="{{ $GYTO['link'] }}" />
        <div class="invalid-feedback"></div>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="hotel_price">{{ translate('Price') }}</label>
        <input class="form-control numberonly" placeholder="{{ translate('Price') }}" id="hotel_price"
            name="hotel_price[]" type="text" value="{{ $GYTO['price'] }}" />
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-6 mt-2">
        <label class="form-label" for="location">{{ translate('Location') }}</label>
        <input class="form-control  location" placeholder="{{ translate('Location') }}" id="location_{{ $hotels_count}}"
            name="location[]" type="text" value="{{ $GYTO['location'] }}" />
            <input class="form-control"  id="location_lat_{{ $hotels_count}}"
            name="location_lat[]" type="hidden" value="{{ $GYTO['latitude'] }}" />
            <input class="form-control numberonly"  id="location_lag_{{ $hotels_count}}"
            name="location_lag[]" type="hidden" value="{{ $GYTO['langitude'] }}" />
        <div class="invalid-feedback"></div>
    </div>

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
        var input = document.getElementsByClassName('location');
        $(input).each(function(index) {
            var id = $(this).attr('id');
            var input_ = document.getElementById(id);
            var autocomplete = new google.maps.places.Autocomplete(input_);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#location_lat_{{ $hotels_count}}').val(place.geometry['location'].lat());
                $('#location_lag_{{ $hotels_count}}').val(place.geometry['location'].lng());
            });
        });

    }
</script>
<script>
    $('.hotel').select2();
    $('.single-select').select2();
</script>
