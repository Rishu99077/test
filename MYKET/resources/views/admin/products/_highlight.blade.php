@if (isset($params_arr))
    @php
        $highlight_count = $params_arr['highlight_count'];
        // $banner_data = ['banner_title' => ''];
        $ProductHighlightDescription = getTableColumn('product_highlight_description');
    @endphp
@endif
<div class="row highlight_row">
    <div class="col-md-11 col-lg-11">
        <input type="hidden" name="highlight_id[]" value="{{ @$ProductHighlightDescription['highlight_id'] }}">
        <textarea class="textArea highlight" onkeyup="CheckedBtnAttr('seven')" autocomplete="off" name="highlight[]"
            id="highlight_{{ $highlight_count }}" minlength="1" rows="1">{{ @$ProductHighlightDescription['title'] }}</textarea>
        <p id="counterShow" class="counter">80 Character Left</p>
        <div class=" col-form-alert-label"></div>
    </div>
    <div class="col-md-1 col-lg-1">
        @if ($highlight_count == 0)
            <button type="button" class="btn btn-success add_highlight mt-3">
                <span class="fa fa-plus-square"></span>
            </button>
        @else
            <button type="button" class="btn btn-danger remove_highlight mt-3" data-id={{ @$AH['id'] }}>
                <span class="icofont icofont-delete-alt"></span>
            </button>
        @endif

    </div>
</div>
