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
                    {{-- <span class="fas fa-list-alt"></span> --}}
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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button"><span
                    class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>
    <form class="row g-3 " method="POST" action="{{ route('admin.yacht_page.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Side Banner') }}
                                <small>(350 × 780)</small> </label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="file" name="side_banner"
                                    aria-describedby="basic-addon2" onchange="loadFile(event,'yacht_side_banner')"
                                    id="side_banner" />
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ isset($MetaGlobalSideBanner['image']) && $MetaGlobalSideBanner['image'] != '' ? asset('uploads/side_banner/' . $MetaGlobalSideBanner['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="yacht_side_banner" width="100" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="colcss">
                            <h3 class="text-dark">Yatch Banners</h3>
                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_slider_images as $LSI)
                                @include('admin.yacht_page._slider_images')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (count($get_slider_images) == 0)
                                @include('admin.yacht_page._slider_images')
                            @endif
                            <div class="show_overview">
                            </div>
                            <div class="row">
                                <div class="col-md-12 add_more_button">
                                    <button class="btn btn-success btn-sm float-end" type="button" id="add_slider"
                                        title='Add more'>
                                        <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- Banner Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".over_view_row").length;

                var ParamArr = {
                    'view': 'admin.yacht_page._slider_images',
                    'data': count,
                }
                getAppendPage(ParamArr, '.show_overview');
                e.preventDefault();
                count++;

            });


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
