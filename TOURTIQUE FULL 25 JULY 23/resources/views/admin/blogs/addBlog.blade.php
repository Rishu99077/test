@extends('admin.layout.master')
@section('content')
    <script src="https://tourtastique.infosparkles.com/admin/assets/js/flatpickr.js"></script>

    <style>
        .border-dashed-black-bottom {
            border-bottom: 1px dashed var(--falcon-headings-color) !important;
        }

        .blck_clr {
            color: var(--falcon-headings-color);
        }
    </style>
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
    <form class="row g-3 " method="POST" action="{{ route('admin.blogs.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body bg-light">
                    <div class="row">
                        <input name="id" type="hidden" value="{{ $get_blog['id'] }}" />

                        
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Title') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title" name="title[{{ $lang_id }}]"
                                type="text"
                                value="{{ getLanguageTranslate($get_blog_language, $lang_id, $get_blog['id'], 'title', 'blog_id') }}" />
                            @error('title.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        

                        <div class="col-md-6">
                            <label class="form-label" for="price">Blog Category</label>

                            <select class="form-select single-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                name="category_id">
                                <option value="">Select Blog Category</option>
                                @foreach ($get_blog_category as $key => $value)
                                    <option value="{{ $value['id'] }}"
                                        {{ $get_blog['category_id'] == $value['id'] ? 'selected' : '' }}>
                                        {{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label" for="price">Status </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">Active</option>
                                <option value="Deactive"{{ $get_blog['status'] == 'Deactive' ? 'selected' : '' }}>
                                    Deactive
                                </option>
                            </select>
                        </div>

                        
                            <div class="col-md-6">
                                <label class="form-label"
                                    for="price">{{ translate('Description') }} </label>

                                <textarea class="form-control editor {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                                    id="description" name="description[{{ $lang_id }}]" placeholder="Enter Description">{{ getLanguageTranslate($get_blog_language, $lang_id, $get_blog['id'], 'description', 'blog_id') }}</textarea>
                                @error('description.' . $lang_id)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                       

                        <div class="col-lg-6 mt-3">
                            <label class="form-label" for="first-name">Image</label>
                            <input class="form-control   {{ $errors->has('image') ? 'is-invalid' : '' }}" id="customFile"
                                name="image" onchange="loadFile(event,'preview')" type="file">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="col-lg-6 mt-1">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_blog['image'] }}" id="preview" width="200" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6  mt-3 content_title">
                            <label class="form-label" for="title">{{ translate('Date') }}

                            </label>
                            <input class="form-control datetimepickerdate" id="date" name="date" type="text"
                                placeholder="Y-m-d" value="{{ $get_blog['date'] }}" />

                            <div class="invalid-feedback">

                            </div>

                        </div>

                        <div class="col-lg-6 mt-3">
                            <label class="form-label" for="first-name">{{ translate('Video Thumnail') }} </label>
                            <input class="form-control   {{ $errors->has('image') ? 'is-invalid' : '' }}" id="customFile"
                                name="thumnail_image" onchange="loadFile(event,'preview_1')" type="file">
                            @error('thumnail_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="col-lg-6 mt-1">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_blog['thumnail_image'] }}" id="preview_1" width="200"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <label class="form-label" for="video">{{ translate('Video URL') }} </label>
                            <input class="form-control   {{ $errors->has('video') ? 'is-invalid' : '' }}" id="customFile"
                                name="video" type="text" value="{{ $get_blog['video'] }}">
                            @error('video')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="colcss">
                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_blog_additional as $BAV)
                                @include('admin.blogs._additional')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (empty($get_blog_additional))
                                @include('admin.blogs._additional')
                            @endif
                            <div class="show_books">
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <a class="mb-4 d-block d-flex align-items-center" id="additional_headlines"
                                        href="javascript:void(0)">
                                        <span class="circle-dashed">
                                            <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true"
                                                focusable="false" data-prefix="fas" data-icon="plus" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                                </path>
                                            </svg>
                                        </span>
                                        <span class="ms-3">{{ translate('Add Additional Headlines') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.ckeditor.com/4.21.0/standard-all/ckeditor.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.editor').each(function(e) {
                CKEDITOR.replace(this.name, {
                    format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
                    extraPlugins: 'colorbutton,colordialog',
                    removeButtons: 'PasteFromWord'
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.remove', function() {
            var _this = $(this);
            status = confirm("Do you want to Remove !");
            if (status == 'true') {
                console.log("fddf");
                _this.closest('.card').remove();
            }
        });
    </script>

    <!-- Why Book -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#additional_headlines').click(function(e) {

                var ParamArr = {
                    'view': 'admin.blogs._additional',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_books');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_book", function(e) {
                var length = $(".delete_book").length;
                // if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.faq_div').remove();
                        e.preventDefault();
                    }
                });
                // }
            });


        });
    </script>
    <script>
        $(".datetimepickerdate").flatpickr({
            // minDate: "today",
            enableTime: false,
            dateFormat: "Y-m-d",
        });
    </script>
@endsection
