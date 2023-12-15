<?php
if (isset($append)) {
    $gallery_img = [];
    $gallery_img['id'] = '';
    $gallery_img['guide_gallery_image'] = '';
}
?>
<style>
    .additional_image {
        border: 1px solid #ccc;
        border-radius: 2px;
        margin-top: 30px;
        margin-bottom: 15px;
        box-shadow: 0 0 15px #00000033;
        background: #f5f5f5;
        padding: 22px 23px 27px 19px;
    }
</style>
<div class="images_div card-block additional_image">
    <input type="hidden" name="add_image_id[]" value="{{ $gallery_img['id'] }}">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <button type="button" class="btn btn-danger waves-effect waves-light delete_image">{{ translate('Remove') }}
                <i class="icofont icofont-close-circled f-16 m-l-5"></i>
            </button>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3 {{ $errors->has('guide_gallery_image') ? 'has-danger' : '' }}">
                <label class="col-form-label">{{ translate('Image') }} </label>
                <input type="file"
                    class="form-control {{ $errors->has('guide_gallery_image') ? 'form-control-danger' : '' }}"
                    onchange="loadFile(event,'image_2_{{ $data }}_{{ $gallery_img['id'] }}')"
                    name="guide_gallery_image[]">
                @error('guide_gallery_image')
                    <div class="col-form-alert-label">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="media-left">
                <a href="#" class="profile-image">
                    <img class="user-img img-circle img-css" style="height:85px;"
                        id="image_2_{{ $data }}_{{ $gallery_img['id'] }}"
                        src="{{ $gallery_img['guide_gallery_image'] != '' ? url('uploads/guide/gallery', $gallery_img['guide_gallery_image']) : asset('uploads/placeholder/placeholder.png') }}">
                </a>
            </div>
        </div>
    </div>
</div>
