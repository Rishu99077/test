@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_voucher_language = [];
        $TVS = getTableColumn('products_voucher');
    }
@endphp
<div class="row voucher_div">
    <div>
        <button class="delete_voucher bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="voucher_id[]" value="{{$TVS['id']}}">
        
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('voucher_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Voucher Title') }}" id="title" name="voucher_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_transfer_voucher_language, $lang_id, $TVS['id'], 'title', 'voucher_id') }}" />
        @error('voucher_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <label class="form-label" for="description">{{ translate('Text') }}</label>
        <textarea class="form-control footer_text{{$data}}{{$TVS['id']}} {{ $errors->has('voucher_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Higlights Description') }}" id="footer_voucher_{{ $data }}" name="voucher_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_voucher_language, $lang_id, $TVS['id'], 'description', 'voucher_id') }}</textarea>
        @error('voucher_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="meeting_point">{{ translate('Meeting Point On Arrival') }}</label>
        <input class="form-control {{ $errors->has('meeting_point') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Meeting Point On Arrival') }}"  id="meeting_point"
            name="meeting_point[]" type="text" value="{{ @$TVS['meeting_point'] }}" />
        @error('meeting_point')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>    

    <div class="col-md-6 mb-3">
        <label class="form-label" for="phone_number">{{ translate('Supplier Name / Phone Number') }}</label>
        <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Supplier Name / Phone Number') }}"  id="phone_number"
            name="phone_number[]" type="text" value="{{ @$TVS['phone_number'] }}" />
        @error('phone_number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div> 

    <div class="col-md-6 mb-3">
        <label class="form-label" for="voucher_amount">{{ translate('Amount or Percentage') }}</label>
        <input class="form-control numberonly {{ $errors->has('voucher_amount') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Amount or Percentage') }}"  id="voucher_amount"
            name="voucher_amount[]" type="text" value="{{ $TVS['voucher_amount'] }}" />
        @error('voucher_amount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>    

    <div class="col-md-6 content_title ">
        <label class="form-label" for="price">{{ translate('Amount type') }}
            <span class="text-danger">*</span>
        </label>
        <select class="form-select single-select amount_type" name="amount_type[]" id="amount_type">
            <option value="">{{ translate('Select Amount type') }}</option>
           
            <option value="flat" <?php if($TVS['amount_type'] == 'flat'){ echo 'selected="selected"'; } ?>>Flat</option>
            <option value="percentage" <?php if($TVS['amount_type'] == 'percentage'){ echo 'selected="selected"'; } ?>>Percentage</option>
        </select>
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Image') }}<small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="voucher_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_voucher_logo_<?php echo $data; ?>')" id="voucher_image"/>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $TVS['voucher_image'] != '' ? asset('uploads/Transfer_images/' . $TVS['voucher_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_voucher_logo_<?php echo $data; ?>" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>  

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Client logo') }}<small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="client_logo[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_client_logo_<?php echo $data; ?>')" id="client_logo"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $TVS['client_logo'] != '' ? asset('uploads/Transfer_images/' . $TVS['client_logo']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_client_logo_<?php echo $data; ?>" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>   


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Our Logo') }}<small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="our_logo[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_our_logo_<?php echo $data; ?>')" id="our_logo"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $TVS['our_logo'] != '' ? asset('uploads/Transfer_images/' . $TVS['our_logo']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_our_logo_<?php echo $data; ?>" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>   


    <div class="col-md-6 mb-3">
        <label class="form-label" for="remark">{{ translate('Remark') }}</label>
        <textarea class="form-control" placeholder="{{ translate('Enter Remark') }}" id="footer_voucher_{{ $data }}" name="voucher_remark[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_voucher_language, $lang_id, $TVS['id'], 'voucher_remark', 'voucher_id') }}</textarea>
       
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    CKEDITOR.replaceAll('footer_text{{$data}}{{$TVS['id']}}');
</script>