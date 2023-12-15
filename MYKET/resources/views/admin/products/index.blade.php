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
                    <li class="breadcrumb-item"><a href="{{ route('admin.add_product') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row product_listings_page">
                <div class="col-sm-3 col-md-3 mt-52">
                    <div class="card">
                        <form action="" method="post" id="product_filter">
                            @csrf
                            <div class="card-header">
                                <div class="card-header-left">
                                    <h5>{{ translate('Filter') }}</h5>
                                </div>

                            </div>
                            <div class="card-block">
                                <div class="form-group mb-0">
                                    <label class=" col-form-label">{{ translate('Product Name') }}</label>
                                    <div>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Product Name') }}" name="product_name">
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class=" col-form-label">{{ translate('Category') }}</label>
                                    <div>
                                        <select name="categories" id="categories"
                                            class="form-control select2 single-select">
                                            <option value="" selected disabled>{{ translate('Select') }}</option>
                                            @foreach ($categories as $C)
                                                <option value="{{ $C['id'] }}">{{ $C['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class=" col-form-label">{{ translate('Approved') }}</label>
                                    <div>
                                        <select name="approved" id="approved" class="form-control select2 single-select">
                                            <option value="" selected disabled>{{ translate('Select') }}</option>

                                            <option value="Approved">{{ translate('Approved') }}</option>
                                            <option value="Not approved">{{ translate('Not approved') }}</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class=" col-form-label">{{ translate('Status') }}</label>
                                    <div>
                                        <select name="status" id="status" class="form-control select2 single-select">
                                            <option value="" selected disabled>{{ translate('Select') }}</option>

                                            <option value="Draft">{{ translate('Draft') }}</option>
                                            <option value="Active">{{ translate('Active') }}</option>
                                            <option value="Deactive">{{ translate('Deactive') }}</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class=" col-form-label">{{ translate('Partners') }}</label>
                                    <div>
                                        <select name="partner" id="partner" class="form-control select2 single-select">
                                            <option value="" selected disabled>{{ translate('Select') }}</option>
                                            @foreach ($get_partner as $GP)
                                                <option value="{{ $GP['id'] }}">
                                                    {{ $GP['first_name'] . ' ' . $GP['last_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-inverse p-2 " type="submit">
                                    <span class="fa fa-filter"></span>{{ translate('Filter') }}
                                </button>
                                <a href="{{ route('admin.get_products') }}">
                                    <button class="btn btn-danger p-2 " type="button">
                                        <span class="fa fa-refresh"></span>{{ translate('Reset') }}
                                    </button>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-sm-9 col-md-9">
                    <div class="add_product_btn_div">

                        <a href="{{ route('admin.add_product') }}"
                            class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                            data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i>
                            {{ translate('Add Product') }}
                        </a>
                        <a href="{{ url(goPreviousUrl()) }}"
                            class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                            data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                        </a>
                    </div>

                    <div class="AppendData">
                        @include('admin.products._listing')
                    </div>

                </div>
            </div>
        </div>
    </div>

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".confirm-delete", function(e) {
                e.preventDefault();
                const url = $(this).attr("href");
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });


            $(document).on('click', '.pagination a.page-link', function(event) {
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
                    url: "{{ route('admin.get_products') }}",
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
                // $("#country").val('').trigger('change');
                // $("#state").val('').trigger('change');
                // $("#city").val('').trigger('change');
                // $("#status").val('').trigger('change');
                fetch_data(1);
            });



        });

        function ChangeApproved(id) {
            $.ajax({
                "type": "POST",
                "data": {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.change_product_approved') }}",
                success: function(response) {
                    if (response == 0) {
                        danger_msg("Product option or pricing incomplete...")
                    } else if (response == 1) {
                        danger_msg("Partner not approved")
                    } else if (response) {
                        success_msg("Product update successfully...");
                        $('.approvedDiv_' + id).html(response);
                    } else {
                        window.location.reload();
                    }

                }
            })
        }


        $(document).on("click", ".product_approval", function() {
            $(".send_reason_div").addClass('d-none');
            $(".product_approval_div").removeClass('d-none');
        });

        $(document).on("click", ".decline_pro", function() {
            $(".product_approval_div").addClass('d-none');
            $(".send_reason_div").removeClass('d-none');
        });

        $(document).on('submit', ".sendReasonForm", function(e) {
            e.preventDefault();
            var key = $(this).data('id');
            var isChecked = $('.approved_checkbox_' + key).is(":checked");
            var id = $('.approved_checkbox_' + key).data("id");

            if (isChecked == true) {
                ChangeApproved(id);
                $(".send_reason_moadal .close").click()
            } else {
                $.ajax({
                    "type": "POST",
                    "data": $(this).serialize(),
                    url: " {{ route('admin.send_reason') }}",
                    success: function(response) {
                        location.reload();
                    }
                })
            }
            $(this)[0].reset();
            // console.log(isCheck  ed, id);
        })
    </script>
@endsection
@endsection
