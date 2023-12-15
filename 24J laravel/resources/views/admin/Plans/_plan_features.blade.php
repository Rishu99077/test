@php
    if (isset($append)) {
        $PFV = getTableColumn('plan_features');
    }
@endphp
<div class="row features_div" style="display: contents!important;">
    <div>
        <button class="delete_features bg-card btn btn-danger btn-sm float-right" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="features_id[]" value="{{ $PFV['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title"> Feature Title </label>
        <input class="form-control"
            placeholder=" Enter Feature Title" id="title"
            name="feature_title[]" type="text"
            value="{{ $PFV['feature_title'] }}" />

    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
