<?php
if (isset($append)) {
    $faq = [];
    $faq['id'] = '';
    $faq['faq_title'] = '';
    $faq['faq_description'] = '';
}
?>
<style>
    .additional_faqs {
        border: 1px solid #ccc;
        border-radius: 2px;
        margin-top: 30px;
        margin-bottom: 15px;
        box-shadow: 0 0 15px #00000033;
        background: #f5f5f5;
        padding: 22px 23px 27px 19px;
    }
</style>
<div class="faqs_div card-block additional_faqs">
    <input type="hidden" name="add_faq_id[]" value="{{ $faq['id'] }}">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <button type="button" class="btn btn-danger waves-effect waves-light delete_faqs">{{ translate('Remove') }}
                <i class="icofont icofont-close-circled f-16 m-l-5"></i>
            </button>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="col-form-label"> {{ translate('Title') }}</label>
                <input class="form-control" name="faq_title[]" type="text"
                    value="{{ old('faq_title.' . $data, $faq['faq_title']) }}" placeholder="Enter Title">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label class="col-form-label"> {{ translate('Description') }}</label>
                <textarea class="form-control summernote" name="faq_description[]" placeholder="Enter Description">{{ old('faq_description.' . $data, $faq['faq_description']) }}</textarea>
            </div>
        </div>
    </div>
</div>
