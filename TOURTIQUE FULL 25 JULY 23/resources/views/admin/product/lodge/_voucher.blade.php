@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_voucher_language = [];
        $GPV = getTableColumn('products_voucher');
    }
@endphp
<div class="row voucher_div">
    <div>
        <button class="delete_voucher bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="voucher_id[]" value="{{$GPV['id']}}">
 
    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Title') }}</label>
        <input class="form-control {{ $errors->has('voucher_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Voucher Title') }}" id="voucher_title_{{ $lang_id }}_{{ $data }}" name="voucher_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_product_voucher_language, $lang_id, $GPV['id'], 'title', 'voucher_id') }}" />
        <div class="invalid-feedback">
            
        </div>
    </div>
    <div class="col-md-6">    
        <label class="form-label" for="description">{{ translate('Text') }}</label>
        <textarea class="form-control footer_text footer_text_{{$GPV['id']}}_{{$data}} {{ $errors->has('voucher_description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Higlights Description') }}" id="voucher_description_{{ $lang_id }}_{{ $data }}" name="voucher_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_voucher_language, $lang_id, $GPV['id'], 'description', 'voucher_id') }}</textarea>
        
        <div class="invalid-feedback">
           
        </div>
    </div>

     <div class="col-md-6 mb-3">
        <label class="form-label" for="meeting_point">{{ translate('Meeting Point On Arrival') }}</label>
        <input class="form-control {{ $errors->has('meeting_point') ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Meeting Point On Arrival') }}"  id="meeting_point"
            name="meeting_point[]" type="text" value="{{ $GPV['meeting_point'] }}" />
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
            name="phone_number[]" type="text" value="{{ $GPV['phone_number'] }}" />
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
            name="voucher_amount[]" type="text" value="{{ $GPV['voucher_amount'] }}" />
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
           
            <option value="flat" <?php if($GPV['amount_type'] == 'flat'){ echo 'selected="selected"'; } ?>>Flat</option>
            <option value="percentage" <?php if($GPV['amount_type'] == 'percentage'){ echo 'selected="selected"'; } ?>>Percentage</option>
        </select>
    </div>

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Image') }}<small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="voucher_image[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_voucher_logo{{$data}}{{$GPV['id']}}')" id="voucher_image"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GPV['voucher_image'] != '' ? asset('uploads/product_images/' . $GPV['voucher_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_voucher_logo{{$data}}{{$GPV['id']}}" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>  

    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Client logo') }}<small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="client_logo[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_client_logo_{{$data}}{{$GPV['id']}}')" id="client_logo"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GPV['client_logo'] != '' ? asset('uploads/product_images/' . $GPV['client_logo']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_client_logo_{{$data}}{{$GPV['id']}}" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>   


    <div class="col-md-6 content_title">
        <label class="form-label" for="duration_from">{{ translate('Our Logo') }}<small>(792X450)</small> </label>
        <div class="input-group mb-3">
            <input class="form-control " type="file" name="our_logo[]" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_our_logo{{$data}}{{$GPV['id']}}')" id="our_logo"/>

            <div class="invalid-feedback">
            </div>
        </div>
        <div class="col-lg-3 mt-2">
            <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                <div class="h-100 w-50  overflow-hidden position-relative">
                    <img src="{{ $GPV['our_logo'] != '' ? asset('uploads/product_images/' . $GPV['our_logo']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_our_logo{{$data}}{{$GPV['id']}}" width="50%" alt="" />
                </div>
            </div>
        </div>
    </div>   

    <div class="col-md-6 mb-3">
        <label class="form-label" for="remark">{{ translate('Remark') }}</label>
        <textarea class="form-control" placeholder="{{ translate('Enter Remark') }}" id="footer_voucher_{{ $data }}" name="voucher_remark[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_voucher_language, $lang_id, $GPV['id'], 'voucher_remark', 'voucher_id') }}</textarea>
       
    </div>   
    
    <div class="mt-3">
        <hr>
    </div>
</div>



<script>
    CKEDITOR.replaceAll('footer_text_{{$GPV["id"]}}_{{$data}}');
</script>
