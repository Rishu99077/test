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
        <div class="col-auto ms-auto">
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button"><span
                    class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3" method="POST" action="{{ route('admin.media_blogs.add') }}" enctype="multipart/form-data"s>
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_media_blog['id'] }}" />
                        
                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_media_blog['status'])) }} id="status" type="checkbox" value="Active" name="status">
                                <label class="form-check-label form-label"
                                    for="status">{{ translate('Status') }}
                                </label>
                            </div>
                        </div>    


                        @foreach ($languages as $key => $L)
                            <div class="col-md-6">
                                <label class="form-label" for="price">{{ translate('Description') }}({{ $L['title'] }}) </label>

                                 <textarea class="form-control footer_text {{ $errors->has('description.' . $L['id']) ? 'is-invalid' : '' }}" rows="8" id="description" name="description[{{ $L['id'] }}]" placeholder="Enter Description">{{ getLanguageTranslate($get_media_blog_language, $L['id'], $get_media_blog['id'], 'description', 'media_blog_id') }}</textarea>
                                @error('description.' . $L['id'])
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                
                            </div>
                        @endforeach 

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Media blog video') }}
                                <small>(792X450)</small> </label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="file" name="media_video" aria-describedby="basic-addon2"  id="media_video"/>

                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div> 

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Media Blog Thumbnail Image') }}
                                <small>(792X450)</small> </label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="file" name="media_image" aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo')" id="work_image"/>

                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_media_blog['media_image'] != '' ? asset('uploads/MediaBlog/' . $get_media_blog['media_image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_work_logo" width="100" alt="" />
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
@endsection
