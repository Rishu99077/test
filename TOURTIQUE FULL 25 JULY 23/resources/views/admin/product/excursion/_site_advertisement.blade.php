@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_site_adver_language = [];
        $GPSD = getTableColumn('product_site_advertisement');
    }
@endphp
<div class="row  adver_div">
    <div>
        <button class="delete_adver bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="adver_id[]" value="{{ $GPSD['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="adver_title">{{ translate('Advertisement Title') }}
        </label>
        <input class="form-control {{ $errors->has('adver_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Advertisement Title') }}" id="adver_title_{{ $lang_id }}_{{ $data }}"
            name="adver_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_site_adver_language, $lang_id, $GPSD['id'], 'title', 'site_advertisement_id') }}" />
        
        <div class="invalid-feedback">
            
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="adver_desc">{{ translate('Advertisement Description') }}
        </label>
        <textarea class="form-control  {{ $errors->has('adver_desc.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Advertisement Sort Description') }}" id="adver_desc_{{ $lang_id }}_{{ $data }}" rows="5"
            name="adver_desc[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_site_adver_language, $lang_id, $GPSD['id'], 'description', 'site_advertisement_id') }}</textarea>
        
        <div class="invalid-feedback">
            
        </div>
        
    </div>
    <div class="col-md-6">
        <label class="form-label" for="adver_image">{{ translate('Image') }}  </label>
        <input class="form-control adver_image_{{$data}}_{{$GPSD['id']}}" id="adver_image{{$data}}_{{$GPSD['id']}}" name="adver_image[]" type="file" onchange="loadFile(event,'upload_adv_{{$data}}_{{$GPSD['id']}}')"  />
        <input type="hidden" class="adver_image_dlt_{{$data}}_{{$GPSD['id']}}" name="adver_image_dlt[]" value="{{ $GPSD['image'] }}">
        
        
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls adv_imgs_div_{{$data}}_{{$GPSD['id']}}" style="display: none;">
                
                <div>
                    <button class="delete_adv_img bg-card btn btn-danger btn-sm float-end" type="button"><span
                            class="fa fa-trash"></span></button>
                </div>
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GPSD['image'] != '' ? asset('uploads/product/' . $GPSD['image']) : '' }}" id="upload_adv_{{$data}}_{{$GPSD['id']}}" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="link">{{ translate('Link') }}

        </label>
        <input class="form-control" id="adver_link" name="adver_link[]"
            value="{{ old('adver_link.*', $GPSD['link']) }}" type="text" value="" />

    </div>
    <div class="mb-2 mt-2">
        <hr>
    </div>
</div>

<script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_adv_img", function(e) {
                
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.adv_imgs_div_{{$data}}_{{$GPSD['id']}}').remove();
                        $('.adver_image_dlt_{{$data}}_{{$GPSD['id']}}').val('');
                        e.preventDefault();
                    }
                });
               
            });

            <?php if ($GPSD['image']) { ?>
                $('.adv_imgs_div_{{$data}}_{{$GPSD['id']}}').show();
            <?php } ?>
           
            $(document).on('change', "#adver_image{{$data}}_{{$GPSD['id']}}", function(e) {
                $('.adv_imgs_div_{{$data}}_{{$GPSD['id']}}').show();
            });

        });
    </script>
