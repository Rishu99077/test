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

    <form class="row g-3 " method="POST" action="{{ route('admin.gift_an_expirence.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card mb-3 partner_div">
                                <div class="card-body position-relative">
                                    <div class="row">
                                        <div class="col-auto align-self-center">
                                            <h3 class="blck_clr">Gift an Experience</h3>
                                        </div>
                                        <div class="col-auto ms-auto">
                                            {{-- <button class="delete_testimonial bg-card btn btn-danger btn-sm float-end"
                                                type="button"><span class="fas fa-trash-alt"></span></button> --}}
                                        </div>
                                    </div>
                                    <div class="row">

                                        <input id="" name="id[]" type="hidden"
                                            value="{{ $get_gift_an_expirence['id'] }}" />
                                        <div class="col-md-6 content_title">
                                            <label class="form-label" for="duration_from">{{ translate('Upload Image') }}
                                                <small>(792X450)</small> </label>
                                            <div class="input-group mb-3">
                                                <input class="form-control " type="file" name="image"
                                                    aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo')"
                                                    id="image" />

                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mt-2">
                                                <div
                                                    class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                                        <img src="{{ $get_gift_an_expirence['image'] != '' ? url('uploads/gift_an_expirence/', $get_gift_an_expirence['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                                            id="upload_logo" width="100" alt="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                                            <select class="form-select single-select" name="status">
                                                <option value="Active">{{ translate('Active') }} </option>
                                                <option value="Deactive"
                                                    {{ $get_gift_an_expirence['status'] == 'Deactive' ? 'selected' : '' }}>
                                                    {{ translate('Deactive') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                for="link">{{ translate('Link') }}
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Enter Link ') }}" id="title"
                                                name="link" type="text"
                                                value="{{old('link',$get_gift_an_expirence['link'])}}" />
                                            @error('link')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3"></div>

                                            <?php
                                            $title = '';
                                            $description = '';
                                            if ($get_gift_an_expirence['id'] != '') {
                                                $get_gift_an_expirence_language = App\Models\BannerOverviewLanguage::where('page', 'gift_an_expirence_section')
                                                    ->where('overview_id', $get_gift_an_expirence['id'])
                                                    ->where('langauge_id', $lang_id)
                                                    ->first();
                                                if ($get_gift_an_expirence_language) {
                                                    $title = $get_gift_an_expirence_language['title'];
                                                    $description = $get_gift_an_expirence_language['description'];
                                                }
                                            }
                                            ?>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"
                                                    for="title">{{ translate('Heading') }}
                                                </label>
                                                <input
                                                    class="form-control {{ $errors->has('gift_an_exp_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                                    placeholder="{{ translate('Enter  Heading ') }}" id="title"
                                                    name="gift_an_exp_heading[{{ $lang_id }}]" type="text"
                                                    value="{{ $title }}" />
                                                @error('gift_an_exp_heading.' . $lang_id)
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label"
                                                    for="price">{{ translate('Description') }}
                                                </label>

                                                <textarea class="form-control {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text"
                                                    rows="8" id="description" name="description[{{ $lang_id }}]" placeholder="Enter Description">{{ $description }}</textarea>
                                                @error('description.' . $lang_id)
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        {{-- {{ getLanguageTranslate($get_heading_title, $lang_id, 'testimonial_heading_title', 'title', 'meta_title') }} --}}

                                    </div>
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
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replaceAll('footer_text');
    </script>
@endsection
