@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>{{ $common['title'] }}</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tax.add') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            {{-- <div class="row"> --}}
            {{-- <div class="col-sm-12"> --}}
            <div class="card">
                <div class="card-header">
                    <h5>{{ $common['heading_title'] }}</h5>

                    <a href="{{ url(goPreviousUrl()) }}"
                        class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1" data-modal="modal-13">
                        <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                    </a>
                </div>
                <div class="card-block">
                    <form id="taxForm" method="post" action="{{ route('admin.tax.add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="destination">
                            <h4>{{ translate('Destination Tax') }}</h4>
                            <input type="text" class="form-control w-50" placeholder="Tax Title"
                                name="page_content[destination_tax_title]" value="{{ $title['destination_tax_title'] }}">
                            @php
                                $destination_count = 0;
                            @endphp
                            <div class="destination_div">
                                @foreach ($destination_tax as $DTKey => $DT)
                                    @php
                                        $States = App\Models\States::where('country_id', $DT['country'])->get();
                                        $Cities = App\Models\Cities::where('state_id', $DT['state'])->get();
                                        $TaxDescription = App\Models\TaxDescription::where('tax_id', $DT['id'])->first();
                                        $DT['title'] = '';
                                        if ($TaxDescription) {
                                            $DT['title'] = $TaxDescription->title;
                                        }

                                    @endphp
                                    @include('admin.tax._destination_tax')
                                    @php
                                        $destination_count++;
                                    @endphp
                                @endforeach
                            </div>
                            <div class="add_more_button my-4">
                                <button class="btn btn-success waves-effect waves-light" type="button" id="add_destination"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span>
                                    {{ translate('Add More') }}</button>
                            </div>
                        </div>
                        <div class="category">
                            <h4>{{ translate('Category Tax') }}</h4>
                            <input type="text" class="form-control w-50" placeholder="Tax Title"
                                name="page_content[category_tax_title]" value="{{ $title['category_tax_title'] }}">
                            @php
                                $category_count = 0;
                            @endphp
                            <div class="category_div">
                                @foreach ($category_tax as $CTKey => $CT)
                                    @php
                                        $TaxDescription = App\Models\TaxDescription::where('tax_id', $CT['id'])->first();
                                        $CT['title'] = '';
                                        if ($TaxDescription) {
                                            $CT['title'] = $TaxDescription->title;
                                        }
                                    @endphp
                                    @include('admin.tax._category_tax')
                                    @php
                                        $category_count++;
                                    @endphp
                                @endforeach
                            </div>
                            <div class="add_more_button my-4">
                                <button class="btn btn-success waves-effect waves-light" type="button" id="add_category"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span>
                                    {{ translate('Add More') }}</button>
                            </div>
                        </div>
                        <div class="product">
                            <h4>{{ translate('Product Tax') }}</h4>
                            <input type="text" class="form-control w-50" placeholder="Tax Title"
                                name="page_content[product_tax_title]" value="{{ $title['product_tax_title'] }}">
                            @php
                                $product_count = 0;
                            @endphp
                            <div class="product_div">
                                @foreach ($product_tax as $PTKey => $PT)
                                    @php
                                        $TaxDescription = App\Models\TaxDescription::where('tax_id', $PT['id'])->first();
                                        $PT['title'] = '';
                                        if ($TaxDescription) {
                                            $PT['title'] = $TaxDescription->title;
                                        }
                                    @endphp
                                    @include('admin.tax._product_tax')
                                    @php
                                        $product_count++;
                                    @endphp
                                @endforeach
                            </div>
                            <div class="add_more_button my-4">
                                <button class="btn btn-success waves-effect waves-light" type="button" id="add_product"
                                    title='Add more'>
                                    <span class="fa fa-plus"></span>
                                    {{ translate('Add More') }}</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                    class="btn btn-primary tax-btn  m-b-0 mr-0">{{ $common['button'] }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {
            var count = "{{ $destination_count }}";
            $('#add_destination').click(function(e) {
                var ParamArr = {
                    'view': 'admin.tax._destination_tax',
                    'data': count
                }
                getAppendPage(ParamArr, '.destination_div');
                e.preventDefault();
                count++;
            });



            // Category Append
            var count = "{{ $category_count }}";
            $('#add_category').click(function(e) {
                var ParamArr = {
                    'view': 'admin.tax._category_tax',
                    'data': count,
                }
                getAppendPage(ParamArr, '.category_div');
                e.preventDefault();
                count++;
            });


            // Product Append
            var count = "{{ $product_count }}";
            $('#add_product').click(function(e) {
                var ParamArr = {
                    'view': 'admin.tax._product_tax',
                    'data': count,
                }
                getAppendPage(ParamArr, '.product_div');
                e.preventDefault();
                count++;
            });

            // For Removing
            $(document).on('click', '.remove_tax', function() {
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().parent().remove();
                        e.preventDefault();
                    }
                });
            })

            // Submit Form
            $('#taxForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                // $(".tax-btn").attr("disabled", true);


                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.tax.add') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("response", response);
                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#taxForm").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#taxForm").find('#' + index).focus();
                                    $("#taxForm").find('#' + index).parent()
                                        .addClass(
                                            'has-danger');

                                    $("#taxForm").find('#' + index).next().next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            success_msg("Tax Update Successfully...");

                        }
                        // $(".step-seven-btn").attr("disabled", false);
                        // $(".step-seven-btn i").addClass('d-none');
                    }
                });

            });
        });
    </script>
@endsection
@endsection
