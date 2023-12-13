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

    <form class="row g-3 " method="POST" action="{{ route('admin.advertisment_banner.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_advertisment_banner['id'] }}" />
                        
                        <div class="col-md-6 mb-2">
                            <label class="form-label" for="title">{{ translate('Title') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title" name="title[{{ $lang_id }}]"
                                type="text"
                                value="{{getLanguageTranslate($get_languge_title, $lang_id, 'heading_title', 'title', 'meta_title')}}" />
                            @error('title.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 content_title mb-2">
                            <label class="form-label" for="price">{{ translate('Link') }} </label>
                            <div class="input-group mb-3">
                                <input class="form-control " placeholder="{{ translate('Title') }}" type="text" name="link" aria-describedby="basic-addon2"
                                    value="{{ $get_advertisment_banner['link'] }}" id="link" />
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }} </option>
                                <option value="Deactive"{{ $get_advertisment_banner['status'] == 'Deactive' ? 'selected' : '' }}>
                                    {{ translate('Deactive') }}
                                </option>
                            </select>
                        </div>

                        

                        <div class="col-md-6 mb-2">
                            <label class="form-label" for="datepicker">{{ translate('Start Date') }}</label>
                            <input class="form-control datetimepicker" id="datepicker" type="text" name="start_date" value="{{$get_advertisment_banner['start_date']}}" placeholder="d-m-y H:i" data-options='{"enableTime":true,"dateFormat":"d-m-Y H:i","disableMobile":true}' />
                        </div>    

                        <div class="col-md-6 mb-2">
                            <label class="form-label" for="datepicker">{{ translate('End Date') }}</label>
                            <input class="form-control datetimepicker" id="datepicker" type="text" name="end_date" value="{{$get_advertisment_banner['end_date']}}" placeholder="d-m-y H:i" data-options='{"enableTime":true,"dateFormat":"d-m-Y H:i","disableMobile":true}' />
                        </div> 
                        
                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Upload Media') }}
                                <small>(792X450)</small> </label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="file" name="image" aria-describedby="basic-addon2"
                                    onchange="loadFile(event,'upload_logo')"
                                    id="image" />

                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_advertisment_banner['image'] != '' ? asset('uploads/setting/' . $get_advertisment_banner['image']) : asset('uploads/placeholder/placeholder.png') }}" id="upload_logo" width="100" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 content_title mb-2">
                            <label class="form-label" for="price">{{ translate('Video Link') }} </label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="text" name="video_link" placeholder="{{ translate('Video Link') }}" aria-describedby="basic-addon2"
                                    value="{{ $get_advertisment_banner['video_link'] }}" id="video_link" />
                                <div class="invalid-feedback">
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
