@extends('admin.layout.master')
@section('content')

    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
                <a href="#" style="width: auto;">

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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="{{ route('admin.partners.add') }}" type="button"><span class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }}</a>
        </div>
    </div>
    <form class="row g-3 " method="POST" action="{{ route('admin.partners.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row colcss">
                        <div class="col-md-12">
                            <div class="row">

                                <input id="" name="id" type="hidden" value="{{ $get_partner['id'] }}" />

                                @foreach ($languages as $key => $L)
                                    <div class="col-md-6">
                                        <label class="form-label" for="title">{{ translate('Main heading') }}({{ $L['title'] }})<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control {{ $errors->has('name.' . $L['id']) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Main heading') }}" id="name" name="name[{{ $L['id'] }}]"
                                            type="text"
                                            value="{{ getLanguageTranslate($get_partner_language, $L['id'], $get_partner['id'], 'title', 'partner_id') }}" />
                                        @error('name.' . $L['id'])
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                    for="customFile">{{ translate('Multiple Banner Image') }} <small>(792X450)</small>
                                    <span class="fas fa-info-circle"></span>
                                </label>
                                <div class="upload_img">

                                    <div class="uploader_file wrapper">
                                        <div class="drop">
                                            <div class="cont">
                                                <span class="image-file">
                                                    <img src="{{ asset('assets/img/add-image.png') }}"
                                                        class="img-fluid">
                                                </span>
                                                <div class="browse">
                                                    <span class="upload-icon">
                                                        <img src="{{ asset('assets/img/pro_upload.png') }}"
                                                            class="img-fluid"></span>
                                                    {{ translate('Drop your image here.or') }}
                                                    <span class="browse_txt">{{ translate('Browse') }}</span>
                                                </div>
                                                <input id="files" id="files" multiple="true" name="files[]"
                                                    type="file" />
                                            </div>
                                            <output id="list"></output>
                                            <div class="row appenImage"></div>
                                        </div>
                                    </div>



                                    @if (count($get_partner_images) > 0)
                                        <?php $i = 1; ?>
                                        <div class="row">
                                            @foreach ($get_partner_images as $key => $image)
                                                <div class='col-md-2'>
                                                    <div class="image-item upload_img_list">
                                                        <input type="hidden" name="image_id[]" value="{{ $image['id'] }}"> 
                                                        <img src="{{ asset('uploads/partner_images/' . $image['partner_images']) }}"
                                                            alt="" width="20" title="">
                                                        <div class="image_name_size">
                                                            <input type="hidden" name="image_id[]" value="{{ $image['id'] }}">
                                                        </div>
                                                        <div class="image-item__btn-wrapper">
                                                            <button type="button" class="btn btn-default remove btn-sm"
                                                                data-count="{{ $i++ }}">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }} </option>
                                <option value="Deactive"{{ $get_partner['status'] == 'Deactive' ? 'selected' : '' }}>
                                    {{ translate('Deactive') }}
                                </option>
                            </select>
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


            $(".pick_from").each(function() {
                var time = $(this).val();
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: time

                })
            });

            $(".pick_to").each(function() {
                var time = $(this).val();
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: time

                })
            });
        });
    </script>

@endsection
