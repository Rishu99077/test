<?php
if (isset($append)) {
    $highlight = [];
    $highlight['id'] = '';
    $highlight['highlight_title'] = '';
    $highlight['highlight_description'] = '';
}
?>
<style>
    .additional_highlights {
        border: 1px solid #ccc;
        border-radius: 2px;
        margin-top: 30px;
        margin-bottom: 15px;
        box-shadow: 0 0 15px #00000033;
        background: #f5f5f5;
        padding: 22px 23px 27px 19px;
    }
</style>
<div class="highlight_div card-block additional_highlights">
    <input type="hidden" name="add_highlight_id[]" value="{{ $highlight['id'] }}">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <button type="button"
                class="btn btn-danger waves-effect waves-light delete_highlight">{{ translate('Remove') }}
                <i class="icofont icofont-close-circled f-16 m-l-5"></i>
            </button>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="col-form-label"> {{ translate('Title') }}</label>
                <input class="form-control" name="highlight_title[]" type="text"
                    value="{{ old('highlight_title.' . $data, $highlight['highlight_title']) }}"
                    placeholder="Enter Title">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label class="col-form-label"> {{ translate('Description') }}</label>
                <textarea class="form-control summernote" name="highlight_description[]" placeholder="Enter Description">{{ old('highlight_description.' . $data, $highlight['highlight_description']) }}</textarea>
            </div>
        </div>
    </div>
</div>
