@if (isset($params_arr))
@php      
    $adventure_img_count = $params_arr['adventure_img_count'];
    $adventure_Img = array('adventure_image' => '');  
@endphp
@endif

<div class="row adventure_div adventure_slider_row">
    <div class="col-md-12 remove_div">
        @if ($adventure_img_count > 0)
            <button type="button" class="btn btn-danger btn-sm float-right delete_adv_img" id="remove_adventure_img"> <span
                    class="icofont icofont-delete-alt"></span>
            </button>
        @endif
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="form-group mb-3 ">
            <label class="col-form-label">{{ translate('Image') }}<span class="mandatory cls"
                    style="color:red;font-size:15px">*<span></label>

            <input type="hidden" name="page_content_multi[adventure_images][{{ $adventure_img_count }}][hidden_adventure_image]" value="{{ $adventure_Img['adventure_image'] != '' ? $adventure_Img['adventure_image'] : '' }}">
            <input type="file" name="page_content_multi[adventure_images][{{ $adventure_img_count }}][adventure_image]" id="adventure_image_{{ $adventure_img_count }}"
                value="" onchange="loadFile(event,'image_9_{{ $adventure_img_count }}')" class="form-control">
            <div class=" col-form-alert-label">
            </div>
        </div>
        <div class="media-left">
            <a href="#" class="profile-image">
                <img class="user-img img-circle img-css" style="height:85px;"
                    id="image_9_{{ $adventure_img_count }}"
                    src="{{ $adventure_Img['adventure_image'] != '' ? url('uploads/pages', $adventure_Img['adventure_image']) : asset('uploads/placeholder/placeholder.png') }}">
            </a>
        </div>
    </div>
</div>
