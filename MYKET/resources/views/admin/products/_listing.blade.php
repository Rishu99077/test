@if (!$get_products->isEmpty())
    @foreach ($products as $key => $value)
        <div class="card product_listing">
            <div class="col-12 p-card  br-5">
                <div class="row">
                    <div class="col-sm-12 col-md-12">

                        @if ($value['message'] != '')
                            <div class="alert alert-default background-default incomplete_msg">
                                <button type="button" class="close mt-0" data-dismiss="alert" aria-label="Close">
                                    <i class="font-bold icofont icofont-close-line-circled text-black"></i>
                                </button>
                                <span> {{ $value['message'] }}</span>
                            </div>
                            {{-- <div class="incomplete_msg">
                                <span> {{ $value['message'] }}</span>
                            </div> --}}
                        @endif
                    </div>
                    <div class="col-sm-5 col-md-3">
                        <div class="position-relative h-sm-100">
                            <div class="swiper-container theme-slider h-100"
                                data-swiper="{&quot;autoplay&quot;:true,&quot;autoHeight&quot;:true,&quot;spaceBetween&quot;:5,&quot;loop&quot;:true,&quot;loopedSlides&quot;:5,&quot;navigation&quot;:{&quot;nextEl&quot;:&quot;.swiper-button-next&quot;,&quot;prevEl&quot;:&quot;.swiper-button-prev&quot;}}">
                                <div class="product_img_container h-100">
                                    {{-- <div class="swiper-slide h-100"><a class="d-block h-sm-100" href=""><img class="rounded-1 h-100 w-100 fit-cover" src="{{ asset('uploads/products/'.$value['image']) }}" alt=""></a>
                        </div> --}}

                                    <div class="swiper-slide h-100">
                                        <a class="d-block h-sm-100" href="">
                                            <div class="product-background-image"
                                                style="background-image: url('{{ asset('uploads/all_thumbnails/' . $value['image']) }}');">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="row">
                            <div class="col-lg-7">
                                <h5 class="mt-3 mt-sm-0">
                                    <a class="text-dark fs-0 fs-lg-1"
                                        href="{{ url('/add-product/title/') }}?tourId={{ $value['id'] }}">
                                        {{ $value['product_title'] == '' ? 'Default Title' : $value['product_title'] }}
                                    </a>
                                </h5>
                                <p class="fs--1 mb-2 mb-md-3">
                                    <span>{{ $value['category_title'] }}</span>
                                    {!! checkStatus($value['status']) !!}

                                    <span class="d-block">{{ $value['reference_code'] }}</span>
                                    <span class="d-block">{{ $value['trip_details'] }}</span>
                                    <span class="d-block">{{ $value['duration_text'] }}</span>
                                    <span class="d-block">{{ $value['location'] }}</span>
                                    @if ($value['activity_text'] != '')
                                        <span class="badge bg-danger br-5 f-14">{{ $value['activity_text'] }}</span>
                                    @endif
                                </p>

                            </div>
                            <div class="col-lg-5">

                                <span class="d-block">{{ translate('Added by') }} :
                                    <span class="font-weight-bold ">{{ Str::ucfirst($value['added_by']) }}</span>
                                    @if ($value['user_status'] == 0)
                                        <span class="badge badge-danger">{{ translate('Not approved') }}</span>
                                    @endif
                                </span>

                                <a class="btn btn-sm btn-outline-secondary border-300  mt-1 me-2 me-lg-0 bg-success text-white"
                                    href="{{ url('/add-product/title/') }}?tourId={{ $value['id'] }}">
                                    <svg class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true" focusable="false"
                                        data-prefix="far" data-icon="edit" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z">
                                        </path>
                                    </svg>
                                    <span class="ms-2 d-none d-md-inline-block ">Edit</span>
                                </a>

                                <a class="btn btn-sm btn-primary  confirm-delete mt-1" data-href=""
                                    href="{{ route('admin.product.delete', encrypt($value['id'])) }}">
                                    <svg class="svg-inline--fa fa-trash-alt fa-w-14" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="trash-alt" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z">
                                        </path>
                                    </svg>
                                    <span class="ms-2 d-none d-md-inline-block">Delete</span>
                                </a>

                                @if ($value['status'] == 'Active' && $value['is_approved'] == 'Approved')
                                    <a class="btn btn-inverse btn-sm  mt-1" target="_blank"
                                        href="{{ env('APP_URL') . 'culture-details/' . $value['slug'] }}">
                                        <span class="fa fa-eye"></span>
                                        {{ translate('View Product') }}</a>
                                @endif
                                @php
                                    $class = 'btn btn-danger';
                                    $icon = 'fa fa-times';
                                    if ($value['is_approved'] == 'Approved') {
                                        $class = 'btn btn-success';
                                        $icon = 'fa fa-check';
                                    }
                                @endphp

                                <div class="approvedDiv_{{ $value['id'] }}">
                                    <button class="{{ $class }} btn-sm  mt-1"
                                        @if (Str::ucfirst($value['added_by']) == 'Partner' && $value['is_approved'] != 'Approved') data-toggle="modal"
                                        data-target="#exampleModalCenter{{ $key }}" 
                                        @else
                                        @if ($value['is_approved'] != 'Approved')
                                        onclick="ChangeApproved({{ $value['id'] }})" @endif
                                        @endif>
                                        <span class="{{ $icon }}"></span>
                                        {{ $value['is_approved'] }}</button>
                                </div>

                                {{-- @if (Str::ucfirst($value['added_by']) == 'Partner' && $value['is_approved'] != 'Approved')
                                    <button type="button" class="btn btn-primary btn-sm  mt-1" data-toggle="modal"
                                        data-target="#exampleModalCenter{{ $key }}">Send Reason</button>
                                @endif --}}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade send_reason_moadal" id="exampleModalCenter{{ $key }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <form id="" method="post" action="" class="sendReasonForm" data-id="{{ $key }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Send Product for approval/Decline</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                        <input class="product_approval approved_checkbox_{{ $key }}" id="flexRadioDefault{{ $key }}" type="radio" name="reason" checked=""
                                        data-id="{{ $value['id'] }}"  />
                                        <label  for="flexRadioDefault{{ $key }}">Product Approval</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="decline_pro" id="flexRadioDefault2{{ $key }}" type="radio" name="reason"/>
                                        <label  for="flexRadioDefault2{{ $key }}">Decline With reason</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row product_approval_div">
                                <div class="col-md-12">
                                    <label>This <b>{{ $value['product_title'] == '' ? 'Default Title' : $value['product_title'] }}</b> is sent for approval</label>
                                </div>
                            </div>
                            <div class="row send_reason_div d-none">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Email</label>
                                        <input class="form-control" name="partner_email" type="text"
                                            placeholder="Enter Email" value="{{ $value['partner_email'] }}"
                                            required="">
                                        <input type="hidden" name="partner_id" value="{{ $value['partner_id'] }}">
                                        <span class="valid_msg"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Description</label>
                                        <textarea rows="3" class="form-control" name="description" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ translate('Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ translate('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@else
    <div class="card mb-2">
        <div class="card-body p-0 overflow-hidden product_listing">
            <div class="row g-0 ">
                <div class="col-12 p-card   br-5 text-center">
                    <h4>{{ translate('No Record Found!') }}</h4>
                    <img class="no_data" src="{{ asset('uploads/no_data.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

@endif

<div>
    {{ $get_products->appends(request()->query())->links() }}
</div>
