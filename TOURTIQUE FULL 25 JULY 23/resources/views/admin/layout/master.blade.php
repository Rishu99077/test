<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ===============================================-->
    <!-- Document Title-->
    <!-- ===============================================-->
    <title>{{ get_setting_data('web_title') }} | {{ $common['title'] != '' ? $common['title'] : '' }}</title>

    <!-- ===============================================-->
    <!-- Favicons-->
    <!-- ===============================================-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ get_setting_data('favicon') != '' ? url('uploads/setting', get_setting_data('favicon')) : asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ get_setting_data('favicon') != '' ? url('uploads/setting', get_setting_data('favicon')) : asset('assets/img/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
    <meta name="theme-color" content="#ffffff">

    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('vendors/plyr/plyr.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/plugins/animate.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/plugins/datatable/dataTables.min.css') }}" rel="stylesheet" id="style-default">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/duration.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <style type="text/css">
        .ml-20 {
            margin-left: 20px;
        }

        .card-body .blog-image-cls {
            width: 150px;
            height: 100px;
        }

        .blog-image-cls img {
            object-fit: contain;
        }
        .transfer_bar_img {
            position: absolute;
            right: 48px;
            top: 25px;
            width: auto;
        }

        .transfer_bar_img img {
            width: 282px;
        }

        /* .transfer_bar_img img {
                                                                                                                            width: 20%;
                                                                                                                        } */
        .transfer_header_table table {
            width: 100%;
        }

        .transfer_header_table table thead td {
            font-size: 16px;
            font-weight: normal;
            padding: 2px 0px;
        }

        .transfer_header_table td {
            color: #727272;
            font-size: 16px;
            font-weight: 500;
        }

        .transfer_header_table td:last-child {
            color: #232A35;
            font-weight: 500;
        }

        .transfer_header_table table thead td {
            font-size: 16px;
            font-weight: normal;
            padding: 2px 0px;
        }

        .transfer_header_info p {
            color: #232A35;
            margin-top: 10px;
            font-size: 20px;
        }

        .transfer_header_info p a {
            color: #3B76D6;
        }

        .transfer_inner_heading h2 {
            background: #232A35;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            font-size: 20px;
            margin: 0;
            font-weight: 400;
        }

        .transfer_inner_table.transfer_header_table {
            margin-top: 10px;
            padding: 5px 10px;
        }

        .transfer_header_table table {
            width: 100%;
        }

        .payDetail_table .black_box {
            display: flex;
            justify-content: space-between;
        }

        .voucher_black_box {
            background: #232A35;
            border-radius: 4px;
            padding: 8px 8px;
        }

        .voucher_black_box p {
            margin-bottom: 0px;
            color: #FFFFFF;
            font-size: 18px;
            font-weight: 500;
        }

        .voucher_box {
            margin-top: 10px;
            background: #F6F7F8;
            border-radius: 4px;
            padding: 15px;
            width: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            padding: 8px 12px;
            border-radius: 6px;
            height: auto;
        }

        .voucher_box .new_dis_log {
            display: flex;
            justify-content: space-between;
            margin-top: 3%;
            padding: 0px 15px;
        }

        .voucher_box .text_main {
            margin-top: 10%;
            padding: 0px 15px;
        }

        .voucher_box .text_main p {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .voucher_box .remarks {
            display: flex;
            justify-content: space-between;
            padding: 0px 15px;
            align-items: center;
        }

        .voucher_box .remarks .new_remrk {
            font-size: 16px;
            font-weight: 500;
            color: #fff;
        }

        .voucher_box .new_price {
            float: right;
            color: #FFFFFF;
            font-size: 18px;
            font-weight: 500;
        }

        .voucher_box .text_main ul li {
            color: #fff;
            font-size: 12px;
            margin-bottom: 5px;
        }



        .voucher_box span.payable_aed {
            color: #BAAD85;
            font-size: 16px;
            font-weight: 500;
        }
    </style>
    <main class="main " id="top">
        <div class="container-fluid" data-layout="container">
            {{-- Sidebar --}}
            @include('admin.layout.sidebar')
            <div class="content form">
                {{-- Header --}}
                @include('admin.layout.header')
                @yield('content')
                {{-- Footer --}}
                @include('admin.layout.footer')
            </div>

            <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog"
                aria-labelledby="authentication-modal-label" aria-hidden="true">
                <div class="modal-dialog mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                                <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>
                            </div><button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <form>
                                <div class="mb-3"><label class="form-label" for="modal-auth-name">Name</label><input
                                        class="form-control" type="text" autocomplete="on" id="modal-auth-name" />
                                </div>
                                <div class="mb-3"><label class="form-label" for="modal-auth-email">Email
                                        address</label><input class="form-control" type="email" autocomplete="on"
                                        id="modal-auth-email" /></div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6"><label class="form-label"
                                            for="modal-auth-password">Password</label><input class="form-control"
                                            type="password" autocomplete="on" id="modal-auth-password" /></div>
                                    <div class="mb-3 col-sm-6"><label class="form-label"
                                            for="modal-auth-confirm-password">Confirm Password</label><input
                                            class="form-control" type="password" autocomplete="on"
                                            id="modal-auth-confirm-password" /></div>
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        id="modal-auth-register-checkbox" /><label class="form-label"
                                        for="modal-auth-register-checkbox">I accept the <a href="#!">terms
                                        </a>and <a href="#!">privacy policy</a></label></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">Register</button></div>
                            </form>
                            <div class="position-relative mt-5">
                                <hr class="bg-300" />
                                <div class="divider-content-center">or register with</div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100"
                                        href="#"><span class="fab fa-google-plus-g me-2"
                                            data-fa-transform="grow-8"></span> google</a></div>
                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100"
                                        href="#"><span class="fab fa-facebook-square me-2"
                                            data-fa-transform="grow-8"></span> facebook</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="eventDetailsModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border"></div>
                </div>
            </div>
            <div class="modal fade" id="addEventModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content border">
                        <form id="addEventForm" autocomplete="off">
                            <div class="modal-header px-card bg-light border-bottom-0">
                                <h5 class="modal-title">Create Schedule</h5><button class="btn-close me-n1"
                                    type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-card">
                                <div class="mb-3"><label class="fs-0" for="eventTitle">Title</label><input
                                        class="form-control" id="eventTitle" type="text" name="title"
                                        required="required" /></div>
                                <div class="mb-3"><label class="fs-0" for="eventStartDate">Start
                                        Date</label><input class="form-control datetimepicker" id="eventStartDate"
                                        type="text" required="required" name="startDate"
                                        placeholder="yyyy/mm/dd hh:mm"
                                        data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' />
                                </div>
                                <div class="mb-3"><label class="fs-0" for="eventEndDate">End
                                        Date</label><input class="form-control datetimepicker" id="eventEndDate"
                                        type="text" name="endDate" placeholder="yyyy/mm/dd hh:mm"
                                        data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' />
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        id="eventAllDay" name="allDay" /><label class="form-check-label"
                                        for="eventAllDay">All Day</label></div>
                                <div class="mb-3"> <label class="fs-0">Schedule Meeting</label>
                                    <div><a class="btn badge-soft-success btn-sm" href="#!"><span
                                                class="fas fa-video me-2"></span>Add video conference link</a></div>
                                </div>
                                <div class="mb-3"><label class="fs-0" for="eventDescription">Description</label>
                                    <textarea class="form-control" rows="3" name="description" id="eventDescription"></textarea>
                                </div>
                                <div class="mb-3"><label class="fs-0" for="eventLabel">Label</label><select
                                        class="form-select" id="eventLabel" name="label">
                                        <option value="" selected="selected">None</option>
                                        <option value="primary">Business</option>
                                        <option value="danger">Important</option>
                                        <option value="success">Personal</option>
                                        <option value="warning">Must Attend</option>
                                    </select></div>
                            </div>
                            <div class="card-footer d-flex justify-content-end align-items-center bg-light"><a
                                    class="me-3 text-600" href="app/events/create-an-event.html">More
                                    options</a><button class="btn btn-primary px-4" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

    <script src="{{ asset('assets/plugins/my_custom_map.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('assets/js/duration.js') }}"></script>
    <script src="{{ asset('vendors/countup/countUp.umd.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/data/world.js') }}"></script>
    <script src="{{ asset('vendors/plyr/plyr.polyfilled.min.js') }}"></script>
    <script src="{{ asset('vendors/chart/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('vendors/leaflet.markercluster/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js') }}"></script>
    <script src="{{ asset('vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('vendors/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('assets/js/echarts-example.js') }}"></script>
    <script src="{{ asset('assets/plugins/alert.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-notify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".single-select").select2();
            $(".multi-select").select2({
                placeholder: "Select",
            });
        })
    </script>
    <script>
        $(document).on("click", ".confirm-delete", function() {
            var link = $(this).data("href");

            Swal.fire({
                title: 'Are you sure you want to Delete ?',

                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: "rgb(255 0 64)",
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = link;
                }
            })
        });

        $(document).on("click", ".confirm-duplicate", function() {
            var link = $(this).data("href");

            Swal.fire({
                title: 'Are you sure you want to Duplicate ?',

                showCancelButton: true,
                confirmButtonText: 'Yes, duplicate it!',
                confirmButtonColor: "rgb(255 0 64)",
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = link;
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable();
        });
    </script>

    <script>
        // $(document).ready(function() {
        function getStateCity(type, selectedCat = "", count = '') {

            var country = $("#country" + count).val();
            var state = $("#state" + count).val();
            $.ajax({
                "type": "POST",
                "data": {
                    country: country,
                    state: state,
                    type: type,
                    selectedCat: selectedCat,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.get_state_city') }}",
                success: function(response) {
                    if (type == "country") {
                        $("#state" + count).html(response);
                    } else {
                        $("#city" + count).html(response);
                    }
                }
            })
        }
        // })
    </script>
    <script>
        function back() {
            window.history.back()
        }
    </script>
    @if ($errors->has('success'))
        <script>
            success_msg("{{ $errors->first('success') }}")
        </script>
    @endif
    @if ($errors->has('error'))
        <script>
            danger_msg("{{ $errors->first('error') }}");
        </script>
    @endif
    <script>
        function doconfirm() {
            // deleteMsg('Do you want to Proceed !').then((result) => {
            //     if (result.isConfirmed) {
            //         return true;
            //     } else {
            //         return false
            //     }

            // });
            // return false


            status = confirm("{{ translate('Do you want to Proceed !') }}");
            if (status == "false") {
                return false;
            } else {
                return true;
            }
        }
    </script>

    <script>
        function getAppendPage(params, appendDiv) {
            $.post("{{ route('admin.get_append_view') }}", {
                params: params,
                _token: "{{ csrf_token() }}"
            }, function(data) {
                console.log(appendDiv);
                $(appendDiv).append(data);
            });
        }
    </script>

    <script type="text/javascript">
        var loadFile = function(event, id) {
            var image = document.getElementById(id);
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    <script>
        $(document).on("keypress", ".numberonly", function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        })
    </script>
    <script>
        $('#recom_tours_main_page_big_picture').click(function() {
            if ($(this).is(':checked')) {
                $('#recom_big_div').removeClass("d-none");
            } else {
                $('#recom_big_div').addClass("d-none");
            }
        });
    </script>
    @yield('script')

</body>

</html>
