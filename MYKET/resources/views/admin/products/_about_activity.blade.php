@if (isset($params_arr))
    @php
        $about_activity_count = $params_arr['about_activity_count'];
        // $banner_data = ['banner_title' => ''];
        $ProductAboutActivityDescription = getTableColumn('product_about_activity_description');
    @endphp
@endif
<div class="row about_activity_row">
    <div class="col-md-6">
        <div class="inputfield title_filed">
            <h6 class="font-weight-bold">{{ 'Image' }}</h6>
            <input type="hidden" name="about_activity_id[]"
                value="{{ @$ProductAboutActivityDescription['about_activity_id'] }}">
            <input class="form-control input_txt about_activity_image" type="file" onkeyup="CheckedBtnAttr('about')"
                value="" id="about_activity_image_{{ $about_activity_count }}"
                onchange="loadFile(event,'cover_image_show_{{ $about_activity_count }}'  )"
                name="about_activity_image[]" errors="">
            @php
                $about_image = asset('uploads/placeholder/placeholder.png');
                if (isset($AA['image'])) {
                    if ($AA['image'] != '') {
                        $about_image = url('uploads/products', $AA['image']);
                    }
                }
            @endphp
            <div class="media-left">
                <a href="#" class="profile-image">
                    <img class="user-img img-circle img-css" style="height:85px;"
                        id="cover_image_show_{{ $about_activity_count }}" src="{{ $about_image }}">
                </a>
            </div>
            <div class=" col-form-alert-label">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="inputfield title_filed">
            <h6 class="font-weight-bold">{{ 'Title' }}</h6>
            <input class="form-control input_txt about_activity_title" onkeyup="CheckedBtnAttr('about')"
                value="{{ @$ProductAboutActivityDescription['title'] }}"
                id="about_activity_title_{{ $about_activity_count }}" name="about_activity_title[]" errors="">
            <div class=" col-form-alert-label">

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="inputfield title_filed">
            <h6 class="font-weight-bold">{{ 'Short Description' }}</h6>
            <textarea name="about_activity_decscription[]" onkeyup="CheckedBtnAttr('about')"
                class="form-control about_activity_decscription" id="about_activity_description_{{ $about_activity_count }}">{{ @$ProductAboutActivityDescription['short_description'] }}</textarea>
            <div class=" col-form-alert-label">

            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">
        @if ($about_activity_count == 0)
            <button type="button" class="btn btn-success add_about_activity mt-3 float-right">
                <span class="fa fa-plus"></span>&nbsp;{{ translate('Add About Activity') }}
            </button>
        @else
            <button type="button" class="btn btn-danger remove_about_activity mt-3 float-right"
                data-id={{ @$ProductAboutActivityDescription['about_activity_id'] }}>
                <span class="fa fa-trash"></span>&nbsp;{{ translate('Remove About Activity') }}
            </button>
        @endif

    </div>
</div>
