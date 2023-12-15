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
                    <li class="breadcrumb-item"><a href="{{ route('admin.blogs') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $common['heading_title'] }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                        </div>
                        <div class="card-block">
                            <form id="main" method="post" action="{{ route('admin.blogs.add') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $get_blogs['id'] }}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Title') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <input
                                                class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                                name="title" type="text"
                                                value="{{ old('title', $get_blog_language['title']) }}"
                                                placeholder="Enter Title">
                                            @error('title')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('blogcategory_id') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ 'Blog Category' }}<span class="mandatory cls"
                                                    style="color:red; font-size:15px">*</span></label>
                                            <select
                                                class = "form-select form-control single-select js-example-placeholder-multiple {{ $errors->has('blogcategory_id') ? 'form-control-danger' : '' }}"
                                                name="blogcategory_id[]" id="blogcategory_id" multiple="multiple">
                                                <option value="">{{ translate('Select Blog Category') }}</option>
                                                @foreach ($get_category as $key => $value)
                                                    <option value="{{ $value['id'] }}"
                                                        {{ in_array($value['id'], $Blog_to_categories) ? 'selected' : '' }}>
                                                        {{ $value['title'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('blogcategory_id')
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
                                                    src="{{ $get_blogs['image'] != '' ? url('uploads/blogs', $get_blogs['image']) : asset('uploads/placeholder/placeholder.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3 {{ $errors->has('description') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Description') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <textarea class="form-control summernote {{ $errors->has('description') ? 'form-control-danger' : '' }}"
                                                name="description" type="message" placeholder="Enter Description">{{ old('description', $get_blog_language['description']) }}</textarea>
                                            @error('description')
                                                <div class="col-form-alert-label">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('short_description') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{ translate('Short Description') }}<span
                                                    class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                                            <textarea class="form-control summernote {{ $errors->has('short_description') ? 'form-control-danger' : '' }}"
                                                name="short_description" type="message" placeholder="Enter Short Description">{{ old('short_description', $get_blog_language['short_description']) }}</textarea>
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
                                                <option value="Deactive"
                                                    {{ getSelected($get_blogs['status'], 'Deactive') }}>
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
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit"
                                            class="btn btn-primary  m-b-0 mr-0">{{ $common['button'] }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
