@if (!$get_product->isEmpty())
    @foreach ($get_product as $key => $value)
        <div class="card mb-2">
            <div class="card-body p-0 overflow-hidden product_listing">
                <div class="row g-0 ">
                    <div class="col-12 p-card   br-5">
                        <div class="row">
                            <div class="col-sm-5 col-md-3">
                                <div class="position-relative h-sm-100">
                                    <div class="swiper-container theme-slider h-100"
                                        data-swiper='{"autoplay":true,"autoHeight":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"navigation":{"nextEl":".swiper-button-next","prevEl":".swiper-button-prev"}}'>
                                        <div class="swiper-wrapper h-100">

                                            <div class="swiper-slide h-100"><a class="d-block h-sm-100"
                                                    href="{{ route('admin.yacht.edit', encrypt($value['id'])) }}"><img
                                                        class="rounded-1 h-100 w-100 fit-cover"
                                                        src="{{ asset('uploads/product_images/' . $value['image']) }}"
                                                        alt="" /></a>
                                            </div>

                                        </div>

                                    </div>
                                    @if ($value['image_text'] != '')
                                        <div class="badge rounded-pill bg-success position-absolute top-0 end-0 me-2 mt-2 fs--2 z-index-2">
                                            {{ $value['image_text'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="mt-3 mt-sm-0">
                                            <a class="text-dark fs-0 fs-lg-1" href="{{ route('admin.yacht.edit', encrypt($value['id'])) }}">
                                                @php
                                                    $get_product_language = App\Models\ProductLanguage::where('product_id', $value['id'])->get();
                                                @endphp
                                                @if($get_product_language)
                                                    {{  getLanguageTranslate($get_product_language, $lang_id, $value['id'], 'description', 'product_id')   }}
                                                @endif
                                            </a>
                                        </h5>
                                        <p class="fs--1 mb-2 mb-md-3"><a class="text-500"
                                                href="#!">{{ $value['category_name'] }}
                                                {!! checkStatus($value['status']) !!}</a></p>
                                        <ul class="list-unstyled d-none d-lg-block mb-0">
                                            <li><span>{{ $value['availability'] }}</span>
                                            </li>
                                            <li><span>{{ $value['excursion_type'] }}</span>
                                            </li>
                                            <li><span>{{ $value['pick_option'] }}</span>
                                            </li>
                                            <li><span>{{ getAllInfo('countries', ['id' => $value['country']], 'name') . ',' . getAllInfo('states', ['id' => $value['state']], 'name') . ',' . getAllInfo('cities', ['id' => $value['city']], 'name') }}</span>
                                            </li>
                                            <li><span>{{ date('Y M,d', strtotime(getAllInfo('products', ['id' => $value['id']], 'rate_valid_until'))) }}</span>
                                            </li>
                                            <?php {
                                                $get_supplier_arr = explode(',',$value['supplier']);
                                                foreach ($get_supplier_arr as $key => $value2) {
                                                    $get_supplier = App\Models\Supplier::select('*')
                                                    ->where('id', $value2)
                                                    ->first(); ?>
                                                    @if($get_supplier)
                                                        <li><span>{{ $get_supplier['username'] }},<b>{{ $get_supplier['company_name'] }}</b></span></li>
                                                    @endif    
                                            <?php } } ?>

                                        </ul>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-between flex-column">
                                        <div>

                                            @if ($value['original_price'] == '')
                                                <h4 class="fs-1 fs-md-2 text-warning mb-0">
                                                    {{ getAmount($value['selling_price']) }}
                                                </h4>
                                            @else
                                                <h4 class="fs-1 fs-md-2 text-warning mb-0">
                                                    {{ getAmount($value['selling_price']) }}
                                                </h4>
                                                <h5 class="fs--1 text-500 mb-0 mt-1">
                                                    <del>{{ getAmount($value['original_price']) }} </del>
                                                </h5>
                                            @endif




                                            <div class="mb-2 mt-3">
                                                {{get_ratings_stars($value['id'])}}
                                                <span class="ms-1">({{ get_rating($value['id']) }})</span>
                                            </div>
                                            <p class="fs--1 fw-semi-bold">{{ translate('Total Sold') }} :
                                                {{ $value['how_many_are_sold'] }} /2
                                            </p>

                                        </div>
                                        <div class="d-flex justify-content-evenly ">
                                            <a class="btn btn-sm btn-outline-secondary border-300 d-lg-block me-2 me-lg-0"
                                                href="{{ route('admin.yacht.edit', encrypt($value['id'])) }}">
                                                <span class="far fa-edit"></span>
                                                <span class="ms-2 d-none d-md-inline-block">{{ translate('Edit') }}</span></a><a
                                                class="btn btn-sm btn-primary d-lg-block confirm-delete"
                                                data-href="{{ route('admin.yacht.delete', encrypt($value['id'])) }}"
                                                href="javascript:void(0)"><span class=" fas fa-trash-alt"> </span>
                                                <span class="ms-2 d-none d-md-inline-block">{{ translate('Delete') }}</span>
                                            </a>
                                        </div>
                                        <a class="btn btn-outline-success me-1 mb-1 btn-sm confirm-duplicate d-lg-block m-2 mt-1"
                                        data-href="{{ route('admin.yacht.duplicate', encrypt($value['id'])) }}"
                                        href="javascript:void(0)">
                                            <span class="fas fa-clone"> </span>
                                            <span class="ms-2 d-none d-md-inline-block">{{ translate('Duplicate') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card mb-2">
        <div class="card-body p-0 overflow-hidden product_listing">
            <div class="row g-0 ">
                <div class="col-12 p-card   br-5 text-center">
                    <h4>{{ translate('No Record Found!') }}</h4>
                    <img src="{{ asset('/public/assets/img/no_record.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

@endif

<div>
    {{ $get_product->appends(request()->query())->links() }}
</div>
