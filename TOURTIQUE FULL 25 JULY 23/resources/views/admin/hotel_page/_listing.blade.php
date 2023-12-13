@if (!$get_hotel_data->isEmpty())
    @foreach ($get_hotel_data as $key => $value)
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
                                                    href="{{ route('admin.hotel_page.edit', encrypt($value['id'])) }}"><img
                                                        class="rounded-1 h-100 w-100 fit-cover"
                                                        src="{{ asset('uploads/MediaPage/' . $value['side_image']) }}"
                                                        alt="" /></a>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="mt-3 mt-sm-0">
                                            <a class="text-dark fs-0 fs-lg-1" href="{{ route('admin.hotel_page.edit', encrypt($value['id'])) }}">
                                                @php
                                                    $get_hotel_language = App\Models\HotelPageLanguage::where('hotel_id', $value['id'])->get();
                                                @endphp
                                                @if($get_hotel_language)
                                                    {{  getLanguageTranslate($get_hotel_language, $lang_id, $value['id'], 'title', 'hotel_id')   }}
                                                @endif
                                            </a>
                                        </h5>
                                        <p class="fs--1 mb-2 mb-md-3">
                                            <a class="text-500" href="#!">
                                                @if($get_hotel_language)
                                                    {{  getLanguageTranslate($get_hotel_language, $lang_id, $value['id'], 'title', 'hotel_id')   }}
                                                @endif
                                                {!! checkStatus($value['status']) !!}
                                            </a>
                                        </p>
                                        <ul class="list-unstyled d-none d-lg-block mb-0">
                                            <li>
                                                <span>
                                                    @if($get_hotel_language)
                                                        {{  getLanguageTranslate($get_hotel_language, $lang_id, $value['id'], 'hotel_room', 'hotel_id')   }}
                                                    @endif
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    @if($get_hotel_language)
                                                        {{  getLanguageTranslate($get_hotel_language, $lang_id, $value['id'], 'hotel_view', 'hotel_id')   }}
                                                    @endif
                                                </span>
                                            </li>
                                            <li>
                                                <span>
                                                    @if($get_hotel_language)
                                                        {{  getLanguageTranslate($get_hotel_language, $lang_id, $value['id'], 'hotel_bars', 'hotel_id')   }}
                                                    @endif
                                                </span>
                                            </li>                                        
                                            <li><span>{{ $value['address'] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-between flex-column">
                                        
                                        <div class="d-flex justify-content-evenly ">
                                            <a class="btn btn-sm btn-outline-secondary border-300 d-lg-block me-2 me-lg-0"
                                                href="{{ route('admin.hotel_page.edit', encrypt($value['id'])) }}">
                                                <span class="far fa-edit"></span>
                                                <span class="ms-2 d-none d-md-inline-block">{{ translate('Edit') }}</span></a>

                                            <a class="btn btn-sm btn-primary d-lg-block confirm-delete"
                                                data-href="{{ route('admin.hotel_page.delete', encrypt($value['id'])) }}"
                                                href="javascript:void(0)"><span class=" fas fa-trash-alt"> </span>
                                                <span class="ms-2 d-none d-md-inline-block">{{ translate('Delete') }}</span>
                                            </a>

                                        </div>
                                       
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
    {{ $get_hotel_data->appends(request()->query())->links() }}
</div>
