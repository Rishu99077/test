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
        {{-- <div class="col-auto ms-auto">
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button"><span
                    class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div> --}}
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.testimonials.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body bg-light">
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label"
                                for="title">{{ translate('Testimonial Heading') }}
                            </label>
                            <input
                                class="form-control {{ $errors->has('testionial_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Enter Testimonial Heading ') }}" id="title"
                                name="testionial_heading[{{ $lang_id }}]" type="text" value="{{ getLanguageTranslate($get_heading_title, $lang_id, 'testimonial_heading_title', 'title', 'meta_title') }}" />
                            @error('testionial_heading.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        

                        <div class="col-md-12">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($get_testimonial as $key => $GT)
                                @include('admin.testimonials._testimonial')
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                            @if (count($get_testimonial) == 0)
                                @include('admin.testimonials._testimonial')
                            @endif

                            <div class="show_testimonial">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <a class="mb-4 d-block d-flex align-items-center" id="add_testimonial"
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


                        

                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replaceAll('footer_text');
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $count }}";
            $('#add_testimonial').click(function(e) {

                var ParamArr = {
                    'view': 'admin.testimonials._testimonial',
                    'count': count
                }
                getAppendPage(ParamArr, '.show_testimonial');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_testimonial", function(e) {
                var length = $(".delete_testimonial").length;
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
