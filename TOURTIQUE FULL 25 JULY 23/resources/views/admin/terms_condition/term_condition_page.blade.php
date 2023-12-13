@extends('admin.layout.master')
@section('content')
    <form method="POST" action="{{ route('admin.term_condition_page.add') }}" enctype="multipart/form-data">
        @csrf
        <ul class="breadcrumb">
            <li>
                <a href="#" style="width: auto;">
                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    {{ Session::get('TopMenu') }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>

        <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
            type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
        </a>
        <button class="btn btn-success me-1 mb-1 backButton float-end" type="submit"><span class="fas fa-save"></span>
            {{ $common['button'] }}
        </button>

        <div class="add_product add_product-effect-scale add_product-theme-1">

            <input type="radio" name="add_product" checked id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Terms & Condition') }}"><i class="icon-highlight"></i></label>




            <ul>
                {{-- Advertise With us  --}}
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Terms & Conditions') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($MetaPageSetting as $MPS)
                                            @include('admin.terms_condition._term_condition')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($MetaPageSetting))
                                            @include('admin.terms_condition._term_condition')
                                        @endif
                                        <div class="show_term_condition">

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_term_condition" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/4.21.0/standard-all/ckeditor.js"></script>
   

    <!-- Advertise With Us -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_term_condition').click(function(e) {
                var ParamArr = {
                    'view': 'admin.terms_condition._term_condition',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_term_condition');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_advertise", function(e) {
                var length = $(".delete_advertise").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.advertise_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Slider Images -->
    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            var html =
                                "<div class='col-md-2'><div class='image-item upload_img_list'>" +
                                "<img src=' " +
                                e.target.result + "' alt='' width='20' title='" + file.name +
                                "'>" + "<div class='image-item__btn-wrapper'>" +
                                "<button type='button' class='btn btn-default remove btn-sm'>" +
                                "<i class='fa fa-times' aria-hidden='true'></i>" +
                                "</button>" +
                                "</div>" +
                                "</div>" +
                                "</div>";
                            // $(html).insertAfter(".appenImage");
                            $(".appenImage").append(html);
                        });
                        fileReader.readAsDataURL(f);
                    }

                });
            } else {
                alert("Your browser doesn't support to File API")
            }
            $(document).on("click", ".remove", function() {
                $(this).closest(".col-md-2").remove();
            });
        });
    </script>

    <!-- Facilities -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_works').click(function(e) {

                var ParamArr = {
                    'view': 'admin.aboutus_page._facilities',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_works');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_media", function(e) {
                var length = $(".delete_media").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.fac_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Why choose -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.advertisment_page._why_choose',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_choose');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_choose", function(e) {
                var length = $(".delete_choose").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.choose_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('input[name="add_product"]').each(function() {
                $(".typography").css("display", "none");

            })
            $("#tab2").addClass("addProTab");
            $("li.tab-content-2").css("display", "block")

            $(".addProTab").click(function() {
                var ClassName = $(this).removeClass("addProTab").attr("class");

                if ($(this).is(':checked') == true) {
                    $('input[name="add_product"]').each(function() {
                        $(".typography").css("display", "none");
                        $(this).addClass("addProTab")
                    })
                    $("li." + ClassName).css("display", "block");
                }
            })
        });
    </script>


    <!-- Banner Overview -->
    <script type="text/javascript">
        $(document).ready(function() {



            $(document).on('click', ".over_view_delete", function(e) {
                var length = $(".over_view_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.over_view_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>
@endsection
