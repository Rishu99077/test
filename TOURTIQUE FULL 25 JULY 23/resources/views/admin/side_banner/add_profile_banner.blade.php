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
        
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.profile_banner.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body bg-light">
                    <div class="row ">

                        <input id="" name="id" type="hidden" value="{{ $get_profilebanner['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_profilebanner['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">{{ translate('Image') }}<span
                                    class="text-danger">*</span> <small>(792X450)</small> </label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="file" name="image"
                                    aria-describedby="basic-addon2" onchange="loadFile(event,'preview_image')"
                                    id="image" />

                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_profilebanner['image'] != '' ? asset('uploads/profile_banner/' . $get_profilebanner['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="preview_image" width="100" alt="" />
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
