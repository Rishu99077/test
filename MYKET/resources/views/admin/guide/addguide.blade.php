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
                    <li class="breadcrumb-item"><a href="{{ route('admin.guide') }}">{{ $common['title'] }}</a>
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
                    <form id="main" method="post" action="{{ route('admin.guide.add') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $get_guide['id'] }}">
                            <div class="col-md-6">
                                <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('Title') }}</label>
                                    <input class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                        name="title" type="text"
                                        value="{{ old('title', $get_guide_language['title']) }}" placeholder="Enter Title"
                                        required="">
                                    @error('title')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3 {{ $errors->has('image') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('Image') }}</label>
                                    <input type="file"
                                        class="form-control {{ $errors->has('image') ? 'form-control-danger' : '' }}"
                                        onchange="loadFile(event,'image')" name="image">
                                    @error('image')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="media-left">
                                    <a href="#" class="profile-image">
                                        <img class="user-img img-circle img-css" id="image"
                                            src="{{ $get_guide['image'] != '' ? url('uploads/guide', $get_guide['image']) : asset('uploads/placeholder/placeholder.png') }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3 {{ $errors->has('country') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('Country') }}</label>
                                    <select id="country" name="country" onchange="getStateCity('country')"
                                        class="form-control select2">
                                        <option value="" disabled selected>{{ translate('Select') }}</option>
                                        @foreach ($Countries as $C)
                                            <option value="{{ $C['id'] }}"
                                                {{ getSelected($C['id'], $get_guide['country']) }}>
                                                {{ $C['name'] }}</option>
                                        @endforeach

                                    </select>
                                    @error('country')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3 {{ $errors->has('state') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('State') }}</label>
                                    <select id="state" name="state" onchange="getStateCity('state')"
                                        class="form-control select2">
                                        <option value="" disabled selected>{{ translate('Select') }}</option>
                                        @foreach ($States as $S)
                                            <option value="{{ $S['id'] }}"
                                                {{ getSelected($S['id'], $get_guide['state']) }}>
                                                {{ $S['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3 {{ $errors->has('city') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('City') }}</label>
                                    <select id="city" name="city" class="form-control select2">
                                        <option value="" disabled selected>{{ translate('Select') }}</option>
                                        @foreach ($Cities as $CI)
                                            <option value="{{ $CI['id'] }}"
                                                {{ getSelected($CI['id'], $get_guide['city']) }}>
                                                {{ $CI['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3 {{ $errors->has('description') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('Description') }}<span class="mandatory cls"
                                            style="color:red; font-size:15px">*</span></label>
                                    <textarea class="form-control summernote {{ $errors->has('description') ? 'form-control-danger' : '' }}"
                                        name="description" type="message" placeholder="Enter Description">{{ old('description', $get_guide_language['description']) }}</textarea>
                                    @error('description')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                                    <label class="col-form-label">{{ translate('Status') }}</label>
                                    <select id="status" name="status" class="form-control stock">
                                        <option value="Active">{{ translate('Active') }}</option>
                                        <option value="Deactive" {{ getSelected($get_guide['status'], 'Deactive') }}>
                                            {{ translate('Deactive') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row wizard p-4 ">
                                    <div class="col-md-12 show_highlights">
                                        <h6>{{ translate('Highlights') }}</h6>
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($highlights as $highlight)
                                            @include('admin.guide._additional_highlights')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        {{-- @if ($highlights == 0)
                                 @include('admin.guide._additional_highlights')
                              @endif --}}
                                    </div>
                                    <div class="col-md-12 add_more_button my-4">
                                        <button class="btn btn-success waves-effect waves-light" type="button"
                                            id="add_highlights" title='Add more'>
                                            <span class="fa fa-plus"></span>
                                            {{ translate('Add More Highlights') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row wizard p-4 ">
                                    <div class="col-md-12 show_faqs">
                                        <h6>{{ translate('FAQ') }}</h6>
                                        @php
                                            $data_1 = 0;
                                        @endphp
                                        @foreach ($faqs as $faq)
                                            @include('admin.guide._additional_faqs')
                                            @php
                                                $data_1++;
                                            @endphp
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 add_more_button my-4">
                                        <button class="btn btn-success waves-effect waves-light" type="button"
                                            id="add_faqs" title='Add more'>
                                            <span class="fa fa-plus"></span>
                                            {{ translate('Add More Faqs') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row wizard p-4 ">
                                    <div class="col-md-12 show_images">
                                        <h6>{{ translate('Image Gallery') }}</h6>
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($images as $gallery_img)
                                            @include('admin.guide._additional_image')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 add_more_button my-4">
                                        <button class="btn btn-success waves-effect waves-light" type="button"
                                            id="add_images" title='Add more'>
                                            <span class="fa fa-plus"></span>
                                            {{ translate('Add More Images') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                    class="btn btn-primary  m-b-0 mr-0">{{ $common['button'] }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $data }}";
            $('#add_highlights').click(function(e) {
                var ParamArr = {
                    'view': 'admin.guide._additional_highlights',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_highlights');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_highlight", function(e) {
                var length = $(".additional_highlights").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.highlight_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $data_1 }}";
            $('#add_faqs').click(function(e) {
                var ParamArr = {
                    'view': 'admin.guide._additional_faqs',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_faqs');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_faqs", function(e) {
                var length = $(".additional_faqs").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.faqs_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $data }}";
            $('#add_images').click(function(e) {
                var ParamArr = {
                    'view': 'admin.guide._additional_image',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_images');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_image", function(e) {
                var length = $(".additional_image").length;
                deleteMsg('Are you sure you want to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.images_div').remove();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
