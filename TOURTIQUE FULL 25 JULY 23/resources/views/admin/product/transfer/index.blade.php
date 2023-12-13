@extends('admin.layout.master')
@section('content')

    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
              <a href="#" style="width: auto;">
                  <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
              </a>
            </li>
            <li>
                <a href="#" style="width: auto;">

                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>
        <div class="col-auto ms-auto">
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="{{ route('admin.transfer.add') }}" type="button"><span
                    class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }}</a>
        </div>
    </div>

    <div class="row g-3 mb-3">

        <div class="col-lg-3">
            <div class="card mb-2">
                <div class="card-body p-0 overflow-hidden product_listing">
                    <form action="" method="POST" id="product_filter">
                        @csrf
                        <div class="bg-500 g-0 p-2 row br-5">
                            <div class="col-12">
                                <h5 class="ms-2">{{ translate('Filter Airport Transfer') }}</h5>
                            </div>
                        </div>
                        <div class="row g-0 p-card">

                            <div class="col-12 ">
                                <label class="form-label" for="product_name">{{ translate('Product Name') }}
                                </label>
                                <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Title') }}" id="product_name" name="product_name"
                                    type="text" value="{{ $common['product_name'] }}" />
                                <div class="invalid-feedback">

                                </div>
                            </div>
                            <div class="col-12 content_title ">
                                <label class="form-label" for="price">{{ translate('Country') }}

                                </label>
                                <select
                                    class="form-select single-select country  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                    name="country" id="country" onchange="getStateCity('country')">
                                    <option value="">{{ translate('Select Country') }}</option>
                                    @foreach ($country as $C)
                                        <option value="{{ $C['id'] }}"
                                            {{ getSelected($C['id'], old('country', $common['country'])) }}>
                                            {{ $C['name'] }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">

                                </div>

                            </div>
                            <div class="col-12">
                                <label class="form-label" for="title">{{ translate('State') }}
                                </label>
                                <select class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                    name="state" id="state" onchange="getStateCity('state')">
                                    <option value="">{{ translate('Select State') }}</option>

                                </select>
                                @error('state')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="title">{{ translate('City') }}
                                </label>
                                <select class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                    name="city" id="city">
                                    <option value="">{{ translate('Select City') }}</option>

                                </select>
                                @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="title">{{ translate('Status') }}
                                </label>
                                <select class="single-select form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                    name="status" id="status">
                                    <option value="">{{ translate('Select Status') }}</option>
                                    <option value="Active" <?php if ($common['status'] == 'Active') {
                                        echo 'selected=selected';
                                    } ?>>{{ translate('Active') }}</option>
                                    <option value="Deactive" <?php if ($common['status'] == 'Deactive') {
                                        echo 'selected=selected';
                                    } ?>>{{ translate('Deactive') }}</option>

                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 ">
                                <label class="form-label" for="car_models">{{ translate('From search') }}
                                </label>
                                <input class="form-control {{ $errors->has('car_models') ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('From search') }}" id="car_models" name="car_models"
                                    type="text" value="{{ $common['car_models'] }}" />
                                <div class="invalid-feedback">

                                </div>
                            </div>

                            <div class="col-12 mt-2 ">
                                <button type="submit" class="btn btn-danger btn-sm float-end product_reset"><span
                                        class="fas fa-eraser"></span>
                                    {{ translate('Reset') }}</button>
                                <button type="submit" class="btn btn-primary btn-sm float-end me-1 "><span
                                        class="fas fa-filter"></span>
                                    {{ translate('Filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-2 mt-2">
                <div class="card-body p-0 overflow-hidden product_listing">

                    <div class="bg-500 g-0 p-2 row br-5">
                        <div class="col-12">
                            <h5 class="ms-2">{{ translate('Expired Contracts') }}</h5>
                        </div>
                    </div>

                    <div class="bg-light pt-3">
                        <div class="px-3">

                            <ul class="list-unstyled management-calendar-events mt-3 scrollbar" style="height: 20rem"
                                id="management-calendar-events">
                                @if (count($expired_Product) > 0)
                                    @foreach ($expired_Product as $EXP)
                                        <li class="border-top pt-3 mb-3 pb-1 cursor-pointer" data-calendar-events="">
                                            <a href="{{ route('admin.excursion.edit', encrypt($EXP['id'])) }}">
                                                <div class="border-start border-3 border-success ps-3 mt-1">
                                                    <h6 class="mb-1 fw-semi-bold text-700">{{ $EXP['title'] }}
                                                    </h6>
                                                    <p class="fs--2 text-600 mb-0">
                                                        {{ date('Y , M d', strtotime($EXP['rate_valid_until'])) }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <h5 class="text-500 text-center">{{ translate('No Product Found') }}</h5>
                                @endif

                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-lg-9">

            @if (!$get_transfer->isEmpty())
                @foreach ($get_transfer as $key => $value)
                    @php
                        $get_session_language  = getSessionLang();
                        $lang_id = $get_session_language['id'];


                        $get_bus_transfer_language = getDataFromDB('transfer_language', ['transfer_id' => $value['id'], 'vehicle_type' => 'bus', 'language_id' => $lang_id], 'row');

                        $get_transfer_car_types = getDataFromDB('transfer_car_types', ['transfer_id' => $value['id']], 'row');
                        $get_transfer_bus_types = getDataFromDB('transfer_bus_types', ['transfer_id' => $value['id']], 'row');

                        $get_car_transfer_language = getDataFromDB('transfer_language', ['transfer_id' => $value['id'], 'vehicle_type' => 'car', 'language_id' => $lang_id], 'row');
                        
                    @endphp
                    
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
                                                        <div class="swiper-slide h-100">
                                                            <a class="d-block h-sm-100" href="{{ route('admin.transfer.edit', encrypt($value['id'])) }}">


                                                                <?php if ($value['product_type'] == 'bus') { ?>
                                                                   <img class="rounded-1 h-100 w-100 fit-cover" src="{{ $get_transfer_bus_types != '' ? asset('uploads/Transfer_images/' . $get_transfer_bus_types->car_image) : asset('uploads/placeholder/placeholder.png') }}" alt="" />     
                                                                <?php }else{ ?>
                                                                    <img class="rounded-1 h-100 w-100 fit-cover" src="{{ $get_transfer_car_types != '' ? asset('uploads/Transfer_images/' . $get_transfer_car_types->car_image) : asset('uploads/placeholder/placeholder.png') }}" alt="" />
                                                                <?php  } ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-md-9">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h5 class="mt-3 mt-sm-0">
                                                        <a class="text-dark fs-0 fs-lg-1" href="{{ route('admin.transfer.edit', encrypt($value['id'])) }}">

                                                            <?php if ($value['product_type'] == 'bus') { ?>

                                                                @php
                                                                    $get_bus_transfer_language_po = App\Models\TransferLanguage::where(['transfer_id' => $value['id'], 'vehicle_type' => 'bus' ])->get();
                                                                @endphp
                                                                @if($get_bus_transfer_language_po)
                                                                    {{  getLanguageTranslate($get_bus_transfer_language_po, $lang_id, $value['id'], 'title', 'transfer_id')   }}
                                                                @endif
                                                            <?php }else{ ?>

                                                                @php
                                                                    $get_car_transfer_language_po = App\Models\TransferLanguage::where(['transfer_id' => $value['id'], 'vehicle_type' => 'car' ])->get();
                                                                @endphp
                                                                @if($get_car_transfer_language_po)
                                                                    {{  getLanguageTranslate($get_car_transfer_language_po, $lang_id, $value['id'], 'title', 'transfer_id')   }}
                                                                @endif

                                                            <?php } ?>
                                                        </a>
                                                    </h5>
                                                    <p class="fs--1 mb-2 mb-md-3"><a class="text-500"
                                                            href="#!">{!! checkStatus($value['status']) !!}</a></p>
                                                    <ul class="list-unstyled d-none d-lg-block mb-0">
                                                        <li><span>{{ $value['car_type'] }}</span></li>
                                                        <li><span>{{ $value['product_type'] == 'bus' ? $value['bus_passenger'] : $value['passengers'] }}</span>
                                                        </li>

                                                        <?php if ($value['product_type'] == 'bus') { ?>
                                                            <li><span>{{ getAllInfo('countries', ['id' => @$get_transfer_bus_types->country], 'name') . ',' . getAllInfo('states', ['id' => @$get_transfer_bus_types->state], 'name') . ',' . getAllInfo('cities', ['id' => @$get_transfer_bus_types->city], 'name') }}</span>
                                                            </li>
                                                        <?php }else{ ?>
                                                            <li><span>{{ getAllInfo('countries', ['id' => $get_transfer_car_types->country], 'name') . ',' . getAllInfo('states', ['id' => $get_transfer_car_types->state], 'name') . ',' . getAllInfo('cities', ['id' => $get_transfer_car_types->city], 'name') }}</span>
                                                            </li>
                                                        <?php  } ?>

                                                        <li><span>{{ date('Y M,d', strtotime($value['rate_valid_until'])) }}</span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4 d-flex justify-content-between flex-column">
                                                    <div>

                                                        @if ($value['car_model'] != '' || $value['bus_model'] != '')
                                                            <h4 class="fs-1 fs-md-2 text-warning mb-0">
                                                                {{ $value['product_type'] == 'bus' ? $value['bus_model'] : $value['car_model'] }}

                                                            </h4>
                                                        @endif

                                                        <div class="mb-2 mt-1"><span
                                                                class="fa fa-star text-warning"></span><span
                                                                class="fa fa-star text-warning"></span><span
                                                                class="fa fa-star text-warning"></span><span
                                                                class="fa fa-star text-warning"></span><span
                                                                class="fa fa-star-half-alt text-warning star-icon"></span><span
                                                                class="ms-1">(5)</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-evenly ">
                                                        <a class="btn btn-sm btn-outline-secondary border-300 d-lg-block me-2 me-lg-0"
                                                            href="{{ route('admin.transfer.edit', encrypt($value['id'])) }}">
                                                            <span class="far fa-edit"></span>
                                                            <span
                                                                class="ms-2 d-none d-md-inline-block">{{ translate('Edit') }}</span></a><a
                                                            class="btn btn-sm btn-primary d-lg-block confirm-delete"
                                                            data-href="{{ route('admin.transfer.delete', encrypt($value['id'])) }}"
                                                            href="javascript:void(0)"><span class=" fas fa-trash-alt">
                                                            </span>
                                                            <span
                                                                class="ms-2 d-none d-md-inline-block">{{ translate('Delete') }}</span>
                                                        </a>
                                                    </div>
                                                    <a class="btn btn-outline-success me-1 mb-1 btn-sm confirm-duplicate d-lg-block m-2 mt-1"
                                                        data-href="{{ route('admin.transfer.duplicate', encrypt($value['id'])) }}"
                                                        href="javascript:void(0)"><span class="fas fa-clone"> </span>
                                                        <span
                                                            class="ms-2 d-none d-md-inline-block">{{ translate('Duplicate') }}</span>
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
                {{ $get_transfer->appends(request()->query())->links() }}
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".product_reset").click(function() {
                $("#product_name").val('');
                $("#country").val('');
                $("#state").val('');
                $("#city").val('');
                $("#status").val('');
                $("#car_models").val('');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var state = "{{ old('state', $common['state']) }}";
            var city = "{{ old('city', $common['city']) }}";
            if (state != "") {
                setTimeout(() => {
                    getStateCity("country", state);
                    setTimeout(() => {
                        getStateCity("state", city);
                    }, 300);
                }, 300);
            }
        });
    </script>
@endsection
