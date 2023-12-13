@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
                <a href="#" style="width: auto;">
                    <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" height="25px" width="25px"></span>
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

    <form class="row g-3 " method="POST" action="{{ route('admin.rewardshare.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_rewards['id'] }}" />

                         <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_rewards['status'])) }} id="status" type="checkbox" value="Active" name="status">
                                <label class="form-check-label form-label"
                                    for="status">{{ translate('Status') }}
                                </label>
                            </div>
                        </div>    

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="title">{{ translate('Title') }}<span
                                        class="text-danger">*</span>
                                </label>
                                <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Title') }}" id="title" name="title[{{ $lang_id }}]"
                                    type="text"
                                    value="{{ getLanguageTranslate($get_rewards_language, $lang_id, $get_rewards['id'], 'title', 'reward_id') }}" />
                                @error('title.' . $lang_id)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Share Points') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('share_points') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Share Points') }}" id="share_points" name="share_points"
                                type="text"
                                value="{{ $get_rewards['id'] }}" />
                            @error('share_points')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                        <img src="{{ $get_rewards['image'] != '' ? asset('uploads/product_images/' . $get_rewards['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="preview_image" width="100" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 mt-2">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end" id="instagram"
                                    {{ getChecked(1, $get_rewards['instagram']) }} type="checkbox"
                                    value="1" name="instagram">
                                <label class="fs-0" for="instagram">{{ translate('Instagram') }}</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end" id="facebook"
                                    {{ getChecked(1, $get_rewards['facebook']) }} type="checkbox"
                                    value="1" name="facebook">
                                <label class="fs-0" for="facebook">{{ translate('Facebook') }}</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end" id="twitter"
                                    {{ getChecked(1, $get_rewards['twitter']) }} type="checkbox"
                                    value="1" name="twitter">
                                <label class="fs-0" for="twitter">{{ translate('Twitter') }}</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end" id="youtube"
                                    {{ getChecked(1, $get_rewards['youtube']) }} type="checkbox"
                                    value="1" name="youtube">
                                <label class="fs-0" for="youtube">{{ translate('You Tube') }}</label>
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
