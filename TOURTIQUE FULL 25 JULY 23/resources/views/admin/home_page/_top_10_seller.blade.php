@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_top_ten_language=[];
        $TTS = getTableColumn('top_ten_seller');
        $get_product = App\Models\Product::select('products.*','product_language.description')
                        ->leftJoin('product_language','products.id','product_language.product_id')
                        ->where('status','Active')->orderBy('id','desc')->get();
    }
@endphp
<div class="row top_10_seller_div">
    <div>
        <button class="delete_top_10_seller bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="top_ten_id[]" value="{{ $TTS['id'] }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Title') }}
            </label>
            <input class="form-control {{ $errors->has('top_ten_title.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter  Title') }}" id="title"
                name="top_ten_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_top_ten_language, $lang_id, $TTS['id'],'title', 'top_ten_seller_id') }}" />
            @error('top_ten_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Sort Order') }}
            </label>
            <input class="form-control numberonly {{ $errors->has('top_ten_sort_order') ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Number') }}" id="top_ten_sort_order" name="top_ten_sort_order[]"
                type="text" value="{{ $TTS['sort_order'] }}" />
            @error('top_ten_sort_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 content_title">
            <label class="form-label" for="duration_from">{{ translate('Products') }}</label>
            <div class="input-group mb-3">
                <select class="form-control single_select {{ $errors->has('top_ten_products') ? 'is-invalid' : '' }}" name="top_ten_products[]"
                    id="top_ten_products{{ $data }}">
                    <option value="">{{ translate('Select Products') }}</option>
                    @foreach($get_product as $product_key => $product_value)
                        <option value="{{$product_value['id']}}" {{ $product_value['id'] == $TTS['product_id'] ? 'selected' : '' }} >{{$product_value['description']}}</option>
                    @endforeach
                </select>
                @error('top_ten_products')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="invalid-feedback">
                </div>
            </div>
        </div>

        <div class="col-md-6 content_title">
            <label class="form-label" for="duration_from">{{ translate('Image') }}
                <small>(792X450)</small> </label>
            <div class="input-group mb-3">
                <input class="form-control " type="file" name="top_ten_image[]" aria-describedby="basic-addon2"
                    onchange="loadFile(event,'top_ten_image<?php echo $data; ?>')" id="top_ten_image" />
                <div class="invalid-feedback">
                </div>
            </div>
            <div class="col-lg-3 mt-2">
                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                    <div class="h-100 w-100  overflow-hidden position-relative">
                        <img src="{{ $TTS['image'] != '' ? asset('uploads/home_page/top_ten_seller/' . $TTS['image']) : asset('uploads/placeholder/placeholder.png') }}"
                            id="top_ten_image<?php echo $data; ?>" width="100" alt="" />
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>
