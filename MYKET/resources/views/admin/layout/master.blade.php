<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ get_setting_data('web_title') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Phoenixcoded">
    <!-- Favicon icon -->

    <link rel="icon"
        href="{{ get_setting_data('favicon') != '' ? url('uploads/setting', get_setting_data('favicon')) : '' }}"
        type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/flag-icon/flag-icon.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/menu-search/css/component.css') }}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
    <!--color css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color/color-1.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/linearicons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ionicons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/component.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/flatpickr/flatpickr.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/jquery.filer/css/jquery.filer.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}">

    <link href="{{ asset('assets/summernote/summernote-bs4.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>
<style>
    .mendatry_cls {
        font-size: 15px;
        font-weight: 600;
        margin-left: 2px;
        color: red;
    }

    li.breadcrumb-item a {
        font-size: 15px;
        color: #4a6076;
        font-weight: 700;
    }
</style>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('admin.layout.header')
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('admin.layout.sidebar')
                </div>
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var SITE_URL = '<?php echo url('/'); ?>';
    </script>
    <!-- Warning Section Ends -->
    <!-- Required Jqurey -->
    <script type="text/javascript" src="{{ asset('assets/js/lightbox-plus-jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/tether/dist/js/tether.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/modernizr/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/modernizr/feature-detects/css-scrollbars.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/select2/dist/js/select2-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/horizontal-timeline/js/main.js') }}"></script>

    <!-- amchart js -->
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/amchart/js/amcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/amchart/js/serial.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/amchart/js/light.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/amchart/js/custom-amchart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/modalEffects.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/classie.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/jquery.filer/js/jquery.filer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jquery.filer/filer/custom-filer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jquery.filer/filer/jquery.fileuploads.init.js') }}"></script>

    <!-- pcmenu js -->
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/js/demo-12.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ asset('assets/customjs/notify.js') }}"></script>
    <script src="{{ asset('assets/customjs/notify.min.js') }}"></script>
    <script src="{{ asset('assets/customjs/alert.js') }}"></script>

    <!-- i18next.min.js -->
    <script type="text/javascript" src="{{ asset('assets/js/i18next/i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/i18next-xhr-backend/i18nextXHRBackend.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/js/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-i18next/jquery-i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/raphael/raphael.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/morris.js/morris.js') }}"></script>

    <script src="{{ asset('assets/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/flatpickr/flatpickr.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/bsz1tznoh1hnv3upbfi1z2pwmbstchf67ucjk4r3v3jp4nu3/tinymce/5-stable/tinymce.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            tiny();
            var date = new Date();

            var currentMonth = date.getMonth() + 1;
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            var today = currentMonth + '/' + currentDate + '/' + currentYear;
            $('.datepickr').daterangepicker({
                minDate: today,
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }

            });

            $('.daterangepickr').daterangepicker({
                minDate: today,
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });
            $('input[name="note_on_sale_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
            });


            $('.multidatePick').flatpickr({
                mode: "multiple",
                dateFormat: "Y-m-d",
            });


        })


        function tiny() {


            tinymce.init({
                selector: '.summernote',
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: "aligncenter alignjustify alignleft alignnone alignright| anchor | blockquote blocks | backcolor | bold | copy | cut | fontfamily fontsize forecolor h1 h2 h3 h4 h5 h6 hr indent | italic | language | lineheight | newdocument | outdent | paste pastetext | print | redo | remove removeformat | selectall | strikethrough | styles | subscript superscript underline | undo | visualaid | a11ycheck advtablerownumbering typopgraphy anchor restoredraft casechange charmap checklist code codesample addcomment showcomments ltr rtl editimage fliph flipv imageoptions rotateleft rotateright emoticons export footnotes footnotesupdate formatpainter fullscreen help image insertdatetime link openlink unlink bullist numlist media mergetags mergetags_list nonbreaking pagebreak pageembed permanentpen preview quickimage quicklink quicktable cancel save searchreplace spellcheckdialog spellchecker | table tablecellprops tablecopyrow tablecutrow tabledelete tabledeletecol tabledeleterow tableinsertdialog tableinsertcolafter tableinsertcolbefore tableinsertrowafter tableinsertrowbefore tablemergecells tablepasterowafter tablepasterowbefore tableprops tablerowprops tablesplitcells tableclass tablecellclass tablecellvalign tablecellborderwidth tablecellborderstyle tablecaption tablecellbackgroundcolor tablecellbordercolor tablerowheader tablecolheader | tableofcontents tableofcontentsupdate | template typography | insertfile | visualblocks visualchars | wordcount",
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        }

        // get state city 
        function getStateCity(type, dataType = "", e = "") {

            var country = $("#country").val();
            var state = $("#state").val();
            if (dataType == 'multiple') {
                var count = $(e).data("count");
                var country = $("#country_" + count).val();
                var state = $("#state_" + count).val();
            }
            console.log("count", count);
            $.ajax({
                "type": "POST",
                "data": {
                    country: country,
                    state: state,
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.get_state_city') }}",
                success: function(response) {
                    if (dataType == "multiple") {
                        if (type == "country") {
                            $("#state_" + count).html(response);
                            $("#city_" + count).html('');
                        } else {
                            $("#city_" + count).html(response);
                        }
                    } else {
                        if (type == "country") {
                            $("#state").html(response);
                            $("#city").html('');
                        } else {
                            $("#city").html(response);
                        }
                    }
                }
            })
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
        $(document).ready(function() {
            $(".single-select").select2();

        })
    </script>
    <script>
        function getAppendPage(params, appendDiv, type = "") {
            $.post("{{ route('admin.get_append_view') }}", {
                params: params,
                _token: "{{ csrf_token() }}"
            }, function(data) {
                if (type == "") {
                    $(appendDiv).append(data);
                } else {
                    if (type == "infant") {
                        $(appendDiv).first().prepend(data);
                    } else {

                        if ($(appendDiv).find('.infant_price_block_category').length > 0) {

                            $(appendDiv).find('.infant_price_block_category').after(data);
                        } else {
                            $(appendDiv).first().prepend(data);
                        }
                    }
                }
            });
        }
    </script>
    <script>
        $(document).on("click", ".confirm-delete", function() {
            var link = $(this).data("href");

            Swal.fire({
                title: 'Are you sure you want to Delete ?',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: "#fc5301",
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = link;
                }
            })
        });
    </script>
    <script>
        function GetURLParameterID(sParam) {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');

            if (sURLVariables.length == 2) {
                for (var i = 0; i < sURLVariables.length; i++) {
                    var sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] == sParam) {
                        return sParameterName[1];
                    }
                }
            } else {
                return "";
            }
        }
        // $('.summernote').summernote({
        //     tabsize: 2,
        //     height: 300
        // });

        function deleteMsg(message) {
            return Swal.fire({
                title: message,
                showCancelButton: true,
                returnInputValueOnDeny: true,
                confirmButtonText: `Delete`,
                denyButtonText: `Cancel`,
            })
        }

        function confirmMsg(title, message) {
            return Swal.fire({
                title: title,
                text: message,
                showCancelButton: true,
                confirmButtonColor: 'rgb(155 176 199)',
                cancelButtonColor: 'rgb(227 46 46)',
                confirmButtonText: 'Yes, delete it!'
            })
        }

        function warningMsg(title, message) {
            return Swal.fire({
                icon: 'error',
                title: title,
                text: message,
            })
        }
    </script>
    <script type="text/javascript">
        $(document).on("click", '.lang_chng', function() {

            var lang_id = $(this).data('id');
            console.log("lang_id", lang_id);
            $.ajax({
                url: "{{ route('admin.language_change') }}",
                type: 'post',
                data: {
                    'lang_id': lang_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        success_msg(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        danger_msg(response.message)
                    }
                }
            });
        });
    </script>
    <script>
        $(document).on("keypress", ".numberonly", function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        })
    </script>
    @yield('script')
</body>

</html>
