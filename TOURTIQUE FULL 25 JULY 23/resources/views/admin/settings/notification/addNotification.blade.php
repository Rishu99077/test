@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
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

    <form class="row g-3 " method="POST" action="{{ route('admin.send_notification.send') }}"
        enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_notification['id'] }}" />
                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Notification Icon') }}
                                <small>(792X450)</small> <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input class="form-control  {{ $errors->has('notifcation_icon') ? 'is-invalid' : '' }}" type="file" name="notifcation_icon"
                                    aria-describedby="basic-addon2" onchange="loadFile(event,'notifcation_icon_pre')"
                                    id="notifcation_icon" />

                                @error('notifcation_icon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-3 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_notification['icon'] != '' ? asset('uploads/notification/' . $get_notification['icon']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="notifcation_icon_pre" width="100" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Notification Image') }}
                                <small>(792X450)</small> </label>
                            <div class="input-group mb-3">
                                <input class="form-control {{ $errors->has('notifcation_image') ? 'is-invalid' : '' }}" type="file" name="notifcation_image"
                                    aria-describedby="basic-addon2" onchange="loadFile(event,'notifcation_image_pre')"
                                    id="notifcation_image" />

                                @error('notifcation_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-3 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_notification['image'] != '' ? asset('uploads/notification/' . $get_notification['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="notifcation_image_pre" width="100" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Title') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title" name="title" type="text"
                                value="{{$get_notification['title']}}" />
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>








                        <div class="col-md-6 content_title mb-2">
                            <label class="form-label" for="price">{{ translate('Link') }} </label>
                            <div class="input-group mb-3">
                                <input class="form-control " placeholder="{{ translate('Title') }}" type="text"
                                    name="link" aria-describedby="basic-addon2" value="{{ $get_notification['link'] }}"
                                    id="link" />
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="price">{{ translate('Description') }}<span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control editor {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="8"
                                id="description" name="description" placeholder="Enter Description">{{$get_notification['description']}}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- </form>
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
    </script> --}}
@endsection
