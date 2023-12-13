@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
$lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_product_lodge_language = [];
        $get_product_option_lodge_upgrade = [];
        $GPL = getTableColumn('product_lodge');
    }
@endphp
<div class="row lodge_div">
    <div>
        <button class="delete_lodge bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="lodge_id[{{ $data }}]" value="{{ $GPL['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Lodge Title') }}
        </label>
        <input class="form-control {{ $errors->has('lodge_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Lodge Title') }}" id="title"
            name="lodge_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_product_lodge_language, $lang_id, $GPL['id'], 'title', 'lodge_id') }}" />
        @error('lodge_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <label class="form-label" for="title">{{ translate('Lodge Description') }}
        </label>
        <textarea
            class="form-control footer_text footer_text_{{ $data }} {{ $errors->has('lodge_description.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Lodge Description') }}" id="footer_text_{{ $data }}"
            name="lodge_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_product_lodge_language, $lang_id, $GPL['id'], 'description', 'lodge_id') }}</textarea>
        @error('lodge_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-12 content_title ">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Room Details') }}
            <small>({{ translate('Enter no of person allowed in rooms') }})</small>
        </h5>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Adult') }}</th>
                    <th>{{ translate('Child') }}</th>
                    <th>{{ translate('Infant') }}</th>
                    <th>{{ translate('No Limit') }}</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('lodge_room_adult') ? 'is-invalid' : '' }}"
                            type="text" name="lodge_room_adult[{{ $data }}]"
                            placeholder="{{ translate('Enter No. Of Adult Person') }}" value="{{ $GPL['adult'] }}" />
                        @error('lodge_room_adult')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('lodge_room_child') ? 'is-invalid' : '' }}"
                            type="text" name="lodge_room_child[{{ $data }}]"
                            placeholder="{{ translate('Enter No. Of Child') }}" value="{{ $GPL['child'] }}" />
                        @error('lodge_room_child')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('lodge_room_infant') ? 'is-invalid' : '' }}"
                            type="text" name="lodge_room_infant[{{ $data }}]"
                            placeholder="{{ translate('Enter No. Infant ') }}"
                            @php if($GPL['infant_limit'] == 1)
                            {
                                echo "value=' No Limit' readonly";
                            }else{
                                echo "value=".$GPL['infant']."";
                            } @endphp>
                        @error('lodge_room_infant')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input class="form-check-input mt-2 tour_infant_limit" id="flexCheckDefault"
                            id="lodge_infant_limit" type="checkbox" name="lodge_infant_limit[{{ $data }}]"
                            value="1"
                            @php if($GPL['product_id'] != "")
                        {
                            if($GPL['infant_limit'] == 1)
                            {
                                echo " checked";
                            }
                        } @endphp />
                    </td>

                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-12 content_title ">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Lodge Price') }}
            <small>({{ translate('Enter default price') }})</small>
        </h5>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Lodger Price') }}</th>
                    {{-- <th>{{ translate('Child Allowed') }}</th>
                    <th>{{ translate('Child Price') }}</th>
                    <th>{{ translate('Infant Allowed') }}</th>
                    <th>{{ translate('Infant') }}</th> --}}
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <input
                            class="form-control numberonly {{ $errors->has('deafult_lodge_price') ? 'is-invalid' : '' }}"
                            style="width: 25%" type="text" name="deafult_lodge_price[{{ $data }}]"
                            placeholder="{{ translate('Lodge Price') }}" value="{{ $GPL['lodge_price'] }}" />
                        @error('deafult_lodge_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>

                </tr>

            </tbody>
        </table>
    </div>

    <div class="col-md-6 content_title ">
        @php
            $ProductTaxSerivce = (array) getDataFromDB('product_option_tax_service', ['product_id' => $GPL['product_id'], 'product_option_id' => $GPL['id']], 'row');
            if (!$ProductTaxSerivce) {
                $ProductTaxSerivce = getTableColumn('product_option_tax_service');
            }
        @endphp
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td> <input class="form-check-input mt-2 " id="option_tax_allowed" type="checkbox"
                            name="option_tax_allowed[{{ $data }}]" value="1"
                            @php if($GPL['product_id'] != "")
    {
        if($ProductTaxSerivce['tax_allowed'] == 1)
        {
            echo " checked";
        }
    } @endphp />
                        <label for="option_tax_allowed" class="fs-0 mt-1">{{ translate('Tax') }}</label>
                    </td>
                    <td>
                        <input type="hidden" name="tax_service_id[{{ $data }}]"
                            value="{{ $ProductTaxSerivce['id'] }}">
                        <input type="hidden" name="tax_serivce[{{ $data }}]">
                        <div class="input-group mb-3">
                            <input class="form-control numberonly" type="text"
                                placeholder="{{ translate('Enter Tax ') }}"
                                name="option_tax_paercentage[{{ $data }}]"
                                value="{{ $ProductTaxSerivce['tax_percentage'] }}" aria-label="Username"
                                aria-describedby="basic-addon1"><span class="input-group-text"
                                id="basic-addon1">%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="col-md-6 content_title">
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td> <input class="form-check-input mt-2 " id="tax_check" type="checkbox"
                            name="option_service_allowed[{{ $data }}]" value="1"
                            @php if($GPL['product_id'] != "")
                            {
                                if($ProductTaxSerivce['service_charge_allowed'] == 1)
                                {
                                    echo " checked";
                                }
                            } @endphp />
                        <label for="tax_check" class="fs-0 mt-1">{{ translate('Service Charge') }}</label>
                    </td>
                    <td>
                        <div class="input-group mb-3"><input class="form-control" type="text"
                                placeholder="{{ translate('Enter Service Charge') }}"
                                name="option_service_amount[{{ $data }}]"
                                value="{{ $ProductTaxSerivce['service_charge_amount'] }}" aria-label="Username"
                                aria-describedby="basic-addon1"><span class="input-group-text"
                                id="basic-addon1">{{ translate('Amount') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    @php
        $ProductLodgePrice = App\Models\ProductLodgePrice::where(['product_id' => $GPL['product_id'], 'product_lodge_id' => $GPL['id']])->get();
        
        if (!$ProductLodgePrice) {
            $ProductLodgePrice = getTableColumn('product_lodge_price_details');
        }
    @endphp

    <div class="col-md-12 content_title ">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Special Days Price') }}

        </h5>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Title') }}</th>
                    <th>{{ translate('From Date') }}</th>
                    <th>{{ translate('To Date') }}</th>
                    <th>{{ translate('Price') }}</th>
                    <th>{{ translate('Action') }}</th>
                </tr>
            </thead>

            <tbody id="lodge_price_tbody{{ $data }}">
                @foreach ($ProductLodgePrice as $PLP)
                    @include('admin.product.lodge._lodge_price')
                @endforeach
                @if (count($ProductLodgePrice) <= 0)
                    @php
                        $PLP = getTableColumn('product_lodge_price_details');
                    @endphp
                    @include('admin.product.lodge._lodge_price')
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <button type="button" class="btn btn-success add_lodge_price btn-sm"
                            data-dataid="{{ $data }}"> <span class="fa fa-plus">
                            </span>{{ translate('Add More') }} </button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Tour Upgrade --}}
    <div>
        <button class="btn btn-sm btn-success mb-1 ml-20 w-25 add_lodge_upgrade" type="button"
            data-val="{{ $data }}"> <span class="fa fa-plus"></span>
            {{ translate('Add Lodge Upgrade') }}
        </button>
    </div>
    <div class="show_lodge_upgrade{{ $data }}">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Title') }}</th>
                    <th>{{ translate('Adult Price') }}</th>
                    <th>{{ translate('Child Allowed') }}</th>
                    <th>{{ translate('Child Price') }}</th>
                    <th>{{ translate('Infant Allowed') }}</th>
                    <th>{{ translate('Infant') }}</th>
                    <th>{{ translate('Action') }}</th>
                </tr>
            </thead>
            <tbody class="show_lodge_upgrade_tbody{{ $data }}">
                @php
                    $id = 1;
                    
                @endphp
                @foreach ($get_product_option_lodge_upgrade as $KK => $GLOLU)
                    @if ($GPL['id'] == $GLOLU['product_option_id'])
                        @include('admin.product.lodge._lodge_upgrade')
                    @else
                        @php
                            $id = 0;
                        @endphp
                    @endif
                    @php
                        $id++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>

<script>
    CKEDITOR.replaceAll('footer_text_{{ $data }}');
</script>
