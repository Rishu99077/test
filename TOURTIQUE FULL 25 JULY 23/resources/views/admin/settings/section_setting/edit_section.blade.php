@extends('admin.layout.master')
@section('content')


    <style type="text/css">
        .frm_cls {
            max-width: 600px;
            margin: auto;
        }

        .avatar-4xl {
            height: 6.125rem;
            width: 200px;
        }

        .avatar img {
            -o-object-fit: cover;
            object-fit: contain;
        }
    </style>
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background: linear-gradient(90deg, rgba(38,42,73,1) 0%, rgba(61,65,100,1) 71%, rgba(9,193,45,0.44019614681810226) 100%);">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ $common['title'] }}</h3>
                </div>
                <div class="col-auto ms-auto">
                    <a class="btn btn-falcon-primary me-1 mb-1" href="javascript:void(0)" onclick="back()"
                        type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body bg-light">
                    <form class="row g-3 " method="POST" action="{{ route('admin.page_setting') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input id="" name="id" type="hidden" value="{{ $id }}" />
                        <div class="row mb-5">
                            @if ($get_main['title'] != 'Empty')
                                <div class="col-md-6">
                                    <label class="form-label" for="title_">Title</label>
                                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                        placeholder="title" id="title_" name="{{ $get_main['child_meta_title'] }}[title]"
                                        type="text" value="{{ old('title', $get_main['title']) }}" />
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif

                            @if ($get_main['file'] != 'Empty')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="customFile1">Image</label>
                                        <input class="form-control   {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                            id="customFile1" onchange="loadFile(event,'preview')"
                                            name="{{ $get_main['child_meta_title'] }}[file]" type="file">
                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="avatar avatar-4xl">
                                        <img class="" id="preview"
                                            src="{{ $get_main['file'] != '' ? url('uploads/setting', $get_main['file']) : asset('uploads/placeholder/no_image.jpg') }}"
                                            alt="" />
                                    </div>
                                </div>
                            @endif

                            @if ($get_main['image'] != 'Empty')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="customFile2">Home Page Bckground Image</label>
                                        <input class="form-control   {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                            id="customFile2" onchange="loadFile(event,'image')"
                                            name="{{ $get_main['child_meta_title'] }}[image]" type="file">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="avatar avatar-4xl">
                                        <img class="" id="image"
                                            src="{{ $get_main['image'] != '' ? url('uploads/setting', $get_main['image']) : asset('uploads/placeholder/no_image.jpg') }}"
                                            alt="" />
                                    </div>
                                </div>
                            @endif


                            @if ($get_main['banner_image'] != 'Empty')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="customFile3">About us Page Banner Image</label>
                                        <input class="form-control   {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                            id="customFile3" onchange="loadFile(event,'banner_image')"
                                            name="{{ $get_main['child_meta_title'] }}[banner_image]" type="file">
                                        @error('banner_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="avatar avatar-4xl">
                                        <img class="" id="banner_image"
                                            src="{{ $get_main['banner_image'] != '' ? url('uploads/setting', $get_main['banner_image']) : asset('uploads/placeholder/no_image.jpg') }}"
                                            alt="" />
                                    </div>
                                </div>
                            @endif

                            @if ($get_main['content'] != 'Empty')
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="content">Description</label>
                                    <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }} editor" placeholder="description"
                                        id="content" rows="5" name="{{ $get_main['child_meta_title'] }}[content]" type="text" value="">{{ old('content', $get_main['content']) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                        </div>



                        {{-- /////////////Sections --}}
                        @if (count($get_main['sections']) > 0)
                            <div class="row">
                                <?php $i = 1; ?>
                                @foreach ($get_main['sections'] as $key => $value)
                                    <div class="col-12">
                                        <h3 class="" style="color: #5e6e82">Section {{ $i++ }}</h3>
                                    </div>
                                    @if ($value['title'] != 'Empty')
                                        <div class="col-md-6  mb-2">
                                            <label class="form-label" for="title">Title</label>
                                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                placeholder="title" id="title"
                                                name="{{ $value['child_meta_title'] }}[title]" type="text"
                                                value="{{ old('title', $value['title']) }}" />
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif

                                    @if ($value['file'] != 'Empty')
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="customFile">Image</label>
                                                <input
                                                    class="form-control   {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                                    id="customFile"
                                                    onchange="loadFile(event,'preview_{{ $value['child_meta_title'] }}')"
                                                    name="{{ $value['child_meta_title'] }}[file]" type="file">
                                                @error('file')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="avatar avatar-4xl">
                                                <img class="" id="preview_{{ $value['child_meta_title'] }}"
                                                    src="{{ $value['file'] != '' ? url('uploads/setting', $value['file']) : asset('uploads/placeholder/no_image.jpg') }}"
                                                    alt="" />
                                            </div>
                                        </div>
                                    @endif

                                    @if ($value['content'] != 'Empty')
                                        <div class="col-md-12  mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }} editor" placeholder="description"
                                                rows="5" id="description" name="{{ $value['child_meta_title'] }}[content]" type="text"
                                                value="">{{ old('content', $value['content']) }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif



                        <div class="col-12 d-flex justify-content-center ">
                            <button class="btn btn-primary" type="submit">{{ $common['button'] }}</button>
                            <button class="btn btn-primary ml-20" type="button" onclick="back()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front_assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replaceAll('editor');
        });
    </script>
@endsection
