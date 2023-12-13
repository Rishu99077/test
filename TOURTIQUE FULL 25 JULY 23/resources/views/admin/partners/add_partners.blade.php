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

                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>
        
    </div>
    <form class="row g-3 " method="POST" action="{{ route('admin.partners.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body bg-light">
                    <div class="row ">
                    
                        <div class="col-md-6 mb-3">
                            <label class="form-label"
                                for="title">{{ translate('Partners Heading') }}
                            </label>
                            <input 
                                class="form-control {{ $errors->has('partners_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Enter Partners Heading ') }}" id="title"
                                name="partners_heading[{{ $lang_id }}]" type="text" value="{{ getLanguageTranslate($get_heading_title, $lang_id, 'partners_heading_title', 'title', 'meta_title') }}" />
                            @error('partners_heading.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"
                                for="title">{{ translate('Partners Text') }} </label>
                            <input type="text"
                                class="form-control  {{ $errors->has('partners_text.' . $lang_id) ? 'is-invalid' : '' }} footer_text "
                                placeholder="{{ translate('Enter Partners Text ') }}" id="partner_text" value="{{ getLanguageTranslate($get_heading_title, $lang_id, 'partners_heading_title', 'content', 'meta_title') }}"
                                name="partners_text[{{ $lang_id }}]" />
                            @error('partners_text.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-12">

                            @php
                                $count = 0;
                            @endphp
                            @foreach ($get_partner as $key => $GP)
                                @include('admin.partners._partners')
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                            @if (count($get_partner) == 0)
                                @include('admin.partners._partners')
                            @endif

                            <div class="show_partners">
                            </div>

                            <div class="col-md-12 mt-3">
                                <a class="mb-4 d-block d-flex align-items-center" id="add_partners"
                                    href="javascript:void(0)">
                                    <span class="circle-dashed">
                                        <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="plus" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="ms-3">{{ translate('Add more') }}</span>
                                </a>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $count }}";
            $('#add_partners').click(function(e) {

                var ParamArr = {
                    'view': 'admin.partners._partners',
                    'count': count
                }
                getAppendPage(ParamArr, '.show_partners');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_partners", function(e) {
                var length = $(".delete_partners").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.partner_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>
@endsection
