@if (isset($params_arr))
    @php
        $information_count = $params_arr['information_count'];
        // $banner_data = ['banner_title' => ''];
        $ProductInformationDescription = getTableColumn('product_important_information_description');
    @endphp
@endif
<div class="row information_row">
    <div class="col-md-12">
        <div class="inputfield title_filed">
            <h6 class="font-weight-bold">{{ 'Title' }}</h6>
            <input type="hidden" name="information_id[]" value="{{ @$ProductInformationDescription['information_id'] }}">
            <input class="form-control input_txt information_title" onkeyup="CheckedBtnAttr('nine')"
                value="{{ @$ProductInformationDescription['title'] }}" id="information_title_{{ $information_count }}"
                name="information_title[]" errors="">
            <div class=" col-form-alert-label">

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="inputfield title_filed">
            <h6 class="font-weight-bold">{{ 'Description' }}</h6>
            <textarea name="information_decscription[]" onkeyup="CheckedBtnAttr('nine')"
                class="form-control information_decscription summernote" id="information_description_{{ $information_count }}">{{ @$ProductInformationDescription['description'] }}</textarea>
            <div class=" col-form-alert-label">

            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">
        @if ($information_count == 0)
            <button type="button" class="btn btn-success add_information mt-3 float-right">
                <span class="fa fa-plus"></span>&nbsp;{{ translate('Add information') }}
            </button>
        @else
            <button type="button" class="btn btn-danger remove_information mt-3 float-right"
                data-id={{ @$ProductInformationDescription['information_id'] }}>
                <span class="fa fa-trash"></span>&nbsp;{{ translate('Remove information') }}
            </button>
        @endif

    </div>
</div>
