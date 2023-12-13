@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_HotelFaqHeading = [];
        $FAQ_data = getTableColumn('hotel_faq');
    }else{
        $data = $FAQ;
    }

@endphp
<div class="row faq_div">

    <input type="hidden" value="{{$FAQ_data['id']}}" name="faq_id[{{ $data }}]">
    <div>
        <button class="delete_high bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <div class="row">
        
        <div class="col-md-2 content_title">
            <label class="form-label" for="duration_from">{{ translate('Faq Icon') }}
                <small>(792X450)</small> </label>
            <div class="input-group mb-3">
                <input class="form-control " type="file" name="faq_icon[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo_<?php echo $data; ?>')" id="faq_icon"/>
                <input class="form-control " type="hidden" name="faq_icon_value[]" aria-describedby="basic-addon2" id="faq_icon_value" value="{{$FAQ_data['faq_icon']}}" />

                <div class="invalid-feedback">
                </div>
            </div>
            <div class="col-lg-3 mt-2">
                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-icon">
                    <div class="h-100 w-100  overflow-hidden position-relative">
                        <img src="{{ $FAQ_data['faq_icon'] != '' ? asset('uploads/MediaPage/' . $FAQ_data['faq_icon']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo_<?php echo $data; ?>" width="100" alt="" />
                    </div>
                </div>
            </div>
        </div>   
        
        
        <div class="col-md-5 mb-3">
            <label class="form-label" for="title">{{ translate('Heading') }}</label>
            <input class="form-control {{ $errors->has('heading.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Heading ') }}" id="title" name="heading[{{$data}}][{{ $lang_id }}]"  type="text"
             value="{{ getLanguageTranslate($get_HotelFaqHeading, $lang_id, $FAQ_data['id'], 'title', 'faq_id') }}" />
        </div>
        
    </div>

    <div class="colcss">
        <div class="more_faq_{{ $data }}">

    <?php

        $getHotelFAQS = App\Models\HotelFAQS::where(['faq_id'=>$FAQ_data['id'],'hotel_id'=>$FAQ_data['hotel_id']])->get();
        

        ?>

        @foreach($getHotelFAQS as $key=> $FAQS)
      
          @include('admin.hotel_page._add_more_faq')

        @endforeach



        </div>
        <div class="row">
            <div class="col-md-12 add_more_button">
                 <button class="btn btn-success btn-sm float-end add_more_faqs" type="button" title='Add more' data-val="{{ $data }}"><span class="fa fa-plus"></span> {{ translate('Add More Highlights') }}</button> 
            </div>
        </div>
    </div>
    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
      if($(".footer_text_{{ $data }}").length > 0){
             CKEDITOR.replaceAll('footer_text_{{ $data }}');
      }
</script>
