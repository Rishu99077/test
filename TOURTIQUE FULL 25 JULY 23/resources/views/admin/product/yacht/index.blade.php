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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="{{ route('admin.addYacht') }}" type="button"><span
                    class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }}</a>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-lg-3">
            <div class="card mb-2">
                <div class="card-body p-0 overflow-hidden product_listing">
                    <form action="" method="POST" id="product_filter">
                        <div class="bg-500 g-0 p-2 row br-5">
                            <div class="col-12">
                                <h5 class="ms-2">{{ translate('Filter Yacht') }}</h5>
                            </div>
                        </div>
                        <div class="row g-0 p-card">

                            <div class="col-12 ">
                                <label class="form-label" for="product_name">{{ translate('Product Name') }}
                                </label>
                                <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Title') }}" id="product_name" name="product_name"
                                    type="text" value="" />
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
                                            {{ getSelected($C['id'], old('country', $get_product['country'])) }}>
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
                                    <option value="Active">{{ translate('Active') }}</option>
                                    <option value="Deactive">{{ translate('Deactive') }}</option>

                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mt-2 ">
                                <button type="button" class="btn btn-danger btn-sm float-end product_reset"><span
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
        <div class="col-lg-9 AppendData">

            @include('admin.product.yacht._listing')

        </div>
    </div>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {

                var data = $("#product_filter").serializeArray();
                data.push({
                    name: "page",
                    value: page
                });
                $.ajax({
                    url: "{{ route('admin.yachtes') }}",
                    datatype: 'JSON',
                    data: data,
                    success: function(data) {
                        $('.AppendData').html(data);
                    }
                });
            }

            $("#product_filter").submit(function(e) {
                e.preventDefault();

                fetch_data(1);
            });

            $(".product_reset").click(function() {
                $("#product_filter")[0].reset();
                $("#country").val('').trigger('change');
                $("#state").val('').trigger('change');
                $("#city").val('').trigger('change');
                $("#status").val('').trigger('change');
                
                fetch_data(1);

            });

        });
    </script>
@endsection
