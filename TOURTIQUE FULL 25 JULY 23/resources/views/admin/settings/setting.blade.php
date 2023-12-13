@extends('admin.layout.master')
@section('content')
    <style>
        .tox-notifications-container {
            display: none;
        }

        .avatar-4xl {
            height: 6.125rem;
            width: 100px;
            padding: 15px;
            background: #232323;
            border-radius: 50px;
        }

        .avatar img {
            -o-object-fit: cover;
            object-fit: contain;
        }
    </style>
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ $common['title'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body bg-light">
                    <form class="row g-3 " method="POST" action="{{ route('admin.settings') }}"
                        enctype="multipart/form-data">
                        @csrf

                        @foreach ($get_settings as $key => $value)
                            @if (get_setting_data($key, 'type') == 'file')
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="customFile">{{ $key }}</label>
                                        <input class="form-control   {{ $errors->has($key) ? 'is-invalid' : '' }}"
                                            id="customFile" onchange="loadFile(event,'{{ $key }}')"
                                            name="{{ $key }}" type="file">
                                        @error($key)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="avatar avatar-4xl">
                                        <img class="" id="{{ $key }}"
                                            src="{{ $get_settings[$key] != '' ? url('uploads/setting', $get_settings[$key]) : asset('uploads/placeholder/no_image.jpg') }}"
                                            alt="" />
                                    </div>
                                </div>
                            @elseif (get_setting_data($key, 'type') == 'text')
                                <div class="col-md-4">
                                    <label class="form-label" for="title">{{ get_setting_data($key, 'title') }}</label>
                                    <input class="form-control {{ $errors->has($key) ? 'is-invalid' : '' }}"
                                        placeholder="{{ get_setting_data($key, 'title') }}" name="{{ $key }}"
                                        type="text" value="{{ old($key, $get_settings[$key]) }}" />
                                    @error($key)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @elseif (get_setting_data($key, 'type') == 'textarea')
                                <div class="col-md-12">
                                    <label class="form-label"
                                        for="description">{{ get_setting_data($key, 'title') }}</label>
                                    <textarea class="form-control footer_text {{ $errors->has($key) ? 'is-invalid' : '' }}" id="footer_text"
                                        placeholder="{{ get_setting_data($key, 'title') }}" name="{{ $key }}">{{ old($key, $get_settings[$key]) }}</textarea>
                                    @error($key)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @elseif (get_setting_data($key, 'type') == 'checkbox')
                                <div class="col-md-4">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" id="{{ $key }}" type="checkbox"
                                            {{ $get_settings[$key] == 'active' ? 'checked' : '' }}>
                                        <input type="hidden" value="{{ $get_settings[$key] }}" name="{{ $key }}"
                                            id="inp_social">

                                        <label class="form-check-label" for="{{ $key }}">Social Icon
                                            Status</label>
                                    </div>
                                </div>
                            @endif
                        @endforeach






                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit"> <span class="fa fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('change', '#social_icon_status', function() {
            if ($('#social_icon_status:checked').length > 0) {
                $('#inp_social').val('active');
            } else {
                $('#inp_social').val('deactive');
            }
        })
    </script>
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replaceAll('footer_text');
        });
    </script>
@endsection
