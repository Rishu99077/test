@extends('admin.layout.master')
@section('content')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <form method="POST" action="{{ route('admin.help_page.add') }}" enctype="multipart/form-data">
        @csrf
        <ul class="breadcrumb">
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

            <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Banner') }}"> <i
                    class="icon-customer"></i></label>


            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Help FAQS') }}"><i
                    class="icon-highlight"></i></label>

            <ul>

                {{-- Help Page Banners  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Help Banner') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($help_pages_slider as $HPG)
                                            @include('admin.help_page._help_banner')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($help_pages_slider))
                                            @include('admin.help_page._help_banner')
                                        @endif
                                        <div class="show_with">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_with" title='Add more'> <span class="fa fa-plus"></span>
                                                    {{ translate('Add more') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>


                {{-- Help FAQS  --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Help FAQS') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $TPH_cnt = 0;
                                        @endphp
                                        @foreach ($get_help_page_highlights as $TPH)
                                            @include('admin.help_page._highlight')
                                            @php
                                                $TPH_cnt++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_help_page_highlights))
                                            @include('admin.help_page._highlight')
                                        @endif
                                        <div class="show_high">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_help_faq" title='Add more'> <span class="fa fa-plus"></span>
                                                    {{ translate('Add more') }}</button>
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

    
    <script>
        CKEDITOR.replaceAll('footer_text');
    </script>
    <!-- WITH US page -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            //    console.log(count);
            $('#add_with').click(function(e) {


                var ParamArr = {
                    'view': 'admin.help_page._help_banner',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_with');

                e.preventDefault();
                count++;
            });

        });
    </script>

    <script type="text/javascript">
        count = 1;
        $(document).on("click", ".add_more_faqs", function(e) {
            var DataID = $(this).data('val');
            // alert(DataID);
            let data = [];
            var ParamArr = {
                'view': 'admin.help_page._help_faqs',
                'data': DataID,
                'id': count,
            }
            getAppendPage(ParamArr, '.show_faqs' + DataID);
            e.preventDefault();
            count++;
        });

        $(document).on('click', ".delete_faqs", function(e) {
            var length = $(".delete_faqs").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.show_faq_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });
    </script>


    <!-- HIGHLIGHTS page -->
    <script type="text/javascript">
        $(document).ready(function() {

            var count = '{{ $TPH_cnt }}';
            $('#add_help_faq').click(function(e) {
                var ParamArr = {
                    'view': 'admin.help_page._highlight',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_high');
                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_high", function(e) {
                var length = $(".delete_high").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.faq_div').remove();
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
            $("#tab1").addClass("addProTab");
            $("li.tab-content-first").css("display", "block")

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

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".delete_with_us", function(e) {
                var length = $(".delete_with_us").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.with_us_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>
@endsection
